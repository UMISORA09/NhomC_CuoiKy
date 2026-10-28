<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
<!-- 3. MAIN SECTION: NEWEST BLOG ENTRIES -->
<main class="news-main-section">
    <div class="news-main-inner">
        <h2 class="news-main-heading"><?php echo esc_html( $widget_title ?: 'NEWEST BLOG ENTRIES' ); ?></h2>

        <div class="news-grid">
            <?php foreach ($news_items as $post_item): ?>
            <article class="news-card">
                <div class="news-card-img-wrap">
                    <a href="<?php echo esc_url($post_item['link']); ?>">
                        <img src="<?php echo esc_url($post_item['image']); ?>" alt="<?php echo esc_attr($post_item['title']); ?>" class="news-card-img" loading="lazy">
                    </a>
                </div>
                <div class="news-card-content">
                    <h3 class="news-card-title">
                        <a href="<?php echo esc_url($post_item['link']); ?>">
                            <?php echo esc_html($post_item['title']); ?>
                        </a>
                    </h3>
                    <p class="news-card-excerpt">
                        <?php echo esc_html($post_item['excerpt']); ?>
                    </p>
                    <a href="<?php echo esc_url($post_item['link']); ?>" class="news-card-readmore">
                        Read More
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</main>
