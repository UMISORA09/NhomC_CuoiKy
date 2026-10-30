<?php
/**
 * ============================================================================
 * TEMPLATE HIỂN THỊ TRANG CHI TIẾT VIỆC LÀM (SINGLE JOB LISTING)
 * Khớp chuẩn thiết kế Figma: 5-job detail.png
 *
 * TẬP TIN NÀY CHỊU TRÁCH NHIỆM:
 * 1. Làm bộ điều phối (Template Router) cho Custom Post Type 'job_listing'.
 * 2. Gọi Header chuyên biệt của trang chi tiết việc làm (header-jobdetail.php).
 * 3. Khởi tạo WordPress The Loop để thiết lập ngữ cảnh dữ liệu của bài đăng việc làm.
 * 4. Nạp thành phần giao diện chính: template-parts/content-jobdetail-view.php.
 * 5. Gọi Footer chuyên biệt (footer-jobdetail.php) chứa Modal nộp hồ sơ CV và script.
 *
 * @package JobScout
 * ============================================================================
 */

// Bước 1: Nạp Header chuyên biệt cho trang chi tiết việc làm (header-jobdetail.php)
get_header( 'jobdetail' );

// Bước 2: Vòng lặp The Loop của WordPress thiết lập bài viết hiện tại
while ( have_posts() ) : the_post();

    // Bước 3: Nạp template hiển thị chi tiết công việc (content-jobdetail-view.php)
    get_template_part( 'template-parts/content', 'jobdetail-view' );

endwhile;

// Bước 4: Nạp Footer chuyên biệt (footer-jobdetail.php) chứa Modal Apply CV & AJAX Script
get_footer( 'jobdetail' );