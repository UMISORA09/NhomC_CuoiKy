<?php
/**
 * The template for displaying all single job posts.
 * NhomC Pixel-Perfect Mockup Match.
 *
 * @package JobScout
 */

get_header( 'jobdetail' );

while ( have_posts() ) : the_post();
    get_template_part( 'template-parts/content', 'jobdetail-view' );
endwhile;

get_footer( 'jobdetail' );