<?php
/**
 * Module Quản lý Newsletter & Subscribers - Nhóm C (FIT - TDC)
 * Tích hợp trang quản trị chuyên nghiệp trong WP-Admin, xuất file CSV,
 * tự động liên kết với Contact Form 7, và TỰ ĐỘNG GỬI EMAIL KHI CÓ BÀI MỚI.
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
        'show_ui'         => false,
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
    add_menu_page(
        'Quản lý Subscribers (Newsletter)',
        'Subscribers',
        'manage_options',
        'nhomc-subscribers',
        'nhomc_render_subscribers_admin_page',
        'dashicons-email-alt',
        27
    );

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

// 5. Cấu hình định dạng Email gửi đi mang thương hiệu Nhóm C
add_filter( 'wp_mail_from_name', function( $name ) {
    return 'JobScout - Nhóm C (FIT - TDC)';
} );

// 6. Xây dựng giao diện Email HTML thông báo bài viết / việc làm mới (Figma Pixel-Perfect)
function nhomc_build_newsletter_email_html( $post ) {
    $post_id   = $post->ID;
    $title     = get_the_title( $post_id );
    $link      = get_permalink( $post_id );
    $post_type = $post->post_type;
    $is_job    = ( $post_type === 'job_listing' );

    $type_label = $is_job ? 'CƠ HỘI VIỆC LÀM MỚI TỪ NHÀ TUYỂN DỤNG' : 'BÀI VIẾT MỚI TỪ BẢN TIN NHÓM C';
    $btn_text   = $is_job ? 'ỨNG TUYỂN &amp; XEM VIỆC LÀM NGAY' : 'ĐỌC BÀI VIẾT ĐẦY ĐỦ';

    // Tóm tắt nội dung
    $excerpt = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : wp_strip_all_tags( $post->post_content );
    $excerpt = wp_trim_words( $excerpt, 40, '...' );

    // Ảnh đại diện
    $thumb_url = get_the_post_thumbnail_url( $post_id, 'large' );
    if ( empty( $thumb_url ) && ! $is_job ) {
        $thumb_url = get_template_directory_uri() . '/images/about/hero.jpg';
    }

    $site_name = get_bloginfo( 'name' );
    $site_url  = home_url( '/' );
    $year      = date( 'Y' );

    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo esc_html( $title ); ?></title>
    </head>
    <body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #334155;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f1f5f9; padding: 35px 15px;">
            <tr>
                <td align="center">
                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.07);">
                        <!-- Header Logo Nhom C -->
                        <tr>
                            <td align="center" style="padding: 28px 20px 22px; background-color: #ffffff;">
                                <div style="display: inline-block; border: 2.5px solid #111111; padding: 5px 24px; font-weight: 800; font-size: 20px; letter-spacing: 4px; color: #111111; box-shadow: 2px 2px #111111;">
                                    NHOM C
                                </div>
                                <div style="font-size: 8.5px; font-weight: 700; letter-spacing: 2.5px; color: #64748b; margin-top: 6px;">
                                    CAREER &amp; RECRUITING PLATFORM
                                </div>
                            </td>
                        </tr>

                        <!-- Banner Thông Báo Cam -->
                        <tr>
                            <td align="center" style="background-color: #ea751e; padding: 14px 20px;">
                                <span style="color: #ffffff; font-weight: 700; font-size: 13px; letter-spacing: 1.5px; text-transform: uppercase;">
                                    <?php echo esc_html( $type_label ); ?>
                                </span>
                            </td>
                        </tr>

                        <?php if ( ! empty( $thumb_url ) ) : ?>
                        <!-- Ảnh Thumbnail -->
                        <tr>
                            <td style="padding: 0;">
                                <a href="<?php echo esc_url( $link ); ?>" style="text-decoration: none; display: block;">
                                    <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width: 100%; max-height: 280px; object-fit: cover; display: block;" />
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>

                        <!-- Nội Dung Chính -->
                        <tr>
                            <td style="padding: 32px 30px;">
                                <div style="font-size: 13px; color: #ea751e; font-weight: 700; margin-bottom: 8px;">
                                    Ngày đăng: <?php echo esc_html( get_the_date( 'd/m/Y', $post_id ) ); ?>
                                </div>

                                <h2 style="margin: 0 0 16px 0; font-size: 22px; line-height: 1.4; color: #0f172a; font-weight: 800;">
                                    <a href="<?php echo esc_url( $link ); ?>" style="color: #0f172a; text-decoration: none;">
                                        <?php echo esc_html( $title ); ?>
                                    </a>
                                </h2>

                                <p style="margin: 0 0 26px 0; font-size: 15px; line-height: 1.6; color: #475569;">
                                    <?php echo esc_html( $excerpt ); ?>
                                </p>

                                <div align="center" style="margin: 30px 0 10px 0;">
                                    <a href="<?php echo esc_url( $link ); ?>" style="display: inline-block; background-color: #ea751e; color: #ffffff; font-size: 14px; font-weight: 700; letter-spacing: 0.8px; padding: 14px 30px; text-decoration: none; border-radius: 6px; box-shadow: 0 4px 12px rgba(234, 117, 30, 0.35); text-transform: uppercase;">
                                        <?php echo esc_html( $btn_text ); ?> &rarr;
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Footer Email Bản Quyền -->
                        <tr>
                            <td align="center" style="background-color: #111111; padding: 24px 20px; color: #94a3b8; font-size: 12px; line-height: 1.6;">
                                <p style="margin: 0 0 8px 0; color: #cbd5e1; font-weight: 600;">
                                    &copy; <?php echo esc_html( $year ); ?> Nhom C (FIT - TDC) - JobScout. All Rights Reserved.
                                </p>
                                <p style="margin: 0; font-size: 11px; color: #64748b;">
                                    Bạn nhận được email thông báo này vì đã đăng ký nhận tin tại <a href="<?php echo esc_url( $site_url ); ?>" style="color: #ea751e; text-decoration: none;"><?php echo esc_html( $site_name ); ?></a>.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

// 7. Hàm gửi email thông báo tới Subscriber (Hỗ trợ gửi hàng loạt hoặc gửi test)
function nhomc_send_post_notification_to_subscribers( $post_id, $target_email = null ) {
    $post = get_post( $post_id );
    if ( ! $post || $post->post_status !== 'publish' ) {
        return array( 'status' => 'error', 'message' => 'Bài viết không tồn tại hoặc chưa xuất bản.' );
    }

    $is_job = ( $post->post_type === 'job_listing' );
    $subject_prefix = $is_job ? '[JobScout Việc Làm Mới]' : '[JobScout Tin Tức Mới]';
    $subject = $subject_prefix . ' ' . wp_strip_all_tags( $post->post_title );
    $html_body = nhomc_build_newsletter_email_html( $post );

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
    );

    // Trường hợp 1: Gửi thử nghiệm (Test Email)
    if ( ! empty( $target_email ) && is_email( $target_email ) ) {
        $sent = wp_mail( $target_email, '[TEST] ' . $subject, $html_body, $headers );
        return array(
            'status'  => $sent ? 'success' : 'error',
            'is_test' => true,
            'count'   => $sent ? 1 : 0,
            'target'  => $target_email,
        );
    }

    // Trường hợp 2: Gửi cho toàn bộ Subscribers trong hệ thống
    $subscribers = get_posts( array(
        'post_type'      => 'nhomc_subscriber',
        'post_status'    => array( 'private', 'publish' ),
        'posts_per_page' => -1,
    ) );

    if ( empty( $subscribers ) ) {
        return array( 'status' => 'empty', 'message' => 'Chưa có subscriber nào trong hệ thống.' );
    }

    $sent_count = 0;
    foreach ( $subscribers as $sub ) {
        $email = $sub->post_title;
        if ( is_email( $email ) ) {
            if ( wp_mail( $email, $subject, $html_body, $headers ) ) {
                $sent_count++;
            }
        }
    }

    // Đánh dấu bài viết đã gửi thông báo
    update_post_meta( $post_id, '_nhomc_subscribers_notified', current_time( 'mysql' ) );

    // Ghi nhật ký lần phát gần nhất
    update_option( 'nhomc_last_newsletter_broadcast', array(
        'post_id'    => $post_id,
        'post_title' => $post->post_title,
        'time'       => current_time( 'mysql' ),
        'count'      => $sent_count,
        'total'      => count( $subscribers ),
    ) );

    return array(
        'status' => 'success',
        'count'  => $sent_count,
        'total'  => count( $subscribers ),
    );
}

// 8. TỰ ĐỘNG GỬI EMAIL KHI XUẤT BẢN BÀI VIẾT HOẶC VIỆC LÀM MỚI
add_action( 'transition_post_status', function( $new_status, $old_status, $post ) {
    // Chỉ kích hoạt khi chuyển từ trạng thái khác (draft, pending, new, auto-draft) sang 'publish'
    if ( $new_status !== 'publish' || $old_status === 'publish' ) {
        return;
    }

    // Chỉ áp dụng cho Tin Tức (post) và Việc Làm (job_listing)
    if ( ! in_array( $post->post_type, array( 'post', 'job_listing' ), true ) ) {
        return;
    }

    // Kiểm tra cấu hình bật/tắt (Mặc định: 'yes')
    if ( get_option( 'nhomc_auto_notify_subscribers', 'yes' ) !== 'yes' ) {
        return;
    }

    // Kiểm tra cờ tránh gửi 2 lần cho cùng một bài
    if ( get_post_meta( $post->ID, '_nhomc_subscribers_notified', true ) ) {
        return;
    }

    // Kích hoạt gửi email thông báo
    nhomc_send_post_notification_to_subscribers( $post->ID );
}, 10, 3 );

// 9. Xử lý các thao tác quản trị (Export CSV, Xóa, Thêm, Gửi Email Thủ Công, Lưu Cấu Hình)
add_action( 'admin_init', function () {
    if ( ! isset( $_GET['page'] ) || $_GET['page'] !== 'nhomc-subscribers' ) {
        return;
    }

    // 9.1. Xuất file CSV
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

    // 9.2. Xóa Subscriber
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'delete' && isset( $_GET['sub_id'] ) ) {
        $sub_id = intval( $_GET['sub_id'] );
        check_admin_referer( 'nhomc_delete_sub_' . $sub_id );

        if ( $sub_id && get_post_type( $sub_id ) === 'nhomc_subscriber' ) {
            wp_delete_post( $sub_id, true );
            wp_safe_redirect( add_query_arg( array( 'page' => 'nhomc-subscribers', 'status' => 'deleted' ), admin_url( 'admin.php' ) ) );
            exit;
        }
    }

    // 9.3. Thêm Subscriber thủ công
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

    // 9.4. Lưu cấu hình Tự động gửi Email khi có bài mới
    if ( isset( $_POST['nhomc_action'] ) && $_POST['nhomc_action'] === 'save_settings' ) {
        check_admin_referer( 'nhomc_save_settings_nonce' );

        $auto_notify = isset( $_POST['auto_notify'] ) ? 'yes' : 'no';
        update_option( 'nhomc_auto_notify_subscribers', $auto_notify );

        wp_safe_redirect( add_query_arg( array( 'page' => 'nhomc-subscribers', 'status' => 'settings_saved' ), admin_url( 'admin.php' ) ) );
        exit;
    }

    // 9.5. Gửi Email Thử Nghiệm (Test Email)
    if ( isset( $_POST['nhomc_action'] ) && $_POST['nhomc_action'] === 'send_test_email' ) {
        check_admin_referer( 'nhomc_send_email_nonce' );

        $post_id    = isset( $_POST['selected_post_id'] ) ? intval( $_POST['selected_post_id'] ) : 0;
        $test_email = isset( $_POST['test_email'] ) ? sanitize_email( trim( $_POST['test_email'] ) ) : '';

        if ( ! $post_id || ! is_email( $test_email ) ) {
            wp_safe_redirect( add_query_arg( array( 'page' => 'nhomc-subscribers', 'status' => 'mail_error' ), admin_url( 'admin.php' ) ) );
            exit;
        }

        $result = nhomc_send_post_notification_to_subscribers( $post_id, $test_email );
        $status = ( $result['status'] === 'success' ) ? 'test_sent' : 'mail_error';

        wp_safe_redirect( add_query_arg( array( 'page' => 'nhomc-subscribers', 'status' => $status, 'target' => urlencode( $test_email ) ), admin_url( 'admin.php' ) ) );
        exit;
    }

    // 9.6. Gửi Email Thủ Công tới tất cả Subscribers
    if ( isset( $_POST['nhomc_action'] ) && $_POST['nhomc_action'] === 'broadcast_email' ) {
        check_admin_referer( 'nhomc_send_email_nonce' );

        $post_id = isset( $_POST['selected_post_id'] ) ? intval( $_POST['selected_post_id'] ) : 0;

        if ( ! $post_id ) {
            wp_safe_redirect( add_query_arg( array( 'page' => 'nhomc-subscribers', 'status' => 'mail_error' ), admin_url( 'admin.php' ) ) );
            exit;
        }

        $result = nhomc_send_post_notification_to_subscribers( $post_id );
        $count = $result['count'] ?? 0;

        wp_safe_redirect( add_query_arg( array( 'page' => 'nhomc-subscribers', 'status' => 'broadcast_sent', 'count' => $count ), admin_url( 'admin.php' ) ) );
        exit;
    }
} );

// 10. Giao diện Trang Quản trị Subscribers Hoàn Chỉnh
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
        'date_query'     => array( array( 'after' => '7 days ago' ) ),
        'fields'         => 'ids',
    ) );
    $count_recent = count( $recent_posts );

    // Cài đặt tự động gửi
    $auto_notify_enabled = get_option( 'nhomc_auto_notify_subscribers', 'yes' ) === 'yes';

    // Nhật ký lần gửi email gần nhất
    $last_broadcast = get_option( 'nhomc_last_newsletter_broadcast', array() );

    // Lấy danh sách 15 bài viết / việc làm mới nhất để chọn gửi
    $latest_posts = get_posts( array(
        'post_type'      => array( 'post', 'job_listing' ),
        'post_status'    => 'publish',
        'posts_per_page' => 15,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

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
        <h1 class="wp-heading-inline">Hệ Thống Quản Lý Subscribers &amp; Tự Động Gửi Email (Nhóm C)</h1>
        
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
        <?php elseif ( $status_msg === 'settings_saved' ) : ?>
            <div class="notice notice-success is-dismissible"><p><strong>Đã lưu:</strong> Cài đặt thông báo email tự động đã được cập nhật thành công.</p></div>
        <?php elseif ( $status_msg === 'test_sent' ) : ?>
            <div class="notice notice-success is-dismissible"><p><strong>Gửi thử nghiệm thành công:</strong> Email thông báo mẫu đã được gửi tới <code><?php echo esc_html( $_GET['target'] ?? '' ); ?></code>.</p></div>
        <?php elseif ( $status_msg === 'broadcast_sent' ) : ?>
            <div class="notice notice-success is-dismissible"><p><strong>Phát email thành công:</strong> Đã gửi email thông báo tới <strong><?php echo intval( $_GET['count'] ?? 0 ); ?></strong> subscribers!</p></div>
        <?php elseif ( $status_msg === 'mail_error' ) : ?>
            <div class="notice notice-error is-dismissible"><p><strong>Lưu ý về gửi mail:</strong> Thao tác gửi mail được kích hoạt. Nếu chạy trên Docker local chưa cài SMTP, hãy cấu hình plugin SMTP (như WP Mail SMTP) để mail gửi ra ngoài internet.</p></div>
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
                <div class="nc-stat-icon" style="background: <?php echo $auto_notify_enabled ? '#ecfdf5' : '#fef2f2'; ?>; color: <?php echo $auto_notify_enabled ? '#059669' : '#dc2626'; ?>;">
                    <span class="dashicons dashicons-megaphone"></span>
                </div>
                <div class="nc-stat-info">
                    <span class="nc-stat-number"><?php echo $auto_notify_enabled ? 'ĐANG BẬT' : 'ĐANG TẮT'; ?></span>
                    <span class="nc-stat-label">Tự Động Gửi Khi Có Bài Mới</span>
                </div>
            </div>
        </div>

        <!-- Khối Quản Lý Gửi Email Thông Báo Bài Mới (Broadcast & Test) -->
        <div class="nc-broadcast-box">
            <div class="nc-broadcast-header">
                <h3>
                    <span class="dashicons dashicons-email-alt2" style="color: #ea751e; margin-right: 6px;"></span>
                    Trung Tâm Gửi Email Thông Báo Bài Viết / Việc Làm Mới
                </h3>
                <form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=nhomc-subscribers' ) ); ?>" class="nc-toggle-form">
                    <?php wp_nonce_field( 'nhomc_save_settings_nonce' ); ?>
                    <input type="hidden" name="nhomc_action" value="save_settings">
                    <label class="nc-toggle-label">
                        <input type="checkbox" name="auto_notify" value="yes" <?php checked( $auto_notify_enabled, true ); ?> onchange="this.form.submit()">
                        <span><strong>Tự động gửi email</strong> ngay khi xuất bản bài viết hoặc việc làm mới</span>
                    </label>
                </form>
            </div>

            <div class="nc-broadcast-body">
                <form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=nhomc-subscribers' ) ); ?>" class="nc-send-form">
                    <?php wp_nonce_field( 'nhomc_send_email_nonce' ); ?>

                    <div class="nc-form-row">
                        <label for="selected_post_id"><strong>Chọn bài viết hoặc việc làm để gửi:</strong></label>
                        <select name="selected_post_id" id="selected_post_id" style="min-width: 380px; max-width: 100%;">
                            <?php if ( ! empty( $latest_posts ) ) : ?>
                                <?php foreach ( $latest_posts as $lp ) : 
                                    $is_job = ( $lp->post_type === 'job_listing' );
                                    $prefix = $is_job ? '[VIỆC LÀM]' : '[TIN TỨC]';
                                    ?>
                                    <option value="<?php echo esc_attr( $lp->ID ); ?>">
                                        <?php echo esc_html( $prefix . ' ' . $lp->post_title ); ?> (<?php echo get_the_date( 'd/m/Y', $lp->ID ); ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="">Chưa có bài viết hoặc việc làm nào được xuất bản</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="nc-form-row nc-actions-row">
                        <!-- Nhánh 1: Gửi thử nghiệm -->
                        <div class="nc-test-action">
                            <input type="email" name="test_email" placeholder="Email nhận thử nghiệm..." value="<?php echo esc_attr( wp_get_current_user()->user_email ); ?>" style="width: 240px;">
                            <button type="submit" name="nhomc_action" value="send_test_email" class="button button-secondary">
                                <span class="dashicons dashicons-admin-tools" style="vertical-align: middle;"></span> Gửi Thử Nghiệm
                            </button>
                        </div>

                        <!-- Nhánh 2: Gửi cho toàn bộ Subscribers -->
                        <div class="nc-broadcast-action">
                            <button type="submit" name="nhomc_action" value="broadcast_email" class="button button-primary nc-btn-broadcast" onclick="return confirm('Bạn có chắc chắn muốn gửi email thông báo bài viết này tới TẤT CẢ <?php echo $count_total; ?> subscribers không?');">
                                <span class="dashicons dashicons-megaphone" style="vertical-align: middle;"></span> GỬI CHO TẤT CẢ SUBSCRIBERS (<?php echo $count_total; ?>)
                            </button>
                        </div>
                    </div>
                </form>

                <?php if ( ! empty( $last_broadcast['time'] ) ) : ?>
                    <div class="nc-last-log">
                        <span class="dashicons dashicons-clock" style="font-size: 16px; width: 16px; height: 16px; vertical-align: text-bottom; margin-right: 4px;"></span>
                        <strong>Lần phát gần nhất:</strong> Bài <em>"<?php echo esc_html( $last_broadcast['post_title'] ?? '' ); ?>"</em> vào lúc <strong><?php echo esc_html( $last_broadcast['time'] ); ?></strong> (Đã gửi tới <?php echo intval( $last_broadcast['count'] ?? 0 ); ?> / <?php echo intval( $last_broadcast['total'] ?? 0 ); ?> subscribers).
                    </div>
                <?php endif; ?>
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

        /* Broadcast box */
        .nc-broadcast-box { background: #ffffff; border: 1.5px solid #ea751e; border-radius: 8px; padding: 20px 24px; margin-bottom: 22px; box-shadow: 0 2px 8px rgba(234, 117, 30, 0.08); }
        .nc-broadcast-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px; margin-bottom: 16px; }
        .nc-broadcast-header h3 { margin: 0; font-size: 16px; font-weight: 700; color: #0f172a; display: flex; align-items: center; }
        .nc-toggle-label { display: flex; align-items: center; gap: 8px; font-size: 13.5px; cursor: pointer; color: #334155; }
        .nc-send-form { display: flex; flex-direction: column; gap: 14px; }
        .nc-form-row { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .nc-actions-row { justify-content: space-between; margin-top: 6px; padding-top: 12px; border-top: 1px dashed #e2e8f0; }
        .nc-test-action { display: flex; align-items: center; gap: 8px; }
        .nc-btn-broadcast { background: #ea751e !important; border-color: #d46312 !important; color: #ffffff !important; font-weight: 700 !important; padding: 4px 18px !important; }
        .nc-btn-broadcast:hover { background: #d46312 !important; }
        .nc-last-log { margin-top: 14px; padding: 8px 12px; background: #f8fafc; border-radius: 6px; font-size: 12.5px; color: #475569; border-left: 3px solid #10b981; }

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
