<?php
require_once 'wp-load.php';
$menu_items = wp_get_nav_menu_items('Primary');
if ($menu_items) {
    foreach ($menu_items as $item) {
        echo "Title: {$item->title} | URL: {$item->url}\n";
    }
} else {
    echo "No menu items in Primary\n";
}
