<?php
/**
 * Template Part for Displaying Job Detail View (Pixel-perfect matching mockup)
 * All data dynamically queried from WordPress database.
 *
 * @package JobScout
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$current_job_id = get_the_ID();
$company_name   = get_post_meta( $current_job_id, '_company_name', true );
if ( empty( $company_name ) ) {
    $company_name = 'THE SODOH';
}

$badges       = nhomc_get_job_badges( $current_job_id );
$staff_rating = get_post_meta( $current_job_id, '_staff_rating', true );
if ( empty( $staff_rating ) ) {
    $staff_rating = '4.0';
}

$photo_url = get_template_directory_uri() . '/images/company-photos.jpg';
?>

<div class="nhomc-job-detail-wrapper">
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
                        <span class="nhomc-tag-pill"><?php echo esc_html( $badges['type'] ); ?></span>
                        <span class="nhomc-tag-pill"><?php echo esc_html( $badges['category'] ); ?></span>
                        <span class="nhomc-tag-pill"><?php echo esc_html( $badges['location'] ); ?></span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="nhomc-job-hero-right">
                <button type="button" class="nhomc-btn-share" onclick="nhomcShareJob()">SHARE</button>
                <button type="button" class="nhomc-btn-apply" onclick="nhomcOpenApplyModal()">APPLY JOB</button>
            </div>
        </div>
    </div>

    <!-- Two-Column Main Content Section -->
    <div class="nhomc-container">
        <div class="nhomc-job-columns">
            <!-- Left Column: Structured Job Details from DB -->
            <div class="nhomc-job-col-left">
                <article class="nhomc-card-content">
                    <?php
                    // Retrieve raw content from DB
                    $raw_content = get_the_content();

                    if ( ! empty( $raw_content ) ) {
                        // Apply filters to output rich HTML
                        echo apply_filters( 'the_content', $raw_content );
                    } else {
                        // Elegant fallback if content empty
                        ?>
                        <h3>Overview about Company</h3>
                        <p>Plan Do See Global is a hospitality group founded in Japan and rooted in "Omotenashi", the Japanese principle of selfless hospitality. We operate luxury resorts, high-end restaurants, and premier boutique hotels worldwide.</p>
                        
                        <h3>Our Key Skills</h3>
                        <p>• Strategic executive leadership and operational excellence.<br>
                        • Proven track record in luxury resort and hotel chain management.<br>
                        • Strong bilingual English - Vietnamese communication skills.</p>
                        
                        <h3>Why You'll Love Working Here</h3>
                        <p>• Be responsible for the effective operational management of the hotel.<br>
                        • Excellent salary bonuses & executive recognition programs.<br>
                        • Foreign language allowance (up to 500USD/month).</p>
                        
                        <h3>Location</h3>
                        <p><?php echo esc_html( $badges['location'] ); ?></p>
                        <?php
                    }
                    ?>
                </article>
            </div>

            <!-- Right Column: Sidebar Widgets -->
            <div class="nhomc-job-col-right">
                <!-- Staff Rating Card -->
                <div class="nhomc-sidebar-card">
                    <h3 class="nhomc-sidebar-title">Staff Rating</h3>
                    <div class="nhomc-rating-box">
                        <div class="nhomc-stars" aria-label="Rating: 4.0 out of 5 stars">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star empty">☆</span>
                        </div>
                        <span class="nhomc-rating-score"><?php echo esc_html( $staff_rating ); ?></span>
                    </div>
                </div>

                <!-- Company Photos Card -->
                <div class="nhomc-sidebar-card">
                    <h3 class="nhomc-sidebar-title">Company Photos</h3>
                    <div class="nhomc-photos-preview">
                        <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $company_name ); ?> Photos">
                        <div class="nhomc-photo-badge">+5</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- OTHER JOBS Section (Queried dynamically from Database) -->
    <section class="nhomc-other-jobs-section">
        <div class="nhomc-container">
            <h2 class="nhomc-section-heading">OTHER JOBS</h2>

            <div class="nhomc-other-jobs-grid">
                <?php
                // Fetch 6 other active job listings from MySQL
                $other_jobs = get_posts( array(
                    'post_type'      => 'job_listing',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'post__not_in'   => array( $current_job_id ),
                    'orderby'        => 'ID',
                    'order'          => 'ASC',
                ) );

                // If fewer than 6, query general job_listing
                if ( count( $other_jobs ) < 6 ) {
                    $other_jobs = get_posts( array(
                        'post_type'      => 'job_listing',
                        'posts_per_page' => 6,
                        'post_status'    => 'publish',
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ) );
                }

                if ( ! empty( $other_jobs ) ) :
                    foreach ( $other_jobs as $job_item ) :
                        $oj_id       = $job_item->ID;
                        $oj_company  = get_post_meta( $oj_id, '_company_name', true );
                        if ( empty( $oj_company ) ) {
                            $oj_company = 'SODOH';
                        }
                        $oj_badges   = nhomc_get_job_badges( $oj_id );
                        $oj_bullets  = nhomc_get_job_bullets( $oj_id, $job_item->post_content );
                        $oj_date     = date( 'M d, Y', strtotime( $job_item->post_date ) );
                        $oj_link     = get_permalink( $oj_id );
                        ?>
                        <div class="nhomc-other-job-card">
                            <div class="nhomc-oj-top">
                                <!-- Company Logo -->
                                <div class="nhomc-oj-logo">
                                    <?php echo nhomc_get_company_logo( $oj_company, $oj_id, 'small' ); ?>
                                </div>

                                <!-- Job Info -->
                                <div class="nhomc-oj-info">
                                    <h3 class="nhomc-oj-title">
                                        <a href="<?php echo esc_url( $oj_link ); ?>">
                                            <?php echo esc_html( $job_item->post_title ); ?>
                                        </a>
                                    </h3>

                                    <div class="nhomc-oj-date">Created: <?php echo esc_html( $oj_date ); ?></div>

                                    <div class="nhomc-oj-tags">
                                        <span class="nhomc-tag-pill"><?php echo esc_html( $oj_badges['type'] ); ?></span>
                                        <span class="nhomc-tag-pill"><?php echo esc_html( $oj_badges['category'] ); ?></span>
                                        <span class="nhomc-tag-pill"><?php echo esc_html( $oj_badges['location'] ); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- 3 Bullet Highlights -->
                            <div class="nhomc-oj-bullets">
                                <ul>
                                    <?php foreach ( $oj_bullets as $bullet ) : ?>
                                        <li><?php echo esc_html( $bullet ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
</div>
