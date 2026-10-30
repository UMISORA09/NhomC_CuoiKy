<?php
/**
 * ==============================================================================
 * TẬP TIN: blog-list.php
 * VỊ TRÍ: wp-content/themes/jobscout/template-parts/widgets/blog-list.php
 * DỰ ÁN: CỔNG TUYỂN DỤNG JOBSCOUT - FIT TDC (ĐỒ ÁN CUỐI KỲ NHÓM C)
 * NHÁNH: xuanhoa/3-news
 * TÁC GIẢ: Nguyễn Xuân Hòa (vhoa1682006@gmail.com)
 * VAI TRÒ: Khối hiển thị danh sách các bài viết Tin tức (NEWEST BLOG ENTRIES)
 * TÍCH HỢP: Widget 'nhomc_blog_list' trong vùng 'nhomc-blog' tại Customizer (Sửa giao diện)
 * BẢN VẼ: job-design/3-news.png
 * ==============================================================================
 */

defined( 'ABSPATH' ) || exit;

// Lấy tiêu đề khối widget cấu hình từ Customizer (mặc định là 'NEWEST BLOG ENTRIES')
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );

// Đảm bảo biến danh sách bài viết tồn tại
$news_items = $news_items ?? array();
?>
<!-- KHỐI NỘI DUNG CHÍNH: NEWEST BLOG ENTRIES -->
<main class="news-main-section">
    <div class="news-main-inner">
        <!-- Tiêu đề khối bài viết (hỗ trợ chỉnh sửa linh hoạt từ Customizer "Sửa giao diện") -->
        <h2 class="news-main-heading"><?php echo esc_html( ! empty( $widget_title ) ? $widget_title : 'NEWEST BLOG ENTRIES' ); ?></h2>

        <!-- Lưới bài viết tin tức 2 cột chuẩn thiết kế -->
        <div class="news-grid">
            <?php foreach ( $news_items as $post_item ): ?>
            <article class="news-card" onclick="window.location.href='<?php echo esc_url( $post_item['link'] ); ?>';" style="cursor: pointer;" role="link" tabindex="0" onkeydown="if(event.key==='Enter') window.location.href='<?php echo esc_url( $post_item['link'] ); ?>';">
                <!-- Khung ảnh đại diện bài viết -->
                <div class="news-card-img-wrap">
                    <a href="<?php echo esc_url( $post_item['link'] ); ?>" tabindex="-1">
                        <img src="<?php echo esc_url( $post_item['image'] ); ?>" alt="<?php echo esc_attr( $post_item['title'] ); ?>" class="news-card-img" loading="lazy">
                    </a>
                </div>
                <!-- Nội dung tóm tắt bài viết -->
                <div class="news-card-content">
                    <h3 class="news-card-title">
                        <a href="<?php echo esc_url( $post_item['link'] ); ?>">
                            <?php echo esc_html( $post_item['title'] ); ?>
                        </a>
                    </h3>
                    <p class="news-card-excerpt">
                        <?php echo esc_html( $post_item['excerpt'] ); ?>
                    </p>
                    <a href="<?php echo esc_url( $post_item['link'] ); ?>" class="news-card-readmore">
                        Read More
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</main>
