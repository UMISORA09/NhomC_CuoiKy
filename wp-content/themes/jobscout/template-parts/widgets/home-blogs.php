<?php
/**
 * ==============================================================================
 * TẬP TIN: home-blogs.php
 * DỰ ÁN: CỔNG TUYỂN DỤNG JOBSCOUT - FIT TDC (ĐỒ ÁN CUỐI KỲ NHÓM C)
 * NHÁNH: Hien/1-home
 * TÁC GIẢ: Nguyễn Thanh Hiền (thenghien2006@gmail.com)
 * VAI TRÒ: Phụ trách Tính năng 1 - Giao diện Trang Chủ (Home Page)
 * THÀNH PHẦN: Widget 4 Bài Viết Mới Nhất (NEWEST BLOG ENTRIES)
 * BẢN VẼ: job-design/1-home.png (Mục 5. Newest Blog Entries Section)
 * ==============================================================================
 * MÔ TẢ CHI TIẾT:
 * Widget hiển thị lưới 4 bài viết tin tức mới nhất:
 * 1. Bố cục dạng Lưới (Grid) 2 cột x 2 hàng trên Desktop, 1 cột trên Mobile.
 * 2. Vòng lặp foreach duyệt qua mảng $home_blogs đã chuẩn hóa ở template-home.php.
 * 3. Mỗi thẻ bài viết (hm-blog-card) gồm 2 phần ngang:
 *    - Cột trái: Ảnh đại diện tỉ lệ vuông 180x180px sắc nét, bo góc nhẹ.
 *    - Cột phải: Tiêu đề bài viết, đoạn tóm tắt nội dung (giới hạn 3 dòng chống tràn layout)
 *      và nút bấm "Read More" màu cam thương hiệu.
 * ==============================================================================
 */

// 1. Chống truy cập trực tiếp file từ thanh địa chỉ trình duyệt (Bảo mật WordPress: nếu không có ABSPATH thì lập tức exit)
defined( 'ABSPATH' ) || exit;

// 2. Kiểm tra nếu chưa có tiêu đề widget thì gán giá trị mặc định là chuỗi rỗng (Toán tử Null Coalescing ?? chống lỗi Undefined)
$args['widget_title'] = $args['widget_title'] ?? '';

// 3. Hàm extract() bung toàn bộ các phần tử trong mảng $args thành các biến độc lập (ví dụ biến $widget_title, biến $home_blogs). Cờ EXTR_SKIP giúp không ghi đè biến đã có
extract( $args, EXTR_SKIP );
?>

<!-- ============================================================================
     BẮT ĐẦU KHỐI GIAO DIỆN: 4 BÀI VIẾT TIN TỨC MỚI NHẤT (NEWEST BLOG ENTRIES)
     ============================================================================ -->

<!-- Thẻ <section> ngữ nghĩa: Gom toàn bộ khu vực tin tức thành một khối riêng biệt, class hm-section-blogs định dạng màu nền xám nhạt #f5f6f8 và padding -->
<section class="hm-section-blogs">

    <!-- Thẻ <div class="hm-container">: Giới hạn chiều rộng tối đa 1140px và căn giữa màn hình bằng margin: 0 auto -->
    <div class="hm-container">

        <!-- Thẻ <h2>: Tiêu đề đề mục lớn. Hàm esc_html() lọc sạch mã độc XSS trước khi hiển thị. Toán tử ?: in chữ 'NEWEST BLOG ENTRIES' nếu biến rỗng -->
        <h2 class="hm-section-heading"><?php echo esc_html( $widget_title ?: 'NEWEST BLOG ENTRIES' ); ?></h2>
        
        <!-- Thẻ <div>: Lưới hiển thị CSS Grid gồm 2 cột x 2 hàng trên máy tính và tự co thành 1 cột trên điện thoại -->
        <div class="hm-blogs-grid">

            <!-- Vòng lặp foreach: Duyệt qua từng bài viết trong mảng $home_blogs, mỗi lượt lặp thì biến $blog đại diện cho 1 bài viết cụ thể -->
            <?php foreach ( $home_blogs as $blog ) : ?>

                <!-- Thẻ <article>: Ngữ nghĩa HTML5 đại diện cho một bài báo/bài viết hoàn chỉnh, có viền trắng và đổ bóng nhẹ -->
                <article class="hm-blog-card">

                    <!-- CỘT BÊN TRÁI: Khung vuông 180px x 180px cố định để chứa ảnh đại diện của bài viết -->
                    <div class="hm-blog-thumb">
                        <!-- Thẻ <img>: Hiển thị hình ảnh. Hàm esc_url() bảo vệ link ảnh, hàm esc_attr() lọc an toàn tiêu đề ảnh trong thuộc tính alt -->
                        <img src="<?php echo esc_url( $blog['image'] ); ?>" alt="<?php echo esc_attr( $blog['title'] ); ?>">
                    </div><!-- Kết thúc thẻ hm-blog-thumb -->
                    
                    <!-- CỘT BÊN PHẢI: Chứa toàn bộ nội dung văn bản (tiêu đề, tóm tắt và nút xem thêm) -->
                    <div class="hm-blog-body">

                        <!-- Khối chứa tiêu đề và đoạn tóm tắt bài viết -->
                        <div>
                            <!-- Thẻ <h3>: Tiêu đề bài viết in đậm chữ màu đen -->
                            <h3 class="hm-blog-title">
                                <!-- Thẻ <a>: Đường link dẫn sang trang xem chi tiết bài viết, được bảo vệ bằng hàm esc_url() và in tiêu đề bằng esc_html() -->
                                <a href="<?php echo esc_url( $blog['link'] ); ?>"><?php echo esc_html( $blog['title'] ); ?></a>
                            </h3><!-- Kết thúc thẻ h3 tiêu đề -->

                            <!-- Thẻ <p>: Đoạn văn tóm tắt nội dung bài viết. CSS sẽ tự động cắt tối đa 3 dòng kèm dấu 3 chấm nếu nội dung quá dài -->
                            <p class="hm-blog-excerpt"><?php echo esc_html( $blog['excerpt'] ); ?></p>
                        </div><!-- Kết thúc khối tiêu đề và tóm tắt -->

                        <!-- Khối chứa nút bấm xem chi tiết ở góc dưới cùng -->
                        <div>
                            <!-- Thẻ <a>: Nút bấm 'Read More' màu cam thương hiệu #eb6723, click vào sẽ chuyển hướng đến bài viết -->
                            <a href="<?php echo esc_url( $blog['link'] ); ?>" class="hm-blog-readmore">Read More</a>
                        </div><!-- Kết thúc khối chứa nút bấm -->

                    </div><!-- Kết thúc cột bên phải hm-blog-body -->

                </article><!-- Kết thúc thẻ article đại diện 1 thẻ bài viết -->

            <!-- Kết thúc vòng lặp foreach in 4 bài viết tin tức -->
            <?php endforeach; ?>

        </div><!-- Kết thúc thẻ lưới hm-blogs-grid -->

    </div><!-- Kết thúc thẻ container -->

</section><!-- Kết thúc toàn bộ khối section tin tức -->


