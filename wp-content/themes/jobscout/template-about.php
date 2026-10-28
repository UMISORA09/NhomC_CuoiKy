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
<?php nhomc_render_page_widgets( 'nhomc-about', compact( 'theme_uri' ) ); ?>
</main>
<!-- UNIFIED NHOM C FOOTER -->
<?php get_template_part( 'template-parts/nhomc-footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>
