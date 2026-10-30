<?php
/**
 * ============================================================================
 * HEADER CHUYÊN BIỆT CHO TRANG CHI TIẾT VIỆC LÀM (HEADER JOB DETAIL)
 * Khớp chuẩn thiết kế Figma: 5-job detail.png
 *
 * TẬP TIN NÀY CHỊU TRÁCH NHIỆM:
 * 1. Khai báo tài liệu HTML5 chuẩn SEO và Responsive cho thiết bị di động.
 * 2. Gọi wp_head() để WordPress tự động enqueue các file CSS (nhomc-job-detail.css)
 *    và các font chữ, script cần thiết.
 * 3. Thêm class 'nhomc-job-page' vào thẻ <body> để cô lập phạm vi CSS của trang chi tiết.
 * 4. Gọi template phần đầu trang: template-parts/nhomc-header.php (Logo NhomC, Menu chính).
 *
 * @package JobScout
 * ============================================================================
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Thiết lập bộ mã ký tự chuẩn UTF-8 -->
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <!-- Cấu hình hiển thị chuẩn Responsive cho mọi kích thước màn hình -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Hook nạp tài nguyên CSS, Fonts, Scripts từ functions.php -->
    <?php wp_head(); ?>
</head>

<!-- Thẻ body gắn kèm class 'nhomc-job-page' để nhận diện phong cách thiết kế Nhóm C -->
<body <?php body_class( 'nhomc-job-page' ); ?>>
<?php wp_body_open(); ?>

<!-- Nạp thanh điều hướng Header chung của website (Logo NhomC Recruiting & Menu) -->
<?php get_template_part( 'template-parts/nhomc-header' ); ?>

