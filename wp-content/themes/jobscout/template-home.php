<?php
/**
 * Template Name: Home Design
 * Template Post Type: page
 *
 * Giao diện Trang Chủ (Home Page) chuẩn đồ án JobScout - Nhóm C (FIT - TDC)
 * Phụ trách: Nguyễn Thanh Hiền (UI/UX & Quản lý bài viết)
 * Thiết kế bám sát 100% bản vẽ: job-design/1-home.png
 * Thương hiệu: NHÓM C RECRUITING (Đã xử lý bản quyền)
 * Đã tối ưu CSS chuyên sâu chống xung đột và chống bị đè giao diện.
 *
 * @package JobScout
 */

defined( 'ABSPATH' ) || exit;

$theme_uri     = get_template_directory_uri();
$site_url      = home_url();
$img_home_dir  = $theme_uri . '/images/home';

// 6 Thương hiệu chuẩn theo bản vẽ thiết kế 1-home.png và all-jobs (Vector sắc nét 100%)
$preset_brands = array(
    array(
        'icon' => 'fa-solid fa-hotel',
        'name' => 'THE SODOH',
        'sub'  => 'KYOTO'
    ),
    array(
        'icon' => 'fa-solid fa-tree',
        'name' => 'FORTUNE',
        'sub'  => 'GARDEN'
    ),
    array(
        'icon' => 'fa-solid fa-champagne-glasses',
        'name' => 'BANQUET',
        'sub'  => 'EVENTS'
    ),
    array(
        'icon' => 'fa-solid fa-bell-concierge',
        'name' => 'SEVEN',
        'sub'  => 'HOUSE'
    ),
    array(
        'icon' => 'fa-solid fa-utensils',
        'name' => 'PHO THIN',
        'sub'  => 'TOKYO'
    ),
    array(
        'icon' => 'fa-solid fa-compass',
        'name' => 'STAND',
        'sub'  => 'GLOBAL'
    )
);

// 1. QUERY TOP JOBS (Lấy 6 việc làm từ CSDL WP Job Manager)
$args_jobs = array(
    'post_type'      => 'job_listing',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC'
);
$jobs_query = new WP_Query( $args_jobs );
$home_jobs = array();

$idx = 0;
if ( $jobs_query->have_posts() ) {
    while ( $jobs_query->have_posts() ) {
        $jobs_query->the_post();
        $jid       = get_the_ID();
        $loc       = get_post_meta( $jid, '_job_location', true );
        $types     = wp_get_post_terms( $jid, 'job_listing_type' );
        $type_name = ( ! is_wp_error( $types ) && ! empty( $types ) ) ? $types[0]->name : 'Fulltime';
        $cats      = wp_get_post_terms( $jid, 'job_listing_category' );
        $cat_name  = ( ! is_wp_error( $cats ) && ! empty( $cats ) ) ? $cats[0]->name : 'Category Name';
        $company   = get_post_meta( $jid, '_company_name', true );
        $brand     = $preset_brands[$idx % count($preset_brands)];

        $home_jobs[] = array(
            'title'    => get_the_title(),
            'date'     => 'Created: ' . get_the_date( 'M d, Y' ),
            'type'     => $type_name,
            'category' => $cat_name,
            'location' => $loc ? $loc : 'Ho Chi Minh City',
            'company'  => $company ? $company : 'Nhóm C Recruiting',
            'brand'    => $brand,
            'link'     => esc_url( home_url( '/job-detail/?job_id=' . $jid ) ),
            'bullets'  => array(
                'Be responsible for the effective operational management of the property',
                'Excellent salary bonuses & recognition activities',
                'Foreign language allowance (up to 500USD/month)'
            )
        );
        $idx++;
    }
    wp_reset_postdata();
}

// Fallback nếu CSDL chưa đủ 6 jobs: Hiển thị đúng 6 việc làm trong bản vẽ 1-home.png
if ( count( $home_jobs ) < 6 ) {
    $fallback_jobs = array(
        array(
            'title'    => 'HOTEL MANAGER',
            'date'     => 'Created: Oct 20, 2022',
            'type'     => 'Fulltime',
            'category' => 'Category Name',
            'location' => 'Ho Chi Minh City',
            'brand'    => $preset_brands[0],
            'link'     => esc_url( home_url( '/jobs/' ) ),
            'bullets'  => array(
                'Be responsible for the effective operational management of the hotel',
                'Excellent salary bonuses & recognition activities',
                'Foreign language allowance (up to 500USD/month)'
            )
        ),
        array(
            'title'    => 'GENERAL MANAGER - LEADING HOTEL CHAIN',
            'date'     => 'Created: Oct 20, 2022',
            'type'     => 'Fulltime',
            'category' => 'Category Name',
            'location' => 'Ho Chi Minh City',
            'brand'    => $preset_brands[1],
            'link'     => esc_url( home_url( '/jobs/' ) ),
            'bullets'  => array(
                'Be responsible for the effective operational management of the hotel',
                'Excellent salary bonuses & recognition activities',
                'Foreign language allowance (up to 500USD/month)'
            )
        ),
        array(
            'title'    => 'BANQUET MANAGER',
            'date'     => 'Created: Oct 20, 2022',
            'type'     => 'Fulltime',
            'category' => 'Category Name',
            'location' => 'Ho Chi Minh City',
            'brand'    => $preset_brands[2],
            'link'     => esc_url( home_url( '/jobs/' ) ),
            'bullets'  => array(
                'Be responsible for the effective operational management of the hotel',
                'Excellent salary bonuses & recognition activities',
                'Foreign language allowance (up to 500USD/month)'
            )
        ),
        array(
            'title'    => 'BELLMAN',
            'date'     => 'Created: Oct 20, 2022',
            'type'     => 'Fulltime',
            'category' => 'Category Name',
            'location' => 'Ho Chi Minh City',
            'brand'    => $preset_brands[3],
            'link'     => esc_url( home_url( '/jobs/' ) ),
            'bullets'  => array(
                'Be responsible for the effective operational management of the hotel',
                'Excellent salary bonuses & recognition activities',
                'Foreign language allowance (up to 500USD/month)'
            )
        ),
        array(
            'title'    => 'CHIEF OPERATING OFFICER HOTEL/ RESORT CHAIN',
            'date'     => 'Created: Oct 20, 2022',
            'type'     => 'Fulltime',
            'category' => 'Category Name',
            'location' => 'Ho Chi Minh City',
            'brand'    => $preset_brands[4],
            'link'     => esc_url( home_url( '/jobs/' ) ),
            'bullets'  => array(
                'Be responsible for the effective operational management of the hotel',
                'Excellent salary bonuses & recognition activities',
                'Foreign language allowance (up to 500USD/month)'
            )
        ),
        array(
            'title'    => 'LOSS PREVENTION OFFICER',
            'date'     => 'Created: Oct 20, 2022',
            'type'     => 'Fulltime',
            'category' => 'Category Name',
            'location' => 'Ho Chi Minh City',
            'brand'    => $preset_brands[5],
            'link'     => esc_url( home_url( '/jobs/' ) ),
            'bullets'  => array(
                'Be responsible for the effective operational management of the hotel',
                'Excellent salary bonuses & recognition activities',
                'Foreign language allowance (up to 500USD/month)'
            )
        ),
    );
    $home_jobs = array_merge( $home_jobs, array_slice( $fallback_jobs, count( $home_jobs ) ) );
}

// 2. 4 THUMBNAIL BLOG CHUẨN GỐC TỪ THIẾT KẾ (VUÔNG 200x200 SẮC NÉT)
$img_news_dir = $theme_uri . '/images/news';
$blog_images = array(
    $img_news_dir . '/blog-project-dev.jpg',
    $img_news_dir . '/blog-restaurant-hotel.jpg',
    $img_news_dir . '/blog-hospitality-consulting.jpg',
    $img_news_dir . '/blog-interior-design.jpg',
);

$fallback_blogs = array(
    array(
        'title'   => 'Project Development',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'link'    => esc_url( home_url( '/blog/' ) ),
        'image'   => $blog_images[0]
    ),
    array(
        'title'   => 'Restaurant & Hotel Management And Operations',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'link'    => esc_url( home_url( '/blog/' ) ),
        'image'   => $blog_images[1]
    ),
    array(
        'title'   => 'Hospitality Consulting',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'link'    => esc_url( home_url( '/blog/' ) ),
        'image'   => $blog_images[2]
    ),
    array(
        'title'   => 'Venue And Interior Design',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'link'    => esc_url( home_url( '/blog/' ) ),
        'image'   => $blog_images[3]
    ),
);

$args_blogs = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC'
);
$blog_query = new WP_Query( $args_blogs );
$home_blogs = array();
$b_idx = 0;

if ( $blog_query->have_posts() ) {
    while ( $blog_query->have_posts() ) {
        $blog_query->the_post();
        $bid = get_the_ID();
        $thumb = get_the_post_thumbnail_url( $bid, 'medium' );
        if ( ! $thumb ) {
            $thumb = $blog_images[$b_idx % count($blog_images)];
        }
        $home_blogs[] = array(
            'title'   => get_the_title(),
            'excerpt' => wp_trim_words( get_the_excerpt(), 18, '...' ),
            'link'    => get_permalink( $bid ),
            'image'   => $thumb
        );
        $b_idx++;
    }
    wp_reset_postdata();
}

if ( count( $home_blogs ) < 4 ) {
    $home_blogs = array_merge( $home_blogs, array_slice( $fallback_blogs, count( $home_blogs ) ) );
}

$cache_bust = time();
$hero_bg   = $img_home_dir . '/hero-home-bg.jpg?v=' . $cache_bust;
$career_bg = $img_home_dir . '/career-bg.jpg?v=' . $cache_bust;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Find Your Dream Jobs | Nhóm C Recruiting</title>
    
    <!-- Google Fonts & Font Awesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php wp_head(); ?>

    <!-- CSS SCOPED CHỐNG XUNG ĐỘT VÀ CHỐNG ĐÈ GIAO DIỆN -->
    <style id="nhomc-home-scoped-css">
        /* RESET CƠ BẢN */
        html, body.home-design {
            margin: 0 !important;
            padding: 0 !important;
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
            color: #222222 !important;
            background-color: #ffffff !important;
            line-height: 1.5 !important;
            -webkit-font-smoothing: antialiased !important;
            overflow-x: hidden !important;
            max-width: 100vw !important;
        }

        body.home-design *, 
        body.home-design *::before, 
        body.home-design *::after {
            box-sizing: border-box !important;
        }

        .hm-container {
            width: 100% !important;
            max-width: 1140px !important;
            margin: 0 auto !important;
            padding: 0 15px !important;
        }

        /* 1. HEADER */
        .hm-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #eaeaea !important;
            height: 78px !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 1000 !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03) !important;
        }

        body.admin-bar .hm-header {
            top: 32px !important;
        }
        @media screen and (max-width: 782px) {
            body.admin-bar .hm-header {
                top: 46px !important;
            }
        }

        .hm-header-inner {
            height: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        /* LOGO THƯƠNG HIỆU NHÓM C RECRUITING */
        .hm-logo-brand {
            display: inline-flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-decoration: none !important;
            cursor: pointer !important;
            flex-shrink: 0 !important;
        }

        .hm-logo-box {
            border: 2px solid #111111 !important;
            padding: 3px 18px !important;
            background: #ffffff !important;
            box-shadow: 2px 2px 0px #111111 !important;
            transition: all 0.2s ease !important;
        }

        .hm-logo-box:hover {
            box-shadow: 1px 1px 0px #111111 !important;
            transform: translate(1px, 1px) !important;
        }

        .hm-logo-text-main {
            font-size: 17px !important;
            font-weight: 800 !important;
            color: #111111 !important;
            letter-spacing: 3.5px !important;
            text-transform: uppercase !important;
            line-height: 1.15 !important;
            display: block !important;
        }

        .hm-logo-sub {
            font-size: 8.5px !important;
            font-weight: 700 !important;
            color: #222222 !important;
            letter-spacing: 3.2px !important;
            text-transform: uppercase !important;
            margin-top: 3px !important;
            display: block !important;
        }

        .hm-header-right {
            display: flex !important;
            align-items: center !important;
            gap: 32px !important;
        }

        .hm-nav {
            display: flex !important;
            align-items: center !important;
            gap: 28px !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .hm-nav a {
            text-decoration: none !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            letter-spacing: 0.6px !important;
            color: #222222 !important;
            text-transform: uppercase !important;
            position: relative !important;
            padding: 6px 0 !important;
            transition: color 0.2s !important;
        }

        .hm-nav a:hover,
        .hm-nav a.active {
            color: #111111 !important;
        }

        .hm-nav a.active::after {
            content: '' !important;
            position: absolute !important;
            bottom: -2px !important;
            left: 0 !important;
            width: 100% !important;
            height: 2px !important;
            background-color: #eb6723 !important;
        }

        .hm-btn-submit {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 10px 22px !important;
            background-color: #eb6723 !important;
            color: #ffffff !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            letter-spacing: 0.6px !important;
            text-decoration: none !important;
            text-transform: uppercase !important;
            border-radius: 4px !important;
            white-space: nowrap !important;
            transition: background-color 0.2s, transform 0.1s !important;
        }

        .hm-btn-submit:hover {
            background-color: #d85413 !important;
            color: #ffffff !important;
            transform: translateY(-1px) !important;
        }

        /* 2. HERO BANNER */
        .hm-hero {
            position: relative !important;
            min-height: 540px !important;
            background-size: cover !important;
            background-position: center right !important;
            background-repeat: no-repeat !important;
            display: flex !important;
            align-items: center !important;
            color: #ffffff !important;
            padding: 85px 0 !important;
        }

        .hm-hero-overlay {
            position: absolute !important;
            inset: 0 !important;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.55) 0%, rgba(0, 0, 0, 0.25) 60%, rgba(0, 0, 0, 0.15) 100%) !important;
        }

        .hm-hero-content {
            position: relative !important;
            z-index: 2 !important;
            max-width: 900px !important;
        }

        .hm-hero-title {
            font-size: 38px !important;
            font-weight: 800 !important;
            letter-spacing: 1.5px !important;
            text-transform: uppercase !important;
            margin: 0 0 16px 0 !important;
            line-height: 1.2 !important;
            color: #ffffff !important;
        }

        .hm-hero-subtitle {
            font-size: 14.5px !important;
            line-height: 1.7 !important;
            color: #f0f0f0 !important;
            max-width: 780px !important;
            margin: 0 0 35px 0 !important;
            font-weight: 400 !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4) !important;
        }

        .hm-search-form {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            max-width: 860px !important;
        }

        .hm-search-input-box {
            flex: 1.8 !important;
            background: #ffffff !important;
            border-radius: 4px !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 16px !important;
            height: 48px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15) !important;
        }

        .hm-search-input-box i,
        .hm-icon-search {
            color: #eb6723 !important;
            margin-right: 12px !important;
            font-size: 15px !important;
            flex-shrink: 0 !important;
            display: inline-block !important;
        }

        .hm-search-input-box input {
            width: 100% !important;
            border: none !important;
            outline: none !important;
            font-size: 14px !important;
            color: #333333 !important;
            font-family: inherit !important;
            background: transparent !important;
            padding: 0 !important;
        }

        .hm-search-location-box {
            flex: 1 !important;
            background: #ffffff !important;
            border-radius: 4px !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 14px !important;
            height: 48px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15) !important;
            position: relative !important;
        }

        .hm-search-location-box i.fa-location-dot,
        .hm-icon-location {
            color: #eb6723 !important;
            margin-right: 10px !important;
            font-size: 15px !important;
            flex-shrink: 0 !important;
            display: inline-block !important;
        }

        .hm-icon-chevron {
            position: absolute !important;
            right: 14px !important;
            pointer-events: none !important;
            flex-shrink: 0 !important;
        }

        .hm-search-location-box select {
            width: 100% !important;
            border: none !important;
            outline: none !important;
            font-size: 14px !important;
            color: #333333 !important;
            background: transparent !important;
            cursor: pointer !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            padding-right: 20px !important;
            font-family: inherit !important;
        }

        .hm-search-location-box .fa-chevron-down {
            position: absolute !important;
            right: 14px !important;
            color: #666666 !important;
            font-size: 11px !important;
            pointer-events: none !important;
        }

        .hm-search-submit-btn {
            padding: 0 28px !important;
            height: 48px !important;
            background-color: #eb6723 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 4px !important;
            font-size: 13.5px !important;
            font-weight: 700 !important;
            letter-spacing: 0.8px !important;
            text-transform: uppercase !important;
            cursor: pointer !important;
            transition: background-color 0.2s !important;
            white-space: nowrap !important;
            font-family: inherit !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15) !important;
        }

        .hm-search-submit-btn:hover {
            background-color: #d85413 !important;
        }

        /* 3. SECTION TOP JOBS */
        .hm-section-jobs {
            padding: 65px 0 60px 0 !important;
            background-color: #f5f6f8 !important;
        }

        .hm-section-heading {
            text-align: center !important;
            font-size: 28px !important;
            font-weight: 800 !important;
            letter-spacing: 1.5px !important;
            text-transform: uppercase !important;
            color: #111111 !important;
            margin: 0 0 40px 0 !important;
        }

        .hm-jobs-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 22px !important;
            margin-bottom: 40px !important;
        }

        .hm-job-card {
            background: #ffffff !important;
            border-radius: 4px !important;
            padding: 22px !important;
            display: flex !important;
            align-items: flex-start !important;
            gap: 20px !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
            border: 1px solid #ededed !important;
            transition: transform 0.2s, box-shadow 0.2s !important;
            cursor: pointer !important;
        }

        .hm-job-card:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
            border-color: #dcdcdc !important;
        }

        .hm-job-logo {
            width: 104px !important;
            height: 104px !important;
            min-width: 104px !important;
            border: 1px solid #e2e2e2 !important;
            border-radius: 3px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 8px !important;
            text-align: center !important;
            background: #ffffff !important;
            flex-shrink: 0 !important;
        }

        .hm-logo-vector-icon {
            font-size: 26px !important;
            color: #222222 !important;
            margin-bottom: 4px !important;
        }

        .hm-logo-vector-name {
            font-size: 9px !important;
            font-weight: 700 !important;
            color: #333333 !important;
            letter-spacing: 0.8px !important;
            text-transform: uppercase !important;
            line-height: 1.2 !important;
            display: block !important;
        }

        .hm-logo-vector-sub {
            font-size: 8px !important;
            color: #888888 !important;
            letter-spacing: 0.5px !important;
            text-transform: uppercase !important;
            display: block !important;
            margin-top: 2px !important;
        }

        .hm-job-info {
            flex: 1 !important;
            min-width: 0 !important;
        }

        .hm-job-title {
            font-size: 15.5px !important;
            font-weight: 700 !important;
            letter-spacing: 0.3px !important;
            text-transform: uppercase !important;
            margin: 0 0 4px 0 !important;
            line-height: 1.35 !important;
        }

        .hm-job-title a {
            color: #111111 !important;
            text-decoration: none !important;
            transition: color 0.2s !important;
        }

        .hm-job-title a:hover {
            color: #eb6723 !important;
        }

        .hm-job-date {
            font-size: 11.5px !important;
            color: #888888 !important;
            margin-bottom: 8px !important;
        }

        .hm-job-tags {
            display: inline-flex !important;
            align-items: center !important;
            background-color: #f1f3f5 !important;
            border-radius: 4px !important;
            padding: 4px 10px !important;
            gap: 8px !important;
            margin-bottom: 12px !important;
            width: fit-content !important;
            max-width: 100% !important;
        }

        .hm-job-tag {
            background: transparent !important;
            border: none !important;
            border-radius: 0 !important;
            padding: 0 !important;
            color: #4b5563 !important;
            font-size: 11px !important;
            font-weight: 400 !important;
            line-height: 1.2 !important;
            white-space: nowrap !important;
        }

        .hm-tag-sep {
            color: #cbd5e1 !important;
            font-size: 10px !important;
            line-height: 1 !important;
            user-select: none !important;
        }

        .hm-job-bullets {
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .hm-job-bullets li {
            font-size: 12px !important;
            color: #555555 !important;
            line-height: 1.5 !important;
            position: relative !important;
            padding-left: 14px !important;
            margin-bottom: 3px !important;
        }

        .hm-job-bullets li::before {
            content: "•" !important;
            color: #555555 !important;
            font-size: 14px !important;
            position: absolute !important;
            left: 2px !important;
            top: -1px !important;
        }

        .hm-more-jobs-wrap {
            text-align: center !important;
        }

        .hm-btn-view-more {
            display: inline-block !important;
            padding: 10px 42px !important;
            background-color: transparent !important;
            border: 1px solid #eb6723 !important;
            color: #eb6723 !important;
            font-size: 12.5px !important;
            font-weight: 700 !important;
            letter-spacing: 0.8px !important;
            text-decoration: none !important;
            text-transform: uppercase !important;
            border-radius: 3px !important;
            transition: all 0.2s !important;
        }

        .hm-btn-view-more:hover {
            background-color: #eb6723 !important;
            color: #ffffff !important;
        }

        /* 4. CAREER WITH US */
        .hm-section-career {
            position: relative !important;
            padding: 90px 0 95px 0 !important;
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            color: #ffffff !important;
            text-align: center !important;
        }

        .hm-career-overlay {
            position: absolute !important;
            inset: 0 !important;
            background: rgba(0, 0, 0, 0.45) !important;
        }

        .hm-career-content {
            position: relative !important;
            z-index: 2 !important;
            max-width: 820px !important;
            margin: 0 auto !important;
        }

        .hm-career-title {
            font-size: 30px !important;
            font-weight: 800 !important;
            letter-spacing: 1.5px !important;
            text-transform: uppercase !important;
            margin: 0 0 24px 0 !important;
            color: #ffffff !important;
        }

        .hm-career-desc {
            font-size: 14.5px !important;
            line-height: 1.8 !important;
            color: #ffffff !important;
            margin: 0 0 18px 0 !important;
            font-weight: 400 !important;
        }

        .hm-career-btn-wrap {
            margin-top: 32px !important;
        }

        .hm-btn-more-about {
            display: inline-block !important;
            padding: 10px 36px !important;
            background: rgba(0, 0, 0, 0.35) !important;
            border: 1px solid #ffffff !important;
            color: #ffffff !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            letter-spacing: 1px !important;
            text-decoration: none !important;
            text-transform: uppercase !important;
            border-radius: 3px !important;
            transition: all 0.2s !important;
        }

        .hm-btn-more-about:hover {
            background: #ffffff !important;
            color: #111111 !important;
        }

        /* 5. NEWEST BLOG ENTRIES (BỐ CỤC CHUẨN XÁC KHÔNG BỊ KHUẤT ẢNH) */
        .hm-section-blogs {
            padding: 70px 0 80px 0 !important;
            background-color: #f5f6f8 !important;
        }

        .hm-blogs-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 26px !important;
        }

        .hm-blog-card {
            background: #ffffff !important;
            border-radius: 4px !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: stretch !important;
            padding: 20px !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
            border: 1px solid #ededed !important;
            min-height: 220px !important;
            height: auto !important;
            transition: transform 0.2s, box-shadow 0.2s !important;
            box-sizing: border-box !important;
        }

        .hm-blog-card:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        }

        .hm-blog-thumb {
            width: 180px !important;
            height: 180px !important;
            min-width: 180px !important;
            max-width: 180px !important;
            flex-shrink: 0 !important;
            overflow: hidden !important;
            border-radius: 2px !important;
            background-color: #f0f0f0 !important;
            display: block !important;
            position: relative !important;
        }

        .hm-blog-thumb img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            display: block !important;
        }

        .hm-blog-body {
            padding-left: 20px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            flex: 1 !important;
            min-width: 0 !important;
        }

        .hm-blog-title {
            font-size: 15.5px !important;
            font-weight: 700 !important;
            line-height: 1.4 !important;
            margin: 0 0 8px 0 !important;
        }

        .hm-blog-title a {
            color: #111111 !important;
            text-decoration: none !important;
            transition: color 0.2s !important;
        }

        .hm-blog-title a:hover {
            color: #eb6723 !important;
        }

        .hm-blog-excerpt {
            font-size: 12px !important;
            color: #666666 !important;
            line-height: 1.55 !important;
            margin: 0 0 8px 0 !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 3 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
        }

        .hm-blog-readmore {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #eb6723 !important;
            text-decoration: none !important;
        }

        .hm-blog-readmore:hover {
            text-decoration: underline !important;
        }

        /* 6. NEWSLETTER */
        .hm-section-newsletter {
            background-color: #eb6723 !important;
            color: #ffffff !important;
            padding: 38px 0 !important;
        }

        .hm-newsletter-inner {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 30px !important;
        }

        .hm-newsletter-heading {
            font-size: 24px !important;
            font-weight: 800 !important;
            letter-spacing: 0.5px !important;
            line-height: 1.25 !important;
            color: #ffffff !important;
        }

        .hm-newsletter-form {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            flex: 1 !important;
            max-width: 620px !important;
        }

        .hm-newsletter-input-box {
            flex: 1 !important;
            background: #ffffff !important;
            border-radius: 4px !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 14px !important;
            height: 44px !important;
        }

        .hm-newsletter-input-box i,
        .hm-icon-mail {
            color: #eb6723 !important;
            margin-right: 12px !important;
            font-size: 15px !important;
            flex-shrink: 0 !important;
            display: inline-block !important;
        }

        .hm-newsletter-input-box input {
            width: 100% !important;
            border: none !important;
            outline: none !important;
            font-size: 13.5px !important;
            color: #333333 !important;
            background: transparent !important;
            padding: 0 !important;
            font-family: inherit !important;
        }

        .hm-newsletter-btn {
            height: 44px !important;
            padding: 0 30px !important;
            background: transparent !important;
            border: 1px solid #ffffff !important;
            color: #ffffff !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            letter-spacing: 0.8px !important;
            text-transform: uppercase !important;
            border-radius: 4px !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
            white-space: nowrap !important;
            font-family: inherit !important;
        }

        .hm-newsletter-btn:hover {
            background: #ffffff !important;
            color: #eb6723 !important;
        }

        /* 7. FOOTER */
        .hm-footer {
            background-color: #ffffff !important;
            padding: 45px 0 25px 0 !important;
            text-align: center !important;
        }

        .hm-footer-brand {
            margin-bottom: 22px !important;
            display: inline-flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }

        .hm-footer-nav {
            display: flex !important;
            justify-content: center !important;
            gap: 28px !important;
            list-style: none !important;
            margin: 0 0 24px 0 !important;
            padding: 0 !important;
        }

        .hm-footer-nav a {
            color: #222222 !important;
            text-decoration: none !important;
            font-size: 12.5px !important;
            font-weight: 700 !important;
            letter-spacing: 0.8px !important;
            text-transform: uppercase !important;
            transition: color 0.2s !important;
        }

        .hm-footer-nav a:hover {
            color: #eb6723 !important;
        }

        .hm-footer-socials {
            display: flex !important;
            justify-content: center !important;
            gap: 14px !important;
            margin-bottom: 25px !important;
        }

        .hm-social-icon {
            width: 34px !important;
            height: 34px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
            text-decoration: none !important;
            font-size: 15px !important;
            transition: opacity 0.2s !important;
        }

        .hm-social-icon:hover {
            opacity: 0.85 !important;
        }

        .hm-social-fb { background-color: #3b5998 !important; }
        .hm-social-gg { background-color: #ea4335 !important; }
        .hm-social-line { background-color: #00b900 !important; }
        .hm-social-tw { background-color: #1da1f2 !important; }

        .hm-footer-copyright-bar {
            background-color: #000000 !important;
            color: #888888 !important;
            padding: 12px 0 !important;
            font-size: 12px !important;
            text-align: center !important;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .hm-hero-title { font-size: 32px !important; }
            .hm-search-form { flex-wrap: wrap !important; }
            .hm-jobs-grid { grid-template-columns: 1fr !important; }
            .hm-blogs-grid { grid-template-columns: 1fr !important; }
            .hm-newsletter-inner { flex-direction: column !important; text-align: center !important; }
            .hm-newsletter-form { width: 100% !important; }
        }

        @media (max-width: 768px) {
            .hm-header { height: auto !important; padding: 12px 0 !important; }
            .hm-nav { display: none !important; }
            .hm-hero { min-height: 420px !important; padding: 50px 0 !important; }
            .hm-hero-title { font-size: 26px !important; }
            .hm-search-form { flex-direction: column !important; width: 100% !important; }
            .hm-search-input-box,
            .hm-search-location-box,
            .hm-search-submit-btn { width: 100% !important; }
            .hm-job-card { flex-direction: column !important; align-items: center !important; text-align: center !important; }
            .hm-job-tags { justify-content: center !important; }
            .hm-job-bullets li { text-align: left !important; }
            .hm-blog-card { flex-direction: column !important; height: auto !important; }
            .hm-blog-thumb { width: 100% !important; max-width: 100% !important; height: 200px !important; min-width: 100% !important; }
            .hm-blog-body { padding-left: 0 !important; margin-top: 14px !important; }
            .hm-newsletter-form { flex-direction: column !important; }
            .hm-newsletter-input-box,
            .hm-newsletter-btn { width: 100% !important; }
            .hm-footer-nav { flex-wrap: wrap !important; gap: 16px !important; }
        }
    </style>
</head>
<body <?php body_class( 'home-design' ); ?>>
<?php wp_body_open(); ?>

<!-- 1. HEADER & NAVIGATION -->
<?php get_template_part( 'template-parts/nhomc-header' ); ?>

<?php nhomc_render_page_widgets( 'nhomc-home', compact( 'hero_bg', 'career_bg', 'home_jobs', 'home_blogs' ) ); ?>
<!-- 6 & 7. UNIFIED NHOM C FOOTER -->
<?php get_template_part( 'template-parts/nhomc-footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
