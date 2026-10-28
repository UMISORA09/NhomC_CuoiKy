<?php
/**
 * Module Quản lý Hồ Sơ Ứng Tuyển & CV Ứng Viên - Nhóm C (JobScout)
 * 
 * - Đăng ký Custom Post Type 'nhomc_application' lưu trữ thông tin ứng viên và file CV PDF.
 * - RÀNG BUỘC DỮ LIỆU CHẶT CHẼ (Họ tên, Email, SĐT, Giới hạn từ, Kiểm tra tin tuyển dụng còn mở).
 * - CƠ CHẾ OPTIMISTIC LOCKING (Khóa lạc quan): Kiểm tra cột phiên bản '_version' chống Lost Update & Concurrency Conflict.
 * - Xử lý tải lên file PDF an toàn (giới hạn <= 5MB) qua WordPress AJAX.
 * - Cung cấp trang quản trị đẹp mắt, chuyên nghiệp trong WP-Admin (Bộ lọc, Thống kê, Đổi trạng thái, Xem CV, Xuất CSV, Xóa).
 *
 * @package JobScout
 */

defined( 'ABSPATH' ) || exit;

/**
 * 1. Đăng ký Custom Post Type 'nhomc_application'
 */
add_action( 'init', function () {
    register_post_type( 'nhomc_application', array(
        'labels' => array(
            'name'               => 'Hồ Sơ Ứng Tuyển',
            'singular_name'      => 'Hồ Sơ Ứng Tuyển',
            'menu_name'          => 'Ứng Viên & CV',
            'all_items'          => 'Tất cả Ứng Viên',
            'search_items'      => 'Tìm kiếm Ứng Viên',
            'not_found'          => 'Không có hồ sơ ứng tuyển nào',
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

/**
 * 2. Đăng ký Menu Quản trị trong WP-Admin
 */
add_action( 'admin_menu', function () {
    // Menu chính trên Admin Bar
    add_menu_page(
        'Quản lý Hồ Sơ Ứng Tuyển (Job Applications)',
        'Ứng Viên & CV',
        'manage_options',
        'nhomc-applications',
        'nhomc_render_applications_admin_page',
        'dashicons-id-alt',
        26
    );

    // Submenu dưới menu Job Listings của WP Job Manager (nếu có)
    add_submenu_page(
        'edit.php?post_type=job_listing',
        'Hồ Sơ Ứng Tuyển',
        'Hồ Sơ Ứng Tuyển',
        'manage_options',
        'nhomc-applications',
        'nhomc_render_applications_admin_page'
    );
} );

/**
 * 3. Xử lý AJAX Tiếp nhận Hồ sơ Ứng tuyển & Lưu File PDF (Có Ràng Buộc Dữ Liệu Chặt Chẽ)
 */
function nhomc_handle_application_submission() {
    // 3.1. Kiểm tra nonce bảo mật
    $nonce = isset( $_POST['apply_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['apply_nonce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'nhomc_apply_action' ) ) {
        wp_send_json_error( array( 'message' => 'Phiên làm việc đã hết hạn. Vui lòng tải lại trang và thử lại!' ) );
    }

    // 3.2. Lấy dữ liệu ứng viên
    $job_id      = isset( $_POST['job_id'] ) ? intval( $_POST['job_id'] ) : 0;
    $name        = isset( $_POST['applicant_name'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['applicant_name'] ) ) ) : '';
    $email       = isset( $_POST['applicant_email'] ) ? trim( sanitize_email( wp_unslash( $_POST['applicant_email'] ) ) ) : '';
    $phone       = isset( $_POST['applicant_phone'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['applicant_phone'] ) ) ) : '';
    $notes       = isset( $_POST['applicant_notes'] ) ? trim( sanitize_textarea_field( wp_unslash( $_POST['applicant_notes'] ) ) ) : '';

    // RÀNG BUỘC 1: Kiểm tra vị trí công việc có còn tồn tại và đang publish hay không
    if ( $job_id <= 0 ) {
        wp_send_json_error( array( 'message' => 'Lỗi: Vị trí tuyển dụng không hợp lệ.' ) );
    }
    $job_post = get_post( $job_id );
    if ( ! $job_post || $job_post->post_status !== 'publish' ) {
        wp_send_json_error( array( 'message' => 'Lỗi: Tin tuyển dụng này hiện đã đóng, bị ẩn hoặc không còn tồn tại!' ) );
    }
    $job_title = $job_post->post_title;

    // RÀNG BUỘC 2: Kiểm tra Họ và Tên (Từ 2 đến 70 ký tự, chỉ chứa chữ cái và khoảng trắng)
    $name_len = mb_strlen( $name, 'UTF-8' );
    if ( $name_len < 2 || $name_len > 70 ) {
        wp_send_json_error( array( 'message' => 'Lỗi: Họ và tên phải từ 2 đến 70 ký tự (hiện tại: ' . $name_len . ' ký tự).' ) );
    }
    // Unicode regex: chỉ cho phép chữ cái (\p{L}), khoảng trắng (\s), dấu chấm, gạch nối
    if ( ! preg_match( '/^[\p{L}\s\.\-]+$/u', $name ) ) {
        wp_send_json_error( array( 'message' => 'Lỗi: Họ và tên không được chứa số hoặc ký tự đặc biệt lạ.' ) );
    }

    // RÀNG BUỘC 3: Kiểm tra Email (Hợp lệ, tối đa 100 ký tự)
    if ( empty( $email ) || ! is_email( $email ) || strlen( $email ) > 100 ) {
        wp_send_json_error( array( 'message' => 'Lỗi: Địa chỉ email không hợp lệ hoặc vượt quá 100 ký tự.' ) );
    }

    // RÀNG BUỘC 4: Kiểm tra Số Điện Thoại (Định dạng VN: 9-11 chữ số, ví dụ 0912345678 hoặc +84912345678)
    $clean_phone = preg_replace( '/[\s\-\.]/', '', $phone );
    if ( ! preg_match( '/^(0|\+84)[0-9]{8,10}$/', $clean_phone ) ) {
        wp_send_json_error( array( 'message' => 'Lỗi: Số điện thoại không hợp lệ (Vui lòng nhập định dạng 9 - 11 chữ số, ví dụ: 0912345678).' ) );
    }

    // RÀNG BUỘC 5: Kiểm tra Lời Nhắn (Tối đa 500 ký tự, tránh spam quá nhiều từ làm phình CSDL)
    $notes_len = mb_strlen( $notes, 'UTF-8' );
    if ( $notes_len > 500 ) {
        wp_send_json_error( array( 'message' => 'Lỗi: Lời nhắn giới thiệu bản thân vượt quá 500 ký tự (hiện tại: ' . $notes_len . ' ký tự). Vui lòng rút gọn lại!' ) );
    }

    // RÀNG BUỘC 6: Kiểm tra Tệp CV đính kèm (File PDF, tối đa 5MB)
    if ( ! isset( $_FILES['applicant_cv'] ) || empty( $_FILES['applicant_cv']['name'] ) ) {
        wp_send_json_error( array( 'message' => 'Lỗi: Vui lòng đính kèm tệp CV định dạng PDF (tối đa 5MB).' ) );
    }

    $file = $_FILES['applicant_cv'];
    if ( $file['error'] !== UPLOAD_ERR_OK ) {
        wp_send_json_error( array( 'message' => 'Có lỗi xảy ra khi tải tệp tin lên máy chủ. Mã lỗi: ' . $file['error'] ) );
    }

    $max_size = 5 * 1024 * 1024; // 5MB
    if ( $file['size'] > $max_size ) {
        wp_send_json_error( array( 'message' => 'Lỗi: Dung lượng file CV vượt quá giới hạn cho phép (tối đa 5MB).' ) );
    }

    $filename = sanitize_file_name( $file['name'] );
    $ext      = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
    if ( $ext !== 'pdf' ) {
        wp_send_json_error( array( 'message' => 'Lỗi: Chỉ chấp nhận tệp tin có định dạng PDF (.pdf).' ) );
    }

    // Nạp các hàm hỗ trợ upload của WordPress nếu chưa có
    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }

    $upload_overrides = array(
        'test_form' => false,
        'mimes'     => array( 'pdf' => 'application/pdf' ),
    );

    $uploaded = wp_handle_upload( $file, $upload_overrides );
    if ( isset( $uploaded['error'] ) && ! empty( $uploaded['error'] ) ) {
        wp_send_json_error( array( 'message' => 'Lỗi lưu trữ tệp: ' . $uploaded['error'] ) );
    }

    $cv_url  = isset( $uploaded['url'] ) ? $uploaded['url'] : '';
    $cv_path = isset( $uploaded['file'] ) ? $uploaded['file'] : '';
    $cv_size = size_format( $file['size'], 2 );

    // 3.3. Lưu hồ sơ ứng viên vào CSDL dưới post_type 'nhomc_application'
    $post_title = $name . ' — ' . $job_title;
    $app_id = wp_insert_post( array(
        'post_type'    => 'nhomc_application',
        'post_title'   => $post_title,
        'post_status'  => 'publish',
        'post_content' => $notes,
    ), true );

    if ( is_wp_error( $app_id ) ) {
        wp_send_json_error( array( 'message' => 'Không thể tạo bản ghi hồ sơ: ' . $app_id->get_error_message() ) );
    }

    // 3.4. Lưu các trường meta dữ liệu và KHỞI TẠO OPTIMISTIC LOCKING VERSION = 1
    update_post_meta( $app_id, '_job_id', $job_id );
    update_post_meta( $app_id, '_job_title', $job_title );
    update_post_meta( $app_id, '_applicant_name', $name );
    update_post_meta( $app_id, '_applicant_email', $email );
    update_post_meta( $app_id, '_applicant_phone', $clean_phone );
    update_post_meta( $app_id, '_applicant_notes', $notes );
    update_post_meta( $app_id, '_applicant_cv_url', $cv_url );
    update_post_meta( $app_id, '_applicant_cv_path', $cv_path );
    update_post_meta( $app_id, '_applicant_cv_filename', $filename );
    update_post_meta( $app_id, '_applicant_cv_size', $cv_size );
    update_post_meta( $app_id, '_application_status', 'new' ); // Trạng thái: 'new', 'reviewing', 'interview', 'hired', 'rejected'
    update_post_meta( $app_id, '_version', 1 ); // KHÓA LẠC QUAN: Khởi tạo version = 1

    // 3.5. (Tùy chọn) Gửi email thông báo cho Quản trị viên
    $admin_email = get_option( 'admin_email' );
    if ( is_email( $admin_email ) ) {
        $subject = '[JobScout] Hồ sơ ứng tuyển mới: ' . $name . ' ứng tuyển ' . $job_title;
        $body  = "Xin chào Quản trị viên,\n\n";
        $body .= "Hệ thống vừa tiếp nhận một hồ sơ ứng tuyển mới:\n";
        $body .= "--------------------------------------------------\n";
        $body .= "- Vị trí công việc: " . $job_title . "\n";
        $body .= "- Họ và tên: " . $name . "\n";
        $body .= "- Email: " . $email . "\n";
        $body .= "- Số điện thoại: " . $clean_phone . "\n";
        $body .= "- Lời nhắn: " . ( ! empty( $notes ) ? $notes : '(Không có)' ) . "\n";
        $body .= "- File CV (PDF): " . $cv_url . "\n";
        $body .= "--------------------------------------------------\n";
        $body .= "Xem quản trị: " . admin_url( 'admin.php?page=nhomc-applications' ) . "\n\n";
        $body .= "Trân trọng,\nJobScout - Nhóm C";

        @wp_mail( $admin_email, $subject, $body );
    }

    wp_send_json_success( array(
        'message' => 'Nộp hồ sơ ứng tuyển thành công! File CV "' . $filename . '" (' . $cv_size . ') đã được lưu an toàn.',
        'app_id'  => $app_id,
    ) );
}
add_action( 'wp_ajax_nhomc_submit_application', 'nhomc_handle_application_submission' );
add_action( 'wp_ajax_nopriv_nhomc_submit_application', 'nhomc_handle_application_submission' );

/**
 * 4. AJAX: CẬP NHẬT TRẠNG THÁI HỒ SƠ VỚI CƠ CHẾ OPTIMISTIC LOCKING
 */
function nhomc_handle_update_application_status() {
    check_ajax_referer( 'nhomc_admin_app_nonce', 'security' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( array( 'message' => 'Bạn không có quyền thực hiện hành động này.' ) );
    }

    $app_id       = isset( $_POST['app_id'] ) ? intval( $_POST['app_id'] ) : 0;
    $new_status   = isset( $_POST['new_status'] ) ? sanitize_text_field( wp_unslash( $_POST['new_status'] ) ) : '';
    $sent_version = isset( $_POST['version'] ) ? intval( $_POST['version'] ) : 1;

    // 1. Kiểm tra bản ghi có còn tồn tại không
    $post = get_post( $app_id );
    if ( ! $post || $post->post_type !== 'nhomc_application' ) {
        wp_send_json_error( array(
            'error_type' => 'CONCURRENCY_DELETED',
            'message'    => 'Xung đột dữ liệu (Concurrency Conflict): Hồ sơ này đã bị xóa bởi một người dùng hoặc tab khác trước đó!'
        ) );
    }

    // 2. Kiểm tra Optimistic Locking Version
    $db_version = intval( get_post_meta( $app_id, '_version', true ) );
    if ( $db_version === 0 ) $db_version = 1;

    if ( $sent_version !== $db_version ) {
        wp_send_json_error( array(
            'error_type' => 'OPTIMISTIC_LOCK_EXCEPTION',
            'message'    => 'Xung đột dữ liệu - Optimistic Locking (Khóa lạc quan): Bản ghi này vừa được cập nhật bởi một người dùng khác (Phiên bản trên màn hình: v' . $sent_version . ', Phiên bản thực tế trong CSDL: v' . $db_version . '). Dữ liệu của bạn đã cũ (Stale Data), vui lòng tải lại trang!',
            'db_version' => $db_version
        ) );
    }

    // 3. Khớp version -> Cho phép cập nhật và tăng version = version + 1
    $valid_statuses = array( 'new', 'reviewing', 'interview', 'hired', 'rejected' );
    if ( ! in_array( $new_status, $valid_statuses, true ) ) {
        $new_status = 'new';
    }

    $next_version = $db_version + 1;
    update_post_meta( $app_id, '_application_status', $new_status );
    update_post_meta( $app_id, '_version', $next_version );

    wp_send_json_success( array(
        'message'     => 'Cập nhật trạng thái thành công!',
        'new_version' => $next_version,
        'new_status'  => $new_status
    ) );
}
add_action( 'wp_ajax_nhomc_update_application_status', 'nhomc_handle_update_application_status' );

/**
 * 5. Xử lý Hành động Quản trị (XÓA HỒ SƠ VỚI OPTIMISTIC LOCKING, Xuất CSV)
 */
add_action( 'admin_init', function () {
    if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // 5.1. Xuất file CSV danh sách ứng viên
    if ( isset( $_GET['nhomc_export_apps'] ) && $_GET['nhomc_export_apps'] === '1' ) {
        check_admin_referer( 'nhomc_export_apps_nonce' );

        $filter_job = isset( $_GET['job_id'] ) ? intval( $_GET['job_id'] ) : 0;
        $meta_query = array();
        if ( $filter_job > 0 ) {
            $meta_query[] = array(
                'key'   => '_job_id',
                'value' => $filter_job,
            );
        }

        $apps = get_posts( array(
            'post_type'      => 'nhomc_application',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'meta_query'     => $meta_query,
        ) );

        $filename = 'ung_vien_nhomc_' . date( 'Y-m-d_His' ) . '.csv';

        header( 'Content-Type: text/csv; charset=UTF-8' );
        header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
        header( 'Pragma: no-cache' );
        header( 'Expires: 0' );

        $output = fopen( 'php://output', 'w' );
        fprintf( $output, chr(0xEF) . chr(0xBB) . chr(0xBF) ); // UTF-8 BOM

        fputcsv( $output, array( 'STT', 'Họ và Tên', 'Email', 'Số Điện Thoại', 'Vị Trí Ứng Tuyển', 'Trạng Thái', 'Phiên Bản (Version)', 'Ngày Nộp', 'Tên File CV', 'Link CV PDF', 'Ghi Chú' ) );

        $stt = 1;
        foreach ( $apps as $app ) {
            $status_code = get_post_meta( $app->ID, '_application_status', true );
            $version     = get_post_meta( $app->ID, '_version', true );
            if ( empty( $version ) ) $version = 1;

            fputcsv( $output, array(
                $stt++,
                get_post_meta( $app->ID, '_applicant_name', true ),
                get_post_meta( $app->ID, '_applicant_email', true ),
                get_post_meta( $app->ID, '_applicant_phone', true ),
                get_post_meta( $app->ID, '_job_title', true ),
                $status_code,
                'v' . $version,
                get_the_date( 'd/m/Y H:i:s', $app->ID ),
                get_post_meta( $app->ID, '_applicant_cv_filename', true ),
                get_post_meta( $app->ID, '_applicant_cv_url', true ),
                get_post_meta( $app->ID, '_applicant_notes', true ),
            ) );
        }

        fclose( $output );
        exit;
    }

    // 5.2. XÓA HỒ SƠ ỨNG VIÊN CÓ KIỂM TRA OPTIMISTIC LOCKING
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'delete' && isset( $_GET['app_id'] ) ) {
        $app_id       = intval( $_GET['app_id'] );
        $sent_version = isset( $_GET['version'] ) ? intval( $_GET['version'] ) : 1;
        check_admin_referer( 'nhomc_delete_app_' . $app_id );

        // BƯỚC 1: Kiểm tra xem bản ghi có còn tồn tại không
        $post = get_post( $app_id );
        if ( ! $post || $post->post_type !== 'nhomc_application' ) {
            wp_safe_redirect( add_query_arg( array( 'page' => 'nhomc-applications', 'error' => 'deleted_already' ), admin_url( 'admin.php' ) ) );
            exit;
        }

        // BƯỚC 2: Kiểm tra phiên bản version (Optimistic Locking)
        $db_version = intval( get_post_meta( $app_id, '_version', true ) );
        if ( $db_version === 0 ) $db_version = 1;

        if ( $sent_version !== $db_version ) {
            // Version không khớp: Ai đó đã sửa bản ghi này trước khi tab này bấm Xóa!
            wp_safe_redirect( add_query_arg( array( 
                'page'     => 'nhomc-applications', 
                'error'    => 'version_mismatch',
                'v_sent'   => $sent_version,
                'v_actual' => $db_version
            ), admin_url( 'admin.php' ) ) );
            exit;
        }

        // BƯỚC 3: Version khớp -> Cho phép xóa tệp CV và xóa bản ghi
        $cv_path = get_post_meta( $app_id, '_applicant_cv_path', true );
        if ( ! empty( $cv_path ) && file_exists( $cv_path ) ) {
            @unlink( $cv_path );
        }

        wp_delete_post( $app_id, true );
        wp_safe_redirect( add_query_arg( array( 'page' => 'nhomc-applications', 'status' => 'deleted' ), admin_url( 'admin.php' ) ) );
        exit;
    }
} );

/**
 * 6. Giao diện Trang Quản trị Hồ Sơ Ứng Tuyển trong WP-Admin
 */
function nhomc_render_applications_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Bạn không có quyền truy cập trang này.' );
    }

    $search_query = isset( $_GET['s'] ) ? sanitize_text_field( trim( wp_unslash( $_GET['s'] ) ) ) : '';
    $filter_job   = isset( $_GET['job_id'] ) ? intval( $_GET['job_id'] ) : 0;
    $paged        = isset( $_GET['paged'] ) ? max( 1, intval( $_GET['paged'] ) ) : 1;
    $posts_per_pg = 15;

    $meta_query = array();
    if ( $filter_job > 0 ) {
        $meta_query[] = array(
            'key'     => '_job_id',
            'value'   => $filter_job,
            'compare' => '=',
        );
    }

    $args = array(
        'post_type'      => 'nhomc_application',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_pg,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => $meta_query,
    );

    if ( ! empty( $search_query ) ) {
        $args['s'] = $search_query;
    }

    $app_query = new WP_Query( $args );
    $total_apps = wp_count_posts( 'nhomc_application' )->publish;

    // Đếm số đơn nộp hôm nay
    $today_query = new WP_Query( array(
        'post_type'      => 'nhomc_application',
        'post_status'    => 'publish',
        'date_query'     => array(
            array(
                'year'  => date( 'Y' ),
                'month' => date( 'm' ),
                'day'   => date( 'd' ),
            ),
        ),
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ) );
    $today_count = $today_query->found_posts;

    $jobs = get_posts( array(
        'post_type'      => 'job_listing',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ) );

    // Từ điển trạng thái ứng tuyển
    $status_labels = array(
        'new'        => array( 'label' => 'Mới nhận', 'bg' => '#eff6ff', 'color' => '#1d4ed8', 'border' => '#bfdbfe' ),
        'reviewing'  => array( 'label' => 'Đang xem xét', 'bg' => '#fefce8', 'color' => '#a16207', 'border' => '#fef08a' ),
        'interview'  => array( 'label' => 'Mời phỏng vấn', 'bg' => '#f5f3ff', 'color' => '#6d28d9', 'border' => '#ddd6fe' ),
        'hired'      => array( 'label' => 'Đã tuyển', 'bg' => '#ecfdf5', 'color' => '#047857', 'border' => '#a7f3d0' ),
        'rejected'   => array( 'label' => 'Từ chối', 'bg' => '#fef2f2', 'color' => '#b91c1c', 'border' => '#fecaca' ),
    );
    ?>
    <div class="wrap nhomc-apps-admin-wrap">
        <h1 class="wp-heading-inline">
            <span class="dashicons dashicons-id-alt" style="font-size:28px; line-height:1; vertical-align:middle; color:#ea580c; margin-right:8px;"></span>
            Quản Lý Hồ Sơ Ứng Tuyển &amp; CV Ứng Viên
        </h1>
        <hr class="wp-header-end">

        <!-- THÔNG BÁO XUNG ĐỘT OPTIMISTIC LOCKING -->
        <?php if ( isset( $_GET['error'] ) && $_GET['error'] === 'deleted_already' ) : ?>
            <div class="notice notice-error is-dismissible" style="border-left-color: #dc2626;">
                <p>
                    <strong>⚠️ Xung đột dữ liệu (Concurrency Conflict):</strong> 
                    Hồ sơ ứng viên này đã bị xóa trước đó bởi một tiến trình hoặc tab trình duyệt khác! Danh sách đã được tự động làm mới.
                </p>
            </div>
        <?php elseif ( isset( $_GET['error'] ) && $_GET['error'] === 'version_mismatch' ) : ?>
            <div class="notice notice-error is-dismissible" style="border-left-color: #dc2626;">
                <p>
                    <strong>⚠️ Xung đột phiên bản - Optimistic Locking (Khóa lạc quan):</strong> 
                    Hồ sơ này vừa được chỉnh sửa hoặc cập nhật bởi một người dùng khác (Phiên bản trên màn hình của bạn là <code>v<?php echo intval( $_GET['v_sent'] ); ?></code>, nhưng phiên bản thực tế hiện tại là <code>v<?php echo intval( $_GET['v_actual'] ); ?></code>).
                    <br>Hành động xóa đã bị hủy bỏ để bảo toàn dữ liệu mới nhất. Vui lòng kiểm tra lại!
                </p>
            </div>
        <?php elseif ( isset( $_GET['status'] ) && $_GET['status'] === 'deleted' ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>Thành công:</strong> Đã xóa hồ sơ ứng viên và tệp CV liên quan khỏi hệ thống.</p>
            </div>
        <?php endif; ?>

        <!-- Cards Thống Kê -->
        <div class="nhomc-stats-grid">
            <div class="nhomc-stat-card">
                <div class="nhomc-stat-icon" style="background: #fff7ed; color: #ea580c;">
                    <span class="dashicons dashicons-groups"></span>
                </div>
                <div class="nhomc-stat-info">
                    <span class="nhomc-stat-label">Tổng Số Hồ Sơ Ứng Tuyển</span>
                    <strong class="nhomc-stat-num"><?php echo number_format_i18n( $total_apps ); ?></strong>
                </div>
            </div>

            <div class="nhomc-stat-card">
                <div class="nhomc-stat-icon" style="background: #ecfdf5; color: #059669;">
                    <span class="dashicons dashicons-calendar-alt"></span>
                </div>
                <div class="nhomc-stat-info">
                    <span class="nhomc-stat-label">Ứng Tuyển Mới Hôm Nay</span>
                    <strong class="nhomc-stat-num" style="color: #059669;"><?php echo number_format_i18n( $today_count ); ?></strong>
                </div>
            </div>

            <div class="nhomc-stat-card">
                <div class="nhomc-stat-icon" style="background: #eff6ff; color: #2563eb;">
                    <span class="dashicons dashicons-portfolio"></span>
                </div>
                <div class="nhomc-stat-info">
                    <span class="nhomc-stat-label">Công Việc Đang Tuyển Dụng</span>
                    <strong class="nhomc-stat-num" style="color: #2563eb;"><?php echo count( $jobs ); ?></strong>
                </div>
            </div>
        </div>

        <!-- Thanh Tìm Kiếm, Lọc & Xuất File -->
        <div class="nhomc-toolbar">
            <form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>" class="nhomc-filter-form">
                <input type="hidden" name="page" value="nhomc-applications">
                
                <div class="nhomc-filter-group">
                    <input type="search" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="Tìm tên ứng viên, email..." class="nhomc-search-input">
                    
                    <select name="job_id" class="nhomc-select-job">
                        <option value="0">— Tất cả vị trí công việc —</option>
                        <?php foreach ( $jobs as $job ) : ?>
                            <option value="<?php echo esc_attr( $job->ID ); ?>" <?php selected( $filter_job, $job->ID ); ?>>
                                <?php echo esc_html( $job->post_title ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="button button-primary">Lọc Hồ Sơ</button>

                    <?php if ( ! empty( $search_query ) || $filter_job > 0 ) : ?>
                        <a href="<?php echo esc_url( admin_url( 'admin.php?page=nhomc-applications' ) ); ?>" class="button button-secondary">Đặt Lại</a>
                    <?php endif; ?>
                </div>
            </form>

            <div class="nhomc-actions-right">
                <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'nhomc_export_apps' => '1', 'job_id' => $filter_job ), admin_url( 'admin.php' ) ), 'nhomc_export_apps_nonce' ) ); ?>" class="button button-secondary">
                    <span class="dashicons dashicons-download" style="vertical-align:text-bottom; margin-right:4px;"></span> Xuất File CSV
                </a>
            </div>
        </div>

        <!-- Bảng Danh Sách Ứng Viên -->
        <table class="wp-list-table widefat fixed striped nhomc-apps-table">
            <thead>
                <tr>
                    <th style="width: 45px; text-align: center;">STT</th>
                    <th style="width: 210px;">Ứng Viên</th>
                    <th style="width: 190px;">Vị Trí Ứng Tuyển</th>
                    <th style="width: 180px;">Hồ Sơ CV (PDF)</th>
                    <th style="width: 170px;">Trạng Thái &amp; Khóa (Lock)</th>
                    <th>Lời Nhắn / Giới Thiệu</th>
                    <th style="width: 120px;">Thời Gian</th>
                    <th style="width: 75px; text-align: center;">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if ( $app_query->have_posts() ) : ?>
                    <?php
                    $stt = ( $paged - 1 ) * $posts_per_pg + 1;
                    while ( $app_query->have_posts() ) :
                        $app_query->the_post();
                        $app_id   = get_the_ID();
                        $name     = get_post_meta( $app_id, '_applicant_name', true );
                        $email    = get_post_meta( $app_id, '_applicant_email', true );
                        $phone    = get_post_meta( $app_id, '_applicant_phone', true );
                        $job_name = get_post_meta( $app_id, '_job_title', true );
                        $job_id   = get_post_meta( $app_id, '_job_id', true );
                        $notes    = get_post_meta( $app_id, '_applicant_notes', true );
                        $cv_url   = get_post_meta( $app_id, '_applicant_cv_url', true );
                        $cv_name  = get_post_meta( $app_id, '_applicant_cv_filename', true );
                        $cv_size  = get_post_meta( $app_id, '_applicant_cv_size', true );
                        $status   = get_post_meta( $app_id, '_application_status', true );
                        if ( empty( $status ) ) $status = 'new';
                        
                        // OPTIMISTIC LOCKING VERSION
                        $version  = intval( get_post_meta( $app_id, '_version', true ) );
                        if ( $version === 0 ) $version = 1;

                        if ( empty( $cv_name ) ) $cv_name = 'cv-ung-vien.pdf';
                        $status_info = isset( $status_labels[ $status ] ) ? $status_labels[ $status ] : $status_labels['new'];
                    ?>
                        <tr id="nhomc-app-row-<?php echo $app_id; ?>" data-app-id="<?php echo $app_id; ?>" data-version="<?php echo $version; ?>">
                            <td style="text-align: center; font-weight: 600; color: #64748b;"><?php echo $stt++; ?></td>
                            <td>
                                <strong style="font-size: 13.5px; color: #0f172a; display: block; margin-bottom: 3px;">
                                    <?php echo esc_html( $name ); ?>
                                </strong>
                                <div style="font-size: 12px; color: #475569; display: flex; flex-direction: column; gap: 2px;">
                                    <span><span class="dashicons dashicons-email-alt" style="font-size:14px; width:14px; height:14px; vertical-align:middle;"></span> <a href="mailto:<?php echo esc_attr( $email ); ?>" style="text-decoration:none;"><?php echo esc_html( $email ); ?></a></span>
                                    <span><span class="dashicons dashicons-phone" style="font-size:14px; width:14px; height:14px; vertical-align:middle;"></span> <a href="tel:<?php echo esc_attr( $phone ); ?>" style="color:#059669; text-decoration:none; font-weight:600;"><?php echo esc_html( $phone ); ?></a></span>
                                </div>
                            </td>
                            <td>
                                <?php if ( $job_id && get_post( $job_id ) ) : ?>
                                    <a href="<?php echo esc_url( get_permalink( $job_id ) ); ?>" target="_blank" style="font-weight: 600; color: #2563eb; text-decoration: none; font-size: 12.5px;">
                                        <?php echo esc_html( $job_name ); ?>
                                        <span class="dashicons dashicons-external" style="font-size: 13px; vertical-align: middle;"></span>
                                    </a>
                                <?php else : ?>
                                    <span style="font-weight: 600; color: #64748b; font-size: 12.5px;"><?php echo esc_html( $job_name ); ?> (Đã đóng)</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ( ! empty( $cv_url ) ) : ?>
                                    <div class="nhomc-admin-cv-pill">
                                        <div class="nhomc-admin-cv-icon">
                                            <span class="dashicons dashicons-media-document"></span>
                                        </div>
                                        <div class="nhomc-admin-cv-text">
                                            <a href="<?php echo esc_url( $cv_url ); ?>" target="_blank" class="nhomc-btn-view-cv" title="Mở file PDF trong tab mới">
                                                Xem File CV (PDF) &nearr;
                                            </a>
                                            <span class="nhomc-admin-cv-meta"><?php echo esc_html( $cv_size ); ?></span>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <span style="color: #94a3b8; font-style: italic;">Không có file</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Dropdown Thay Đổi Trạng Thái với Optimistic Locking -->
                                <div class="nhomc-status-container">
                                    <select class="nhomc-status-select" onchange="nhomcChangeStatus(<?php echo $app_id; ?>, this.value, this)">
                                        <?php foreach ( $status_labels as $s_key => $s_data ) : ?>
                                            <option value="<?php echo esc_attr( $s_key ); ?>" <?php selected( $status, $s_key ); ?>>
                                                <?php echo esc_html( $s_data['label'] ); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="nhomc-version-badge" title="Phiên bản Optimistic Locking hiện tại">
                                        v<span class="v-num"><?php echo $version; ?></span>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <?php if ( ! empty( $notes ) ) : ?>
                                    <div style="font-size: 12px; color: #334155; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px; padding: 6px 10px; max-height: 70px; overflow-y: auto;">
                                        <?php echo nl2br( esc_html( $notes ) ); ?>
                                    </div>
                                <?php else : ?>
                                    <span style="color: #94a3b8; font-style: italic; font-size: 12px;">(Không có)</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size: 12px; color: #64748b;">
                                <strong><?php echo get_the_date( 'd/m/Y' ); ?></strong><br>
                                <span style="font-size: 11px;"><?php echo get_the_time( 'H:i' ); ?></span>
                            </td>
                            <td style="text-align: center;">
                                <!-- Nút Xóa kèm Version hiện tại để kiểm tra Optimistic Locking -->
                                <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'action' => 'delete', 'app_id' => $app_id, 'version' => $version ), admin_url( 'admin.php?page=nhomc-applications' ) ), 'nhomc_delete_app_' . $app_id ) ); ?>" 
                                   class="button button-small button-link-delete nhomc-btn-delete"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa hồ sơ ứng viên <?php echo esc_js( $name ); ?> (Phiên bản v<?php echo $version; ?>) và file CV PDF đính kèm không?');"
                                   style="color: #dc2626;">
                                    Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 36px 15px; color: #64748b;">
                            <span class="dashicons dashicons-info" style="font-size: 32px; width: 32px; height: 32px; color: #94a3b8; display: block; margin: 0 auto 10px;"></span>
                            <strong style="font-size: 15px; display: block; margin-bottom: 4px;">Chưa có hồ sơ ứng tuyển nào</strong>
                            <span>Khi ứng viên bấm "APPLY JOB" và đính kèm CV trên website, hồ sơ sẽ tự động xuất hiện tại đây.</span>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Phân Trang -->
        <?php if ( $app_query->max_num_pages > 1 ) : ?>
            <div class="tablenav">
                <div class="tablenav-pages">
                    <?php
                    echo paginate_links( array(
                        'base'      => add_query_arg( 'paged', '%#%' ),
                        'format'    => '',
                        'prev_text' => '&laquo; Trước',
                        'next_text' => 'Sau &raquo;',
                        'total'     => $app_query->max_num_pages,
                        'current'   => $paged,
                    ) );
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- JavaScript Xử Lý Cập Nhật Trạng Thái & Xung Đột Optimistic Locking -->
    <script>
    var nhomcAdminNonce = '<?php echo wp_create_nonce( 'nhomc_admin_app_nonce' ); ?>';

    function nhomcChangeStatus(appId, newStatus, selectElem) {
        var row = document.getElementById('nhomc-app-row-' + appId);
        if (!row) return;

        var currentVersion = parseInt(row.getAttribute('data-version') || '1', 10);
        var originalValue = selectElem.getAttribute('data-original-value') || selectElem.value;

        selectElem.disabled = true;

        var formData = new FormData();
        formData.append('action', 'nhomc_update_application_status');
        formData.append('security', nhomcAdminNonce);
        formData.append('app_id', appId);
        formData.append('new_status', newStatus);
        formData.append('version', currentVersion);

        fetch(ajaxurl, {
            method: 'POST',
            body: formData
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            selectElem.disabled = false;

            if (data && data.success) {
                // Cập nhật version mới vào DOM
                var nextVersion = data.data.new_version;
                row.setAttribute('data-version', nextVersion);
                var vSpan = row.querySelector('.v-num');
                if (vSpan) vSpan.innerText = nextVersion;

                // Cập nhật link xóa kèm version mới
                var delBtn = row.querySelector('.nhomc-btn-delete');
                if (delBtn) {
                    var href = delBtn.getAttribute('href');
                    href = href.replace(/version=\d+/, 'version=' + nextVersion);
                    delBtn.setAttribute('href', href);
                }

                selectElem.setAttribute('data-original-value', newStatus);
                selectElem.style.borderColor = '#10b981';
                setTimeout(function() { selectElem.style.borderColor = ''; }, 1500);
            } else {
                // XỬ LÝ LỖI XUNG ĐỘT OPTIMISTIC LOCKING
                var errorMsg = (data && data.data && data.data.message) ? data.data.message : 'Có lỗi xảy ra!';
                alert(errorMsg);

                // Khôi phục lại trạng thái cũ trên select
                selectElem.value = originalValue;

                // Tự động tải lại trang sau 1.5s nếu là lỗi xung đột để lấy dữ liệu mới nhất
                if (data && data.data && (data.data.error_type === 'OPTIMISTIC_LOCK_EXCEPTION' || data.data.error_type === 'CONCURRENCY_DELETED')) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1200);
                }
            }
        })
        .catch(function(err) {
            selectElem.disabled = false;
            selectElem.value = originalValue;
            alert('Lỗi kết nối máy chủ khi cập nhật trạng thái!');
        });
    }
    </script>

    <!-- Admin Styling -->
    <style>
    .nhomc-apps-admin-wrap {
        margin: 20px 20px 40px 2px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .nhomc-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin: 20px 0;
    }
    .nhomc-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .nhomc-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .nhomc-stat-icon .dashicons {
        font-size: 24px;
        width: 24px;
        height: 24px;
    }
    .nhomc-stat-info {
        display: flex;
        flex-direction: column;
    }
    .nhomc-stat-label {
        font-size: 12.5px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .nhomc-stat-num {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 2px;
    }
    .nhomc-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }
    .nhomc-filter-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .nhomc-search-input {
        min-width: 220px;
        height: 34px !important;
        border-radius: 4px !important;
    }
    .nhomc-select-job {
        max-width: 260px;
        height: 34px !important;
        border-radius: 4px !important;
    }
    .nhomc-apps-table {
        background: #ffffff;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .nhomc-apps-table th {
        font-weight: 700 !important;
        color: #1e293b !important;
        padding: 12px 14px !important;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    .nhomc-apps-table td {
        padding: 14px !important;
        vertical-align: middle !important;
    }
    .nhomc-admin-cv-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff1f2;
        border: 1px solid #fecdd3;
        border-radius: 6px;
        padding: 6px 10px;
    }
    .nhomc-admin-cv-icon {
        color: #e11d48;
        display: flex;
        align-items: center;
    }
    .nhomc-admin-cv-icon .dashicons {
        font-size: 18px;
        width: 18px;
        height: 18px;
    }
    .nhomc-admin-cv-text {
        display: flex;
        flex-direction: column;
    }
    .nhomc-btn-view-cv {
        font-size: 12.5px;
        font-weight: 700;
        color: #e11d48 !important;
        text-decoration: none;
        line-height: 1.2;
    }
    .nhomc-btn-view-cv:hover {
        text-decoration: underline;
    }
    .nhomc-admin-cv-meta {
        font-size: 11px;
        color: #9f1239;
        margin-top: 1px;
    }
    .nhomc-status-container {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .nhomc-status-select {
        font-size: 12px !important;
        font-weight: 600 !important;
        padding: 3px 6px !important;
        border-radius: 4px !important;
        border-color: #cbd5e1 !important;
        background-color: #f8fafc !important;
    }
    .nhomc-version-badge {
        font-size: 10.5px;
        font-weight: 800;
        color: #6366f1;
        background: #eef2ff;
        border: 1px solid #c7d2fe;
        border-radius: 4px;
        padding: 2px 6px;
        white-space: nowrap;
    }
    </style>
    <?php
}
