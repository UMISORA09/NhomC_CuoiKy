<?php
/**
 * Module Quản lý Newsletter & Subscribers - Nhóm C (FIT - TDC)
 * Tích hợp trang quản trị chuyên nghiệp trong WP-Admin, xuất file CSV,
 * và tự động liên kết với Contact Form 7.
 *
 * @package JobScout
 */

defined( 'ABSPATH' ) || exit;

// 1. Đăng ký Custom Post Type 'nhomc_subscriber'
add_action( 'init', function () {
    register_post_type( 'nhomc_subscriber', array(
        'labels' => array(
            'name'               => 'Subscribers',
            'singular_name'      => 'Subscriber',
            'menu_name'          => 'Subscribers',
            'all_items'          => 'Tất cả Subscribers',
            'search_items'      => 'Tìm kiếm Subscriber',
            'not_found'          => 'Không có subscriber nào',
        ),
        'public'          => false,
        'show_ui'         => false, // Dùng trang quản trị tùy biến đẹp hơn bên dưới
        'supports'        => array( 'title' ),
        'capabilities'    => array_fill_keys( array(
            'edit_post', 'read_post', 'delete_post', 'edit_posts', 'edit_others_posts',
            'publish_posts', 'read_private_posts', 'delete_posts', 'delete_private_posts',
            'delete_published_posts', 'delete_others_posts', 'edit_private_posts',
            'edit_published_posts', 'create_posts',
        ), 'manage_options' ),
        'map_meta_cap'    => false,
    ) );
} );

// 2. Đăng ký Menu Quản trị trong WP-Admin (Menu chính và Submenu dưới Contact Form 7)
add_action( 'admin_menu', function () {
    // Menu chính riêng biệt nổi bật trên thanh bên
    add_menu_page(
        'Quản lý Subscribers (Newsletter)',
        'Subscribers',
        'manage_options',
        'nhomc-subscribers',
        'nhomc_render_subscribers_admin_page',
        'dashicons-email-alt',
        27
    );

    // Submenu bổ sung nằm trong mục Contact Form 7 (nếu Contact Form 7 đã cài đặt)
    add_submenu_page(
        'wpcf7',
        'Subscribers Newsletter',
        'Subscribers',
        'manage_options',
        'nhomc-subscribers',
        'nhomc_render_subscribers_admin_page'
    );
} );

// 3. Xử lý lưu email từ Form Subscribe (Footer)
function nhomc_newsletter_subscribe() {
    $status = 'invalid';
    $nonce = isset( $_POST['newsletter_nonce'] ) && is_string( $_POST['newsletter_nonce'] )
        ? wp_unslash( $_POST['newsletter_nonce'] ) : '';

    if ( 'POST' !== $_SERVER['REQUEST_METHOD'] || ! wp_verify_nonce( $nonce, 'nhomc_newsletter' ) ) {
        $status = 'expired';
    } elseif ( ! empty( $_POST['newsletter_website'] ) ) {
        $status = 'invalid';
    } else {
        $email = isset( $_POST['email'] ) && is_string( $_POST['email'] )
            ? strtolower( trim( wp_unslash( $_POST['email'] ) ) ) : '';

        if ( strlen( $email ) <= 254 && is_email( $email ) ) {
            $slug = hash( 'sha256', $email );
            $existing = get_page_by_path( $slug, OBJECT, 'nhomc_subscriber' );

            if ( $existing ) {
                $status = 'success';
            } else {
                $result = wp_insert_post( array(
                    'post_type'   => 'nhomc_subscriber',
                    'post_status' => 'private',
                    'post_title'  => sanitize_email( $email ),
                    'post_name'   => $slug,
                ), true );

                if ( ! is_wp_error( $result ) && $result ) {
                    update_post_meta( $result, '_subscriber_source', 'Footer Newsletter' );
                    $status = 'success';
                } else {
                    $status = 'error';
                }
            }
        }
    }

    $return_url = isset( $_POST['newsletter_return'] ) && is_string( $_POST['newsletter_return'] )
        ? wp_validate_redirect( esc_url_raw( wp_unslash( $_POST['newsletter_return'] ) ), home_url( '/about-us/' ) )
        : home_url( '/about-us/' );

    wp_safe_redirect( add_query_arg( 'newsletter', $status, $return_url ) . '#newsletter-title', 303 );
    exit;
}
add_action( 'admin_post_nhomc_newsletter', 'nhomc_newsletter_subscribe' );
add_action( 'admin_post_nopriv_nhomc_newsletter', 'nhomc_newsletter_subscribe' );

// 4. Tự động liên kết lưu Subscriber khi người dùng gửi form Contact Form 7
add_action( 'wpcf7_mail_sent', function( $contact_form ) {
    $submission = class_exists( 'WPCF7_Submission' ) ? WPCF7_Submission::get_instance() : null;
    if ( ! $submission ) {
        return;
    }

    $posted_data = $submission->get_posted_data();
    $email = '';

    if ( ! empty( $posted_data['your-email'] ) && is_email( $posted_data['your-email'] ) ) {
        $email = $posted_data['your-email'];
    } elseif ( ! empty( $posted_data['email'] ) && is_email( $posted_data['email'] ) ) {
        $email = $posted_data['email'];
    }

    if ( $email ) {
        $email_clean = strtolower( trim( $email ) );
        $slug = hash( 'sha256', $email_clean );
        $existing = get_page_by_path( $slug, OBJECT, 'nhomc_subscriber' );

        if ( ! $existing ) {
            $post_id = wp_insert_post( array(
                'post_type'   => 'nhomc_subscriber',
                'post_status' => 'private',
                'post_title'  => sanitize_email( $email_clean ),
                'post_name'   => $slug,
            ) );

            if ( $post_id ) {
                $form_title = method_exists( $contact_form, 'title' ) ? $contact_form->title() : 'Contact Form';
                update_post_meta( $post_id, '_subscriber_source', 'Contact Form 7 (' . $form_title . ')' );
            }
        }
    }
} );

// 5. Xử lý các thao tác quản trị (Export CSV, Xóa, Thêm thủ công)
add_action( 'admin_init', function () {
    if ( ! isset( $_GET['page'] ) || $_GET['page'] !== 'nhomc-subscribers' ) {
        return;
    }

    // 5.1. Xuất file CSV
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'export_csv' ) {
        check_admin_referer( 'nhomc_export_subscribers_nonce' );

        $subscribers = get_posts( array(
            'post_type'      => 'nhomc_subscriber',
            'post_status'    => array( 'private', 'publish' ),
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );

        $filename = 'subscribers_nhomc_' . date( 'Y-m-d_His' ) . '.csv';

        header( 'Content-Type: text/csv; charset=UTF-8' );
        header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
        header( 'Pragma: no-cache' );
        header( 'Expires: 0' );

        $output = fopen( 'php://output', 'w' );
        // UTF-8 BOM cho Excel tiếng Việt
        fprintf( $output, chr(0xEF) . chr(0xBB) . chr(0xBF) );

        fputcsv( $output, array( 'STT', 'Địa chỉ Email', 'Ngày đăng ký', 'Nguồn đăng ký', 'Trạng thái' ) );

        $stt = 1;
        foreach ( $subscribers as $sub ) {
            $source = get_post_meta( $sub->ID, '_subscriber_source', true );
            if ( empty( $source ) ) {
                $source = 'Footer Newsletter';
            }

            fputcsv( $output, array(
                $stt++,
                $sub->post_title,
                get_the_date( 'd/m/Y H:i:s', $sub->ID ),
                $source,
                'Đang hoạt động (Active)',
            ) );
        }

        fclose( $output );
        exit;
    }

    // 5.2. Xóa Subscriber
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'delete' && isset( $_GET['sub_id'] ) ) {
        $sub_id = intval( $_GET['sub_id'] );
        check_admin_referer( 'nhomc_delete_sub_' . $sub_id );

        if ( $sub_id && get_post_type( $sub_id ) === 'nhomc_subscriber' ) {
            wp_delete_post( $sub_id, true );
            wp_safe_redirect( add_query_arg( array( 'page' => 'nhomc-subscribers', 'status' => 'deleted' ), admin_url( 'admin.php' ) ) );
            exit;
        }
    }

    // 5.3. Thêm Subscriber thủ công
    if ( isset( $_POST['nhomc_action'] ) && $_POST['nhomc_action'] === 'add_subscriber' ) {
        check_admin_referer( 'nhomc_add_subscriber_nonce' );

        $email = isset( $_POST['subscriber_email'] ) ? sanitize_email( trim( $_POST['subscriber_email'] ) ) : '';

        if ( ! is_email( $email ) ) {
            wp_safe_redirect( add_query_arg( array( 'page' => 'nhomc-subscribers', 'status' => 'invalid' ), admin_url( 'admin.php' ) ) );
            exit;
        }

        $slug = hash( 'sha256', strtolower( $email ) );
        $existing = get_page_by_path( $slug, OBJECT, 'nhomc_subscriber' );

        if ( $existing ) {
            wp_safe_redirect( add_query_arg( array( 'page' => 'nhomc-subscribers', 'status' => 'exists' ), admin_url( 'admin.php' ) ) );
            exit;
        }

        $post_id = wp_insert_post( array(
            'post_type'   => 'nhomc_subscriber',
            'post_status' => 'private',
            'post_title'  => $email,
            'post_name'   => $slug,
        ) );

        if ( $post_id ) {
            update_post_meta( $post_id, '_subscriber_source', 'Admin Thêm Thủ Công' );
            wp_safe_redirect( add_query_arg( array( 'page' => 'nhomc-subscribers', 'status' => 'added' ), admin_url( 'admin.php' ) ) );
            exit;
        }
    }
} );

// 6. Giao diện Trang Quản trị Subscribers (HTML + CSS sang trọng, trực quan)
function nhomc_render_subscribers_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Bạn không có quyền truy cập trang quản trị này.' );
    }

    $search_query = isset( $_GET['s'] ) ? sanitize_text_field( trim( $_GET['s'] ) ) : '';
    $paged = isset( $_GET['paged'] ) ? max( 1, intval( $_GET['paged'] ) ) : 1;
    $per_page = 20;

    // Đếm tổng số subscriber
    $total_all = wp_count_posts( 'nhomc_subscriber' );
    $count_total = ( $total_all->private ?? 0 ) + ( $total_all->publish ?? 0 );

    // Đếm số subscriber trong 7 ngày gần nhất
    $recent_posts = get_posts( array(
        'post_type'      => 'nhomc_subscriber',
        'post_status'    => array( 'private', 'publish' ),
        'posts_per_page' => -1,
        'date_query'     => array(
            array(
                'after' => '7 days ago',
            ),
        ),
        'fields'         => 'ids',
    ) );
    $count_recent = count( $recent_posts );

    // Truy vấn danh sách subscriber hiển thị theo trang
    $args = array(
        'post_type'      => 'nhomc_subscriber',
        'post_status'    => array( 'private', 'publish' ),
        'posts_per_page' => $per_page,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    if ( ! empty( $search_query ) ) {
        $args['s'] = $search_query;
    }

    $query = new WP_Query( $args );
    $subscribers = $query->posts;
    $total_found = $query->found_posts;
    $total_pages = ceil( $total_found / $per_page );

    $status_msg = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '';
    ?>
    <div class="wrap nhomc-subscribers-wrap">
        <h1 class="wp-heading-inline">Danh Sách Email Đăng Ký (Newsletter Subscribers)</h1>
        
        <hr class="wp-header-end">

        <!-- Thông báo thao tác -->
        <?php if ( $status_msg === 'added' ) : ?>
            <div class="notice notice-success is-dismissible"><p><strong>Thành công:</strong> Đã thêm subscriber mới vào hệ thống.</p></div>
        <?php elseif ( $status_msg === 'deleted' ) : ?>
            <div class="notice notice-success is-dismissible"><p><strong>Đã xóa:</strong> Subscriber đã được xóa khỏi danh sách.</p></div>
        <?php elseif ( $status_msg === 'exists' ) : ?>
            <div class="notice notice-warning is-dismissible"><p><strong>Trùng lặp:</strong> Email này đã tồn tại trong danh sách subscribers.</p></div>
        <?php elseif ( $status_msg === 'invalid' ) : ?>
            <div class="notice notice-error is-dismissible"><p><strong>Lỗi:</strong> Địa chỉ email không hợp lệ. Vui lòng kiểm tra lại.</p></div>
        <?php endif; ?>

        <!-- Thẻ Thống kê Tổng quan (KPI Cards) -->
        <div class="nc-stat-grid">
            <div class="nc-stat-card">
                <div class="nc-stat-icon" style="background: #fff4e5; color: #ea751e;">
                    <span class="dashicons dashicons-email-alt"></span>
                </div>
                <div class="nc-stat-info">
                    <span class="nc-stat-number"><?php echo number_format_i18n( $count_total ); ?></span>
                    <span class="nc-stat-label">Tổng Số Email Subscribers</span>
                </div>
            </div>

            <div class="nc-stat-card">
                <div class="nc-stat-icon" style="background: #e6f7ed; color: #10b981;">
                    <span class="dashicons dashicons-chart-line"></span>
                </div>
                <div class="nc-stat-info">
                    <span class="nc-stat-number">+<?php echo number_format_i18n( $count_recent ); ?></span>
                    <span class="nc-stat-label">Đăng Ký Mới Trong 7 Ngày</span>
                </div>
            </div>

            <div class="nc-stat-card">
                <div class="nc-stat-icon" style="background: #ebf5ff; color: #3b82f6;">
                    <span class="dashicons dashicons-plugins-checked"></span>
                </div>
                <div class="nc-stat-info">
                    <span class="nc-stat-number">Hoạt Động</span>
                    <span class="nc-stat-label">Tích Hợp: Footer &amp; Contact Form 7</span>
                </div>
            </div>
        </div>

        <!-- Khối Thao Tác: Thêm mới & Xuất CSV -->
        <div class="nc-action-bar">
            <!-- Form Thêm Email Thủ Công -->
            <form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=nhomc-subscribers' ) ); ?>" class="nc-quick-add-form">
                <?php wp_nonce_field( 'nhomc_add_subscriber_nonce' ); ?>
                <input type="hidden" name="nhomc_action" value="add_subscriber">
                <input type="email" name="subscriber_email" placeholder="Nhập địa chỉ email mới..." required class="regular-text">
                <button type="submit" class="button button-primary">
                    <span class="dashicons dashicons-plus-alt2" style="vertical-align: middle; margin-top: -2px;"></span> Thêm Subscriber
                </button>
            </form>

            <div class="nc-bar-right">
                <!-- Nút Xuất File CSV -->
                <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=nhomc-subscribers&action=export_csv' ), 'nhomc_export_subscribers_nonce' ) ); ?>" class="button button-secondary nc-btn-export">
                    <span class="dashicons dashicons-download" style="vertical-align: middle; margin-top: -2px;"></span> Xuất File CSV (Excel)
                </a>

                <!-- Form Tìm kiếm -->
                <form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>" class="nc-search-form">
                    <input type="hidden" name="page" value="nhomc-subscribers">
                    <input type="search" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="Tìm kiếm theo email...">
                    <button type="submit" class="button">Tìm</button>
                    <?php if ( ! empty( $search_query ) ) : ?>
                        <a href="<?php echo esc_url( admin_url( 'admin.php?page=nhomc-subscribers' ) ); ?>" class="button">Xóa lọc</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Bảng Dữ Liệu Subscribers -->
        <div class="nc-table-card">
            <table class="wp-list-table widefat fixed striped table-view-list">
                <thead>
                    <tr>
                        <th scope="col" style="width: 60px; text-align: center;">STT</th>
                        <th scope="col" style="width: 320px;">Địa Chỉ Email</th>
                        <th scope="col" style="width: 220px;">Nguồn Đăng Ký</th>
                        <th scope="col" style="width: 200px;">Ngày Đăng Ký</th>
                        <th scope="col" style="width: 140px; text-align: center;">Trạng Thái</th>
                        <th scope="col" style="width: 100px; text-align: center;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ( ! empty( $subscribers ) ) : 
                        $index = ( $paged - 1 ) * $per_page + 1;
                        foreach ( $subscribers as $sub ) :
                            $sub_id = $sub->ID;
                            $email  = $sub->post_title;
                            $date   = get_the_date( 'd/m/Y - H:i', $sub_id );
                            $source = get_post_meta( $sub_id, '_subscriber_source', true );
                            if ( empty( $source ) ) {
                                $source = 'Footer Newsletter';
                            }
                            $delete_url = wp_nonce_url(
                                admin_url( 'admin.php?page=nhomc-subscribers&action=delete&sub_id=' . $sub_id ),
                                'nhomc_delete_sub_' . $sub_id
                            );
                            ?>
                            <tr>
                                <td style="text-align: center; color: #888; font-weight: 600;"><?php echo $index++; ?></td>
                                <td>
                                    <div class="nc-email-cell">
                                        <span class="dashicons dashicons-email-alt" style="color: #ea751e; margin-right: 6px;"></span>
                                        <a href="mailto:<?php echo esc_attr( $email ); ?>" style="font-weight: 700; color: #1e293b; font-size: 14px;">
                                            <?php echo esc_html( $email ); ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <?php if ( stripos( $source, 'Contact Form' ) !== false ) : ?>
                                        <span class="nc-badge nc-badge-cf7"><?php echo esc_html( $source ); ?></span>
                                    <?php elseif ( stripos( $source, 'Thủ Công' ) !== false ) : ?>
                                        <span class="nc-badge nc-badge-manual"><?php echo esc_html( $source ); ?></span>
                                    <?php else : ?>
                                        <span class="nc-badge nc-badge-newsletter">Footer Newsletter</span>
                                    <?php endif; ?>
                                </td>
                                <td style="color: #64748b; font-size: 13px;">
                                    <?php echo esc_html( $date ); ?>
                                </td>
                                <td style="text-align: center;">
                                    <span class="nc-badge nc-badge-active">Hoạt Động</span>
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?php echo esc_url( $delete_url ); ?>" 
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa email: <?php echo esc_js( $email ); ?> khỏi danh sách không?');" 
                                       class="button button-small button-link-delete" 
                                       title="Xóa subscriber này">
                                       Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #64748b;">
                                <p style="font-size: 15px; margin: 0 0 8px;">Chưa có subscriber nào phù hợp.</p>
                                <small>Người dùng có thể đăng ký qua khối <strong>Subscribe To Our Newsletter</strong> ở chân trang hoặc gửi qua form liên hệ.</small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Phân trang (Pagination) -->
        <?php if ( $total_pages > 1 ) : ?>
            <div class="tablenav bottom">
                <div class="tablenav-pages">
                    <span class="displaying-num"><?php echo esc_html( $total_found ); ?> mục</span>
                    <span class="pagination-links">
                        <?php if ( $paged > 1 ) : ?>
                            <a class="prev-page button" href="<?php echo esc_url( add_query_arg( 'paged', $paged - 1 ) ); ?>">‹ Trước</a>
                        <?php endif; ?>
                        <span class="paging-input">
                            Trang <?php echo esc_html( $paged ); ?> / <?php echo esc_html( $total_pages ); ?>
                        </span>
                        <?php if ( $paged < $total_pages ) : ?>
                            <a class="next-page button" href="<?php echo esc_url( add_query_arg( 'paged', $paged + 1 ) ); ?>">Sau ›</a>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <style>
        .nhomc-subscribers-wrap { margin-top: 20px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .nc-stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin: 20px 0 24px; }
        .nc-stat-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .nc-stat-icon { width: 48px; height: 48px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .nc-stat-icon .dashicons { font-size: 26px; width: 26px; height: 26px; }
        .nc-stat-info { display: flex; flex-direction: column; }
        .nc-stat-number { font-size: 24px; font-weight: 800; color: #0f172a; line-height: 1.2; }
        .nc-stat-label { font-size: 12.5px; color: #64748b; font-weight: 600; margin-top: 3px; }
        .nc-action-bar { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .nc-quick-add-form { display: flex; align-items: center; gap: 8px; }
        .nc-bar-right { display: flex; align-items: center; gap: 12px; }
        .nc-search-form { display: flex; align-items: center; gap: 6px; }
        .nc-table-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .nc-table-card table { border: 0 !important; }
        .nc-table-card th { background: #f8fafc; font-weight: 700; color: #334155; padding: 14px 12px; }
        .nc-table-card td { padding: 14px 12px; vertical-align: middle; }
        .nc-email-cell { display: flex; align-items: center; }
        .nc-badge { display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 11.5px; font-weight: 600; }
        .nc-badge-active { background: #dcfce7; color: #15803d; }
        .nc-badge-newsletter { background: #ffedd5; color: #c2410c; }
        .nc-badge-cf7 { background: #dbeafe; color: #1e40af; }
        .nc-badge-manual { background: #f3e8ff; color: #7e22ce; }
        .nc-btn-export { background: #0284c7 !important; border-color: #0284c7 !important; color: #ffffff !important; }
        .nc-btn-export:hover { background: #0369a1 !important; border-color: #0369a1 !important; }
    </style>
    <?php
}
