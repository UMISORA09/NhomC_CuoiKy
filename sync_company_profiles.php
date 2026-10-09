<?php
require_once __DIR__ . '/wp-load.php';

$companies_data = [
    'VNG Corporation' => [
        'description' => 'Công ty công nghệ kỳ lân hàng đầu Việt Nam chuyên về game, Zalo và dịch vụ đám mây.',
        'website' => 'https://vng.com.vn',
    ],
    'FPT Software Vietnam' => [
        'description' => 'Tập đoàn công nghệ và gia công phần mềm hàng đầu Đông Nam Á.',
        'website' => 'https://fpt-software.com',
    ],
    'Viettel Digital Solutions' => [
        'description' => 'Tổng công ty Dịch vụ số Viettel, tiên phong phát triển hệ sinh thái tài chính số và dữ liệu lớn.',
        'website' => 'https://viettel.vn',
    ],
    'MoMo Financial Technology' => [
        'description' => 'Fintech kỳ lân hàng đầu Việt Nam, ví điện tử phổ biến nhất với hơn 30 triệu người dùng.',
        'website' => 'https://momo.vn',
    ],
    'Plan Do See Global (PDS)' => [
        'description' => 'Tập đoàn quản trị và vận hành khách sạn nghỉ dưỡng cao cấp quốc tế.',
        'website' => 'https://plandosee.com',
    ],
];

foreach ($companies_data as $comp_name => $info) {
    $term = get_term_by('name', $comp_name, 'companies');
    if (!$term) {
        $result = wp_insert_term($comp_name, 'companies', [
            'description' => $info['description'],
        ]);
        if (!is_wp_error($result)) {
            $term_id = $result['term_id'];
            update_term_meta($term_id, '__term_meta_text', $info['website']);
            update_term_meta($term_id, 'website', $info['website']);
            echo "Created company term: $comp_name (ID: $term_id)\n";
        } else {
            echo "Error creating $comp_name: " . $result->get_error_message() . "\n";
        }
    } else {
        echo "Company term exists: $comp_name (ID: {$term->term_id})\n";
        wp_update_term($term->term_id, 'companies', [
            'description' => $info['description'],
        ]);
        update_term_meta($term->term_id, '__term_meta_text', $info['website']);
        update_term_meta($term->term_id, 'website', $info['website']);
    }
}

// Map jobs to company terms
$jobs = get_posts([
    'post_type' => 'job_listing',
    'posts_per_page' => -1,
    'post_status' => 'any',
]);

echo "Total jobs found: " . count($jobs) . "\n";

foreach ($jobs as $job) {
    $company_name = get_post_meta($job->ID, '_company_name', true);
    if (!empty($company_name)) {
        $term = get_term_by('name', $company_name, 'companies');
        if ($term) {
            wp_set_object_terms($job->ID, (int)$term->term_id, 'companies', false);
            echo "Linked Job #{$job->ID} ({$job->post_title}) -> Company: {$company_name}\n";
        }
    }
}

echo "Done mapping jobs to company profiles!\n";
