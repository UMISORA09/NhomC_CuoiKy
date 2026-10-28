<?php
/** Replace legacy widget configuration with the six current Nhom C page designs. */
if ( PHP_SAPI !== 'cli' ) { http_response_code( 403 ); exit; }
require_once __DIR__ . '/wp-load.php';
if ( 'jobscout' !== get_stylesheet() ) { fwrite( STDERR, "Activate JobScout first.\n" ); exit( 1 ); }
if ( get_option( 'nhomc_widgets_version' ) === 'six-pages-20261023' ) {
    echo "Already configured; retaining widget edits.\n"; exit;
}
global $wpdb;
$names = $wpdb->get_col( $wpdb->prepare( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s", $wpdb->esc_like( 'widget_' ) . '%' ) );
$names = array_merge( $names, array( 'sidebars_widgets', 'nhomc_widgets_version' ) );
$before = array();
foreach ( $names as $name ) { $before[ $name ] = get_option( $name ); }
$counts_sql = "SELECT post_type, post_status, COUNT(*) AS total FROM {$wpdb->posts} GROUP BY post_type, post_status ORDER BY post_type, post_status";
$counts = $wpdb->get_results( $counts_sql, ARRAY_A );
$backup = array( 'options' => $before, 'content_counts' => $counts, 'users' => (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->users}" ), 'comments' => (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->comments}" ) );
add_option( 'nhomc_six_page_widgets_backup_20261023', $backup, '', false );
if ( ! is_array( get_option( 'nhomc_six_page_widgets_backup_20261023' ) ) ) {
    fwrite( STDERR, "Cannot save configuration backup.\n" ); exit( 1 );
}
$expected = array();
try {
    $sidebars = get_option( 'sidebars_widgets', array() );
    $html = get_option( 'widget_custom_html', array() );
    $context = array( 'theme_uri' => get_template_directory_uri(), 'site_url' => home_url(), 'hero_bg' => get_template_directory_uri() . '/images/home/hero-home-bg.jpg', 'career_bg' => get_template_directory_uri() . '/images/home/career-bg.jpg' );
    if ( ! empty( $sidebars['nhomc-home-career'][0] ) && preg_match( '/^custom_html-(\d+)$/', $sidebars['nhomc-home-career'][0], $match ) ) {
        $context['career_widget_content'] = $html[ (int) $match[1] ]['content'] ?? '';
    }
    $numeric_ids = array_filter( array_keys( $html ), 'is_numeric' );
    $next_id = $numeric_ids ? max( $numeric_ids ) + 1 : 2;
    foreach ( nhomc_page_widgets() as $area => $definition ) {
        $sidebars[ $area ] = array();
        foreach ( $definition[1] as $section => $data ) {
            if ( $data[1] ) {
                $base = 'nhomc_' . str_replace( '-', '_', $section );
                $value = get_option( 'widget_' . $base, array() );
                $ids = array_filter( array_keys( $value ), 'is_numeric' );
                $id = $ids ? max( $ids ) + 1 : 2;
                $value[ $id ] = array( 'title' => '' );
                $value['_multiwidget'] = 1;
                $expected[ 'widget_' . $base ] = $value;
                $sidebars[ $area ][] = $base . '-' . $id;
            } else {
                ob_start();
                get_template_part( 'template-parts/widgets/' . $section, null, $context );
                $content = ob_get_clean();
                $html[ $next_id ] = array( 'title' => $data[0], 'content' => str_replace( rtrim( home_url(), '/' ), '', $content ) );
                $sidebars[ $area ][] = 'custom_html-' . $next_id++;
            }
        }
    }
    $html['_multiwidget'] = 1;
    $expected['widget_custom_html'] = $html;
    foreach ( $names as $name ) {
        if ( preg_match( '/^widget_(raratheme_|rrtc_)/', $name ) ) {
            $expected[ $name ] = array( '_multiwidget' => 1 );
        }
    }
    $legacy_areas = array( 'sidebar', 'cta', 'testimonial', 'client', 'footer-one', 'footer-two', 'footer-three', 'footer-four', 'nhomc-home-career', 'wp_inactive_widgets' );
    $removed = array();
    foreach ( $legacy_areas as $area ) {
        $removed = array_merge( $removed, $sidebars[ $area ] ?? array() );
        unset( $sidebars[ $area ] );
    }
    $retained = array();
    foreach ( $sidebars as $ids ) { if ( is_array( $ids ) ) { $retained = array_merge( $retained, $ids ); } }
    foreach ( array_diff( array_unique( $removed ), $retained ) as $widget_id ) {
        if ( ! preg_match( '/^(.*)-(\d+)$/', $widget_id, $match ) ) { continue; }
        $name = 'widget_' . $match[1];
        $value = $expected[ $name ] ?? get_option( $name, array() );
        unset( $value[ (int) $match[2] ] );
        $expected[ $name ] = $value;
    }
    $sidebars['wp_inactive_widgets'] = array();
    $expected['sidebars_widgets'] = $sidebars;
    foreach ( $expected as $name => $value ) { update_option( $name, $value ); }
    foreach ( $expected as $name => $value ) {
        if ( get_option( $name ) !== $value ) { throw new RuntimeException( 'Failed to save ' . $name ); }
    }
    if ( $counts !== $wpdb->get_results( $counts_sql, ARRAY_A ) ) { throw new RuntimeException( 'Content counts changed.' ); }
    update_option( 'nhomc_widgets_version', 'six-pages-20261023' );
    echo "PASS: configured 18 blocks across six pages; cleared legacy widget data.\n";
} catch ( Throwable $error ) {
    foreach ( array_unique( array_merge( array_keys( $expected ), array_keys( $before ) ) ) as $name ) {
        if ( array_key_exists( $name, $before ) ) { update_option( $name, $before[ $name ] ); } else { delete_option( $name ); }
    }
    fwrite( STDERR, $error->getMessage() . " Previous widget options restored.\n" ); exit( 1 );
}
