<?php
require_once 'wp-load.php';

// 1. Create or clean Primary Menu
$menu_name = 'Main Navigation';
$menu_exists = wp_get_nav_menu_object($menu_name);

if (!$menu_exists) {
    $menu_id = wp_create_nav_menu($menu_name);
} else {
    $menu_id = $menu_exists->term_id;
    // Remove old items
    $items = wp_get_nav_menu_items($menu_id);
    if ($items) {
        foreach ($items as $item) {
            wp_delete_post($item->ID, true);
        }
    }
}

// Add Menu items: HOME, JOBS, NEWS, ABOUT, CONTACT
$menu_items = [
    ['title' => 'HOME', 'url' => home_url('/')],
    ['title' => 'JOBS', 'url' => home_url('/jobs/')],
    ['title' => 'NEWS', 'url' => home_url('/news/')],
    ['title' => 'ABOUT', 'url' => home_url('/about-us/')],
    ['title' => 'CONTACT', 'url' => home_url('/contact-us/')],
];

foreach ($menu_items as $order => $item) {
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'   => $item['title'],
        'menu-item-url'     => $item['url'],
        'menu-item-status'  => 'publish',
        'menu-item-position'=> $order + 1,
        'menu-item-type'    => 'custom',
    ]);
}

// Set this menu as 'primary' location
$locations = get_theme_mod('nav_menu_locations');
if (!is_array($locations)) {
    $locations = [];
}
$locations['primary'] = $menu_id;
set_theme_mod('nav_menu_locations', $locations);

echo "Primary menu updated successfully with 5 items!\n";
