<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
<!-- 4. SECTION 2: FOR EMPLOYERS & FOR JOBSEEKERS -->
<section class="cu-info-section">
    <div class="cu-info-inner">

        <!-- Cột Trái: For Employers -->
        <div class="cu-col-employers">
            <h3 class="cu-col-title">For Employers</h3>
            <p class="cu-col-subtitle">Call our Sales Hotline</p>

            <div class="cu-city-block">
                <h4 class="cu-city-name">Ho Chi Minh</h4>
                <a href="mailto:contact.hcm@nhomc.vn" class="cu-phone-number">contact.hcm@nhomc.vn</a>
            </div>

            <div class="cu-city-block">
                <h4 class="cu-city-name">Ha Noi</h4>
                <a href="mailto:contact.hanoi@nhomc.vn" class="cu-phone-number">contact.hanoi@nhomc.vn</a>
            </div>

            <div class="cu-employers-note">
                <p>Request a call from one of our</p>
                <p>Customer Love Account Managers</p>
                <p>We're ready to help you grow!</p>
            </div>
        </div>

        <!-- Cột Phải: For Jobseekers -->
        <div class="cu-col-jobseekers">
            <h3 class="cu-col-title">For Jobseekers</h3>

            <div class="cu-jobseekers-links">
                <p>Ask a question on our <a href="https://facebook.com" target="_blank" rel="noopener noreferrer">Facebook</a> page</p>
                <p>Read our <a href="<?php echo esc_url($site_url); ?>/blog/">blog posts</a> on interview and CV tips</p>
            </div>

            <div class="cu-callus-block">
                <h4 class="cu-callus-title">Call us at</h4>
                <a href="tel:+84901234567" class="cu-phone-number">(+84) 90 123 4567</a>
            </div>
        </div>

    </div>
</section>
