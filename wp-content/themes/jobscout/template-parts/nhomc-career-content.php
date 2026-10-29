<?php
/**
 * ==============================================================================
 * TẬP TIN: nhomc-career-content.php
 * DỰ ÁN: CỔNG TUYỂN DỤNG JOBSCOUT - FIT TDC (ĐỒ ÁN CUỐI KỲ NHÓM C)
 * NHÁNH: Hien/1-home
 * TÁC GIẢ: Nguyễn Thanh Hiền (thenghien2006@gmail.com)
 * VAI TRÒ: Phụ trách Tính năng 1 - Giao diện Trang Chủ (Home Page)
 * ==============================================================================
 * MÔ TẢ CHI TIẾT:
 * Nội dung mẫu chuẩn cho khối CAREER WITH US theo thiết kế 1-home.png:
 * 1. Tiêu đề in hoa: CAREER WITH US
 * 2. 2 đoạn văn bản giới thiệu tinh thần hiếu khách Omotenashi của tập đoàn.
 * 3. Nút bấm viền trắng bán trong suốt dẫn sang trang Giới thiệu (/about-us/).
 * ==============================================================================
 */

// 1. Chống truy cập trực tiếp file từ thanh địa chỉ trình duyệt
defined( 'ABSPATH' ) || exit; 
?>

<!-- Thẻ <h2>: Tiêu đề in hoa chữ trắng, kích thước lớn 30px, khoảng cách ký tự 1.5px -->
<h2 class="hm-career-title">CAREER WITH US</h2>

<!-- Thẻ <p>: Đoạn văn thứ nhất giới thiệu nguồn gốc triết lý Omotenashi của tập đoàn Plan Do See Global -->
<p class="hm-career-desc">
    Plan Do See Global is a hospitality group founded in Japan and rooted in “Omotenashi”, the Japanese principle of selfless hospitality. We strive to deliver unforgettable and bespoke experiences, to understand local cultures like natives, to provide service that is warm but not intrusive, and to foresee our guests' every need at all times. That is our sole mission and purpose.
</p>

<!-- Thẻ <p>: Đoạn văn thứ hai mô tả năng lực phát triển dự án và quản lý vận hành -->
<p class="hm-career-desc">
    We are experts in all stages of project development: concept, design, implementation and management.<br>
    We love to find unique ways to create experiences that surprise and delight guests and customers.
</p>

<!-- Thẻ <div>: Khung bao bọc căn lề phía trên cho nút bấm (margin-top: 32px) -->
<div class="hm-career-btn-wrap">
    <!-- Thẻ <a>: Nút bấm 'MORE ABOUT US' bo góc viền trắng. Hàm wp_make_link_relative() tạo URL tương đối an toàn dẫn tới trang /about-us/ -->
    <a href="<?php echo esc_url( wp_make_link_relative( home_url( '/about-us/' ) ) ); ?>" class="hm-btn-more-about">MORE ABOUT US</a>
</div><!-- Kết thúc hm-career-btn-wrap -->

