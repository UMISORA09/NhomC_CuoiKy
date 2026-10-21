<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package JobScout
 */
    
    /**
     * After Content
     * 
     * @hooked jobscout_content_end - 20
    */
    do_action( 'jobscout_before_footer' );

    // Unified Nhom C Footer (Pixel-perfect)
    get_template_part( 'template-parts/nhomc-footer' );

    /**
     * After Footer
     * 
     * @hooked jobscout_page_end - 20
    */
    do_action( 'jobscout_after_footer' );

    wp_footer(); ?>

</body>
</html>
