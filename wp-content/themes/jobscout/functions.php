<?php
/**
 * JobScout functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package JobScout
 */

$jobscout_theme_data = wp_get_theme();
if( ! defined( 'JOBSCOUT_THEME_VERSION' ) ) define ( 'JOBSCOUT_THEME_VERSION', $jobscout_theme_data->get( 'Version' ) );
if( ! defined( 'JOBSCOUT_THEME_NAME' ) ) define( 'JOBSCOUT_THEME_NAME', $jobscout_theme_data->get( 'Name' ) );

/**
 * Implement Local Font Method functions.
 */
require get_template_directory() . '/inc/class-webfont-loader.php';

/**
 * Custom Functions.
 */
require get_template_directory() . '/inc/custom-functions.php';

/**
 * Standalone Functions.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Template Functions.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom functions for selective refresh.
 */
require get_template_directory() . '/inc/partials.php';

if( jobscout_is_rara_theme_companion_activated() ) :
	/**
	 * Modify filter hooks of RTC plugin.
	 */
	require get_template_directory() . '/inc/rtc-filters.php';
endif;

/**
 * Custom Controls
 */
require get_template_directory() . '/inc/custom-controls/custom-control.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Metabox
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Getting Started
*/
require get_template_directory() . '/inc/dashboard/dashboard.php';

/**
 * Plugin Recommendation
*/
require get_template_directory() . '/inc/tgmpa/recommended-plugins.php';

/**
 * Add theme compatibility function for woocommerce if active
*/
if( jobscout_is_woocommerce_activated() ){
    require get_template_directory() . '/inc/woocommerce-functions.php';    
}

/**
 * Modify filter hooks of WP Job Manager plugin.
 */
if( jobscout_is_wp_job_manager_activated() ) :
	require get_template_directory() . '/inc/wp-job-manager-filters.php';
endif;

/**
 * Nhom C Custom Helper Functions.
 */
require get_template_directory() . '/inc/nhomc-helpers.php';
require get_template_directory() . '/inc/nhomc-newsletter.php';

/** Use the same header on standard WordPress pages and the custom page designs. */
function jobscout_nhomc_header() {
    get_template_part( 'template-parts/nhomc-header' );
}
remove_action( 'jobscout_before_header', 'jobscout_responsive_header', 15 );
remove_action( 'jobscout_header', 'jobscout_header', 20 );
add_action( 'jobscout_header', 'jobscout_nhomc_header', 20 );

remove_action( 'jobscout_footer', 'jobscout_footer_start', 20 );
remove_action( 'jobscout_footer', 'jobscout_footer_top', 30 );
remove_action( 'jobscout_footer', 'jobscout_footer_bottom', 40 );
remove_action( 'jobscout_footer', 'jobscout_footer_end', 50 );

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'nhomc-header-font', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&display=swap', array(), null );
    wp_enqueue_style( 'nhomc-header', get_template_directory_uri() . '/css/nhomc-header.css', array(), filemtime( get_template_directory() . '/css/nhomc-header.css' ) );
    wp_enqueue_style( 'nhomc-newsletter', get_template_directory_uri() . '/css/nhomc-newsletter.css', array(), filemtime( get_template_directory() . '/css/nhomc-newsletter.css' ) );
    wp_enqueue_style( 'nhomc-footer', get_template_directory_uri() . '/css/nhomc-footer.css', array(), filemtime( get_template_directory() . '/css/nhomc-footer.css' ) );
} );

/**
 * -----------------------------------------------------------------------------
 * NHÓM C - XUÂN HÒA: ĐIỀU HƯỚNG TỰ ĐỘNG CHO TRANG CHI TIẾT TIN TỨC (6-NEWS DETAIL)
 * Đảm bảo 100% mọi thành viên, thầy cô và máy tính khác đều xem được tin tức
 * Tuyệt đối không bao giờ bị rơi vào trang 404 (Uh - oh...)
 * -----------------------------------------------------------------------------
 */

// 1. Tự động chuyển hướng tải file template-news-detail.php khi có yêu cầu xem bài viết
add_filter( 'template_include', function( $template ) {
    $req_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
    $uri_path = parse_url( $req_uri, PHP_URL_PATH );
    $uri_path = trim( (string) $uri_path, '/' );

    $is_news_detail = false;

    if ( is_page( array( 'news-detail', 'newsdetail' ) ) ) {
        $is_news_detail = true;
    } elseif ( preg_match( '#(^|/)(news-detail|newsdetail)(/|$)#i', $uri_path ) ) {
        $is_news_detail = true;
    } elseif ( isset( $_GET['post'] ) && ! empty( $_GET['post'] ) && ( is_404() || is_page( 'news' ) || is_home() ) ) {
        $is_news_detail = true;
    } elseif ( is_404() && ( stripos( $req_uri, 'news-detail' ) !== false || stripos( $req_uri, 'newsdetail' ) !== false ) ) {
        $is_news_detail = true;
    }

    if ( $is_news_detail ) {
        global $wp_query;
        if ( is_object( $wp_query ) ) {
            $wp_query->is_404  = false;
            $wp_query->is_page = true;
        }
        status_header( 200 );
        $detail_template = get_template_directory() . '/template-news-detail.php';
        if ( file_exists( $detail_template ) ) {
            return $detail_template;
        }
    }

    return $template;
}, 99 );

// 2. Tự động khởi tạo trang 'news-detail' trong CSDL nếu trên máy mới chưa có
add_action( 'init', function() {
    $detail_page = get_page_by_path( 'news-detail' );
    if ( ! $detail_page ) {
        $page_id = wp_insert_post( array(
            'post_title'     => 'News Detail',
            'post_name'      => 'news-detail',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => '',
            'comment_status' => 'closed',
            'ping_status'    => 'closed',
        ) );
        if ( $page_id && ! is_wp_error( $page_id ) ) {
            update_post_meta( $page_id, '_wp_page_template', 'template-news-detail.php' );
        }
    } else {
        $tpl = get_post_meta( $detail_page->ID, '_wp_page_template', true );
        if ( empty( $tpl ) || $tpl === 'default' ) {
            update_post_meta( $detail_page->ID, '_wp_page_template', 'template-news-detail.php' );
        }
    }
} );

