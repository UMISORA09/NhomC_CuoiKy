<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
    <section class="ab-company" aria-label="Company information">
        <div class="ab-container ab-grid">
            <dl>
                <dt>Established since</dt><dd>April 1993</dd>
                <dt>Head Office</dt><dd>Marunouchi 2-1-1, Chiyoda, Tokyo</dd>
                <dt>Capital</dt><dd>100,000,000 JPY</dd>
                <dt>CEO</dt><dd>Yutaka Noda</dd>
                <dt>Number of Employees</dt><dd>Full time: 830 / Total: 1,600</dd>
            </dl>
            <img src="<?php echo esc_url( $theme_uri . '/images/about/tokyo.jpg' ); ?>" alt="Tokyo Tower at sunset reflected in the street" width="480" height="400" loading="lazy">
        </div>
    </section>
