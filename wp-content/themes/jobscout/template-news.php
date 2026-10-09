<?php
/**
 * Template Name: News Design
 * Template Post Type: page, post
 *
 * Giao diện trang TIN TỨC (NEWS) chuẩn đồ án JobScout - Nhóm C (FIT - TDC)
 * Thiết kế chính xác 100% theo bản vẽ thiết kế 3-news.png
 * Đầy đủ Responsive đa thiết bị, giữ trọn vẹn bố cục và phong cách nhận diện NhomC.
 */

$site_url = home_url();
$theme_uri = get_template_directory_uri();
$banner_img = $theme_uri . '/images/news/news-hero-banner.jpg';
$news_img_dir = $theme_uri . '/images/news/';

// 8 tin tức chuẩn như trong thiết kế 3-news.png
$default_news = [
    [
        'title'   => 'Project Development',
        'slug'    => 'project-development',
        'image'   => $news_img_dir . 'blog-project-dev.jpg',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    ],
    [
        'title'   => 'Restaurant & Hotel Management And Operations',
        'slug'    => 'restaurant-hotel-management-and-operations',
        'image'   => $news_img_dir . 'blog-restaurant-hotel.jpg',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut .',
    ],
    [
        'title'   => 'Hospitality Consulting',
        'slug'    => 'hospitality-consulting',
        'image'   => $news_img_dir . 'blog-hospitality-consulting.jpg',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    ],
    [
        'title'   => 'Venue And Interior Design',
        'slug'    => 'venue-and-interior-design',
        'image'   => $news_img_dir . 'blog-interior-design.jpg',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut .',
    ],
    [
        'title'   => 'Project Development',
        'slug'    => 'project-development-2',
        'image'   => $news_img_dir . 'blog-project-dev.jpg',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    ],
    [
        'title'   => 'Restaurant & Hotel Management And Operations',
        'slug'    => 'restaurant-hotel-management-and-operations-2',
        'image'   => $news_img_dir . 'blog-restaurant-hotel.jpg',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut .',
    ],
    [
        'title'   => 'Hospitality Consulting',
        'slug'    => 'hospitality-consulting-2',
        'image'   => $news_img_dir . 'blog-hospitality-consulting.jpg',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    ],
    [
        'title'   => 'Venue And Interior Design',
        'slug'    => 'venue-and-interior-design-2',
        'image'   => $news_img_dir . 'blog-interior-design.jpg',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut .',
    ],
];

// Lấy link chi tiết bài viết từ database nếu có bài viết tương ứng
$news_items = [];
foreach ($default_news as $idx => $item) {
    // Tìm post trong WP theo slug gốc
    $base_slug = preg_replace('/-\d+$/', '', $item['slug']);
    $wp_post = get_page_by_path($base_slug, OBJECT, 'post');
    if (!$wp_post) {
        $wp_post = get_page_by_path($item['slug'], OBJECT, 'post');
    }
    
    $detail_link = $wp_post ? get_permalink($wp_post->ID) : esc_url($site_url . '/news-detail/?post=' . urlencode($item['slug']));
    
    $item['link'] = $detail_link;
    $news_items[] = $item;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>News &amp; Blog | NhomC JobScout</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php wp_head(); ?>

    <style>
        /* === RESET & CẤU TRÚC NỀN TẢNG === */
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
            background-color: #f2f2f2;
            color: #222222;
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

        .news-sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* === 1. TOP NAVBAR / HEADER === */
        .news-header {
            background-color: #ffffff;
            height: 80px;
            width: 100%;
            border-bottom: 1px solid #eaeaea;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03);
            transition: top 0.2s ease;
        }
        body.admin-bar .news-header {
            top: 32px;
        }
        @media screen and (max-width: 782px) {
            body.admin-bar .news-header {
                top: 46px;
            }
        }
        .news-header-inner {
            max-width: 1280px;
            margin: 0 auto;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: relative;
        }

        /* LOGO NhomC */
        .news-logo-brand {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
            flex-shrink: 0;
        }
        .news-logo-box {
            border: 2px solid #111111;
            padding: 3px 22px;
            background: #ffffff;
            box-shadow: 2px 2px 0px #111111;
            transition: all 0.2s ease;
        }
        .news-logo-box:hover {
            box-shadow: 1px 1px 0px #111111;
            transform: translate(1px, 1px);
        }
        .news-logo-text-main {
            font-size: 18px;
            font-weight: 800;
            color: #111111;
            letter-spacing: 4px;
            text-transform: uppercase;
            line-height: 1.15;
        }
        .news-logo-sub {
            font-size: 8.5px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* Header Right */
        .news-header-right {
            display: flex;
            align-items: center;
            gap: 36px;
        }

        /* MENU DESKTOP */
        .news-nav {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 32px;
            margin: 0;
            padding: 0;
        }
        .news-nav li {
            position: relative;
            display: flex;
            align-items: center;
            height: 80px;
        }
        .news-nav a {
            font-size: 13px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 6px 2px;
            display: inline-block;
            position: relative;
        }
        .news-nav a:hover {
            color: #ea751e;
        }
        /* Active item: NEWS có gạch chân cam chuẩn ảnh 3-news.png */
        .news-nav li.active a {
            color: #222222;
        }
        .news-nav li.active a::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #ea751e;
        }

        /* Nút SUBMIT JOB cam */
        .news-btn-submit-job {
            background-color: #ea751e;
            color: #ffffff !important;
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 10px 22px;
            border-radius: 3px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            box-shadow: 0 2px 6px rgba(234, 117, 30, 0.25);
            flex-shrink: 0;
        }
        .news-btn-submit-job:hover {
            background-color: #d66412;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(234, 117, 30, 0.35);
        }

        /* Nút Mobile Hamburger */
        .news-mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 22px;
            color: #111111;
            cursor: pointer;
            padding: 8px;
        }

        /* Mobile Drawer */
        .news-mobile-drawer {
            position: fixed;
            top: 0;
            right: -300px;
            width: 280px;
            height: 100vh;
            background-color: #ffffff;
            box-shadow: -4px 0 20px rgba(0,0,0,0.15);
            z-index: 2000;
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            padding: 24px;
        }
        .news-mobile-drawer.is-open {
            right: 0;
        }
        .news-drawer-close {
            align-self: flex-end;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333333;
            margin-bottom: 24px;
        }
        .news-mobile-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .news-mobile-nav a {
            font-size: 15px;
            font-weight: 700;
            color: #222222;
            display: block;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .news-mobile-nav li.active a {
            color: #ea751e;
        }
        .news-mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 1999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .news-mobile-overlay.is-active {
            opacity: 1;
            pointer-events: auto;
        }

        /* === 2. HERO BANNER: PDS NEWS === */
        .news-hero {
            width: 100%;
            height: 360px;
            background-image: url('<?php echo esc_url($banner_img); ?>');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* === 3. MAIN SECTION: NEWEST BLOG ENTRIES === */
        .news-main-section {
            background-color: #f2f2f2;
            padding: 60px 20px 80px 20px;
            width: 100%;
        }
        .news-main-inner {
            max-width: 1050px;
            margin: 0 auto;
        }
        .news-main-heading {
            font-size: 28px;
            font-weight: 800;
            color: #1a1a1a;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 48px;
        }

        /* GRID 2 CỘT */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }

        /* CARD BÀI VIẾT */
        .news-card {
            background-color: #ffffff;
            display: flex;
            flex-direction: row;
            padding: 20px;
            border-radius: 2px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            min-height: 240px;
        }
        .news-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        /* Ảnh card 200x200 */
        .news-card-img-wrap {
            width: 200px;
            height: 200px;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 1px;
            background-color: #eee;
        }
        .news-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }
        .news-card:hover .news-card-img {
            transform: scale(1.04);
        }

        /* Nội dung bên phải card */
        .news-card-content {
            padding-left: 22px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            flex: 1;
        }
        .news-card-title {
            font-size: 17px;
            font-weight: 700;
            color: #111111;
            line-height: 1.35;
            margin-bottom: 12px;
            transition: color 0.2s ease;
        }
        .news-card-title a {
            color: inherit;
        }
        .news-card-title a:hover {
            color: #ea751e;
        }
        .news-card-excerpt {
            font-size: 13px;
            color: #666666;
            line-height: 1.55;
            margin-bottom: 16px;
            flex-grow: 1;
        }
        .news-card-readmore {
            font-size: 13.5px;
            font-weight: 600;
            color: #ea751e;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
            margin-top: auto;
        }
        .news-card-readmore:hover {
            color: #c95c0c;
            transform: translateX(3px);
        }

        /* === 4. SUBSCRIBE TO OUR NEWSLETTER === */
        .news-newsletter {
            background-color: #ea751e;
            padding: 30px 20px;
            width: 100%;
        }
        .news-nl-inner {
            max-width: 920px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 28px;
        }
        .news-nl-title {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.25;
            letter-spacing: 0.3px;
            white-space: nowrap;
            flex-shrink: 0;
            margin: 0;
        }
        .news-nl-form {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: 1;
            max-width: 700px;
        }
        .news-nl-input-group {
            position: relative;
            background: #ffffff !important;
            border-radius: 0 !important;
            border: none !important;
            box-shadow: none !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 16px !important;
            height: 52px !important;
            flex: 1 !important;
            min-width: 260px !important;
            box-sizing: border-box !important;
        }
        .news-nl-input-icon {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 12px !important;
            flex-shrink: 0 !important;
            color: #ea751e !important;
        }
        .news-nl-input,
        input.news-nl-input[type="email"],
        .news-nl-input-group input[type="email"] {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            background-color: transparent !important;
            border-radius: 0 !important;
            padding: 0 0 0 4px !important;
            margin: 0 !important;
            height: 100% !important;
            line-height: 52px !important;
            font-size: 14px !important;
            font-family: inherit !important;
            color: #333333 !important;
            width: 100% !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
        }
        .news-nl-input:focus,
        input.news-nl-input[type="email"]:focus,
        .news-nl-input-group input[type="email"]:focus {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }
        .news-nl-input::placeholder {
            color: #999999 !important;
            font-size: 14px !important;
        }
        .news-btn-subscribe {
            background-color: transparent;
            color: #ffffff;
            border: 1px solid #ffffff;
            padding: 0 28px;
            height: 52px;
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            border-radius: 0;
            cursor: pointer;
            transition: all 0.25s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .news-btn-subscribe:hover {
            background-color: #ffffff;
            color: #ea751e;
        }

        /* === 5. FOOTER NHOM C === */
        .news-footer {
            background-color: #ffffff;
            padding: 50px 20px 40px 20px;
            width: 100%;
            border-top: 1px solid #eeeeee;
        }
        .news-footer-inner {
            max-width: 1050px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
        }

        /* Brand Footer */
        .news-footer-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .news-footer-brand-box {
            border: 2px solid #111111;
            padding: 4px 28px;
            background: #ffffff;
            box-shadow: 2px 2px 0px #111111;
        }
        .news-footer-brand-title {
            font-size: 19px;
            font-weight: 800;
            color: #111111;
            letter-spacing: 4px;
            text-transform: uppercase;
        }
        .news-footer-brand-sub {
            font-size: 9px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* Nav Footer */
        .news-footer-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 32px;
            list-style: none;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
        }
        .news-footer-nav a {
            font-size: 13px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }
        .news-footer-nav a:hover {
            color: #ea751e;
        }

        /* 4 Icon Mạng Xã Hội Tròn */
        .news-social-icons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }
        .news-social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 16px;
            transition: transform 0.2s ease, opacity 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .news-social-btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }
        .news-social-facebook {
            background-color: #3b5998;
        }
        .news-social-google {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
        }
        .news-social-line {
            background-color: #00c300;
        }
        .news-social-twitter {
            background-color: #1da1f2;
        }

        /* Bottom Copyright Bar */
        .news-copyright-bar {
            background-color: #000000;
            color: #888888;
            font-size: 12px;
            text-align: center;
            padding: 16px 20px;
            letter-spacing: 0.5px;
        }

        /* === RESPONSIVE BREAKPOINTS === */
        @media screen and (max-width: 992px) {
            .news-nav {
                display: none;
            }
            .news-btn-submit-job {
                display: none;
            }
            .news-mobile-toggle {
                display: block;
            }
            .news-grid {
                grid-template-columns: 1fr;
            }
            .news-card {
                max-width: 580px;
                margin: 0 auto;
                width: 100%;
            }
        }

        @media screen and (max-width: 768px) {
            .news-nl-inner {
                flex-direction: column;
                text-align: center;
                gap: 18px;
            }
            .news-nl-form {
                flex-direction: column;
                width: 100%;
                gap: 14px;
            }
            .news-nl-input-group {
                width: 100%;
            }
            .news-btn-subscribe {
                width: 100%;
            }
        }

        @media screen and (max-width: 600px) {
            .news-hero {
                height: 220px;
            }
            .news-main-heading {
                font-size: 22px;
            }
            .news-card {
                flex-direction: column;
                align-items: center;
                padding: 16px;
                min-height: auto;
            }
            .news-card-img-wrap {
                width: 100%;
                height: 180px;
            }
            .news-card-content {
                padding-left: 0;
                padding-top: 14px;
                width: 100%;
            }
            .news-footer-nav {
                gap: 18px;
            }
        }
    </style>
</head>
<body <?php body_class('nhomc-news-page'); ?>>

<!-- 1. HEADER / NAVBAR -->
<header class="news-header">
    <div class="news-header-inner">
        
        <!-- Logo Nhom C -->
        <a href="<?php echo esc_url($site_url); ?>" class="news-logo-brand">
            <div class="news-logo-box">
                <span class="news-logo-text-main">NHOM C</span>
            </div>
            <span class="news-logo-sub">CAREER &amp; RECRUITING PLATFORM</span>
        </a>

        <!-- Header Right: Nav Desktop & Submit Job -->
        <div class="news-header-right">
            <nav>
                <ul class="news-nav">
                    <li><a href="<?php echo esc_url($site_url); ?>">HOME</a></li>
                    <li><a href="<?php echo esc_url($site_url); ?>/jobs/">JOBS</a></li>
                    <li class="active"><a href="<?php echo esc_url($site_url); ?>/news/">NEWS</a></li>
                    <li><a href="<?php echo esc_url($site_url); ?>/about-us/">ABOUT</a></li>
                    <li><a href="<?php echo esc_url($site_url); ?>/contact-us/">CONTACT</a></li>
                </ul>
            </nav>

            <a href="<?php echo esc_url($site_url); ?>/post-a-job/" class="news-btn-submit-job">SUBMIT JOB</a>
        </div>

        <!-- Mobile Toggle Button -->
        <button class="news-mobile-toggle" id="newsMobileToggle" aria-label="Toggle Navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</header>

<!-- Mobile Navigation Drawer -->
<div class="news-mobile-overlay" id="newsMobileOverlay"></div>
<aside class="news-mobile-drawer" id="newsMobileDrawer">
    <button class="news-drawer-close" id="newsDrawerClose" aria-label="Close Navigation Menu">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <ul class="news-mobile-nav">
        <li><a href="<?php echo esc_url($site_url); ?>">HOME</a></li>
        <li><a href="<?php echo esc_url($site_url); ?>/jobs/">JOBS</a></li>
        <li class="active"><a href="<?php echo esc_url($site_url); ?>/news/">NEWS</a></li>
        <li><a href="<?php echo esc_url($site_url); ?>/about-us/">ABOUT</a></li>
        <li><a href="<?php echo esc_url($site_url); ?>/contact-us/">CONTACT</a></li>
    </ul>
    <div style="margin-top: 30px;">
        <a href="<?php echo esc_url($site_url); ?>/post-a-job/" class="news-btn-submit-job" style="display: flex; width: 100%; text-align: center;">SUBMIT JOB</a>
    </div>
</aside>

<!-- 2. HERO BANNER: PDS NEWS (Hình ảnh gốc chứa sẵn tiêu đề PDS NEWS sắc nét) -->
<section class="news-hero">
    <h1 class="news-sr-only">PDS NEWS</h1>
</section>

<!-- 3. MAIN SECTION: NEWEST BLOG ENTRIES -->
<main class="news-main-section">
    <div class="news-main-inner">
        <h2 class="news-main-heading">NEWEST BLOG ENTRIES</h2>

        <div class="news-grid">
            <?php foreach ($news_items as $post_item): ?>
            <article class="news-card">
                <div class="news-card-img-wrap">
                    <a href="<?php echo esc_url($post_item['link']); ?>">
                        <img src="<?php echo esc_url($post_item['image']); ?>" alt="<?php echo esc_attr($post_item['title']); ?>" class="news-card-img" loading="lazy">
                    </a>
                </div>
                <div class="news-card-content">
                    <h3 class="news-card-title">
                        <a href="<?php echo esc_url($post_item['link']); ?>">
                            <?php echo esc_html($post_item['title']); ?>
                        </a>
                    </h3>
                    <p class="news-card-excerpt">
                        <?php echo esc_html($post_item['excerpt']); ?>
                    </p>
                    <a href="<?php echo esc_url($post_item['link']); ?>" class="news-card-readmore">
                        Read More
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<!-- 4. SUBSCRIBE TO OUR NEWSLETTER -->
<section class="news-newsletter">
    <div class="news-nl-inner">
        <h3 class="news-nl-title">Subscribe To<br>Our Newsletter</h3>
        <form class="news-nl-form" onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã đăng ký nhận bản tin tuyển dụng NhomC!'); this.reset();">
            <div class="news-nl-input-group">
                <span class="news-nl-input-icon">
                    <svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1" y="1" width="18" height="13" rx="1" stroke="#ea751e" stroke-width="1.8"/>
                        <path d="M2 2.5L10 8.5L18 2.5" stroke="#ea751e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <input type="email" class="news-nl-input" placeholder="Input your email address" required style="border: none !important; outline: none !important; box-shadow: none !important; background: transparent !important; border-radius: 0 !important; padding: 0 0 0 4px !important; height: 100% !important; margin: 0 !important; -webkit-appearance: none !important;">
            </div>
            <button type="submit" class="news-btn-subscribe">SUBSCRIBE</button>
        </form>
    </div>
</section>

<!-- 5. FOOTER NHOM C -->
<footer class="news-footer">
    <div class="news-footer-inner">
        
        <!-- Logo NhomC Chân trang -->
        <div class="news-footer-brand">
            <div class="news-footer-brand-box">
                <span class="news-footer-brand-title">NHOM C</span>
            </div>
            <span class="news-footer-brand-sub">CAREER &amp; RECRUITING PLATFORM</span>
        </div>

        <!-- Navigation Links Footer -->
        <ul class="news-footer-nav">
            <li><a href="<?php echo esc_url($site_url); ?>/jobs/">JOBS</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/companies/">COMPANIES</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/news/">BLOG</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/about-us/">ABOUT</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/contact-us/">CONTACT</a></li>
        </ul>

        <!-- 4 Icon Mạng Xã Hội Tròn -->
        <div class="news-social-icons">
            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="news-social-btn news-social-facebook" title="Facebook">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="https://google.com" target="_blank" rel="noopener noreferrer" class="news-social-btn news-social-google" title="Google">
                <svg width="20" height="20" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
            </a>
            <a href="https://line.me" target="_blank" rel="noopener noreferrer" class="news-social-btn news-social-line" title="LINE">
                <i class="fa-brands fa-line"></i>
            </a>
            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="news-social-btn news-social-twitter" title="Twitter">
                <i class="fa-brands fa-twitter"></i>
            </a>
        </div>

    </div>
</footer>

<!-- 6. BOTTOM COPYRIGHT BAR -->
<div class="news-copyright-bar">
    Copyright &copy; 2026 Nhom C - FIT TDC. All Rights Reserved.
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.getElementById('newsMobileToggle');
    const drawerClose = document.getElementById('newsDrawerClose');
    const mobileDrawer = document.getElementById('newsMobileDrawer');
    const mobileOverlay = document.getElementById('newsMobileOverlay');

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
});
</script>

<?php wp_footer(); ?>
</body>
</html>
