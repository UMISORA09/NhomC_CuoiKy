<?php
/**
 * Unified Standard Footer Component for Nhom C (FIT - TDC)
 * Matching Figma Mockup pixel-perfect.
 *
 * @package JobScout
 */
defined( 'ABSPATH' ) || exit;

$blog_page = get_page_by_path( 'blog' );
$news_path = $blog_page && (int) $blog_page->ID !== (int) get_option( 'page_for_posts' ) ? '/blog/' : '/news/';
?>

<!-- 1. NEWSLETTER SUBSCRIPTION SECTION -->
<?php get_template_part( 'template-parts/nhomc-newsletter' ); ?>

<!-- 2. MAIN FOOTER -->
<footer class="nc-unified-footer" role="contentinfo">
    <div class="nc-footer-container">
        <!-- Brand Logo Nhom C -->
        <div class="nc-footer-brand-wrap">
            <?php get_template_part( 'template-parts/nhomc-brand', null, array( 'footer' => true ) ); ?>
        </div>

        <!-- Footer Navigation Links -->
        <nav class="nc-footer-nav" aria-label="<?php esc_attr_e( 'Footer Navigation', 'jobscout' ); ?>">
            <a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>">JOBS</a>
            <a href="<?php echo esc_url( home_url( '/company/plan-do-see-global-pds/' ) ); ?>">COMPANIES</a>
            <a href="<?php echo esc_url( home_url( $news_path ) ); ?>">BLOG</a>
            <a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">ABOUT</a>
            <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">CONTACT</a>
        </nav>

        <!-- Social Media Buttons -->
        <div class="nc-footer-social-wrap">
            <?php get_template_part( 'template-parts/nhomc-social' ); ?>
        </div>
    </div>

    <!-- 3. COPYRIGHT SUB-FOOTER BOTTOM BAR -->
    <div class="nc-footer-copyright">
        <div class="nc-footer-container">
            &copy; 2026 Nhom C (FIT - TDC) - JobScout. All Rights Reserved.
        </div>
    </div>
</footer>
