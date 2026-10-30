<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
<!-- 2. HERO BANNER: CONTACT US (Hình ảnh nguyên bản có sẵn chữ CONTACT US sắc nét) -->
<section class="cu-hero" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/images/contact/contact-hero-banner.jpg' ); ?>');">
    <h1 class="cu-sr-only">CONTACT US</h1>
</section>
