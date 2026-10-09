<?php
/**
 * Template Name: All Jobs Design
 * Template Post Type: page
 *
 * Giao diện trang ALL JOBS chuẩn đồ án JobScout - Nhóm C (FIT - TDC)
 * Đã tối ưu Responsive đa thiết bị (Mobile, Tablet, Desktop, Zoom in/out) không bao giờ bị vỡ giao diện.
 */

$site_url = home_url();
$theme_img_uri = get_template_directory_uri() . '/images/alljobs';

// Lấy danh sách jobs từ CSDL nếu có
$args = array(
    'post_type'      => 'job_listing',
    'post_status'    => 'publish',
    'posts_per_page' => 24,
    'orderby'        => 'date',
    'order'          => 'DESC'
);
$jobs_query = new WP_Query($args);
$db_jobs = array();
if ($jobs_query->have_posts()) {
    while ($jobs_query->have_posts()) {
        $jobs_query->the_post();
        $jid = get_the_ID();
        $loc = get_post_meta($jid, '_job_location', true);
        $terms = wp_get_post_terms($jid, 'job_listing_type');
        $tname = (!is_wp_error($terms) && !empty($terms)) ? $terms[0]->name : 'Fulltime';
        $cat_terms = wp_get_post_terms($jid, 'job_listing_category');
        $cname = (!is_wp_error($cat_terms) && !empty($cat_terms)) ? $cat_terms[0]->name : 'Category Name';
        
        $db_jobs[] = array(
            'title' => strtoupper(get_the_title()),
            'date' => get_the_date('M d, Y'),
            'type' => $tname,
            'category' => $cname,
            'location' => $loc ? $loc : 'Ho Chi Minh City',
            'link' => get_permalink($jid)
        );
    }
    wp_reset_postdata();
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>All Jobs - Career With Us | NhomC JobScout</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php wp_head(); ?>

    <style>
        /* === RESET & CẤU TRÚC NỀN TẢNG CHỐNG TRÀN === */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        html {
            max-width: 100vw;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f7f7f7;
            color: #333333;
            -webkit-font-smoothing: antialiased;
            max-width: 100vw;
            overflow-x: hidden;
            line-height: 1.5;
        }
        img, svg {
            max-width: 100%;
            height: auto;
            display: block;
        }
        a {
            text-decoration: none;
            color: inherit;
            transition: all 0.2s ease;
        }

        /* === 1. TOP NAVBAR / HEADER === */
        .aj-header {
            background-color: #ffffff;
            height: 78px;
            width: 100%;
            border-bottom: 1px solid #eaeaea;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03);
            transition: top 0.2s ease;
        }
        body.admin-bar .aj-header {
            top: 32px;
        }
        @media screen and (max-width: 782px) {
            body.admin-bar .aj-header {
                top: 46px;
            }
        }
        .aj-header-inner {
            max-width: 1140px;
            margin: 0 auto;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: relative;
        }
        
        /* LOGO NhomC */
        .aj-logo-brand {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
            flex-shrink: 0;
        }
        .aj-logo-box {
            border: 2px solid #111111;
            padding: 4px 20px;
            background: #ffffff;
            box-shadow: 2px 2px 0px #111111;
            transition: all 0.2s ease;
        }
        .aj-logo-box:hover {
            box-shadow: 1px 1px 0px #111111;
            transform: translate(1px, 1px);
        }
        .aj-logo-text-main {
            font-size: 18px;
            font-weight: 800;
            color: #111111;
            letter-spacing: 4px;
            text-transform: uppercase;
            line-height: 1.1;
        }
        .aj-logo-sub {
            font-size: 9px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* MENU DESKTOP: NHÍCH PHẦN HOME VÀ CỤM MENU SANG PHẢI */
        .aj-nav {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
            /* Đẩy menu nhích sang bên phải về phía nút SUBMIT JOB */
            margin-left: auto;
            margin-right: 32px;
        }
        .aj-nav-item a {
            font-size: 13px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            padding: 8px 0;
            position: relative;
            display: inline-block;
            white-space: nowrap;
        }
        .aj-nav-item.active a {
            color: #222222;
        }
        .aj-nav-item.active a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0px;
            width: 100%;
            height: 2px;
            background-color: #f26522;
        }
        .aj-nav-item a:hover {
            color: #f26522;
        }

        /* Nút Submit Job */
        .aj-header-action {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .aj-btn-submit {
            background-color: #f26522;
            color: #ffffff !important;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 11px 22px;
            border-radius: 4px;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }
        .aj-btn-submit:hover {
            background-color: #d84b16;
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        /* Nút Hamburger Toggle trên Mobile */
        .aj-menu-toggle {
            display: none;
            background: transparent;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            width: 40px;
            height: 40px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            color: #222222;
            font-size: 18px;
            transition: background 0.2s ease;
        }
        .aj-menu-toggle:hover {
            background-color: #f2f2f2;
        }

        /* === MOBILE DRAWER MENU & OVERLAY === */
        .aj-mobile-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1090;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .aj-mobile-overlay.is-active {
            opacity: 1;
            visibility: visible;
        }
        .aj-mobile-drawer {
            position: fixed;
            top: 0;
            right: -290px;
            width: 280px;
            height: 100%;
            background-color: #ffffff;
            z-index: 1100;
            box-shadow: -4px 0 20px rgba(0,0,0,0.15);
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }
        .aj-mobile-drawer.is-open {
            right: 0;
        }
        .aj-drawer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
        }
        .aj-drawer-close {
            background: transparent;
            border: none;
            font-size: 20px;
            color: #555555;
            cursor: pointer;
            padding: 6px;
        }
        .aj-drawer-nav {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 30px;
        }
        .aj-drawer-nav a {
            font-size: 14px;
            font-weight: 700;
            color: #222222;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            padding: 8px 0;
            border-bottom: 1px solid #fafafa;
        }
        .aj-drawer-nav a:hover,
        .aj-drawer-nav .active a {
            color: #f26522;
        }
        .aj-drawer-submit {
            width: 100%;
            text-align: center;
            margin-top: auto;
            padding: 12px;
        }

        /* === 2. HERO BANNER: CAREER WITH US (RESPONSIVE CHUẨN) === */
        .aj-hero-banner {
            width: 100%;
            height: 356px;
            position: relative;
            background-image: url('<?php echo esc_url($theme_img_uri . "/career-banner.jpg"); ?>');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .screen-reader-text {
            border: 0;
            clip: rect(1px, 1px, 1px, 1px);
            clip-path: inset(50%);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
            word-wrap: normal !important;
        }

        /* === 3. ALL JOBS SECTION === */
        .aj-main-content {
            background-color: #f7f7f7;
            padding: 48px 0 70px 0;
            width: 100%;
        }
        .aj-container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
        }
        .aj-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .aj-section-title {
            font-size: clamp(20px, 3.5vw, 26px);
            font-weight: 800;
            color: #222222;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .aj-sort-wrapper {
            position: relative;
            flex-shrink: 0;
        }
        .aj-sort-select {
            appearance: none;
            -webkit-appearance: none;
            background-color: #ffffff;
            border: 1px solid #dcdcdc;
            border-radius: 4px;
            padding: 9px 34px 9px 16px;
            font-size: 13px;
            font-weight: 500;
            color: #444444;
            font-family: inherit;
            cursor: pointer;
            outline: none;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }
        .aj-sort-select:focus {
            border-color: #f26522;
        }
        .aj-sort-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            font-size: 11px;
            color: #666666;
        }

        /* === 4. JOBS GRID (RESPONSIVE CHỐNG VỠ TRÊN MỌI THIẾT BỊ) === */
        .aj-jobs-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            width: 100%;
        }
        .aj-job-card {
            background-color: #ffffff;
            border: 1px solid #e7e7e7;
            border-radius: 4px;
            padding: 22px;
            display: flex;
            align-items: flex-start;
            gap: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            min-width: 0; /* Giúp flexbox không bị tràn text */
        }
        .aj-job-card:hover {
            border-color: #d0d0d0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            transform: translateY(-2px);
        }

        /* Ô vuông Logo Công ty sắc nét */
        .aj-card-logo-box {
            width: 105px;
            height: 105px;
            min-width: 105px;
            border: 1px solid #e2e2e2;
            border-radius: 2px;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px;
            text-align: center;
            flex-shrink: 0;
        }
        .aj-logo-vector-icon {
            font-size: 26px;
            color: #222222;
            margin-bottom: 4px;
        }
        .aj-logo-vector-name {
            font-size: 9px;
            font-weight: 700;
            color: #333333;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        /* Thông tin Job bên phải */
        .aj-card-body {
            flex: 1;
            min-width: 0;
            overflow: hidden;
        }
        .aj-card-title {
            font-size: 15px;
            font-weight: 700;
            color: #222222;
            text-transform: uppercase;
            line-height: 1.35;
            margin-bottom: 5px;
            letter-spacing: 0.3px;
            word-wrap: break-word;
        }
        .aj-card-title a {
            color: #222222;
        }
        .aj-card-title a:hover {
            color: #f26522;
        }
        .aj-card-date {
            font-size: 12px;
            color: #888888;
            margin-bottom: 10px;
            font-weight: 400;
        }
        
        /* Pills tags */
        .aj-card-tags {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }
        .aj-tag-pill {
            background-color: #f7f7f7;
            border: 1px solid #e4e4e4;
            border-radius: 0;
            padding: 2px 10px;
            font-size: 11px;
            color: #555555;
            font-weight: 500;
            white-space: nowrap;
        }

        /* Bullet points */
        .aj-card-perks {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .aj-card-perks li {
            position: relative;
            padding-left: 14px;
            font-size: 12px;
            color: #555555;
            line-height: 1.55;
            margin-bottom: 3px;
            word-wrap: break-word;
        }
        .aj-card-perks li::before {
            content: '•';
            position: absolute;
            left: 0;
            top: 0;
            color: #333333;
            font-size: 13px;
        }

        /* === 5. LOAD MORE BUTTON === */
        .aj-load-more-wrap {
            text-align: center;
            margin-top: 45px;
        }
        .aj-btn-loadmore {
            display: inline-block;
            background-color: transparent;
            color: #f26522;
            border: 1.5px solid #f26522;
            border-radius: 3px;
            padding: 12px 38px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            cursor: pointer;
            transition: all 0.25s ease;
            font-family: inherit;
            max-width: 90%;
        }
        .aj-btn-loadmore:hover {
            background-color: #f26522;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(242, 101, 34, 0.25);
        }

        /* === 6. NEWSLETTER BANNER (ORANGE) === */
        .aj-newsletter {
            background-color: #e56322;
            padding: 34px 0;
            width: 100%;
        }
        .aj-nl-inner {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 32px;
            flex-wrap: wrap;
        }
        .aj-nl-title {
            color: #ffffff;
            font-size: 20px;
            font-weight: 600;
            line-height: 1.25;
            letter-spacing: 0.2px;
            text-align: left;
            margin: 0;
        }
        .aj-nl-form {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            max-width: 100%;
        }
        .aj-nl-input-group {
            background-color: #ffffff;
            border-radius: 0 !important;
            display: flex;
            align-items: center;
            padding: 0 16px;
            width: 440px;
            max-width: 100%;
            height: 44px;
            box-sizing: border-box;
        }
        .aj-nl-envelope-svg {
            margin-right: 12px;
            flex-shrink: 0;
            display: block;
        }
        .aj-nl-input {
            width: 100% !important;
            height: 100% !important;
            background-color: transparent !important;
            border: none !important;
            border-radius: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            font-size: 13px;
            color: #333333;
            font-family: inherit;
            outline: none !important;
            box-shadow: none !important;
        }
        .aj-nl-input::placeholder {
            color: #999999;
            font-size: 13px;
        }
        .aj-btn-subscribe {
            height: 44px !important;
            background-color: transparent !important;
            border: 1px solid #ffffff !important;
            border-radius: 0 !important;
            color: #ffffff !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.6px;
            padding: 0 28px !important;
            margin: 0 !important;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
            white-space: nowrap;
            box-shadow: none !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .aj-btn-subscribe:hover {
            background-color: #ffffff !important;
            color: #e56322 !important;
        }

        /* === 7. FOOTER === */
        .aj-footer {
            background-color: #ffffff;
            padding: 48px 0 35px 0;
            text-align: center;
            width: 100%;
        }
        .aj-footer-inner {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* FOOTER BRANDING NhomC */
        .aj-footer-brand {
            margin-bottom: 24px;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
        }
        .aj-footer-brand-box {
            border: 1.5px solid #111111;
            padding: 3px 20px;
            display: inline-block;
        }
        .aj-footer-brand-title {
            font-size: 17px;
            font-weight: 800;
            color: #111111;
            letter-spacing: 4px;
            text-transform: uppercase;
        }
        .aj-footer-brand-sub {
            font-size: 9px;
            font-weight: 600;
            color: #555555;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .aj-footer-nav {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 28px;
            list-style: none;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        .aj-footer-nav a {
            font-size: 13px;
            font-weight: 700;
            color: #222222;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .aj-footer-nav a:hover {
            color: #f26522;
        }
        .aj-social-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }
        .aj-social-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 15px;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }
        .aj-social-btn:hover {
            transform: scale(1.08);
            opacity: 0.9;
        }
        .aj-social-facebook { background-color: #3b5998; }
        .aj-social-google { background-color: #ea4335; }
        .aj-social-line { background-color: #00c300; }
        .aj-social-twitter { background-color: #1da1f2; }

        /* Bottom copyright bar */
        .aj-copyright-bar {
            background-color: #111111;
            padding: 15px 20px;
            text-align: center;
            color: #888888;
            font-size: 11.5px;
            letter-spacing: 0.6px;
            word-wrap: break-word;
        }
        .aj-copyright-bar a {
            color: #aaaaaa;
        }
        .aj-copyright-bar a:hover {
            color: #f26522;
        }

        /* =======================================================
           HỆ THỐNG RESPONSIVE TOÀN DIỆN (CHỐNG VỠ TRÊN MỌI MÀN HÌNH)
           ======================================================= */
        
        /* 1. Màn hình Tablet & Laptop nhỏ (<= 991px) */
        @media screen and (max-width: 991px) {
            .aj-nav {
                display: none; /* Ẩn menu ngang, thay thế bằng Hamburger */
            }
            .aj-menu-toggle {
                display: flex; /* Hiện nút Hamburger */
            }
            .aj-jobs-grid {
                grid-template-columns: 1fr; /* 1 cột cho máy tính bảng */
                gap: 20px;
            }
            .aj-hero-banner {
                height: 280px;
            }
        }

        /* 2. Màn hình Điện thoại di động (<= 768px) */
        @media screen and (max-width: 768px) {
            .aj-header {
                height: 70px;
            }
            .aj-header-inner {
                padding: 0 16px;
            }
            .aj-logo-text-main {
                font-size: 16px;
                letter-spacing: 3px;
            }
            .aj-logo-box {
                padding: 3px 14px;
            }
            .aj-logo-sub {
                font-size: 8px;
                letter-spacing: 2.5px;
            }
            .aj-btn-submit {
                display: none; /* Trên mobile nút Submit gom vào menu Drawer */
            }
            .aj-hero-banner {
                height: 210px;
            }
            .aj-main-content {
                padding: 35px 0 50px 0;
            }
            .aj-container {
                padding: 0 15px;
            }
            .aj-nl-inner {
                flex-direction: column;
                text-align: center;
                gap: 18px;
            }
            .aj-nl-title {
                text-align: center;
                font-size: 19px;
            }
            .aj-nl-form {
                width: 100%;
                flex-direction: column;
                gap: 12px;
            }
            .aj-nl-input-group,
            .aj-btn-subscribe {
                width: 100%;
                max-width: 360px;
            }
            .aj-btn-subscribe {
                margin-left: 0;
            }
            .aj-footer-nav {
                gap: 14px 20px;
            }
        }

        /* 3. Màn hình Điện thoại nhỏ (<= 540px) */
        @media screen and (max-width: 540px) {
            .aj-job-card {
                padding: 16px;
                gap: 14px;
            }
            .aj-card-logo-box {
                width: 78px;
                height: 78px;
                min-width: 78px;
                padding: 6px;
            }
            .aj-logo-vector-icon {
                font-size: 20px;
            }
            .aj-logo-vector-name {
                font-size: 8px;
            }
            .aj-card-title {
                font-size: 13.5px;
            }
            .aj-card-date {
                font-size: 11px;
                margin-bottom: 8px;
            }
            .aj-tag-pill {
                padding: 2px 8px;
                font-size: 10px;
            }
            .aj-card-perks li {
                font-size: 11.5px;
                line-height: 1.5;
            }
            .aj-btn-loadmore {
                padding: 10px 28px;
                font-size: 12px;
            }
        }

        /* 4. Màn hình Điện thoại cực nhỏ (<= 360px) */
        @media screen and (max-width: 360px) {
            .aj-job-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .aj-card-tags {
                justify-content: center;
            }
            .aj-card-perks {
                text-align: left;
            }
        }
    </style>
</head>
<body <?php body_class('aj-custom-page'); ?>>

<!-- 1. TOP HEADER -->
<header class="aj-header">
    <div class="aj-header-inner">
        <!-- Logo thương hiệu NhomC -->
        <a href="<?php echo esc_url($site_url); ?>" class="aj-logo-brand" title="Trang chủ JobScout - NhomC">
            <div class="aj-logo-box">
                <span class="aj-logo-text-main">NHOM C</span>
            </div>
            <span class="aj-logo-sub">RECRUITING</span>
        </a>

        <!-- Menu điều hướng Desktop: Nhích sang bên phải -->
        <ul class="aj-nav">
            <li class="aj-nav-item"><a href="<?php echo esc_url($site_url); ?>/">HOME</a></li>
            <li class="aj-nav-item active"><a href="<?php echo esc_url($site_url); ?>/jobs/">JOBS</a></li>
            <li class="aj-nav-item"><a href="<?php echo esc_url($site_url); ?>/news/">NEWS</a></li>
            <li class="aj-nav-item"><a href="<?php echo esc_url($site_url); ?>/about-us/">ABOUT</a></li>
            <li class="aj-nav-item"><a href="<?php echo esc_url($site_url); ?>/contact-us/">CONTACT</a></li>
        </ul>

        <!-- Action bên phải: Nút Submit Job + Nút Hamburger Mobile -->
        <div class="aj-header-action">
            <a href="<?php echo esc_url($site_url); ?>/post-a-job/" class="aj-btn-submit">SUBMIT JOB</a>
            <button class="aj-menu-toggle" id="ajMobileToggle" aria-label="Mở menu di động">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </div>
</header>

<!-- MOBILE MENU DRAWER & OVERLAY -->
<div class="aj-mobile-overlay" id="ajMobileOverlay"></div>
<aside class="aj-mobile-drawer" id="ajMobileDrawer">
    <div class="aj-drawer-header">
        <div class="aj-logo-brand">
            <div class="aj-logo-box" style="padding: 2px 14px;">
                <span class="aj-logo-text-main" style="font-size: 15px;">NHOM C</span>
            </div>
            <span class="aj-logo-sub" style="font-size: 7.5px;">RECRUITING</span>
        </div>
        <button class="aj-drawer-close" id="ajDrawerClose" aria-label="Đóng menu">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <ul class="aj-drawer-nav">
        <li><a href="<?php echo esc_url($site_url); ?>/">HOME</a></li>
        <li class="active"><a href="<?php echo esc_url($site_url); ?>/jobs/">JOBS</a></li>
        <li><a href="<?php echo esc_url($site_url); ?>/news/">NEWS</a></li>
        <li><a href="<?php echo esc_url($site_url); ?>/about-us/">ABOUT</a></li>
        <li><a href="<?php echo esc_url($site_url); ?>/contact-us/">CONTACT</a></li>
    </ul>
    <div class="aj-drawer-submit">
        <a href="<?php echo esc_url($site_url); ?>/post-a-job/" class="aj-btn-submit" style="display: block; width: 100%;">SUBMIT JOB</a>
    </div>
</aside>

<!-- 2. HERO BANNER: CAREER WITH US -->
<section class="aj-hero-banner" role="banner">
    <h1 class="screen-reader-text">CAREER WITH US</h1>
</section>

<!-- 3. ALL JOBS MAIN CONTENT -->
<main class="aj-main-content">
    <div class="aj-container">
        <!-- Section Header -->
        <div class="aj-section-header">
            <h2 class="aj-section-title">ALL JOBS</h2>
            <div class="aj-sort-wrapper">
                <select class="aj-sort-select" id="jobSortSelect">
                    <option value="latest">Latest Jobs</option>
                    <option value="oldest">Oldest Jobs</option>
                    <option value="alpha">A to Z</option>
                </select>
                <i class="fa-solid fa-chevron-down aj-sort-icon"></i>
            </div>
        </div>

        <!-- 4. JOBS GRID (12 CARDS CO GIÃN TỰ ĐỘNG CHỐNG VỠ LAYOUT) -->
        <div class="aj-jobs-grid" id="jobsGrid">
            <?php
            // Định nghĩa 6 biểu tượng logo sắc nét
            $preset_brands = array(
                array(
                    'icon' => 'fa-solid fa-hotel',
                    'name' => 'THE SODOH',
                    'sub' => 'KYOTO',
                    'default_title' => 'HOTEL MANAGER',
                    'date' => 'Oct 20, 2022'
                ),
                array(
                    'icon' => 'fa-solid fa-tree',
                    'name' => 'FORTUNE',
                    'sub' => 'GARDEN',
                    'default_title' => 'GENERAL MANAGER - LEADING HOTEL CHAIN',
                    'date' => 'Oct 28, 2022'
                ),
                array(
                    'icon' => 'fa-solid fa-champagne-glasses',
                    'name' => 'BANQUET',
                    'sub' => 'EVENTS',
                    'default_title' => 'BANQUET MANAGER',
                    'date' => 'Oct 20, 2022'
                ),
                array(
                    'icon' => 'fa-solid fa-bell-concierge',
                    'name' => 'SEVEN',
                    'sub' => 'HOUSE',
                    'default_title' => 'BELLMAN',
                    'date' => 'Oct 28, 2022'
                ),
                array(
                    'icon' => 'fa-solid fa-utensils',
                    'name' => 'PHO THIN',
                    'sub' => 'TOKYO',
                    'default_title' => 'CHIEF OPERATING OFFICER HOTEL/ RESORT CHAIN',
                    'date' => 'Oct 20, 2022'
                ),
                array(
                    'icon' => 'fa-solid fa-compass',
                    'name' => 'STAND',
                    'sub' => 'GLOBAL',
                    'default_title' => 'LOSS PREVENTION OFFICER',
                    'date' => 'Oct 28, 2022'
                )
            );

            // Tạo danh sách 12 card
            $total_display = 12;
            for ($i = 0; $i < $total_display; $i++) {
                $brand = $preset_brands[$i % 6];
                
                $title = $brand['default_title'];
                $date = $brand['date'];
                $type = 'Fulltime';
                $category = 'Category Name';
                $location = 'Ho Chi Minh City';
                $link = home_url('/jobs/');

                // Lấy thông tin từ database nếu có
                if (isset($db_jobs[$i])) {
                    $title = $db_jobs[$i]['title'];
                    $location = $db_jobs[$i]['location'];
                    $link = $db_jobs[$i]['link'];
                    if (!empty($db_jobs[$i]['type'])) $type = $db_jobs[$i]['type'];
                    if (!empty($db_jobs[$i]['category'])) $category = $db_jobs[$i]['category'];
                }
            ?>
                <article class="aj-job-card" data-title="<?php echo esc_attr($title); ?>" data-idx="<?php echo $i; ?>">
                    <div class="aj-card-logo-box">
                        <i class="<?php echo esc_attr($brand['icon']); ?> aj-logo-vector-icon"></i>
                        <span class="aj-logo-vector-name"><?php echo esc_html($brand['name']); ?></span>
                        <span style="font-size: 8px; color: #888; letter-spacing: 0.5px;"><?php echo esc_html($brand['sub']); ?></span>
                    </div>

                    <div class="aj-card-body">
                        <h3 class="aj-card-title">
                            <a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a>
                        </h3>
                        <p class="aj-card-date">Created: <?php echo esc_html($date); ?></p>
                        <div class="aj-card-tags">
                            <span class="aj-tag-pill"><?php echo esc_html($type); ?></span>
                            <span class="aj-tag-pill"><?php echo esc_html($category); ?></span>
                            <span class="aj-tag-pill"><?php echo esc_html($location); ?></span>
                        </div>
                        <ul class="aj-card-perks">
                            <li>Be responsible for the effective operational management of the hotel</li>
                            <li>Excellent salary bonuses &amp; recognition activities</li>
                            <li>Foreign language allowance (up to 500USD/month)</li>
                        </ul>
                    </div>
                </article>
            <?php } ?>
        </div>

        <!-- 5. LOAD MORE BUTTON -->
        <div class="aj-load-more-wrap">
            <button class="aj-btn-loadmore" id="btnLoadMore">LOAD MORE JOBS</button>
        </div>
    </div>
</main>

<!-- 6. NEWSLETTER BANNER -->
<section class="aj-newsletter">
    <div class="aj-nl-inner">
        <h3 class="aj-nl-title">Subscribe To<br>Our Newsletter</h3>
        <form class="aj-nl-form" onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã đăng ký nhận bản tin tuyển dụng NhomC!');">
            <div class="aj-nl-input-group">
                <svg width="20" height="15" viewBox="0 0 22 17" fill="none" xmlns="http://www.w3.org/2000/svg" class="aj-nl-envelope-svg">
                    <rect x="0.75" y="0.75" width="20.5" height="15.5" stroke="#e56322" stroke-width="1.5" rx="0"/>
                    <path d="M1.5 1.5L11 9L20.5 1.5" stroke="#e56322" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="email" class="aj-nl-input" placeholder="Input your email address" required>
            </div>
            <button type="submit" class="aj-btn-subscribe">SUBSCRIBE</button>
        </form>
    </div>
</section>

<!-- 7. FOOTER -->
<footer class="aj-footer">
    <div class="aj-footer-inner">
        <!-- Logo NhomC Chân trang -->
        <div class="aj-footer-brand">
            <div class="aj-footer-brand-box">
                <span class="aj-footer-brand-title">NHOM C</span>
            </div>
            <span class="aj-footer-brand-sub">CAREER &amp; RECRUITING PLATFORM</span>
        </div>

        <!-- Menu Footer -->
        <ul class="aj-footer-nav">
            <li><a href="<?php echo esc_url($site_url); ?>/jobs/">JOBS</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/company/plan-do-see-global-pds/">COMPANIES</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/blog/">BLOG</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/about-us/">ABOUT</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/contact-us/">CONTACT</a></li>
        </ul>

        <!-- 4 Icon Mạng Xã Hội Tròn -->
        <div class="aj-social-icons">
            <a href="https://facebook.com" target="_blank" class="aj-social-btn aj-social-facebook" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://google.com" target="_blank" class="aj-social-btn aj-social-google" title="Google"><i class="fa-brands fa-google"></i></a>
            <a href="https://line.me" target="_blank" class="aj-social-btn aj-social-line" title="LINE"><i class="fa-brands fa-line"></i></a>
            <a href="https://twitter.com" target="_blank" class="aj-social-btn aj-social-twitter" title="Twitter"><i class="fa-brands fa-twitter"></i></a>
        </div>
    </div>
</footer>

<!-- 8. COPYRIGHT BOTTOM BAR -->
<div class="aj-copyright-bar">
    &copy; 2026 Nhom C - FIT TDC. All Rights Reserved. JobScout CMS Platform.
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Mobile Menu Drawer logic
    const mobileToggle = document.getElementById('ajMobileToggle');
    const drawerClose = document.getElementById('ajDrawerClose');
    const mobileDrawer = document.getElementById('ajMobileDrawer');
    const mobileOverlay = document.getElementById('ajMobileOverlay');

    function openDrawer() {
        if (mobileDrawer) mobileDrawer.classList.add('is-open');
        if (mobileOverlay) mobileOverlay.classList.add('is-active');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        if (mobileDrawer) mobileDrawer.classList.remove('is-open');
        if (mobileOverlay) mobileOverlay.classList.remove('is-active');
        document.body.style.overflow = '';
    }

    if (mobileToggle) mobileToggle.addEventListener('click', openDrawer);
    if (drawerClose) drawerClose.addEventListener('click', closeDrawer);
    if (mobileOverlay) mobileOverlay.addEventListener('click', closeDrawer);

    // 2. Sắp xếp jobs theo dropdown
    const sortSelect = document.getElementById('jobSortSelect');
    const jobsGrid = document.getElementById('jobsGrid');
    if (sortSelect && jobsGrid) {
        sortSelect.addEventListener('change', function() {
            const cards = Array.from(jobsGrid.querySelectorAll('.aj-job-card'));
            if (this.value === 'alpha') {
                cards.sort((a, b) => a.getAttribute('data-title').localeCompare(b.getAttribute('data-title')));
            } else if (this.value === 'oldest') {
                cards.reverse();
            } else {
                cards.sort((a, b) => parseInt(a.getAttribute('data-idx')) - parseInt(b.getAttribute('data-idx')));
            }
            cards.forEach(card => jobsGrid.appendChild(card));
        });
    }

    // 3. Hiệu ứng nút Load More
    const btnLoadMore = document.getElementById('btnLoadMore');
    if (btnLoadMore) {
        btnLoadMore.addEventListener('click', function() {
            this.textContent = 'LOADING...';
            setTimeout(() => {
                this.textContent = 'NO MORE JOBS';
                this.style.opacity = '0.6';
                this.style.cursor = 'default';
                this.disabled = true;
            }, 600);
        });
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>
