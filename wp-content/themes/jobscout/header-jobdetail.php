<?php
/**
 * Header template for NhomC Job Detail (Pixel-perfect matching mockup)
 *
 * @package JobScout
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class( 'nhomc-job-page' ); ?>>
<?php wp_body_open(); ?>

<header id="nhomc-masthead" class="nhomc-header">
    <div class="nhomc-container">
        <div class="nhomc-header-wrap">
            <!-- Brand Logo -->
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nhomc-brand-logo" rel="home">
                <div class="nhomc-logo-badge">
                    <span class="nhomc-logo-title">NHOM C<span class="orange-dot">.</span></span>
                    <span class="nhomc-logo-sub">RECRUITING</span>
                </div>
            </a>

            <!-- Main Navigation -->
            <nav id="nhomc-site-nav" class="nhomc-main-nav">
                <ul class="nhomc-nav-list">
                    <li class="nhomc-nav-item">
                        <a href="<?php echo esc_url( home_url( '/home/' ) ); ?>">HOME</a>
                    </li>
                    <li class="nhomc-nav-item active">
                        <a href="<?php echo esc_url( home_url( '/all-jobs/' ) ); ?>">JOBS</a>
                    </li>
                    <li class="nhomc-nav-item">
                        <a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">NEWS</a>
                    </li>
                    <li class="nhomc-nav-item">
                        <a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">ABOUT</a>
                    </li>
                    <li class="nhomc-nav-item">
                        <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">CONTACT</a>
                    </li>
                </ul>
            </nav>

            <!-- Submit Job CTA -->
            <div class="nhomc-header-cta">
                <a href="<?php echo esc_url( home_url( '/post-a-job/' ) ); ?>" class="nhomc-btn-submit-job">SUBMIT JOB</a>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="nhomc-mobile-toggle" aria-label="Toggle Menu" onclick="document.querySelector('.nhomc-nav-list').classList.toggle('mobile-open');">
                ☰
            </button>
        </div>
    </div>
</header>
