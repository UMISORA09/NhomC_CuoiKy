<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
<!-- 3. TOP JOBS SECTION -->
<section class="hm-section-jobs" id="top-jobs">
    <div class="hm-container">
        <h2 class="hm-section-heading"><?php echo esc_html( $widget_title ?: 'TOP JOBS' ); ?></h2>
        <div class="hm-jobs-grid">
            <?php foreach ( $home_jobs as $job ) : ?>
                <div class="hm-job-card" onclick="window.location.href='<?php echo esc_url( $job['link'] ); ?>';">
                    <div class="hm-job-logo">
                        <i class="<?php echo esc_attr( $job['brand']['icon'] ); ?> hm-logo-vector-icon"></i>
                        <span class="hm-logo-vector-name"><?php echo esc_html( $job['brand']['name'] ); ?></span>
                        <span class="hm-logo-vector-sub"><?php echo esc_html( $job['brand']['sub'] ); ?></span>
                    </div>
                    <div class="hm-job-info">
                        <h3 class="hm-job-title">
                            <a href="<?php echo esc_url( $job['link'] ); ?>"><?php echo esc_html( $job['title'] ); ?></a>
                        </h3>
                        <div class="hm-job-date"><?php echo esc_html( $job['date'] ); ?></div>
                        <div class="hm-job-tags">
                            <span class="hm-job-tag"><?php echo esc_html( $job['type'] ); ?></span>
                            <span class="hm-tag-sep">|</span>
                            <span class="hm-job-tag"><?php echo esc_html( $job['category'] ); ?></span>
                            <span class="hm-tag-sep">|</span>
                            <span class="hm-job-tag"><?php echo esc_html( $job['location'] ); ?></span>
                        </div>
                        <ul class="hm-job-bullets">
                            <?php foreach ( $job['bullets'] as $bullet ) : ?>
                                <li><?php echo esc_html( $bullet ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="hm-more-jobs-wrap">
            <a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>" class="hm-btn-view-more">VIEW MORE JOBS</a>
        </div>
    </div>
</section>
