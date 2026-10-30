<?php
/** Read-only checks: docker exec wordpress_app php test_widgets_menu.php */
if ( PHP_SAPI !== 'cli' ) { http_response_code( 403 ); exit; }
require __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';

$admins = get_users( array( 'role' => 'administrator', 'number' => 1, 'fields' => 'ID' ) );
if ( ! $admins ) { fwrite( STDERR, "No administrator available for the menu check.\n" ); exit( 1 ); }
$original_user = get_current_user_id();
global $menu, $submenu;
$menu = array();
$submenu = array();
$checks = array();
try {
    wp_set_current_user( (int) $admins[0] );
    nhomc_add_widgets_menu();
    $entries = array_values( array_filter( $submenu['themes.php'] ?? array(), static function ( $item ) { return 'widgets.php' === $item[2]; } ) );
    $checks['administrator gets Widgets under Appearance'] = count( $entries ) === 1 && $entries[0][1] === 'edit_theme_options';
    nhomc_add_widgets_menu();
    $checks['existing menu entry is not duplicated'] = count( $submenu['themes.php'] ) === 1;
    $submenu = array();
    wp_set_current_user( 0 );
    nhomc_add_widgets_menu();
    $checks['unauthorized user gets no Widgets menu'] = empty( $submenu['themes.php'] );
    wp_set_current_user( (int) $admins[0] );
    unset( $GLOBALS['_wp_theme_features']['widgets'] );
    nhomc_add_widgets_menu();
    $checks['unsupported theme gets no Widgets menu'] = empty( $submenu['themes.php'] );
} finally {
    add_theme_support( 'widgets' );
    wp_set_current_user( $original_user );
}
foreach ( $checks as $name => $passed ) { echo ( $passed ? 'PASS: ' : 'FAIL: ' ) . $name . "\n"; }
exit( in_array( false, $checks, true ) ? 1 : 0 );
