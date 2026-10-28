<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
    <section class="ab-intro" aria-labelledby="about-us-title">
        <div class="ab-container">
            <h2 id="about-us-title">ABOUT US</h2>
            <div class="ab-grid">
                <img src="<?php echo esc_url( $theme_uri . '/images/about/torii.jpg' ); ?>" alt="A red torii gate standing in the water in Japan" width="480" height="400">
                <div class="ab-values">
                    <h3>Our Vision</h3>
                    <p>Create hotels and restaurants around the world that offer memorable experiences while building a lasting, positive relationship together with our guests, partners, team members and communities.</p>
                    <h3>Ours Mission</h3>
                    <p>Share “Omotenashi” with the world</p>
                    <h3>Our Core Value</h3>
                    <p>“If I were the guest…”<br>To provide guests with the hospitality you would want to receive as a guest.</p>
                </div>
            </div>
        </div>
    </section>
