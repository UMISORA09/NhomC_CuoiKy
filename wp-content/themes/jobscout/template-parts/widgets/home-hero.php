<?php
/**
 * ==============================================================================
 * TẬP TIN: home-hero.php
 * DỰ ÁN: CỔNG TUYỂN DỤNG JOBSCOUT - FIT TDC (ĐỒ ÁN CUỐI KỲ NHÓM C)
 * NHÁNH: Hien/1-home
 * TÁC GIẢ: Nguyễn Thanh Hiền (thenghien2006@gmail.com)
 * VAI TRÒ: Phụ trách Tính năng 1 - Giao diện Trang Chủ (Home Page)
 * THÀNH PHẦN: Widget Banner Hero & Khung Tìm Kiếm Việc Làm
 * BẢN VẼ: job-design/1-home.png (Mục 2. Hero Section)
 * ==============================================================================
 * MÔ TẢ CHI TIẾT:
 * Widget hiển thị banner chính của trang chủ:
 * 1. Hình nền lớn công trình hiện đại (hero_bg).
 * 2. Lớp phủ đen trong suốt (overlay) giúp tôn nổi chữ màu trắng tương phản cao.
 * 3. Tiêu đề lớn: "FIND YOUR DREAM JOBS" và đoạn thông điệp truyền cảm hứng.
 * 4. Biểu mẫu tìm kiếm (Form GET) gửi dữ liệu trực tiếp sang trang /jobs/:
 *    - Ô input tìm theo từ khóa: chức danh, kỹ năng, công ty tuyển dụng.
 *    - Ô select chọn địa điểm làm việc: Tokyo, TP.HCM, Hà Nội, Đà Nẵng.
 *    - Nút bấm cam nổi bật "SEARCH JOB".
 * ==============================================================================
 */

// 1. Chống truy cập trực tiếp file từ thanh địa chỉ trình duyệt (Bảo mật: ngăn chặn gọi file ngoài luồng WordPress)
defined( 'ABSPATH' ) || exit;

// 2. Gán giá trị mặc định cho tiêu đề widget là chuỗi rỗng nếu chưa được truyền vào (Toán tử Null Coalescing ?? chống lỗi Undefined)
$args['widget_title'] = $args['widget_title'] ?? '';

// 3. Hàm extract() bung toàn bộ các phần tử trong mảng $args thành các biến độc lập (như $widget_title, $hero_bg). Cờ EXTR_SKIP tránh ghi đè biến đã có
extract( $args, EXTR_SKIP );
?>

<!-- ============================================================================
     BẮT ĐẦU KHỐI GIAO DIỆN: BANNER HERO & THANH TÌM KIẾM VIỆC LÀM TRANG CHỦ
     ============================================================================ -->

<!-- Thẻ <section>: Khối Banner Hero toàn màn hình. Thuộc tính style gắn hình nền $hero_bg thông qua hàm bảo mật esc_url() -->
<section class="hm-hero" style="background-image: url('<?php echo esc_url( $hero_bg ); ?>');">

    <!-- Thẻ <div>: Lớp phủ màu đen bán trong suốt (CSS opacity 0.45) giúp chữ màu trắng nổi bật, dễ đọc trên ảnh nền -->
    <div class="hm-hero-overlay"></div>
    
    <!-- Thẻ <div class="hm-container">: Giới hạn độ rộng khung nội dung tối đa 1140px, tự động căn giữa màn hình bằng margin: 0 auto -->
    <div class="hm-container">

        <!-- Thẻ <div>: Khung chứa nội dung trung tâm của Banner (tiêu đề, phụ đề và form tìm kiếm) -->
        <div class="hm-hero-content">

            <!-- Thẻ <h1>: Tiêu đề quan trọng nhất của trang chủ, in hoa chữ trắng lớn 'FIND YOUR DREAM JOBS' -->
            <h1 class="hm-hero-title">FIND YOUR DREAM JOBS</h1>
            
            <!-- Thẻ <p>: Đoạn thông điệp triết lý công ty theo đúng bản vẽ thiết kế 1-home.png -->
            <p class="hm-hero-subtitle">
                The secret behind our company is simple: to always put ourselves in the other person's shoes-employee, guest or customer. This allows us to see the world through their eyes, anticipate their needs and better understand their feelings.
            </p>
            
            <!-- Thẻ <form>: Biểu mẫu tìm kiếm việc làm. Action gửi đến trang /jobs/, method="get" để từ khóa hiển thị trên URL cho phép bookmark link -->
            <form class="hm-search-form" action="<?php echo esc_url( home_url( '/jobs/' ) ); ?>" method="get">
                
                <!-- 1. Ô NHẬP TỪ KHÓA TÌM VIỆC (Job Title, Skills, Company) -->
                <div class="hm-search-input-box">
                    <!-- Icon kính lúp vector SVG màu cam thương hiệu #eb6723 -->
                    <svg class="hm-icon-search" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#eb6723" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <!-- Ô <input>: Cho phép người dùng gõ từ khóa. Thuộc tính name="search_keywords" là tham số chuẩn của plugin WP Job Manager -->
                    <input type="text" name="search_keywords" placeholder="Search for jobs, companies, skills" autocomplete="off">
                </div><!-- Kết thúc ô nhập từ khóa -->
                
                <!-- 2. Ô CHỌN ĐỊA ĐIỂM LÀM VIỆC (Location Dropdown) -->
                <div class="hm-search-location-box">
                    <!-- Icon định vị bản đồ vector SVG màu cam thương hiệu #eb6723 -->
                    <svg class="hm-icon-location" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#eb6723" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <!-- Thẻ <select>: Danh sách cuộn chọn địa điểm làm việc tương ứng với tham số name="search_location" -->
                    <select name="search_location">
                        <option value="">Tokyo</option>
                        <option value="Ho Chi Minh City">Ho Chi Minh City</option>
                        <option value="Ha Noi">Ha Noi</option>
                        <option value="Da Nang">Da Nang</option>
                    </select>
                    <!-- Icon mũi tên chỉ xuống vector SVG cho menu thả xuống -->
                    <svg class="hm-icon-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div><!-- Kết thúc ô chọn địa điểm -->
                
                <!-- 3. NÚT BẤM GỬI TÌM KIẾM -->
                <!-- Thẻ <button type="submit">: Kích hoạt gửi toàn bộ từ khóa và địa điểm sang trang danh sách việc làm -->
                <button type="submit" class="hm-search-submit-btn">SEARCH JOB</button>

            </form><!-- Kết thúc form tìm kiếm hm-search-form -->

        </div><!-- Kết thúc hm-hero-content -->

    </div><!-- Kết thúc hm-container -->

</section><!-- Kết thúc section hm-hero -->


