<?php
/**
 * ============================================================================
 * PAGE TEMPLATE: XEM CHI TIẾT VIỆC LÀM QUA ĐƯỜNG DẪN TRANG (PAGE QUERY ROUTE)
 * Template Name: Job Detail Page (NhomC Design)
 *
 * TẬP TIN NÀY CHỊU TRÁCH NHIỆM:
 * 1. Cho phép xem chi tiết công việc qua URL tĩnh: /job-detail/?job_id=XXX.
 * 2. Lấy tham số 'job_id' từ URL (GET Request) và ép kiểu an toàn (intval).
 * 3. Cơ chế Fallback thông minh: nếu không truyền ID hoặc ID không tồn tại,
 *    tự động lấy bài đăng việc làm (job_listing) mới nhất từ MySQL.
 * 4. Thiết lập biến toàn cục $post và kích hoạt setup_postdata() để WordPress
 *    nhận diện đầy đủ metadata của bài viết đó.
 * 5. Gọi template-parts/content-jobdetail-view.php và footer-jobdetail.php.
 * 6. Khôi phục trạng thái bài viết toàn cục với wp_reset_postdata().
 *
 * @package JobScout
 * ============================================================================
 */

// Bước 1: Nạp Header chuyên biệt cho trang chi tiết việc làm
get_header( 'jobdetail' );

// Bước 2: Lấy ID công việc từ tham số URL (?job_id=...), mặc định là ID 19
$target_job_id = isset( $_GET['job_id'] ) ? intval( $_GET['job_id'] ) : 19;
$job_post = get_post( $target_job_id );

// Bước 3: Kiểm tra nếu ID không hợp lệ hoặc không phải post_type 'job_listing'
if ( ! $job_post || $job_post->post_type !== 'job_listing' ) {
    // Tự động truy vấn bài viết việc làm (job_listing) hợp lệ đầu tiên đang phát hành
    $fallback_jobs = get_posts( array(
        'post_type'      => 'job_listing',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ) );
    if ( ! empty( $fallback_jobs ) ) {
        $job_post = $fallback_jobs[0];
    }
}

// Bước 4: Thiết lập ngữ cảnh bài viết cho toàn bộ hệ thống WordPress
if ( $job_post ) {
    global $post;
    $post = $job_post;
    setup_postdata( $post ); // Khởi tạo dữ liệu post để dùng the_title(), the_content(), get_the_ID()...

    // Nạp giao diện chính của trang chi tiết việc làm
    get_template_part( 'template-parts/content', 'jobdetail-view' );
}

// Bước 5: Nạp Footer chuyên biệt chứa Modal Apply CV và các script xử lý
get_footer( 'jobdetail' );

// Bước 6: Khôi phục lại trạng thái biến $post ban đầu để tránh xung đột với các truy vấn khác
if ( $job_post ) {
    wp_reset_postdata();
}


