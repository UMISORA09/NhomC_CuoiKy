<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package JobScout
 */

// BẢO VỆ CHỐNG LỖI 404 CHO CHỨC NĂNG 6-NEWS DETAIL (XUÂN HÒA):
// Bất kể ai truy cập đường dẫn có chứa news-detail, newsdetail hoặc query post tin tức
// hệ thống sẽ tự động hiển thị giao diện Chi tiết tin tức (template-news-detail.php), không hiển thị Uh - oh...
$req_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
if (stripos($req_uri, 'news-detail') !== false || stripos($req_uri, 'newsdetail') !== false || !empty($_GET['post'])) {
    status_header(200);
    global $wp_query;
    if (is_object($wp_query)) {
        $wp_query->is_404 = false;
        $wp_query->is_page = true;
    }
    $detail_tpl = get_template_directory() . '/template-news-detail.php';
    if (file_exists($detail_tpl)) {
        require_once $detail_tpl;
        exit;
    }
}

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Uh - oh...', 'jobscout' ); ?></h1>
				</header><!-- .page-header -->
				<div class="page-content">
					<p class="error-text"><?php esc_html_e( 'The page you are looking for may have been moved, deleted, or possibly never existed.', 'jobscout' ); ?></p>
					<div class="error-num"><?php esc_html_e( '404','jobscout' ); ?></div>
					<a class="btn-readmore" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Take me to the home page', 'jobscout' ); ?></a>
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
