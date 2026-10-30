<?php
/**
 * ==============================================================================
 * TẬP TIN: blog-hero.php
 * VỊ TRÍ: wp-content/themes/jobscout/template-parts/widgets/blog-hero.php
 * DỰ ÁN: CỔNG TUYỂN DỤNG JOBSCOUT - FIT TDC (ĐỒ ÁN CUỐI KỲ NHÓM C)
 * NHÁNH: xuanhoa/3-news
 * TÁC GIẢ: Nguyễn Xuân Hòa (vhoa1682006@gmail.com)
 * VAI TRÒ: Khối Banner Hero "PDS NEWS" của trang Tin tức (News Page)
 * TÍCH HỢP: Vùng widget 'nhomc-blog' trong Trình tùy biến Customizer (Sửa giao diện)
 * BẢN VẼ: job-design/3-news.png
 * ==============================================================================
 */

defined( 'ABSPATH' ) || exit;

// Lấy tham số widget_title nếu được cấu hình trong Customizer
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
<!-- HERO BANNER: PDS NEWS (Hình ảnh gốc chứa sẵn tiêu đề PDS NEWS sắc nét chuẩn bản vẽ 3-news.png) -->
<section class="news-hero" aria-label="PDS News Banner">
    <h1 class="news-sr-only">PDS NEWS</h1>
</section>
