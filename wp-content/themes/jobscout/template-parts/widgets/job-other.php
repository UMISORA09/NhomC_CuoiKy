<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
    <!-- OTHER JOBS Section (Queried dynamically from Database) -->
    <section class="nhomc-other-jobs-section">
        <div class="nhomc-container">
            <h2 class="nhomc-section-heading"><?php echo esc_html( $widget_title ?: 'OTHER JOBS' ); ?></h2>

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
                        $oj_link     = esc_url( home_url( '/job-detail/?job_id=' . $oj_id ) );
                        ?>
                        <div class="nhomc-other-job-card" onclick="window.location.href='<?php echo esc_url( $oj_link ); ?>';" style="cursor: pointer;">
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
                                        <span class="nhomc-oj-tag-item"><?php echo esc_html( $oj_badges['type'] ); ?></span>
                                        <span class="nhomc-oj-sep">|</span>
                                        <span class="nhomc-oj-tag-item"><?php echo esc_html( $oj_badges['category'] ); ?></span>
                                        <span class="nhomc-oj-sep">|</span>
                                        <span class="nhomc-oj-tag-item"><?php echo esc_html( $oj_badges['location'] ); ?></span>
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
