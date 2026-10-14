<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {
    register_post_type( 'nhomc_subscriber', array(
        'labels' => array( 'name' => 'Newsletter', 'singular_name' => 'Email đăng ký' ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'tools.php',
        'supports' => array( 'title' ),
        'capabilities' => array_fill_keys( array(
            'edit_post', 'read_post', 'delete_post', 'edit_posts', 'edit_others_posts',
            'publish_posts', 'read_private_posts', 'delete_posts', 'delete_private_posts',
            'delete_published_posts', 'delete_others_posts', 'edit_private_posts',
            'edit_published_posts', 'create_posts',
        ), 'manage_options' ),
        'map_meta_cap' => false,
    ) );
} );

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
                    'post_type' => 'nhomc_subscriber',
                    'post_status' => 'private',
                    'post_title' => sanitize_email( $email ),
                    'post_name' => $slug,
                ), true );
                $status = is_wp_error( $result ) || ! $result ? 'error' : 'success';
            }
        }
    }
    wp_safe_redirect( add_query_arg( 'newsletter', $status, home_url( '/about-us/' ) ) . '#newsletter-title', 303 );
    exit;
}
add_action( 'admin_post_nhomc_newsletter', 'nhomc_newsletter_subscribe' );
add_action( 'admin_post_nopriv_nhomc_newsletter', 'nhomc_newsletter_subscribe' );
