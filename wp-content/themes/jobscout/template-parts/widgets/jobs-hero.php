<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
<!-- 2. HERO BANNER: CAREER WITH US -->
<section class="aj-hero-banner" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/images/alljobs/career-banner.jpg' ); ?>');" role="banner">
    <h1 class="screen-reader-text">CAREER WITH US</h1>
</section>
