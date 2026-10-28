<?php
/** Read-only regression checks for the six-page widget migration. */
if ( PHP_SAPI !== 'cli' ) { http_response_code( 403 ); exit; }
require __DIR__ . '/wp-load.php';
global $wpdb, $wp_registered_sidebars;
$backup = get_option( 'nhomc_six_page_widgets_backup_20261023' );
$sidebars = get_option( 'sidebars_widgets' );
$checks = array();
foreach ( nhomc_page_widgets() as $area => $definition ) {
    $checks[ $area . ' populated' ] = isset( $wp_registered_sidebars[ $area ] ) && count( $sidebars[ $area ] ) === count( $definition[1] );
    foreach ( $sidebars[ $area ] as $id ) {
        $checks[ $id . ' registered' ] = isset( $GLOBALS['wp_registered_widgets'][ $id ] );
    }
}
$checks['only eight current areas'] = count( $wp_registered_sidebars ) === 8;
$legacy_types = array_filter( $GLOBALS['wp_widget_factory']->widgets, static function ( $widget ) {
    return str_starts_with( $widget->id_base, 'raratheme_' ) || str_starts_with( $widget->id_base, 'rrtc_' );
} );
$checks['legacy Rara widgets removed from editor'] = empty( $legacy_types );
$checks['legacy areas removed'] = ! array_intersect( array( 'sidebar', 'cta', 'testimonial', 'client', 'footer-one', 'footer-two', 'footer-three', 'footer-four', 'nhomc-home-career' ), array_keys( $sidebars ) );
$checks['no inactive demo widgets'] = empty( $sidebars['wp_inactive_widgets'] );
$counts = $wpdb->get_results( "SELECT post_type, post_status, COUNT(*) AS total FROM {$wpdb->posts} GROUP BY post_type, post_status ORDER BY post_type, post_status", ARRAY_A );
$checks['all content counts unchanged'] = $counts === $backup['content_counts'];
$checks['all users retained'] = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->users}" ) === $backup['users'];
$checks['all comments retained'] = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->comments}" ) === $backup['comments'];
foreach ( $backup['options'] as $name => $value ) {
    if ( preg_match( '/^widget_(raratheme_|rrtc_)/', $name ) ) {
        $current = get_option( $name, array() );
        $checks[ $name . ' demo instances cleared' ] = ! array_filter( array_keys( $current ), 'is_numeric' );
    }
}
$widget = new NhomC_Section_Widget( 'home-jobs', 'Top Jobs', 'nhomc-home' );
$instance = $widget->update( array( 'title' => '<b>Custom heading</b>' ), array() );
$checks['dynamic heading sanitized'] = $instance['title'] === 'Custom heading';
ob_start();
$widget->widget( array( 'id' => 'nhomc-home', 'nhomc_context' => array( 'home_jobs' => array() ) ), $instance );
$html = ob_get_clean();
$checks['dynamic heading rendered'] = strpos( $html, 'Custom heading' ) !== false;
ob_start();
$context_filter_before = has_filter( 'dynamic_sidebar_params' );
nhomc_render_page_widgets( 'nhomc-home', array( 'home_jobs' => array(), 'home_blogs' => array() ) );
$home_empty = ob_get_clean();
$checks['live jobs not frozen in widget HTML'] = strpos( $home_empty, 'hm-job-card' ) === false;
$checks['temporary context filter removed'] = has_filter( 'dynamic_sidebar_params' ) === $context_filter_before;
ob_start(); dynamic_sidebar( 'nhomc-newsletter' ); $newsletter = ob_get_clean();
$checks['shared real newsletter preserved'] = strpos( $newsletter, 'name="action" value="nhomc_newsletter"' ) !== false && strpos( $newsletter, wp_create_nonce( 'nhomc_newsletter' ) ) !== false;
foreach ( $checks as $label => $passed ) { if ( ! $passed ) { echo 'FAIL: ' . $label . "\n"; } }
echo count( array_filter( $checks ) ) . '/' . count( $checks ) . " checks passed.\n";
exit( in_array( false, $checks, true ) ? 1 : 0 );
