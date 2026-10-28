<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
    <!-- Breadcrumbs -->
    <div class="nhomc-container">
        <nav class="nhomc-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <span class="sep">/</span>
            <a href="<?php echo esc_url( home_url( '/all-jobs/' ) ); ?>">All Jobs</a>
            <span class="sep">/</span>
            <span class="current">Job Detail</span>
        </nav>
    </div>

    <!-- Main Job Hero Card -->
    <div class="nhomc-container">
        <div class="nhomc-job-hero-card">
            <div class="nhomc-job-hero-left">
                <!-- Company Logo -->
                <div class="nhomc-company-logo-box">
                    <?php echo nhomc_get_company_logo( $company_name, $current_job_id, 'large' ); ?>
                </div>

                <!-- Job Title & Meta -->
                <div class="nhomc-job-hero-info">
                    <h1 class="nhomc-job-title"><?php the_title(); ?></h1>

                    <div class="nhomc-job-meta-row">
                        <span class="nhomc-meta-date">Created: <?php echo date( 'M d, Y', strtotime( get_post_field( 'post_date', $current_job_id ) ) ); ?></span>
                    </div>

                    <div class="nhomc-job-tags-row">
                        <span class="nhomc-tag-item"><?php echo esc_html( $badges['type'] ); ?></span>
                        <span class="nhomc-tag-sep">|</span>
                        <span class="nhomc-tag-item"><?php echo esc_html( $badges['category'] ); ?></span>
                        <span class="nhomc-tag-sep">|</span>
                        <span class="nhomc-tag-item"><?php echo esc_html( $badges['location'] ); ?></span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="nhomc-job-hero-right">
                <button type="button" class="nhomc-btn-share" onclick="nhomcShareJob(this)">SHARE</button>
                <button type="button" class="nhomc-btn-apply" onclick="nhomcOpenApplyModal()">APPLY JOB</button>
            </div>
        </div>
    </div>
