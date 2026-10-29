<?php
/**
 * ==============================================================================
 * TẬP TIN: home-career.php
 * DỰ ÁN: CỔNG TUYỂN DỤNG JOBSCOUT - FIT TDC (ĐỒ ÁN CUỐI KỲ NHÓM C)
 * NHÁNH: Hien/1-home
 * TÁC GIẢ: Nguyễn Thanh Hiền (thenghien2006@gmail.com)
 * VAI TRÒ: Phụ trách Tính năng 1 - Giao diện Trang Chủ (Home Page)
 * THÀNH PHẦN: Widget Cơ Hội Nghề Nghiệp (CAREER WITH US)
 * BẢN VẼ: job-design/1-home.png (Mục 4. Career Section)
 * ==============================================================================
 * MÔ TẢ CHI TIẾT:
 * Widget hiển thị khối thông điệp nghề nghiệp và tuyển dụng:
 * 1. Sử dụng hình nền $career_bg phủ màng tối (overlay) đảm bảo độ tương phản.
 * 2. Linh hoạt nạp nội dung tùy biến $career_widget_content nếu được truyền từ widget,
 *    hoặc nạp template dùng chung 'template-parts/nhomc-career-content.php' chuẩn đồ án.
 * ==============================================================================
 */

// 1. Chống truy cập trực tiếp file từ thanh địa chỉ trình duyệt (Bảo mật: ngăn chặn gọi file ngoài luồng WordPress)
defined( 'ABSPATH' ) || exit;

// 2. Gán giá trị mặc định cho tiêu đề widget là chuỗi rỗng nếu chưa được truyền vào (Toán tử Null Coalescing ?? chống lỗi Undefined)
$args['widget_title'] = $args['widget_title'] ?? '';

// 3. Hàm extract() bung toàn bộ các phần tử trong mảng $args thành các biến độc lập (như $widget_title, $career_bg). Cờ EXTR_SKIP tránh ghi đè biến đã có
extract( $args, EXTR_SKIP );
?>

<!-- ============================================================================
     BẮT ĐẦU KHỐI GIAO DIỆN: CƠ HỘI NGHỀ NGHIỆP (CAREER WITH US)
     ============================================================================ -->

<!-- Thẻ <section>: Khối Career toàn màn hình. Thuộc tính style gắn hình nền $career_bg bằng hàm bảo mật esc_url() -->
<section class="hm-section-career" style="background-image: url('<?php echo esc_url( $career_bg ); ?>');">

    <!-- Thẻ <div>: Lớp phủ tối màu đen (CSS opacity 0.45) giúp văn bản màu trắng dễ đọc, nổi bật trên nền hình ảnh -->
    <div class="hm-career-overlay"></div>
    
    <!-- Thẻ <div class="hm-container">: Giới hạn chiều rộng khung hiển thị tối đa 1140px, tự động căn giữa màn hình -->
    <div class="hm-container">

        <!-- Thẻ <div>: Khung chứa nội dung trung tâm gồm tiêu đề, 2 đoạn văn giới thiệu và nút MORE ABOUT US -->
        <div class="hm-career-content">
            <?php 
            // 4. Kiểm tra điều kiện: Nếu quản trị viên có nhập nội dung tùy biến trong widget thì ưu tiên hiển thị nội dung đó
            if ( ! empty( $career_widget_content ) ) {
                // In ra nội dung tùy biến từ khu vực quản trị widget
                echo $career_widget_content;
            } else {
                // Ngược lại, hàm get_template_part() tự động nạp file mẫu 'template-parts/nhomc-career-content.php' chuẩn đồ án 1-home.png
                get_template_part( 'template-parts/nhomc-career-content' );
            } 
            ?>
        </div><!-- Kết thúc thẻ hm-career-content -->

    </div><!-- Kết thúc thẻ hm-container -->

</section><!-- Kết thúc section hm-section-career -->


