<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
<!-- 2. HERO BANNER: PDS NEWS (Hình ảnh gốc chứa sẵn tiêu đề PDS NEWS sắc nét) -->
<section class="news-hero" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/images/news/news-hero-banner.jpg' ); ?>');">
    <h1 class="news-sr-only">PDS NEWS</h1>
</section>
