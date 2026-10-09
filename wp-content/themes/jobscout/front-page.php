<?php
/**
 * Front Page
 * 
 * @package JobScout
 */

// Ưu tiên hiển thị Template Home Design chuẩn đồ án Nhóm C theo 1-home.png
if ( file_exists( get_template_directory() . '/template-home.php' ) ) {
    include get_template_directory() . '/template-home.php';
    return;
}

$home_sections = jobscout_get_home_sections();

if ( 'posts' == get_option( 'show_on_front' ) ) { //Show Static Blog Page
    include( get_home_template() );
}elseif( $home_sections ){ 
    get_header();
    //If any one section are enabled then show custom home page.
    foreach( $home_sections as $section ){
        get_template_part( 'sections/' . esc_attr( $section ) );  
    }
    get_footer();
}else {
    //If all section are disabled then show respective page template. 
    include( get_page_template() );
}