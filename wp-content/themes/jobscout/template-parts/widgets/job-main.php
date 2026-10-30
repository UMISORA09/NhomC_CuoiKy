<?php
/**
 * ============================================================================
 * WIDGET COMPONENT: BỐ CỤC 2 CỘT NỘI DUNG CHÍNH (JOB MAIN CONTENT WIDGET)
 * Khớp chuẩn thiết kế Figma: 5-job detail.png
 *
 * TẬP TIN NÀY CHỊU TRÁCH NHIỆM:
 * 1. Bố cục 2 cột (Left Column 70% / Right Column 30%).
 * 2. Cột trái: Nội dung chi tiết bài đăng (Overview, Key Skills, Benefits, Location).
 * 3. Cột phải: Widget đánh giá nhân viên (Staff Rating 5 sao) và Xem ảnh công ty (Company Photos).
 *
 * @package JobScout
 * ============================================================================
 */

defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
    <!-- =====================================================================
         1. BỐ CỤC 2 CỘT NỘI DUNG CHÍNH: CHI TIẾT CÔNG VIỆC VÀ SIDEBAR WIDGETS
         ===================================================================== -->
    <div class="nhomc-container">
        <div class="nhomc-job-columns">
            <!-- Cột trái: Toàn bộ nội dung mô tả chi tiết bài đăng được truy vấn từ DB -->
            <div class="nhomc-job-col-left">
                <article class="nhomc-card-content">
                    <?php
                    // Lấy nội dung gốc của bài viết từ Database
                    $raw_content = $widget_description !== '' ? esc_html( $widget_description ) : get_the_content();

                    if ( ! empty( $raw_content ) ) {
                        // Hiển thị nội dung sạch, tự động thêm thẻ đoạn văn <p> và xử lý shortcode
                        echo wpautop( do_shortcode( wp_kses_post( $raw_content ) ) );
                    } else {
                        // Nội dung mẫu dự phòng (Fallback) khớp chuẩn nội dung bản vẽ Figma
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

            <!-- Cột phải: Các khối Widget bổ trợ (Staff Rating & Company Photos) -->
            <div class="nhomc-job-col-right">
                <!-- Khối Widget 1: Điểm số đánh giá từ nhân viên (Staff Rating) -->
                <div class="nhomc-sidebar-card">
                    <h3 class="nhomc-sidebar-title"><?php echo esc_html( $widget_rating_title ?? 'Staff Rating' ); ?></h3>
                    <div class="nhomc-rating-box">
                        <!-- Hiển thị dãy 5 ngôi sao vàng theo thiết kế -->
                        <div class="nhomc-stars" aria-label="Rating: 4.0 out of 5 stars">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star empty">☆</span>
                        </div>
                        <!-- Điểm số trung bình (VD: 4.0) -->
                        <span class="nhomc-rating-score"><?php echo esc_html( $staff_rating ); ?></span>
                    </div>
                </div>

                <!-- Khối Widget 2: Thư viện hình ảnh công ty (Company Photos Preview) -->
                <div class="nhomc-sidebar-card">
                    <h3 class="nhomc-sidebar-title"><?php echo esc_html( $widget_photos_title ?? 'Company Photos' ); ?></h3>
                    <div class="nhomc-photos-preview" id="nhomcCompanyPhotosTrigger" onclick="nhomcOpenPhotoModal(0)" role="button" tabindex="0" title="Click để xem toàn bộ ảnh công ty">
                        <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $company_name ); ?> Photos">
                        <!-- Huy hiệu thông báo số lượng ảnh còn lại (+5) -->
                        <div class="nhomc-photo-badge">+5</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
