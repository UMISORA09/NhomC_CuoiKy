<?php
/**
 * Template Name: Job Detail Page (NhomC Design)
 *
 * @package JobScout
 */

get_header( 'jobdetail' );

$target_job_id = isset( $_GET['job_id'] ) ? intval( $_GET['job_id'] ) : 19;
$job_post = get_post( $target_job_id );

if ( ! $job_post || $job_post->post_type !== 'job_listing' ) {
    // If post 19 not found, grab the first job_listing
    $fallback_jobs = get_posts( array(
        'post_type'      => 'job_listing',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ) );
    if ( ! empty( $fallback_jobs ) ) {
        $job_post = $fallback_jobs[0];
    }
}

if ( $job_post ) {
    global $post;
    $post = $job_post;
    setup_postdata( $post );

    get_template_part( 'template-parts/content', 'jobdetail-view' );
}

get_footer( 'jobdetail' );

if ( $job_post ) {
    wp_reset_postdata();
}

