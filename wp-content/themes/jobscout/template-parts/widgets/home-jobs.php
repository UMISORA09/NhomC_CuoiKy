<?php
/**
 * ==============================================================================
 * TẬP TIN: home-jobs.php
 * DỰ ÁN: CỔNG TUYỂN DỤNG JOBSCOUT - FIT TDC (ĐỒ ÁN CUỐI KỲ NHÓM C)
 * NHÁNH: Hien/1-home
 * TÁC GIẢ: Nguyễn Thanh Hiền (thenghien2006@gmail.com)
 * VAI TRÒ: Phụ trách Tính năng 1 - Giao diện Trang Chủ (Home Page)
 * THÀNH PHẦN: Widget Danh Sách 6 Việc Làm Tiêu Biểu (TOP JOBS)
 * BẢN VẼ: job-design/1-home.png (Mục 3. Top Jobs Section)
 * ==============================================================================
 * MÔ TẢ CHI TIẾT:
 * Widget hiển thị lưới 6 việc làm mới nhất:
 * 1. Lưới Grid hiển thị 2 cột trên máy tính, 1 cột trên điện thoại.
 * 2. Vòng lặp foreach duyệt mảng $home_jobs đã được xử lý ở template-home.php.
 * 3. Mỗi thẻ việc làm (hm-job-card) hỗ trợ tương tác click toàn thẻ (full-card clickable)
 *    để chuyển ngay sang trang chi tiết (/job-detail/?job_id=...).
 * 4. Cột trái: Logo vector thương hiệu đối tác (The Sodoh, Fortune Garden,...).
 * 5. Cột phải: Tiêu đề công việc, Ngày đăng, Thẻ phân loại (Type, Category, Location)
 *    và 3 dòng gạch đầu dòng mô tả đãi ngộ.
 * 6. Cuối khối có nút bấm "VIEW MORE JOBS" dẫn sang trang toàn bộ việc làm (/jobs/).
 * ==============================================================================
 */

// 1. Chống truy cập trực tiếp file từ thanh địa chỉ trình duyệt (Bảo mật: ngăn chặn gọi file ngoài luồng WordPress)
defined( 'ABSPATH' ) || exit;

// 2. Gán giá trị mặc định cho tiêu đề widget là chuỗi rỗng nếu chưa được khai báo (Toán tử Null Coalescing ?? chống lỗi Undefined)
$args['widget_title'] = $args['widget_title'] ?? '';

// 3. Hàm extract() bung toàn bộ các phần tử trong mảng $args thành các biến độc lập (như $widget_title, $home_jobs). Cờ EXTR_SKIP tránh ghi đè biến đã có
extract( $args, EXTR_SKIP );
?>

<!-- ============================================================================
     BẮT ĐẦU KHỐI GIAO DIỆN: 6 VIỆC LÀM TIÊU BIỂU (TOP JOBS)
     ============================================================================ -->

<!-- Thẻ <section>: Nhóm toàn bộ khu vực Top Jobs thành một phần riêng, có id="top-jobs" để hỗ trợ cuộn trang (smooth scroll) -->
<section class="hm-section-jobs" id="top-jobs">

    <!-- Thẻ <div class="hm-container">: Giới hạn độ rộng khung nội dung tối đa 1140px, tự động căn giữa màn hình -->
    <div class="hm-container">

        <!-- Thẻ <h2>: Tiêu đề đề mục lớn. Hàm esc_html() lọc sạch mã độc XSS. Toán tử Elvis ?: in chữ 'TOP JOBS' nếu biến rỗng -->
        <h2 class="hm-section-heading"><?php echo esc_html( $widget_title ?: 'TOP JOBS' ); ?></h2>
        
        <!-- Thẻ <div>: Lưới hiển thị CSS Grid 2 cột trên Desktop và tự động co lại thành 1 cột trên điện thoại di động -->
        <div class="hm-jobs-grid">

            <!-- Vòng lặp foreach: Duyệt qua mảng $home_jobs, mỗi lượt lặp biến $job đại diện cho 1 công việc cụ thể (gồm title, logo, tags, link,...) -->
            <?php foreach ( $home_jobs as $job ) : ?>

                <!-- Thẻ <div class="hm-job-card">: Thẻ bao bọc toàn bộ công việc. Thuộc tính onclick dùng JavaScript window.location.href để click bất kỳ đâu trên thẻ cũng mở trang chi tiết -->
                <div class="hm-job-card" onclick="window.location.href='<?php echo esc_url( $job['link'] ); ?>';">
                    
                    <!-- CỘT BÊN TRÁI: Logo thương hiệu chuẩn Vector sắc nét của doanh nghiệp tuyển dụng -->
                    <div class="hm-job-logo">
                        <!-- Thẻ <i>: Hiển thị icon vector FontAwesome (ví dụ: fa-hotel, fa-tree...). Hàm esc_attr() lọc an toàn thuộc tính class -->
                        <i class="<?php echo esc_attr( $job['brand']['icon'] ); ?> hm-logo-vector-icon"></i>

                        <!-- Thẻ <span>: Tên thương hiệu chính in hoa đậm (ví dụ: THE SODOH, FORTUNE GARDEN...). Hàm esc_html() in an toàn -->
                        <span class="hm-logo-vector-name"><?php echo esc_html( $job['brand']['name'] ); ?></span>

                        <!-- Thẻ <span>: Dòng chữ phụ định danh chi nhánh bên dưới logo (ví dụ: KYOTO, TOKYO, GLOBAL...) -->
                        <span class="hm-logo-vector-sub"><?php echo esc_html( $job['brand']['sub'] ); ?></span>
                    </div><!-- Kết thúc cột bên trái hm-job-logo -->
                    
                    <!-- CỘT BÊN PHẢI: Chứa toàn bộ thông tin chi tiết về việc làm tuyển dụng -->
                    <div class="hm-job-info">

                        <!-- Thẻ <h3>: Tiêu đề việc làm in hoa, đậm nét -->
                        <h3 class="hm-job-title">
                            <!-- Thẻ <a>: Đường link phụ trợ chuyển hướng đến trang chi tiết công việc, bảo vệ bằng hàm esc_url() và esc_html() -->
                            <a href="<?php echo esc_url( $job['link'] ); ?>"><?php echo esc_html( $job['title'] ); ?></a>
                        </h3><!-- Kết thúc thẻ h3 tiêu đề -->
                        
                        <!-- Thẻ <div>: Hiển thị ngày đăng bài viết định dạng Tháng Ngày, Năm (ví dụ: Created: Oct 29, 2026) -->
                        <div class="hm-job-date"><?php echo esc_html( $job['date'] ); ?></div>
                        
                        <!-- Thẻ <div>: Thanh hiển thị 3 nhãn phân loại (Hình thức làm việc | Danh mục ngành nghề | Địa điểm) -->
                        <div class="hm-job-tags">
                            <!-- Nhãn 1: Hình thức làm việc (ví dụ: Fulltime, Part-time) -->
                            <span class="hm-job-tag"><?php echo esc_html( $job['type'] ); ?></span>

                            <!-- Ký tự gạch đứng | màu xám nhạt dùng làm dấu phân cách trực quan -->
                            <span class="hm-tag-sep">|</span>

                            <!-- Nhãn 2: Danh mục ngành nghề tuyển dụng (ví dụ: Category Name) -->
                            <span class="hm-job-tag"><?php echo esc_html( $job['category'] ); ?></span>

                            <!-- Ký tự gạch đứng | màu xám nhạt phân cách -->
                            <span class="hm-tag-sep">|</span>

                            <!-- Nhãn 3: Địa điểm làm việc (ví dụ: Ho Chi Minh City) -->
                            <span class="hm-job-tag"><?php echo esc_html( $job['location'] ); ?></span>
                        </div><!-- Kết thúc thanh gắn nhãn hm-job-tags -->
                        
                        <!-- Thẻ <ul>: Danh sách không thứ tự hiển thị 3 quyền lợi / đãi ngộ của công việc -->
                        <ul class="hm-job-bullets">
                            <!-- Vòng lặp foreach duyệt mảng các dòng quyền lợi trong $job['bullets'] -->
                            <?php foreach ( $job['bullets'] as $bullet ) : ?>
                                <!-- Thẻ <li>: Từng dòng gạch đầu dòng quyền lợi, lọc sạch mã độc bằng esc_html() -->
                                <li><?php echo esc_html( $bullet ); ?></li>
                            <!-- Kết thúc vòng lặp foreach duyệt quyền lợi -->
                            <?php endforeach; ?>
                        </ul><!-- Kết thúc thẻ danh sách ul -->

                    </div><!-- Kết thúc cột bên phải hm-job-info -->

                </div><!-- Kết thúc thẻ div bao bọc 1 công việc (hm-job-card) -->

            <!-- Kết thúc vòng lặp foreach duyệt 6 công việc -->
            <?php endforeach; ?>

        </div><!-- Kết thúc lưới hiển thị hm-jobs-grid -->
        
        <!-- Khối bao bọc nút bấm điều hướng căn giữa trang -->
        <div class="hm-more-jobs-wrap">
            <!-- Thẻ <a>: Nút bấm to màu cam dẫn sang trang toàn bộ danh sách việc làm (/jobs/) -->
            <a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>" class="hm-btn-view-more">VIEW MORE JOBS</a>
        </div><!-- Kết thúc khối bọc nút xem thêm -->

    </div><!-- Kết thúc thẻ container -->

</section><!-- Kết thúc toàn bộ khối section Top Jobs -->


