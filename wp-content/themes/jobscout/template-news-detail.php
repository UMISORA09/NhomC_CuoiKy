<?php
/**
 * Template Name: News Detail Design
 * Template Post Type: post, page
 *
 * Giao diện trang CHI TIẾT BÀI VIẾT (NEWS DETAIL) chuẩn đồ án JobScout - Nhóm C (FIT - TDC)
 * Thiết kế chính xác 100% theo bản vẽ thiết kế 6-news detail.png
 * Đầy đủ Responsive đa thiết bị, giữ trọn vẹn bố cục và phong cách nhận diện NhomC.
 */

$site_url = home_url();
$theme_uri = get_template_directory_uri();
$news_img_dir = $theme_uri . '/images/news/';

// Lấy thông tin bài viết hiện tại (nếu đang trong vòng lặp WordPress single post)
$current_post = get_post();
$is_single = is_single() || (isset($_GET['post']) && !empty($_GET['post']));

if ($is_single && isset($_GET['post'])) {
    $found_by_slug = get_page_by_path(sanitize_title($_GET['post']), OBJECT, 'post');
    if ($found_by_slug) {
        $current_post = $found_by_slug;
    }
}

// Tiêu đề, Ngày, Danh mục, Ảnh thumbnail
$post_title = ($current_post && !empty($current_post->post_title) && $current_post->post_name !== 'news-detail') ? $current_post->post_title : 'CHIEF OPERATING OFFICER HOTEL/ RESORT CHAIN';
$post_date = ($current_post && !empty($current_post->post_date) && $current_post->post_name !== 'news-detail') ? date('M d, Y', strtotime($current_post->post_date)) : 'Oct 20, 2022';

// Danh mục
$categories_list = [];
if ($current_post) {
    $cats = get_the_category($current_post->ID);
    if (!empty($cats)) {
        foreach ($cats as $cat) {
            $categories_list[] = $cat->name;
        }
    }
}
if (empty($categories_list)) {
    $categories_list = ['Category Name', 'Ho Chi Minh City'];
} elseif (count($categories_list) === 1) {
    $categories_list[] = 'Ho Chi Minh City';
}

// Ảnh đại diện thumbnail
$thumb_url = ($current_post && has_post_thumbnail($current_post->ID)) ? get_the_post_thumbnail_url($current_post->ID, 'medium') : ($news_img_dir . 'detail-thumb.jpg');

// Hình ảnh trong nội dung bài viết
$body_img_1 = $news_img_dir . 'detail-body-1.jpg';
$body_img_2 = $news_img_dir . 'detail-body-2.jpg';

// 6 bài viết phần "NEWEST BLOG ENTRIES" dưới trang chuẩn theo ảnh 6-news detail.png
$recent_news = [
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
];

// Gán link chi tiết cho các bài newest entries
$entries_items = [];
foreach ($recent_news as $r_item) {
    $base_slug = preg_replace('/-\d+$/', '', $r_item['slug']);
    $wp_post = get_page_by_path($base_slug, OBJECT, 'post');
    if (!$wp_post) {
        $wp_post = get_page_by_path($r_item['slug'], OBJECT, 'post');
    }
    $r_item['link'] = $wp_post ? get_permalink($wp_post->ID) : esc_url($site_url . '/news-detail/?post=' . urlencode($r_item['slug']));
    $entries_items[] = $r_item;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?php echo esc_html($post_title); ?> | NhomC JobScout</title>
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

        /* === 1. TOP NAVBAR / HEADER === */
        .nd-header {
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
        body.admin-bar .nd-header {
            top: 32px;
        }
        @media screen and (max-width: 782px) {
            body.admin-bar .nd-header {
                top: 46px;
            }
        }
        .nd-header-inner {
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
        .nd-logo-brand {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
            flex-shrink: 0;
        }
        .nd-logo-box {
            border: 2px solid #111111;
            padding: 3px 22px;
            background: #ffffff;
            box-shadow: 2px 2px 0px #111111;
            transition: all 0.2s ease;
        }
        .nd-logo-box:hover {
            box-shadow: 1px 1px 0px #111111;
            transform: translate(1px, 1px);
        }
        .nd-logo-text-main {
            font-size: 18px;
            font-weight: 800;
            color: #111111;
            letter-spacing: 4px;
            text-transform: uppercase;
            line-height: 1.15;
        }
        .nd-logo-sub {
            font-size: 8.5px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* Header Right */
        .nd-header-right {
            display: flex;
            align-items: center;
            gap: 36px;
        }

        /* MENU DESKTOP */
        .nd-nav {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 32px;
            margin: 0;
            padding: 0;
        }
        .nd-nav li {
            position: relative;
            display: flex;
            align-items: center;
            height: 80px;
        }
        .nd-nav a {
            font-size: 13px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 6px 2px;
            display: inline-block;
            position: relative;
        }
        .nd-nav a:hover {
            color: #ea751e;
        }
        /* Active item: NEWS có gạch chân cam chuẩn ảnh 6-news detail.png */
        .nd-nav li.active a {
            color: #222222;
        }
        .nd-nav li.active a::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #ea751e;
        }

        /* Nút SUBMIT JOB cam */
        .nd-btn-submit-job {
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
        .nd-btn-submit-job:hover {
            background-color: #d66412;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(234, 117, 30, 0.35);
        }

        /* Nút Mobile Hamburger */
        .nd-mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 22px;
            color: #111111;
            cursor: pointer;
            padding: 8px;
        }

        /* Mobile Drawer */
        .nd-mobile-drawer {
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
        .nd-mobile-drawer.is-open {
            right: 0;
        }
        .nd-drawer-close {
            align-self: flex-end;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333333;
            margin-bottom: 24px;
        }
        .nd-mobile-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .nd-mobile-nav a {
            font-size: 15px;
            font-weight: 700;
            color: #222222;
            display: block;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .nd-mobile-nav li.active a {
            color: #ea751e;
        }
        .nd-mobile-overlay {
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
        .nd-mobile-overlay.is-active {
            opacity: 1;
            pointer-events: auto;
        }

        /* === 2. BREADCRUMB === */
        .nd-breadcrumb-section {
            width: 100%;
            padding: 26px 20px 20px 20px;
        }
        .nd-breadcrumb-inner {
            max-width: 1050px;
            margin: 0 auto;
            font-size: 13px;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .nd-breadcrumb-link {
            color: #ea751e;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .nd-breadcrumb-link:hover {
            color: #d66412;
            text-decoration: underline;
        }
        .nd-breadcrumb-sep {
            color: #cccccc;
            font-weight: 300;
            user-select: none;
        }
        .nd-breadcrumb-current {
            color: #333333;
            font-weight: 400;
        }

        /* === 3. ARTICLE HEADER CARD === */
        .nd-header-card-section {
            width: 100%;
            padding: 0 20px 30px 20px;
        }
        .nd-header-card {
            max-width: 1050px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 2px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            padding: 24px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }
        .nd-header-card-left {
            display: flex;
            align-items: center;
            gap: 24px;
            flex: 1;
        }
        .nd-header-thumb-wrap {
            width: 140px;
            height: 140px;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 1px;
            background-color: #f0f0f0;
        }
        .nd-header-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .nd-header-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .nd-header-title {
            font-size: 20px;
            font-weight: 700;
            color: #111111;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.35;
            margin-bottom: 8px;
        }
        .nd-header-meta {
            font-size: 13px;
            color: #888888;
            margin-bottom: 12px;
        }
        .nd-header-badge-box {
            display: inline-flex;
            align-items: center;
            background-color: #f2f2f2;
            border-radius: 4px;
            padding: 6px 16px;
            font-size: 12.5px;
            color: #555555;
            gap: 12px;
            width: fit-content;
        }
        .nd-badge-sep {
            color: #cccccc;
        }

        /* Nút SHARE */
        .nd-header-share-btn {
            background-color: #ffffff;
            color: #111111;
            border: 1px solid #111111;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 10px 34px;
            border-radius: 0;
            cursor: pointer;
            transition: all 0.25s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .nd-header-share-btn:hover {
            background-color: #111111;
            color: #ffffff;
        }

        /* === 4. ARTICLE BODY CARD === */
        .nd-body-card-section {
            width: 100%;
            padding: 0 20px 80px 20px;
        }
        .nd-body-card-container {
            max-width: 1050px;
            margin: 0 auto;
        }
        /* Chiều rộng 720px chuẩn như bản vẽ thiết kế 6-news detail.png */
        .nd-body-card {
            max-width: 720px;
            background-color: #ffffff;
            border-radius: 2px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            padding: 34px 30px;
            font-size: 14px;
            color: #333333;
            line-height: 1.8;
        }
        .nd-body-card p {
            margin-bottom: 24px;
            text-align: justify;
        }
        .nd-body-card img {
            width: 100%;
            height: auto;
            border-radius: 2px;
            margin: 28px 0;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }

        /* === 5. NEWEST BLOG ENTRIES (DƯỚI BÀI VIẾT) === */
        .nd-entries-section {
            background-color: #f2f2f2;
            padding: 0 20px 80px 20px;
            width: 100%;
        }
        .nd-entries-inner {
            max-width: 1050px;
            margin: 0 auto;
        }
        .nd-entries-heading {
            font-size: 28px;
            font-weight: 800;
            color: #1a1a1a;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 48px;
        }

        /* GRID 2 CỘT CHO 6 CARD */
        .nd-entries-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }
        .nd-card {
            background-color: #ffffff;
            display: flex;
            flex-direction: row;
            padding: 20px;
            border-radius: 2px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            min-height: 240px;
        }
        .nd-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .nd-card-img-wrap {
            width: 200px;
            height: 200px;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 1px;
            background-color: #eee;
        }
        .nd-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }
        .nd-card:hover .nd-card-img {
            transform: scale(1.04);
        }
        .nd-card-content {
            padding-left: 22px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            flex: 1;
        }
        .nd-card-title {
            font-size: 17px;
            font-weight: 700;
            color: #111111;
            line-height: 1.35;
            margin-bottom: 12px;
            transition: color 0.2s ease;
        }
        .nd-card-title a {
            color: inherit;
        }
        .nd-card-title a:hover {
            color: #ea751e;
        }
        .nd-card-excerpt {
            font-size: 13px;
            color: #666666;
            line-height: 1.55;
            margin-bottom: 16px;
            flex-grow: 1;
        }
        .nd-card-readmore {
            font-size: 13.5px;
            font-weight: 600;
            color: #ea751e;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
            margin-top: auto;
        }
        .nd-card-readmore:hover {
            color: #c95c0c;
            transform: translateX(3px);
        }

        /* === 6. SUBSCRIBE TO OUR NEWSLETTER === */
        .nd-newsletter {
            background-color: #ea751e;
            padding: 30px 20px;
            width: 100%;
        }
        .nd-nl-inner {
            max-width: 920px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 28px;
        }
        .nd-nl-title {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.25;
            letter-spacing: 0.3px;
            white-space: nowrap;
            flex-shrink: 0;
            margin: 0;
        }
        .nd-nl-form {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: 1;
            max-width: 700px;
        }
        .nd-nl-input-group {
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
        .nd-nl-input-icon {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 12px !important;
            flex-shrink: 0 !important;
            color: #ea751e !important;
        }
        .nd-nl-input,
        input.nd-nl-input[type="email"],
        .nd-nl-input-group input[type="email"] {
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
        .nd-nl-input:focus,
        input.nd-nl-input[type="email"]:focus,
        .nd-nl-input-group input[type="email"]:focus {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }
        .nd-nl-input::placeholder {
            color: #999999 !important;
            font-size: 14px !important;
        }
        .nd-btn-subscribe {
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
        .nd-btn-subscribe:hover {
            background-color: #ffffff;
            color: #ea751e;
        }

        /* === 7. FOOTER NHOM C === */
        .nd-footer {
            background-color: #ffffff;
            padding: 50px 20px 40px 20px;
            width: 100%;
            border-top: 1px solid #eeeeee;
        }
        .nd-footer-inner {
            max-width: 1050px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
        }

        /* Brand Footer */
        .nd-footer-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .nd-footer-brand-box {
            border: 2px solid #111111;
            padding: 4px 28px;
            background: #ffffff;
            box-shadow: 2px 2px 0px #111111;
        }
        .nd-footer-brand-title {
            font-size: 19px;
            font-weight: 800;
            color: #111111;
            letter-spacing: 4px;
            text-transform: uppercase;
        }
        .nd-footer-brand-sub {
            font-size: 9px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* Nav Footer */
        .nd-footer-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 32px;
            list-style: none;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
        }
        .nd-footer-nav a {
            font-size: 13px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }
        .nd-footer-nav a:hover {
            color: #ea751e;
        }

        /* 4 Icon Mạng Xã Hội Tròn */
        .nd-social-icons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }
        .nd-social-btn {
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
        .nd-social-btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }
        .nd-social-facebook {
            background-color: #3b5998;
        }
        .nd-social-google {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
        }
        .nd-social-line {
            background-color: #00c300;
        }
        .nd-social-twitter {
            background-color: #1da1f2;
        }

        /* Bottom Copyright Bar */
        .nd-copyright-bar {
            background-color: #000000;
            color: #888888;
            font-size: 12px;
            text-align: center;
            padding: 16px 20px;
            letter-spacing: 0.5px;
        }

        /* Toast thông báo sao chép */
        .nd-toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #222222;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            opacity: 0;
            pointer-events: none;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 9999;
        }
        .nd-toast.is-show {
            opacity: 1;
            transform: translateY(0);
        }

        /* === RESPONSIVE BREAKPOINTS === */
        @media screen and (max-width: 992px) {
            .nd-nav {
                display: none;
            }
            .nd-btn-submit-job {
                display: none;
            }
            .nd-mobile-toggle {
                display: block;
            }
            .nd-header-card {
                flex-direction: column;
                align-items: flex-start;
            }
            .nd-header-share-btn {
                align-self: flex-start;
            }
            .nd-entries-grid {
                grid-template-columns: 1fr;
            }
            .nd-card {
                max-width: 580px;
                margin: 0 auto;
                width: 100%;
            }
        }

        @media screen and (max-width: 768px) {
            .nd-nl-inner {
                flex-direction: column;
                text-align: center;
                gap: 18px;
            }
            .nd-nl-form {
                flex-direction: column;
                width: 100%;
                gap: 14px;
            }
            .nd-nl-input-group {
                width: 100%;
            }
            .nd-btn-subscribe {
                width: 100%;
            }
        }

        @media screen and (max-width: 600px) {
            .nd-header-card-left {
                flex-direction: column;
                align-items: flex-start;
            }
            .nd-header-thumb-wrap {
                width: 100%;
                height: 180px;
            }
            .nd-header-title {
                font-size: 18px;
            }
            .nd-card {
                flex-direction: column;
                align-items: center;
                padding: 16px;
                min-height: auto;
            }
            .nd-card-img-wrap {
                width: 100%;
                height: 180px;
            }
            .nd-card-content {
                padding-left: 0;
                padding-top: 14px;
                width: 100%;
            }
            .nd-footer-nav {
                gap: 18px;
            }
        }
    </style>
</head>
<body <?php body_class('nhomc-news-detail-page'); ?>>

<!-- 1. HEADER / NAVBAR -->
<header class="nd-header">
    <div class="nd-header-inner">
        
        <!-- Logo Nhom C -->
        <a href="<?php echo esc_url($site_url); ?>" class="nd-logo-brand">
            <div class="nd-logo-box">
                <span class="nd-logo-text-main">NHOM C</span>
            </div>
            <span class="nd-logo-sub">CAREER &amp; RECRUITING PLATFORM</span>
        </a>

        <!-- Header Right: Nav Desktop & Submit Job -->
        <div class="nd-header-right">
            <nav>
                <ul class="nd-nav">
                    <li><a href="<?php echo esc_url($site_url); ?>">HOME</a></li>
                    <li><a href="<?php echo esc_url($site_url); ?>/jobs/">JOBS</a></li>
                    <li class="active"><a href="<?php echo esc_url($site_url); ?>/news/">NEWS</a></li>
                    <li><a href="<?php echo esc_url($site_url); ?>/about-us/">ABOUT</a></li>
                    <li><a href="<?php echo esc_url($site_url); ?>/contact-us/">CONTACT</a></li>
                </ul>
            </nav>

            <a href="<?php echo esc_url($site_url); ?>/post-a-job/" class="nd-btn-submit-job">SUBMIT JOB</a>
        </div>

        <!-- Mobile Toggle Button -->
        <button class="nd-mobile-toggle" id="ndMobileToggle" aria-label="Toggle Navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</header>

<!-- Mobile Navigation Drawer -->
<div class="nd-mobile-overlay" id="ndMobileOverlay"></div>
<aside class="nd-mobile-drawer" id="ndMobileDrawer">
    <button class="nd-drawer-close" id="ndDrawerClose" aria-label="Close Navigation Menu">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <ul class="nd-mobile-nav">
        <li><a href="<?php echo esc_url($site_url); ?>">HOME</a></li>
        <li><a href="<?php echo esc_url($site_url); ?>/jobs/">JOBS</a></li>
        <li class="active"><a href="<?php echo esc_url($site_url); ?>/news/">NEWS</a></li>
        <li><a href="<?php echo esc_url($site_url); ?>/about-us/">ABOUT</a></li>
        <li><a href="<?php echo esc_url($site_url); ?>/contact-us/">CONTACT</a></li>
    </ul>
    <div style="margin-top: 30px;">
        <a href="<?php echo esc_url($site_url); ?>/post-a-job/" class="nd-btn-submit-job" style="display: flex; width: 100%; text-align: center;">SUBMIT JOB</a>
    </div>
</aside>

<!-- 2. BREADCRUMB -->
<div class="nd-breadcrumb-section">
    <div class="nd-breadcrumb-inner">
        <a href="<?php echo esc_url($site_url); ?>" class="nd-breadcrumb-link">Home</a>
        <span class="nd-breadcrumb-sep">/</span>
        <a href="<?php echo esc_url($site_url); ?>/news/" class="nd-breadcrumb-link">All News</a>
        <span class="nd-breadcrumb-sep">/</span>
        <span class="nd-breadcrumb-current">News Detail</span>
    </div>
</div>

<!-- 3. ARTICLE HEADER CARD -->
<section class="nd-header-card-section">
    <div class="nd-header-card">
        <div class="nd-header-card-left">
            <div class="nd-header-thumb-wrap">
                <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($post_title); ?>" class="nd-header-thumb">
            </div>
            <div class="nd-header-info">
                <h1 class="nd-header-title"><?php echo esc_html($post_title); ?></h1>
                <div class="nd-header-meta">Posted: <?php echo esc_html($post_date); ?></div>
                <div class="nd-header-badge-box">
                    <span>Category Name</span>
                    <span class="nd-badge-sep">|</span>
                    <span>Ho Chi Minh City</span>
                </div>
            </div>
        </div>
        <button class="nd-header-share-btn" id="ndShareBtn" onclick="shareArticle()">
            SHARE
        </button>
    </div>
</section>

<!-- 4. ARTICLE BODY CARD -->
<main class="nd-body-card-section">
    <div class="nd-body-card-container">
        <article class="nd-body-card">
            <?php if ($current_post && !empty(trim($current_post->post_content)) && $current_post->ID != 6 && $current_post->ID != 20): ?>
                <?php echo apply_filters('the_content', $current_post->post_content); ?>
            <?php else: ?>
                <!-- Nội dung mẫu chuẩn 100% bản vẽ 6-news detail.png -->
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Faucibus lectus tristique massa gravida vel elementum, mi. Sit scelerisque at amet leo. In volutpat turpis dolor, at. Vivamus volutpat in nunc, porttitor dui. Ut placerat aenean accumsan a, aenean lacus eu. Aliquet urna, habitasse elit lorem id enim quam. Eu varius nulla nullam dignissim massa tempor, massa tortor. Eget auctor nulla maecenas ac tortor.<br>
                Ornare faucibus sed vitae dolor eu eu faucibus leo enim. Tincidunt quisque sed netus nibh pharetra. Gravida venenatis, lobortis id mi. Metus, ultrices duis pellentesque aliquet amet cras blandit. Aliquet purus quam laoreet ipsum pretium. Odio quis eu nunc, diam habitant nunc massa sed. Placerat arcu quis est, magna facilisis amet. Dignissim vel adipiscing elit facilisi praesent platea. Nulla posuere feugiat turpis magna etiam. Non nec felis eu praesent cras.</p>

                <img src="<?php echo esc_url($body_img_1); ?>" alt="Japanese street with lanterns" loading="lazy">

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Faucibus lectus tristique massa gravida vel elementum, mi. Sit scelerisque at amet leo. In volutpat turpis dolor, at. Vivamus volutpat in nunc, porttitor dui. Ut placerat aenean accumsan a, aenean lacus eu. Aliquet urna, habitasse elit lorem id enim quam. Eu varius nulla nullam dignissim massa tempor, massa tortor. Eget auctor nulla maecenas ac tortor.<br>
                Ornare faucibus sed vitae dolor eu eu faucibus leo enim. Tincidunt quisque sed netus nibh pharetra. Gravida venenatis, lobortis id mi. Metus, ultrices duis pellentesque aliquet amet cras blandit. Aliquet purus quam laoreet ipsum pretium. Odio quis eu nunc, diam habitant nunc massa sed. Placerat arcu quis est, magna facilisis amet. Dignissim vel adipiscing elit facilisi praesent platea. Nulla posuere feugiat turpis magna etiam. Non nec felis eu praesent cras.</p>

                <img src="<?php echo esc_url($body_img_2); ?>" alt="Cherry blossom lanterns at night" loading="lazy">

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Faucibus lectus tristique massa gravida vel elementum, mi. Sit scelerisque at amet leo. In volutpat turpis dolor, at. Vivamus volutpat in nunc, porttitor dui. Ut placerat aenean accumsan a, aenean lacus eu. Aliquet urna, habitasse elit lorem id enim quam. Eu varius nulla nullam dignissim massa tempor, massa tortor. Eget auctor nulla maecenas ac tortor.</p>
            <?php endif; ?>
        </article>
    </div>
</main>

<!-- 5. NEWEST BLOG ENTRIES (DƯỚI BÀI VIẾT) -->
<section class="nd-entries-section">
    <div class="nd-entries-inner">
        <h2 class="nd-entries-heading">NEWEST BLOG ENTRIES</h2>

        <div class="nd-entries-grid">
            <?php foreach ($entries_items as $entry_item): ?>
            <article class="nd-card">
                <div class="nd-card-img-wrap">
                    <a href="<?php echo esc_url($entry_item['link']); ?>">
                        <img src="<?php echo esc_url($entry_item['image']); ?>" alt="<?php echo esc_attr($entry_item['title']); ?>" class="nd-card-img" loading="lazy">
                    </a>
                </div>
                <div class="nd-card-content">
                    <h3 class="nd-card-title">
                        <a href="<?php echo esc_url($entry_item['link']); ?>">
                            <?php echo esc_html($entry_item['title']); ?>
                        </a>
                    </h3>
                    <p class="nd-card-excerpt">
                        <?php echo esc_html($entry_item['excerpt']); ?>
                    </p>
                    <a href="<?php echo esc_url($entry_item['link']); ?>" class="nd-card-readmore">
                        Read More
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 6. SUBSCRIBE TO OUR NEWSLETTER -->
<section class="nd-newsletter">
    <div class="nd-nl-inner">
        <h3 class="nd-nl-title">Subscribe To<br>Our Newsletter</h3>
        <form class="nd-nl-form" onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã đăng ký nhận bản tin tuyển dụng NhomC!'); this.reset();">
            <div class="nd-nl-input-group">
                <span class="nd-nl-input-icon">
                    <svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1" y="1" width="18" height="13" rx="1" stroke="#ea751e" stroke-width="1.8"/>
                        <path d="M2 2.5L10 8.5L18 2.5" stroke="#ea751e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <input type="email" class="nd-nl-input" placeholder="Input your email address" required style="border: none !important; outline: none !important; box-shadow: none !important; background: transparent !important; border-radius: 0 !important; padding: 0 0 0 4px !important; height: 100% !important; margin: 0 !important; -webkit-appearance: none !important;">
            </div>
            <button type="submit" class="nd-btn-subscribe">SUBSCRIBE</button>
        </form>
    </div>
</section>

<!-- 7. FOOTER NHOM C -->
<footer class="nd-footer">
    <div class="nd-footer-inner">
        
        <!-- Logo NhomC Chân trang -->
        <div class="nd-footer-brand">
            <div class="nd-footer-brand-box">
                <span class="nd-footer-brand-title">NHOM C</span>
            </div>
            <span class="nd-footer-brand-sub">CAREER &amp; RECRUITING PLATFORM</span>
        </div>

        <!-- Navigation Links Footer -->
        <ul class="nd-footer-nav">
            <li><a href="<?php echo esc_url($site_url); ?>/jobs/">JOBS</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/companies/">COMPANIES</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/news/">BLOG</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/about-us/">ABOUT</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/contact-us/">CONTACT</a></li>
        </ul>

        <!-- 4 Icon Mạng Xã Hội Tròn -->
        <div class="nd-social-icons">
            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="nd-social-btn nd-social-facebook" title="Facebook">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="https://google.com" target="_blank" rel="noopener noreferrer" class="nd-social-btn nd-social-google" title="Google">
                <svg width="20" height="20" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
            </a>
            <a href="https://line.me" target="_blank" rel="noopener noreferrer" class="nd-social-btn nd-social-line" title="LINE">
                <i class="fa-brands fa-line"></i>
            </a>
            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="nd-social-btn nd-social-twitter" title="Twitter">
                <i class="fa-brands fa-twitter"></i>
            </a>
        </div>

    </div>
</footer>

<!-- 8. BOTTOM COPYRIGHT BAR -->
<div class="nd-copyright-bar">
    Copyright &copy; 2026 Nhom C - FIT TDC. All Rights Reserved.
</div>

<!-- Toast thông báo -->
<div class="nd-toast" id="ndToast">Đã sao chép liên kết bài viết!</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.getElementById('ndMobileToggle');
    const drawerClose = document.getElementById('ndDrawerClose');
    const mobileDrawer = document.getElementById('ndMobileDrawer');
    const mobileOverlay = document.getElementById('ndMobileOverlay');

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

function shareArticle() {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(window.location.href).then(function() {
            showToast('Đã sao chép liên kết bài viết vào bộ nhớ tạm!');
        }).catch(function() {
            prompt('Sao chép đường dẫn bài viết:', window.location.href);
        });
    } else {
        prompt('Sao chép đường dẫn bài viết:', window.location.href);
    }
}

function showToast(msg) {
    const toast = document.getElementById('ndToast');
    if (toast) {
        toast.textContent = msg;
        toast.classList.add('is-show');
        setTimeout(function() {
            toast.classList.remove('is-show');
        }, 3000);
    }
}
</script>

<?php wp_footer(); ?>
</body>
</html>
