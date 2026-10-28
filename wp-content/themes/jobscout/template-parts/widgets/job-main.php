<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
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
                        // Render clean formatted content matching Figma mockup (excluding redundant WPJM default meta/company box)
                        echo wpautop( do_shortcode( wp_kses_post( $raw_content ) ) );
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
                    <div class="nhomc-photos-preview" id="nhomcCompanyPhotosTrigger" onclick="nhomcOpenPhotoModal(0)" role="button" tabindex="0" title="Click để xem toàn bộ ảnh công ty">
                        <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $company_name ); ?> Photos">
                        <div class="nhomc-photo-badge">+5</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
