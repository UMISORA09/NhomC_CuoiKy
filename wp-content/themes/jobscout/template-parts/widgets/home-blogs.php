<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
<!-- 5. NEWEST BLOG ENTRIES SECTION -->
<section class="hm-section-blogs">
    <div class="hm-container">
        <h2 class="hm-section-heading"><?php echo esc_html( $widget_title ?: 'NEWEST BLOG ENTRIES' ); ?></h2>
        <div class="hm-blogs-grid">
            <?php foreach ( $home_blogs as $blog ) : ?>
                <article class="hm-blog-card">
                    <div class="hm-blog-thumb">
                        <img src="<?php echo esc_url( $blog['image'] ); ?>" alt="<?php echo esc_attr( $blog['title'] ); ?>">
                    </div>
                    <div class="hm-blog-body">
                        <div>
                            <h3 class="hm-blog-title">
                                <a href="<?php echo esc_url( $blog['link'] ); ?>"><?php echo esc_html( $blog['title'] ); ?></a>
                            </h3>
                            <p class="hm-blog-excerpt"><?php echo esc_html( $blog['excerpt'] ); ?></p>
                        </div>
                        <div>
                            <a href="<?php echo esc_url( $blog['link'] ); ?>" class="hm-blog-readmore">Read More</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
