<?php
/**
 * Template Name: Contact Us Design
 * Template Post Type: page
 *
 * Giao diện trang CONTACT US chuẩn đồ án JobScout - Nhóm C (FIT - TDC)
 * Thiết kế chính xác theo bản vẽ thiết kế 7-contact us.png
 * Đầy đủ Responsive đa thiết bị, giữ trọn vẹn bố cục và phong cách nhận diện NhomC.
 */

$site_url = home_url();
$theme_uri = get_template_directory_uri();
$banner_img = $theme_uri . '/images/contact/contact-hero-banner.jpg';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Contact Us | NhomC JobScout</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
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
            background-color: #ffffff;
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

        /* Helper cho SEO */
        .cu-sr-only {
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
        .cu-header {
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
        body.admin-bar .cu-header {
            top: 32px;
        }
        @media screen and (max-width: 782px) {
            body.admin-bar .cu-header {
                top: 46px;
            }
        }
        .cu-header-inner {
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
        .cu-logo-brand {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
            flex-shrink: 0;
        }
        .cu-logo-box {
            border: 2px solid #111111;
            padding: 3px 22px;
            background: #ffffff;
            box-shadow: 2px 2px 0px #111111;
            transition: all 0.2s ease;
        }
        .cu-logo-box:hover {
            box-shadow: 1px 1px 0px #111111;
            transform: translate(1px, 1px);
        }
        .cu-logo-text-main {
            font-size: 18px;
            font-weight: 800;
            color: #111111;
            letter-spacing: 4px;
            text-transform: uppercase;
            line-height: 1.15;
        }
        .cu-logo-sub {
            font-size: 8.5px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* Header Right Wrap */
        .cu-header-right {
            display: flex;
            align-items: center;
            gap: 36px;
        }

        /* MENU DESKTOP */
        .cu-nav {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 32px;
            margin: 0;
            padding: 0;
        }
        .cu-nav li {
            position: relative;
            display: flex;
            align-items: center;
            height: 80px;
        }
        .cu-nav a {
            font-size: 13px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 6px 2px;
            display: inline-block;
            position: relative;
        }
        .cu-nav a:hover {
            color: #ea751e;
        }
        /* Active item: CONTACT với đường gạch chân cam chuẩn */
        .cu-nav li.active a {
            color: #222222;
        }
        .cu-nav li.active a::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #ea751e;
        }

        /* Nút SUBMIT JOB cam */
        .cu-btn-submit-job {
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
        .cu-btn-submit-job:hover {
            background-color: #d66412;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(234, 117, 30, 0.35);
        }

        /* Nút Mobile Hamburger */
        .cu-mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 22px;
            color: #111111;
            cursor: pointer;
            padding: 8px;
        }

        /* Mobile Drawer */
        .cu-mobile-drawer {
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
        .cu-mobile-drawer.is-open {
            right: 0;
        }
        .cu-drawer-close {
            align-self: flex-end;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333333;
            margin-bottom: 24px;
        }
        .cu-mobile-nav {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .cu-mobile-nav a {
            font-size: 15px;
            font-weight: 700;
            color: #222222;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .cu-mobile-nav li.active a {
            color: #ea751e;
            border-bottom-color: #ea751e;
        }
        .cu-mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 1999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .cu-mobile-overlay.is-active {
            opacity: 1;
            visibility: visible;
        }

        /* === 2. HERO BANNER: CONTACT US === */
        .cu-hero {
            position: relative;
            width: 100%;
            height: 360px;
            background-color: #111111;
            background-image: url('<?php echo esc_url($banner_img); ?>');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* === 3. SECTION 1: OUR HEADQUARTERS ADDRESS === */
        .cu-hq-section {
            background-color: #ffffff;
            padding: 55px 20px 50px;
            text-align: center;
        }
        .cu-hq-inner {
            max-width: 820px;
            margin: 0 auto;
        }
        .cu-hq-title {
            font-size: 18.5px;
            font-weight: 700;
            color: #1e1e1e;
            margin-bottom: 18px;
            letter-spacing: 0.2px;
        }
        .cu-hq-address {
            font-size: 13.5px;
            color: #4a4a4a;
            font-weight: 500;
            line-height: 1.6;
            letter-spacing: 0.2px;
        }

        /* === 4. SECTION 2: FOR EMPLOYERS & FOR JOBSEEKERS (NỀN XÁM NHẠT #f2f2f2) === */
        .cu-info-section {
            background-color: #f2f2f2;
            padding: 65px 20px 75px;
        }
        .cu-info-inner {
            max-width: 920px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
        }

        /* Cột Trái: For Employers */
        .cu-col-employers {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .cu-col-title {
            font-size: 17.5px;
            font-weight: 700;
            color: #1e1e1e;
            margin-bottom: 5px;
            letter-spacing: 0.2px;
        }
        .cu-col-subtitle {
            font-size: 13.5px;
            color: #555555;
            margin-bottom: 24px;
        }
        .cu-city-block {
            margin-bottom: 18px;
        }
        .cu-city-name {
            font-size: 15px;
            font-weight: 700;
            color: #1e1e1e;
            margin-bottom: 4px;
        }
        .cu-phone-number {
            font-size: 14px;
            font-weight: 700;
            color: #222222;
            display: inline-block;
            letter-spacing: 0.5px;
            transition: color 0.2s ease;
        }
        .cu-phone-number:hover {
            color: #ea751e;
        }
        .cu-employers-note {
            font-size: 13.5px;
            color: #444444;
            line-height: 1.6;
            margin-top: 14px;
            max-width: 320px;
        }

        /* Cột Phải: For Jobseekers */
        .cu-col-jobseekers {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .cu-jobseekers-links {
            font-size: 13.5px;
            color: #444444;
            line-height: 1.75;
            margin-bottom: 30px;
        }
        .cu-jobseekers-links a {
            color: #ea751e;
            text-decoration: underline;
            font-weight: 600;
            text-underline-offset: 2px;
        }
        .cu-jobseekers-links a:hover {
            color: #c95c0f;
        }
        .cu-callus-block {
            margin-top: 4px;
        }
        .cu-callus-title {
            font-size: 15px;
            font-weight: 700;
            color: #1e1e1e;
            margin-bottom: 5px;
        }

        /* === 5. SECTION 3: SUBSCRIBE NEWSLETTER (CAM #ea751e) === */
        .cu-newsletter {
            background-color: #ea751e;
            padding: 35px 24px;
            width: 100%;
        }
        .cu-nl-inner {
            max-width: 1040px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }
        .cu-nl-title {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.25;
            margin: 0;
            letter-spacing: 0.2px;
            flex-shrink: 0;
        }
        .cu-nl-form {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-grow: 1;
            max-width: 620px;
            justify-content: flex-end;
        }
        .cu-nl-input-group {
            position: relative;
            background: #ffffff;
            border-radius: 0;
            display: flex;
            align-items: center;
            padding: 0 16px;
            height: 48px;
            flex: 1;
            box-shadow: 0 2px 5px rgba(0,0,0,0.06);
        }
        .cu-nl-input-group i {
            color: #ea751e;
            font-size: 17px;
            margin-right: 12px;
        }
        .cu-nl-input {
            border: none;
            outline: none;
            font-family: inherit;
            font-size: 13.5px;
            color: #333333;
            width: 100%;
            background: transparent;
        }
        .cu-nl-input::placeholder {
            color: #999999;
        }
        .cu-btn-subscribe {
            height: 48px;
            padding: 0 28px;
            border: 1.5px solid #ffffff;
            background: transparent;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: 0;
            transition: all 0.25s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .cu-btn-subscribe:hover {
            background-color: #ffffff;
            color: #ea751e;
        }

        /* === 6. SECTION 4: FOOTER NHOM C === */
        .cu-footer {
            background-color: #f2f2f2;
            padding: 55px 20px 45px;
            text-align: center;
        }
        .cu-footer-inner {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        /* Logo Chân trang NhomC */
        .cu-footer-brand {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 24px;
        }
        .cu-footer-brand-box {
            border: 2px solid #111111;
            padding: 4px 24px;
            background: #f2f2f2;
            box-shadow: 2px 2px 0px #111111;
            margin-bottom: 6px;
        }
        .cu-footer-brand-title {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 4px;
            color: #111111;
            text-transform: uppercase;
        }
        .cu-footer-brand-sub {
            font-size: 9px;
            font-weight: 700;
            color: #333333;
            letter-spacing: 3.5px;
            text-transform: uppercase;
        }

        /* Menu Footer */
        .cu-footer-nav {
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 36px;
            margin: 0 0 30px 0;
            padding: 0;
            flex-wrap: wrap;
        }
        .cu-footer-nav a {
            font-size: 13px;
            font-weight: 700;
            color: #222222;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            transition: color 0.2s ease;
        }
        .cu-footer-nav a:hover {
            color: #ea751e;
        }

        /* 4 Icon Mạng Xã Hội Tròn */
        .cu-social-icons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }
        .cu-social-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 17px;
            transition: all 0.25s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        }
        .cu-social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .cu-social-facebook {
            background-color: #3b5998;
        }
        .cu-social-google {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
        }
        .cu-social-google svg, .cu-social-google i {
            font-size: 16px;
        }
        .cu-social-line {
            background-color: #00c300;
            font-size: 18px;
        }
        .cu-social-twitter {
            background-color: #1da1f2;
        }

        /* === 7. BOTTOM COPYRIGHT BAR === */
        .cu-copyright-bar {
            background-color: #231815;
            color: #9c9c9c;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            padding: 13px 20px;
            letter-spacing: 0.5px;
        }

        /* === 8. RESPONSIVE DESIGN (TABLET & MOBILE) === */
        @media screen and (max-width: 900px) {
            .cu-header-right {
                display: none;
            }
            .cu-mobile-toggle {
                display: block;
            }
            .cu-info-inner {
                grid-template-columns: 1fr;
                gap: 45px;
            }
            .cu-nl-inner {
                flex-direction: column;
                text-align: center;
            }
            .cu-nl-form {
                width: 100%;
                max-width: 100%;
                flex-direction: column;
            }
            .cu-nl-input-group {
                width: 100%;
            }
            .cu-btn-subscribe {
                width: 100%;
            }
            .cu-hero {
                height: 260px;
            }
        }

        @media screen and (max-width: 600px) {
            .cu-header-inner {
                padding: 0 16px;
            }
            .cu-footer-nav {
                gap: 20px;
            }
            .cu-footer-nav a {
                font-size: 12px;
            }
            .cu-hero {
                height: 200px;
            }
            .cu-hq-title {
                font-size: 17px;
            }
            .cu-hq-address {
                font-size: 13px;
            }
        }
    </style>
</head>
<body <?php body_class('contact-page-body'); ?>>

<!-- 1. TOP NAVBAR / HEADER -->
<?php get_template_part( 'template-parts/nhomc-header' ); ?>

<!-- 2. HERO BANNER: CONTACT US (Hình ảnh nguyên bản có sẵn chữ CONTACT US sắc nét) -->
<section class="cu-hero">
    <h1 class="cu-sr-only">CONTACT US</h1>
</section>

<!-- 3. SECTION 1: OUR HEADQUARTERS ADDRESS -->
<section class="cu-hq-section">
    <div class="cu-hq-inner">
        <h2 class="cu-hq-title">Our Headquarters Address</h2>
        <p class="cu-hq-address">60 Nguyen Van Thu, Ward Da Kao, District 1, Ho Chi Minh City, Viet Nam</p>
    </div>
</section>

<!-- 4. SECTION 2: FOR EMPLOYERS & FOR JOBSEEKERS -->
<section class="cu-info-section">
    <div class="cu-info-inner">
        
        <!-- Cột Trái: For Employers -->
        <div class="cu-col-employers">
            <h3 class="cu-col-title">For Employers</h3>
            <p class="cu-col-subtitle">Call our Sales Hotline</p>

            <div class="cu-city-block">
                <h4 class="cu-city-name">Ho Chi Minh</h4>
                <a href="mailto:contact.hcm@nhomc.vn" class="cu-phone-number">contact.hcm@nhomc.vn</a>
            </div>

            <div class="cu-city-block">
                <h4 class="cu-city-name">Ha Noi</h4>
                <a href="mailto:contact.hanoi@nhomc.vn" class="cu-phone-number">contact.hanoi@nhomc.vn</a>
            </div>

            <div class="cu-employers-note">
                <p>Request a call from one of our</p>
                <p>Customer Love Account Managers</p>
                <p>We're ready to help you grow!</p>
            </div>
        </div>

        <!-- Cột Phải: For Jobseekers -->
        <div class="cu-col-jobseekers">
            <h3 class="cu-col-title">For Jobseekers</h3>
            
            <div class="cu-jobseekers-links">
                <p>Ask a question on our <a href="https://facebook.com" target="_blank" rel="noopener noreferrer">Facebook</a> page</p>
                <p>Read our <a href="<?php echo esc_url($site_url); ?>/blog/">blog posts</a> on interview and CV tips</p>
            </div>

            <div class="cu-callus-block">
                <h4 class="cu-callus-title">Call us at</h4>
                <a href="tel:+84901234567" class="cu-phone-number">(+84) 90 123 4567</a>
            </div>
        </div>

    </div>
</section>

<!-- 5. SECTION 3: SUBSCRIBE TO OUR NEWSLETTER -->
<section class="cu-newsletter">
    <div class="cu-nl-inner">
        <h3 class="cu-nl-title">Subscribe To<br>Our Newsletter</h3>
        <form class="cu-nl-form" onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã đăng ký nhận bản tin tuyển dụng NhomC!'); this.reset();">
            <div class="cu-nl-input-group">
                <i class="fa-regular fa-envelope"></i>
                <input type="email" class="cu-nl-input" placeholder="Input your email address" required>
            </div>
            <button type="submit" class="cu-btn-subscribe">SUBSCRIBE</button>
        </form>
    </div>
</section>

<!-- 6. SECTION 4: FOOTER NHOM C -->
<footer class="cu-footer">
    <div class="cu-footer-inner">
        
        <!-- Logo NhomC Chân trang -->
        <div class="cu-footer-brand">
            <div class="cu-footer-brand-box">
                <span class="cu-footer-brand-title">NHOM C</span>
            </div>
            <span class="cu-footer-brand-sub">CAREER &amp; RECRUITING PLATFORM</span>
        </div>

        <!-- Navigation Links Footer -->
        <ul class="cu-footer-nav">
            <li><a href="<?php echo esc_url($site_url); ?>/jobs/">JOBS</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/companies/">COMPANIES</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/blog/">BLOG</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/about-us/">ABOUT</a></li>
            <li><a href="<?php echo esc_url($site_url); ?>/contact/">CONTACT</a></li>
        </ul>

        <!-- 4 Icon Mạng Xã Hội Tròn -->
        <div class="cu-social-icons">
            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="cu-social-btn cu-social-facebook" title="Facebook">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="https://google.com" target="_blank" rel="noopener noreferrer" class="cu-social-btn cu-social-google" title="Google">
                <!-- SVG Google Logo chính thức sắc nét -->
                <svg width="20" height="20" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
            </a>
            <a href="https://line.me" target="_blank" rel="noopener noreferrer" class="cu-social-btn cu-social-line" title="LINE">
                <i class="fa-brands fa-line"></i>
            </a>
            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="cu-social-btn cu-social-twitter" title="Twitter">
                <i class="fa-brands fa-twitter"></i>
            </a>
        </div>

    </div>
</footer>

<!-- 7. BOTTOM COPYRIGHT BAR -->
<div class="cu-copyright-bar">
    Copyright &copy; 2026 Nhom C - FIT TDC. All Rights Reserved.
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.getElementById('cuMobileToggle');
    const drawerClose = document.getElementById('cuDrawerClose');
    const mobileDrawer = document.getElementById('cuMobileDrawer');
    const mobileOverlay = document.getElementById('cuMobileOverlay');

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
