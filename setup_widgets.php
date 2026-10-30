<?php
/** Migrate widget layout to direct text/media controls without changing site content. */
if ( PHP_SAPI !== 'cli' ) { http_response_code( 403 ); exit; }
require_once __DIR__ . '/wp-load.php';
if ( 'jobscout' !== get_stylesheet() ) { fwrite( STDERR, "Activate JobScout first.\n" ); exit( 1 ); }
if ( get_option( 'nhomc_widgets_version' ) === NHOMC_WIDGETS_VERSION ) { echo "Already configured; retaining widget edits.\n"; exit; }
global $wpdb;
$names = $wpdb->get_col( $wpdb->prepare( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s", $wpdb->esc_like( 'widget_' ) . '%' ) );
$names = array_merge( $names, array( 'sidebars_widgets', 'nhomc_widgets_version' ) );
$before = array();
foreach ( $names as $name ) { $before[ $name ] = get_option( $name ); }
$counts_sql = "SELECT post_type, post_status, COUNT(*) AS total FROM {$wpdb->posts} GROUP BY post_type, post_status ORDER BY post_type, post_status";
$counts = $wpdb->get_results( $counts_sql, ARRAY_A );
$users = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->users}" );
$comments = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->comments}" );
$backup = array( 'options' => $before, 'content_counts' => $counts, 'users' => $users, 'comments' => $comments );
$backup_name = 'nhomc_editable_widgets_backup_' . gmdate( 'Ymd_His' );
if ( ! add_option( $backup_name, $backup, '', false ) ) { fwrite( STDERR, "Cannot save widget backup.\n" ); exit( 1 ); }
$expected = array();
try {
    $previous = get_option( 'sidebars_widgets', array() );
    $sidebars = array( 'array_version' => 3 );
    $inactive = $previous['wp_inactive_widgets'] ?? array();
    $old_html = get_option( 'widget_custom_html', array() );
    foreach ( nhomc_page_widgets() as $area => $definition ) {
        $sidebars[ $area ] = array();
        foreach ( array_keys( $definition[1] ) as $index => $section ) {
            $base = 'nhomc_' . str_replace( '-', '_', $section );
            $name = 'widget_' . $base;
            $value = get_option( $name, array() );
            $old_id = $previous[ $area ][ $index ] ?? '';
            if ( preg_match( '/^' . preg_quote( $base, '/' ) . '-(\d+)$/', $old_id, $match ) && isset( $value[ (int) $match[1] ] ) ) {
                $id = (int) $match[1];
            } else {
                $ids = array_filter( array_keys( $value ), 'is_numeric' );
                $id = $ids ? max( $ids ) + 1 : 2;
                if ( $definition[1][ $section ][1] ) {
                    $value[ $id ] = array( 'title' => '' );
                } else {
                    $content = nhomc_widget_default_html( $section );
                    if ( preg_match( '/^custom_html-(\d+)$/', $old_id, $match ) && isset( $old_html[ (int) $match[1] ]['content'] ) ) {
                        $content = $old_html[ (int) $match[1] ]['content'];
                    }
                    $value[ $id ] = array( 'html' => $content );
                }
            }
            $value['_multiwidget'] = 1;
            $expected[ $name ] = $value;
            $sidebars[ $area ][] = $base . '-' . $id;
        }
    }
    foreach ( array( 'nhomc-newsletter' => 'nhomc_newsletter', 'nhomc-footer-menu' => 'nhomc_footer_menu' ) as $area => $base ) {
        $value = get_option( 'widget_' . $base, array() );
        $old_id = $previous[ $area ][0] ?? '';
        if ( preg_match( '/^' . preg_quote( $base, '/' ) . '-(\d+)$/', $old_id, $match ) && isset( $value[ (int) $match[1] ] ) ) {
            $id = (int) $match[1];
        } else {
            $ids = array_filter( array_keys( $value ), 'is_numeric' );
            $id = $ids ? max( $ids ) + 1 : 2;
            if ( 'nhomc_newsletter' === $base ) {
                $value[ $id ] = array( 'title' => "Subscribe To\nOur Newsletter", 'placeholder' => 'Input your email address', 'button' => 'SUBSCRIBE' );
            } else {
                $html = nhomc_widget_default_html( 'footer-menu' );
                if ( preg_match( '/^custom_html-(\d+)$/', $old_id, $match ) && isset( $old_html[ (int) $match[1] ]['content'] ) ) { $html = $old_html[ (int) $match[1] ]['content']; }
                $value[ $id ] = array( 'html' => $html );
            }
        }
        $value['_multiwidget'] = 1;
        $expected[ 'widget_' . $base ] = $value;
        $sidebars[ $area ] = array( $base . '-' . $id );
    }
    $assigned = array();
    foreach ( $sidebars as $ids ) { if ( is_array( $ids ) ) { $assigned = array_merge( $assigned, $ids ); } }
    foreach ( $previous as $ids ) { if ( is_array( $ids ) ) { $inactive = array_merge( $inactive, $ids ); } }
    $sidebars['wp_inactive_widgets'] = array_values( array_diff( array_unique( $inactive ), $assigned ) );
    $expected['sidebars_widgets'] = $sidebars;
    foreach ( $expected as $name => $value ) { update_option( $name, $value ); }
    foreach ( $expected as $name => $value ) { if ( get_option( $name ) !== $value ) { throw new RuntimeException( 'Cannot save ' . $name ); } }
    if ( $counts !== $wpdb->get_results( $counts_sql, ARRAY_A ) || $users !== (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->users}" ) || $comments !== (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->comments}" ) ) { throw new RuntimeException( 'Site content counts changed.' ); }
    update_option( 'nhomc_widgets_version', NHOMC_WIDGETS_VERSION );
    update_option( 'nhomc_widgets_backup', $backup_name, false );
    echo "PASS: 18 page blocks and 2 shared widgets have direct edit controls. Previous widget data retained.\n";
} catch ( Throwable $error ) {
    foreach ( array_unique( array_merge( array_keys( $expected ), array_keys( $before ) ) ) as $name ) {
        if ( array_key_exists( $name, $before ) && false !== $before[ $name ] ) { update_option( $name, $before[ $name ] ); } else { delete_option( $name ); }
    }
    fwrite( STDERR, $error->getMessage() . " Previous options restored.\n" ); exit( 1 );
}
