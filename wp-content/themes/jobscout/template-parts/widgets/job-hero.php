<?php
/**
 * ============================================================================
 * WIDGET COMPONENT: KHỐI THÔNG TIN NỔI BẬT VIỆC LÀM (JOB HERO CARD WIDGET)
 * Khớp chuẩn thiết kế Figma: 5-job detail.png
 *
 * TẬP TIN NÀY CHỊU TRÁCH NHIỆM:
 * 1. Hiển thị thanh Breadcrumbs phân cấp (Home > All Jobs > Job Detail).
 * 2. Hiển thị Card Hero: Logo công ty, tiêu đề bài đăng, ngày tạo, thẻ tags phân loại.
 * 3. Cung cấp 2 nút thao tác chính: SHARE (sao chép URL) và APPLY JOB (mở popup nộp CV).
 *
 * @package JobScout
 * ============================================================================
 */

defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
    <!-- =====================================================================
         1. BREADCRUMBS: THANH ĐIỀU HƯỚNG PHÂN CẤP
         ===================================================================== -->
    <div class="nhomc-container">
        <nav class="nhomc-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <span class="sep">/</span>
            <a href="<?php echo esc_url( home_url( '/all-jobs/' ) ); ?>">All Jobs</a>
            <span class="sep">/</span>
            <span class="current">Job Detail</span>
        </nav>
    </div>

    <!-- =====================================================================
         2. MAIN JOB HERO CARD: KHỐI THÔNG TIN NỔI BẬT ĐẦU TRANG
         Gồm: Logo doanh nghiệp, Tiêu đề, Ngày tạo, Bộ thẻ phân loại & Nút thao tác
         ===================================================================== -->
    <div class="nhomc-container">
        <div class="nhomc-job-hero-card">
            <div class="nhomc-job-hero-left">
                <!-- Chức năng hiển thị Logo doanh nghiệp chuẩn tỉ lệ -->
                <div class="nhomc-company-logo-box">
                    <?php if ( $widget_image ) : ?><img class="nc-widget-image" src="<?php echo esc_url( $widget_image ); ?>" alt="<?php echo esc_attr( $company_name ); ?>"><?php else : ?><?php echo nhomc_get_company_logo( $company_name, $current_job_id, 'large' ); ?><?php endif; ?>
                </div>

                <!-- Tiêu đề công việc và siêu dữ liệu (Metadata) -->
                <div class="nhomc-job-hero-info">
                    <!-- Tên vị trí tuyển dụng lấy trực tiếp từ tiêu đề bài viết -->
                    <h1 class="nhomc-job-title"><?php echo esc_html( $widget_title ?: get_the_title() ); ?></h1>
                    <?php if ( $widget_description !== '' ) : ?><p><?php echo nl2br( esc_html( $widget_description ) ); ?></p><?php endif; ?>

                    <!-- Ngày đăng bài định dạng: Tháng Ngày, Năm (VD: Oct 28, 2026) -->
                    <div class="nhomc-job-meta-row">
                        <span class="nhomc-meta-date">Created: <?php echo date( 'M d, Y', strtotime( get_post_field( 'post_date', $current_job_id ) ) ); ?></span>
                    </div>

                    <!-- Bộ thẻ tags phân loại chuẩn thương hiệu: Loại hình | Ngành nghề | Khu vực -->
                    <div class="nhomc-job-tags-row">
                        <span class="nhomc-tag-item"><?php echo esc_html( $badges['type'] ); ?></span>
                        <span class="nhomc-tag-sep">|</span>
                        <span class="nhomc-tag-item"><?php echo esc_html( $badges['category'] ); ?></span>
                        <span class="nhomc-tag-sep">|</span>
                        <span class="nhomc-tag-item"><?php echo esc_html( $badges['location'] ); ?></span>
                    </div>
                </div>
            </div>

            <!-- Các nút tương tác: Chia sẻ công việc (Share) và Ứng tuyển nhanh (Apply Job) -->
            <div class="nhomc-job-hero-right">
                <button type="button" class="nhomc-btn-share" onclick="nhomcShareJob(this)">SHARE</button>
                <button type="button" class="nhomc-btn-apply" onclick="nhomcOpenApplyModal()">APPLY JOB</button>
            </div>
        </div>
    </div>
