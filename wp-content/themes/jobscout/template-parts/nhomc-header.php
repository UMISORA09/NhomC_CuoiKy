<?php
/** Shared navigation for the Nhom C page designs and standard WordPress pages. */
defined( 'ABSPATH' ) || exit;
$items = array(
    array( 'HOME', '/', is_front_page() || is_page( 'home' ) ),
    array( 'JOBS', '/jobs/', is_page( array( 'jobs', 'all-jobs', 'job-detail', 'jobdetail' ) ) || is_singular( 'job_listing' ) ),
    array( 'NEWS', '/blog/', is_home() || is_page( array( 'blog', 'news', 'news-detail' ) ) || is_singular( 'post' ) ),
    array( 'ABOUT', '/about-us/', is_page( 'about-us' ) ),
    array( 'CONTACT', '/contact-us/', is_page( array( 'contact', 'contact-us' ) ) ),
);
?>
<header class="nc-header">
    <div class="nc-header-inner">
        <a class="nc-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><strong>NHOM C</strong><small>RECRUITING</small></a>
        <nav aria-label="Main navigation">
            <ul class="nc-nav">
                <?php foreach ( $items as $item ) : ?>
                    <li><a href="<?php echo esc_url( home_url( $item[1] ) ); ?>"<?php if ( $item[2] ) echo ' aria-current="page"'; ?>><?php echo esc_html( $item[0] ); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <a class="nc-submit" href="<?php echo esc_url( home_url( '/post-a-job/' ) ); ?>">SUBMIT JOB</a>
        <details class="nc-mobile-menu">
            <summary aria-label="Navigation menu"><span aria-hidden="true">☰</span></summary>
            <nav aria-label="Mobile navigation">
                <ul>
                    <?php foreach ( $items as $item ) : ?>
                        <li><a href="<?php echo esc_url( home_url( $item[1] ) ); ?>"<?php if ( $item[2] ) echo ' aria-current="page"'; ?>><?php echo esc_html( $item[0] ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <a class="nc-submit" href="<?php echo esc_url( home_url( '/post-a-job/' ) ); ?>">SUBMIT JOB</a>
            </nav>
        </details>
    </div>
</header>
