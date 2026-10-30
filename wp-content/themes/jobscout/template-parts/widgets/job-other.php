<?php
/**
 * ============================================================================
 * WIDGET COMPONENT: VIỆC LÀM LIÊN QUAN KHÁC (OTHER JOBS WIDGET)
 * Khớp chuẩn thiết kế Figma: 5-job detail.png
 *
 * TẬP TIN NÀY CHỊU TRÁCH NHIỆM:
 * 1. Truy vấn động danh sách 6 việc làm liên quan khác từ Database (trừ job hiện tại).
 * 2. Hiển thị dạng lưới (Grid) 6 Card việc làm: Logo công ty, tiêu đề, ngày đăng, tags,
 *    và 3 gạch đầu dòng điểm nhấn công việc.
 * 3. Hỗ trợ tiêu đề Widget tùy biến từ cấu hình Widget Admin.
 *
 * @package JobScout
 * ============================================================================
 */

defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
    <!-- =====================================================================
         1. OTHER JOBS SECTION: DANH SÁCH 6 VIỆC LÀM LIÊN QUAN KHÁC
         Truy vấn động từ cơ sở dữ liệu MySQL thông qua hàm get_posts()
         ===================================================================== -->
    <section class="nhomc-other-jobs-section">
        <div class="nhomc-container">
            <!-- Tiêu đề phân đoạn: Hỗ trợ tiêu đề tùy biến từ cài đặt Widget Admin -->
            <h2 class="nhomc-section-heading"><?php echo esc_html( $widget_title ?: 'OTHER JOBS' ); ?></h2>
        <?php if ( $widget_description !== '' ) : ?><div class="nc-widget-description"><?php echo wpautop( esc_html( $widget_description ) ); ?></div><?php endif; ?>

            <div class="nhomc-other-jobs-grid">
                <?php
                // Truy vấn lấy 6 việc làm đang phát hành khác từ MySQL (loại trừ bài viết hiện tại)
                $other_jobs = get_posts( array(
                    'post_type'      => 'job_listing',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'post__not_in'   => array( $current_job_id ),
                    'orderby'        => 'ID',
                    'order'          => 'ASC',
                ) );

                // Nếu số lượng ít hơn 6, truy vấn dự phòng các việc làm mới nhất
                if ( count( $other_jobs ) < 6 ) {
                    $other_jobs = get_posts( array(
                        'post_type'      => 'job_listing',
                        'posts_per_page' => 6,
                        'post_status'    => 'publish',
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ) );
                }

                // Vòng lặp duyệt hiển thị từng thẻ việc làm liên quan
                if ( ! empty( $other_jobs ) ) :
                    foreach ( $other_jobs as $job_item ) :
                        $oj_id       = $job_item->ID;
                        $oj_company  = get_post_meta( $oj_id, '_company_name', true );
                        if ( empty( $oj_company ) ) {
                            $oj_company = 'SODOH';
                        }
                        $oj_badges   = nhomc_get_job_badges( $oj_id );
                        $oj_bullets  = nhomc_get_job_bullets( $oj_id, $job_item->post_content );
                        $oj_date     = date( 'M d, Y', strtotime( $job_item->post_date ) );
                        $oj_link     = esc_url( home_url( '/job-detail/?job_id=' . $oj_id ) );
                        ?>
                        <div class="nhomc-other-job-card" onclick="window.location.href='<?php echo esc_url( $oj_link ); ?>';" style="cursor: pointer;">
                            <div class="nhomc-oj-top">
                                <!-- Logo công ty kích thước nhỏ gọn -->
                                <div class="nhomc-oj-logo">
                                    <?php if ( $widget_image ) : ?><img class="nc-widget-image" src="<?php echo esc_url( $widget_image ); ?>" alt="<?php echo esc_attr( $oj_company ); ?>"><?php else : ?><?php echo nhomc_get_company_logo( $oj_company, $oj_id, 'small' ); ?><?php endif; ?>
                                </div>

                                <!-- Tiêu đề công việc và siêu dữ liệu -->
                                <div class="nhomc-oj-info">
                                    <h3 class="nhomc-oj-title">
                                        <a href="<?php echo esc_url( $oj_link ); ?>">
                                            <?php echo esc_html( $job_item->post_title ); ?>
                                        </a>
                                    </h3>

                                    <div class="nhomc-oj-date">Created: <?php echo esc_html( $oj_date ); ?></div>

                                    <!-- Bộ 3 thẻ phân loại: Loại hình | Ngành nghề | Địa điểm -->
                                    <div class="nhomc-oj-tags">
                                        <span class="nhomc-oj-tag-item"><?php echo esc_html( $oj_badges['type'] ); ?></span>
                                        <span class="nhomc-oj-sep">|</span>
                                        <span class="nhomc-oj-tag-item"><?php echo esc_html( $oj_badges['category'] ); ?></span>
                                        <span class="nhomc-oj-sep">|</span>
                                        <span class="nhomc-oj-tag-item"><?php echo esc_html( $oj_badges['location'] ); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- 3 gạch đầu dòng điểm nhấn công việc trích xuất tự động -->
                            <div class="nhomc-oj-bullets">
                                <ul>
                                    <?php foreach ( $oj_bullets as $bullet ) : ?>
                                        <li><?php echo esc_html( $bullet ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
