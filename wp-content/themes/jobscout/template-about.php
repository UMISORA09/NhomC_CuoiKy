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
    <link rel="stylesheet" href="<?php echo esc_url( add_query_arg( 'ver', filemtime( get_template_directory() . '/css/about.css' ), $theme_uri . '/css/about.css' ) ); ?>">
</head>
<body <?php body_class( 'about-design' ); ?>>
<?php wp_body_open(); ?>
<a class="ab-skip" href="#about-content">Skip to content</a>
<?php get_template_part( 'template-parts/nhomc-header' ); ?>
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
<?php get_template_part( 'template-parts/nhomc-newsletter' ); ?>
<footer class="ab-footer">
    <?php get_template_part( 'template-parts/nhomc-brand', null, array( 'footer' => true ) ); ?>
    <nav aria-label="Footer navigation">
        <ul class="ab-nav">
            <li><a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>">JOBS</a></li>
            <li><a href="<?php echo esc_url( home_url( '/companies/' ) ); ?>">COMPANIES</a></li>
            <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">BLOG</a></li>
            <li><a href="<?php echo esc_url( get_permalink() ); ?>" aria-current="page">ABOUT</a></li>
            <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">CONTACT</a></li>
        </ul>
    </nav>
    <?php get_template_part( 'template-parts/nhomc-social' ); ?>
</footer>
<div class="ab-copyright">Copyright &copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> Nhom C - FIT TDC. All Rights Reserved.</div>
<?php wp_footer(); ?>
</body>
</html>
