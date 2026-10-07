<?php
require_once 'wp-load.php';

$args = [
    'post_type' => 'job_listing',
    'post_status' => 'publish',
    'posts_per_page' => 25,
    'orderby' => 'ID',
    'order' => 'ASC'
];

$jobs = get_posts($args);
echo "Total published jobs: " . count($jobs) . "\n";
foreach ($jobs as $j) {
    $location = get_post_meta($j->ID, '_job_location', true);
    $company = get_post_meta($j->ID, '_company_name', true);
    $types = wp_get_post_terms($j->ID, 'job_listing_type');
    $type_name = (!is_wp_error($types) && !empty($types)) ? $types[0]->name : 'Fulltime';
    echo "ID: {$j->ID} | Date: " . get_the_date('M d, Y', $j->ID) . " | Title: {$j->post_title} | Company: {$company} | Loc: {$location}\n";
}
