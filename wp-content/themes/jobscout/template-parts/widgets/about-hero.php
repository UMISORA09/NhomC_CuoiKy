<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
    <section class="ab-hero" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/images/about/hero.jpg' ); ?>');" aria-labelledby="about-title">
        <!-- shortcut: desktop banner includes the reference lettering; use a clean source photo when available. -->
        <h1 id="about-title">SHARE “OMOTENASHI”<br>WITH THE WORLD</h1>
    </section>
