<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
<!-- 4. CAREER WITH US SECTION -->
<section class="hm-section-career" style="background-image: url('<?php echo esc_url( $career_bg ); ?>');">
    <div class="hm-career-overlay"></div>
    <div class="hm-container">
        <div class="hm-career-content">
            <?php if ( ! empty( $career_widget_content ) ) {
                echo $career_widget_content;
            } else {
                get_template_part( 'template-parts/nhomc-career-content' );
            } ?>
        </div>
    </div>
</section>
