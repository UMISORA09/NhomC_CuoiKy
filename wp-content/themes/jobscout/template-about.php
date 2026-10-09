<?php
/**
 * Template Name: About Us Design
 * Template Post Type: page
 * @package JobScout
 */
defined( 'ABSPATH' ) || exit;
$theme_uri = get_template_directory_uri();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo esc_url( $theme_uri . '/css/about.css' ); ?>">
</head>
<body <?php body_class( 'about-design' ); ?>>
<?php wp_body_open(); ?>
<a class="ab-skip" href="#about-content">Skip to content</a>
<header class="ab-header">
    <a class="ab-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><strong>NHOM C</strong><small>RECRUITING</small></a>
    <nav aria-label="Main navigation">
        <ul class="ab-nav">
            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a></li>
            <li><a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>">JOBS</a></li>
            <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">NEWS</a></li>
            <li><a href="<?php echo esc_url( get_permalink() ); ?>" aria-current="page">ABOUT</a></li>
            <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">CONTACT</a></li>
        </ul>
    </nav>
    <a class="ab-submit" href="<?php echo esc_url( home_url( '/post-a-job/' ) ); ?>">SUBMIT JOB</a>
</header>
<main id="about-content">
    <section class="ab-hero" aria-labelledby="about-title">
        <!-- shortcut: desktop banner includes the reference lettering; use a clean source photo when available. -->
        <h1 id="about-title">SHARE “OMOTENASHI”<br>WITH THE WORLD</h1>
    </section>
    <section class="ab-intro" aria-labelledby="about-us-title">
        <div class="ab-container">
            <h2 id="about-us-title">ABOUT US</h2>
            <div class="ab-grid">
                <img src="<?php echo esc_url( $theme_uri . '/images/about/torii.jpg' ); ?>" alt="A red torii gate standing in the water in Japan" width="480" height="400">
                <div class="ab-values">
                    <h3>Our Vision</h3>
                    <p>Create hotels and restaurants around the world that offer memorable experiences while building a lasting, positive relationship together with our guests, partners, team members and communities.</p>
                    <h3>Ours Mission</h3>
                    <p>Share “Omotenashi” with the world</p>
                    <h3>Our Core Value</h3>
                    <p>“If I were the guest…”<br>To provide guests with the hospitality you would want to receive as a guest.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="ab-business" aria-labelledby="business-title">
        <div class="ab-container">
            <h3 id="business-title">Hotels, restaurants, banquets/weddings management</h3>
            <p>Plan Do See developed and operates 17 properties worldwide including 3 award-winning resorts in Japan; 17 restaurants of diverse cuisines in cities including New York, Miami and Los Angeles; and other countries including Japan, Indonesia, Malaysia and Bali.</p>
            <p>Each venue carries its own concept and design. Many of them are originally historical landmarks that were loved by the local people.</p>
        </div>
    </section>
    <section class="ab-company" aria-label="Company information">
        <div class="ab-container ab-grid">
            <dl>
                <dt>Established since</dt><dd>April 1993</dd>
                <dt>Head Office</dt><dd>Marunouchi 2-1-1, Chiyoda, Tokyo</dd>
                <dt>Capital</dt><dd>100,000,000 JPY</dd>
                <dt>CEO</dt><dd>Yutaka Noda</dd>
                <dt>Number of Employees</dt><dd>Full time: 830 / Total: 1,600</dd>
            </dl>
            <img src="<?php echo esc_url( $theme_uri . '/images/about/tokyo.jpg' ); ?>" alt="Tokyo Tower at sunset reflected in the street" width="480" height="400" loading="lazy">
        </div>
    </section>
</main>
<section class="ab-newsletter" aria-labelledby="newsletter-title">
    <div class="ab-newsletter-inner">
        <h2 id="newsletter-title">Subscribe To<br>Our Newsletter</h2>
        <div class="ab-newsletter-fields">
            <label class="ab-email"><span aria-hidden="true">✉</span><span class="ab-sr-only">Email address</span><input type="email" placeholder="Input your email address" aria-describedby="newsletter-note" disabled></label>
            <button type="button" disabled aria-describedby="newsletter-note">SUBSCRIBE</button>
            <p id="newsletter-note">Newsletter registration is currently unavailable.</p>
        </div>
    </div>
</section>
<footer class="ab-footer">
    <a class="ab-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><strong>NHOM C</strong><small>CAREER &amp; RECRUITING PLATFORM</small></a>
    <nav aria-label="Footer navigation">
        <ul class="ab-nav">
            <li><a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>">JOBS</a></li>
            <li><a href="<?php echo esc_url( home_url( '/companies/' ) ); ?>">COMPANIES</a></li>
            <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">BLOG</a></li>
            <li><a href="<?php echo esc_url( get_permalink() ); ?>" aria-current="page">ABOUT</a></li>
            <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">CONTACT</a></li>
        </ul>
    </nav>
    <div class="ab-social" aria-label="Social media">
        <a class="ab-facebook" href="https://facebook.com" aria-label="Facebook">f</a>
        <a class="ab-google" href="https://google.com" aria-label="Google">G</a>
        <a class="ab-line" href="https://line.me" aria-label="LINE">LINE</a>
        <a class="ab-twitter" href="https://twitter.com" aria-label="Twitter"><svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><path fill="currentColor" d="M23 3a9 9 0 0 1-2.6.7A4.5 4.5 0 0 0 22.4 1a9 9 0 0 1-2.9 1.1A4.5 4.5 0 0 0 11.8 6a13 13 0 0 1-9.4-4.8A4.5 4.5 0 0 0 3.8 7.2a4.5 4.5 0 0 1-2-.6 4.5 4.5 0 0 0 3.6 4.5 4.5 4.5 0 0 1-2 .1 4.5 4.5 0 0 0 4.2 3.1A9 9 0 0 1 1 16.2a12.8 12.8 0 0 0 19.7-10.8A9 9 0 0 0 23 3Z"/></svg></a>
    </div>
</footer>
<div class="ab-copyright">Copyright &copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> Nhom C - FIT TDC. All Rights Reserved.</div>
<?php wp_footer(); ?>
</body>
</html>
