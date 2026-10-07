<?php
require_once 'wp-load.php';

echo "=== CHECK POST 21 (jobs) ===\n";
$p21 = get_post(21);
if ($p21) {
    echo "Title: {$p21->post_title}\nSlug: {$p21->post_name}\nContent:\n{$p21->post_content}\n";
    echo "Page Template: " . get_post_meta(21, '_wp_page_template', true) . "\n";
}

echo "\n=== CHECK POST 7 (all-jobs) ===\n";
$p7 = get_post(7);
if ($p7) {
    echo "Title: {$p7->post_title}\nSlug: {$p7->post_name}\nContent:\n{$p7->post_content}\n";
    echo "Page Template: " . get_post_meta(7, '_wp_page_template', true) . "\n";
}

echo "\n=== PRIMARY MENU ===\n";
$locations = get_nav_menu_locations();
print_r($locations);
foreach ($locations as $loc => $id) {
    echo "Location: $loc (ID: $id)\n";
    $items = wp_get_nav_menu_items($id);
    if ($items) {
        foreach ($items as $it) {
            echo " - [{$it->ID}] {$it->title} => {$it->url}\n";
        }
    }
}
