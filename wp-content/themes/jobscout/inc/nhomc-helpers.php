<?php
/**
 * ============================================================================
 * CÁC HÀM TRỢ GIÚP DÀNH RIÊNG CHO TRANG CHI TIẾT VIỆC LÀM (NHOM C HELPERS)
 * Dự án: FIT - TDC Cuối Kỳ | Thương hiệu: NhomC RECRUITING
 * Khớp chuẩn thiết kế: 5-job detail.png
 *
 * DANH SÁCH CÁC HÀM XỬ LÝ:
 * 1. nhomc_get_company_logo(): Hiển thị logo doanh nghiệp linh hoạt (Ảnh đại diện,
 *    post meta _company_logo, logo typography SVG thương hiệu hoặc avatar viết tắt).
 * 2. nhomc_get_job_badges(): Lấy thông tin phân loại: Loại hình (Full time), Ngành nghề, Địa điểm.
 * 3. nhomc_get_job_bullets(): Trích xuất 3 điểm nhấn công việc hiển thị trên Card Other Jobs.
 * 4. nhomc_ensure_custom_pages(): Tự động tạo và kiểm tra các trang cần thiết trong Database.
 *
 * @package JobScout
 * ============================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * HÀM 1: HIỂN THỊ LOGO DOANH NGHIỆP DỰA THEO DỮ LIỆU DATABASE HOẶC TÊN CÔNG TY
 * 
 * Thứ tự ưu tiên hiển thị:
 * 1. Ảnh đại diện bài viết (Featured Image / Thumbnail).
 * 2. Đường dẫn ảnh lưu trong custom field '_company_logo'.
 * 3. Biểu trưng đồ họa SVG chuẩn thiết kế Figma theo các thương hiệu nổi bật (THE SODOH, FONTAINE GARDEN, Seven House, Phở Thìn...).
 * 4. Fallback tự động: Huy hiệu chữ viết tắt (Initials) kết hợp tên công ty trên nền xám chuyên nghiệp.
 *
 * @param string $company_name Tên công ty
 * @param int    $post_id      ID bài đăng việc làm
 * @param string $size         Kích thước logo ('large' cho Hero Card, 'small' cho Other Jobs Card)
 * @return string              Mã HTML hiển thị logo
 */
function nhomc_get_company_logo( $company_name = '', $post_id = 0, $size = 'large' ) {
    // 1. Kiểm tra ảnh đại diện bài viết
    if ( ! empty( $post_id ) && has_post_thumbnail( $post_id ) ) {
        return get_the_post_thumbnail( $post_id, 'medium', array( 'class' => 'nhomc-logo-img' ) );
    }

    // 2. Kiểm tra custom meta '_company_logo'
    if ( ! empty( $post_id ) ) {
        $logo_url = get_post_meta( $post_id, '_company_logo', true );
        if ( ! empty( $logo_url ) ) {
            return '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $company_name ) . '" class="nhomc-logo-img">';
        }
    }

    $c_clean = strtoupper( trim( (string)$company_name ) );

    // 3.1. Thương hiệu THE SODOH (Higashiyama Kyoto)
    if ( strpos( $c_clean, 'SODOH' ) !== false || strpos( $c_clean, '0TBEOH' ) !== false ) {
        return '
        <div class="nhomc-typo-logo sodoh">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#222" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
            <span class="logo-sub">THE</span>
            <span class="logo-main" style="letter-spacing:1px;font-weight:900;">SODOH</span>
            <span class="logo-sub" style="font-size:5px;">HIGASHIYAMA KYOTO</span>
        </div>';
    }

    // 3.2. Thương hiệu FONTAINE GARDEN
    if ( strpos( $c_clean, 'GARDEN' ) !== false ) {
        return '
        <div class="nhomc-typo-logo garden" style="border:1px solid #d1d5db;padding:4px;width:90%;height:85%;">
            <span class="logo-sub" style="font-size:6px;letter-spacing:1px;">FONTAINE</span>
            <span class="logo-main" style="font-size:10px;font-weight:700;letter-spacing:0.8px;">GARDEN</span>
        </div>';
    }

    // 3.3. Thương hiệu The Seygn House / The Seven House Kyoto
    if ( strpos( $c_clean, 'SEYGN' ) !== false || strpos( $c_clean, 'SEVEN' ) !== false ) {
        return '
        <div class="nhomc-typo-logo seven-house">
            <div style="width:20px;height:20px;border:3px solid #111;margin-bottom:3px;"></div>
            <span class="logo-main" style="font-size:9px;font-weight:800;letter-spacing:0.5px;">TH€ Seygn House</span>
            <span class="logo-sub" style="font-size:5px;">KYOTO</span>
        </div>';
    }

    // 3.4. Thương hiệu PHỞ THÌN
    if ( strpos( $c_clean, 'THIN' ) !== false || strpos( $c_clean, 'PHỞ' ) !== false || strpos( $c_clean, 'PHO' ) !== false ) {
        return '
        <div class="nhomc-typo-logo pho-thin">
            <div style="border:1px solid #111;padding:2px 6px;margin-bottom:2px;">
                <span class="logo-main" style="font-size:12px;font-weight:900;letter-spacing:1px;">PHỞ</span>
            </div>
            <span class="logo-main" style="font-size:8px;font-weight:800;letter-spacing:1px;">THÌN</span>
        </div>';
    }

    // 3.5. Thương hiệu FROM WHERE I STAND
    if ( strpos( $c_clean, 'STAND' ) !== false || strpos( $c_clean, 'WHERE' ) !== false ) {
        return '
        <div class="nhomc-typo-logo stand" style="border-radius:50%;border:1px solid #999;width:55px;height:55px;display:flex;flex-direction:column;align-items:center;justify-content:center;">
            <span style="font-size:16px;">⟐</span>
            <span class="logo-sub" style="font-size:5px;letter-spacing:0.5px;text-align:center;">FROM WHERE<br>I STAND</span>
        </div>';
    }

    // 3.6. Thương hiệu PLAN DO SEE GLOBAL
    if ( strpos( $c_clean, 'PLAN' ) !== false || strpos( $c_clean, 'PDS' ) !== false ) {
        return '
        <div class="nhomc-typo-logo pds">
            <span class="logo-main" style="font-size:11px;font-weight:800;letter-spacing:0.8px;">PLAN DO SEE</span>
            <span class="logo-sub" style="font-size:6px;letter-spacing:1px;">GLOBAL</span>
        </div>';
    }

    // 4. Logo mặc định: Tạo từ chữ cái đầu (Initials) của tên công ty
    $initials = '';
    $words = explode( ' ', (string)$company_name );
    foreach ( $words as $w ) {
        if ( ! empty( $w ) ) {
            $initials .= mb_substr( $w, 0, 1 );
        }
    }
    $initials = mb_substr( $initials, 0, 3 );

    return '
    <div class="nhomc-typo-logo default" style="background:#f3f4f6;width:100%;height:100%;border-radius:3px;">
        <span class="logo-main" style="font-size:13px;font-weight:900;color:#ea580c;">' . esc_html( $initials ) . '</span>
        <span class="logo-sub" style="font-size:7px;color:#4b5563;max-width:70px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' . esc_html( $company_name ) . '</span>
    </div>';
}

/**
 * HÀM 2: TRUY VẤN CÁC HUY HIỆU PHÂN LOẠI CÔNG VIỆC TỪ TAXONOMY & META (Type, Category, Location)
 *
 * @param int $post_id ID bài viết việc làm
 * @return array Mảng kết hợp chứa ['type', 'category', 'location']
 */
function nhomc_get_job_badges( $post_id ) {
    // 1. Phân loại Loại hình công việc (Full time / Part time / Internship)
    if ( function_exists( 'wpjm_get_the_job_types' ) ) {
        $types = wpjm_get_the_job_types( $post_id );
    } else {
        $types = wp_get_post_terms( $post_id, 'job_listing_type' );
    }
    $type_name = 'Fulltime';
    if ( ! empty( $types ) && is_array( $types ) ) {
        $first_type = reset( $types );
        $type_name = $first_type->name;
    }
    if ( strtolower( str_replace( array( ' ', '-' ), '', $type_name ) ) === 'fulltime' ) {
        $type_name = 'Fulltime';
    }

    // 2. Phân loại Ngành nghề tuyển dụng (Job Category)
    $cats = get_the_terms( $post_id, 'job_listing_category' );
    $cat_name = 'Category Name';
    if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
        $first_cat = reset( $cats );
        $cat_name = $first_cat->name;
    }

    // 3. Địa điểm làm việc (Job Location từ post meta '_job_location')
    $location = get_post_meta( $post_id, '_job_location', true );
    if ( empty( $location ) ) {
        $location = 'Ho Chi Minh City';
    }

    return array(
        'type'     => $type_name,
        'category' => $cat_name,
        'location' => $location,
    );
}

/**
 * HÀM 3: TRÍCH XUẤT 3 ĐIỂM NỔI BẬT (BULLETS) CHO CARD VIỆC LÀM LIÊN QUAN (OTHER JOBS)
 *
 * Tự động quét nội dung bài viết và lọc ra các câu gạch đầu dòng (• hoặc -).
 * Nếu bài viết chưa có, tự động dùng 3 gạch đầu dòng chuẩn theo thiết kế Figma.
 *
 * @param int    $post_id      ID việc làm
 * @param string $post_content Nội dung bài viết
 * @return array               Mảng đúng 3 chuỗi mô tả ngắn
 */
function nhomc_get_job_bullets( $post_id, $post_content = '' ) {
    $bullets = array();

    // Bóc tách nội dung từ bài viết nếu có ký tự bullet • hoặc dấu gạch -
    if ( ! empty( $post_content ) ) {
        $lines = explode( "\n", strip_tags( $post_content, '<br>' ) );
        foreach ( $lines as $line ) {
            $cleaned = trim( str_replace( array( '<br>', '<br/>', '<br />' ), '', $line ) );
            if ( mb_strpos( $cleaned, '•' ) !== false || mb_strpos( $cleaned, '-' ) === 0 ) {
                $cleaned = trim( preg_replace( '/^[•\-\*\s]+/u', '', $cleaned ) );
                if ( ! empty( $cleaned ) && mb_strlen( $cleaned ) > 10 ) {
                    $bullets[] = $cleaned;
                }
            }
        }
    }

    // Mẫu dự phòng đúng 3 gạch đầu dòng chuẩn Figma nếu không bóc tách được
    if ( count( $bullets ) < 3 ) {
        $bullets = array(
            'Be responsible for the effective operational management of the hotel',
            'Excellent salary bonuses & recognition activities',
            'Foreign language allowance (up to 500USD/month)'
        );
    }

    return array_slice( $bullets, 0, 3 );
}

/**
 * Tu dong kiem tra va tao cac trang Nhom C can thiet trong CSDL (Job Detail, News Detail...)
 * Tranh loi 404 khi pull code sang may khac hoac reset Database.
 */
function nhomc_ensure_custom_pages() {
    $required_pages = array(
        'job-detail' => array(
            'title'    => 'Job Detail',
            'template' => 'page-job-detail.php',
        ),
        'jobdetail' => array(
            'title'    => 'Job Detail',
            'template' => 'page-jobdetail.php',
        ),
        'news-detail' => array(
            'title'    => 'News Detail',
            'template' => 'page-news-detail.php',
        ),
    );

    $needs_rewrite_flush = false;

    foreach ( $required_pages as $slug => $data ) {
        $existing = get_posts( array(
            'name'           => $slug,
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
        ) );

        if ( empty( $existing ) ) {
            $page_id = wp_insert_post( array(
                'post_title'     => $data['title'],
                'post_name'      => $slug,
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
            ) );

            if ( $page_id && ! is_wp_error( $page_id ) ) {
                if ( ! empty( $data['template'] ) ) {
                    update_post_meta( $page_id, '_wp_page_template', $data['template'] );
                }
                $needs_rewrite_flush = true;
            }
        }
    }

    if ( $needs_rewrite_flush ) {
        flush_rewrite_rules( false );
    }
}
add_action( 'init', 'nhomc_ensure_custom_pages' );
