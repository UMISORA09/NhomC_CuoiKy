<?php
/**
 * ==============================================================================
 * TẬP TIN: front-page.php
 * DỰ ÁN: CỔNG TUYỂN DỤNG JOBSCOUT - FIT TDC (ĐỒ ÁN CUỐI KỲ NHÓM C)
 * NHÁNH: Hien/1-home
 * TÁC GIẢ: Nguyễn Thanh Hiền (thenghien2006@gmail.com)
 * VAI TRÒ: Phụ trách Tính năng 1 - Giao diện Trang Chủ (Home Page)
 * ==============================================================================
 * MÔ TẢ CHI TIẾT:
 * File điều hướng mặc định của WordPress khi người dùng truy cập vào trang chủ.
 * Cơ chế hoạt động:
 * 1. Kiểm tra sự tồn tại của file template tùy biến 'template-home.php' của Hiền.
 * 2. Ưu tiên nạp ngay 'template-home.php' để website hiển thị đúng 100% bản vẽ 1-home.png.
 * 3. Nếu không có mới rơi về cấu hình mặc định của theme gốc JobScout.
 * ==============================================================================
 */

// BƯỚC 1: Kiểm tra xem file giao diện tùy biến template-home.php của Nhóm C có tồn tại trong theme hay không
if ( file_exists( get_template_directory() . '/template-home.php' ) ) {
    // Nạp trực tiếp giao diện Trang Chủ do Nguyễn Thanh Hiền xây dựng
    include get_template_directory() . '/template-home.php';
    // Dừng xử lý các đoạn code mặc định phía dưới để tối ưu tốc độ tải trang
    return;
}

// BƯỚC 2: Cấu hình mặc định dự phòng của theme gốc (chỉ chạy khi thiếu file template-home.php)
$home_sections = jobscout_get_home_sections();

if ( 'posts' == get_option( 'show_on_front' ) ) { 
    // Nếu trong Cài đặt > Đọc (Settings > Reading) chọn hiển thị bài viết mới nhất
    include( get_home_template() );
} elseif ( $home_sections ) { 
    // Nạp phần đầu trang (Header) mặc định
    get_header();
    // Vòng lặp nạp các section mặc định của theme gốc nếu được bật trong Customizer
    foreach( $home_sections as $section ){
        get_template_part( 'sections/' . esc_attr( $section ) );  
    }
    // Nạp phần chân trang (Footer) mặc định
    get_footer();
} else {
    // Hiển thị template trang tĩnh mặc định tương ứng
    include( get_page_template() );
}