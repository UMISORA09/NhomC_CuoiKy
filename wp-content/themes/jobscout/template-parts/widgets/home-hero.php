<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
<!-- 2. HERO BANNER & SEARCH BAR -->
<section class="hm-hero" style="background-image: url('<?php echo esc_url( $hero_bg ); ?>');">
    <div class="hm-hero-overlay"></div>
    <div class="hm-container">
        <div class="hm-hero-content">
            <h1 class="hm-hero-title">FIND YOUR DREAM JOBS</h1>
            <p class="hm-hero-subtitle">
                The secret behind our company is simple: to always put ourselves in the other person's shoes-employee, guest or customer. This allows us to see the world through their eyes, anticipate their needs and better understand their feelings.
            </p>
            <form class="hm-search-form" action="<?php echo esc_url( home_url( '/jobs/' ) ); ?>" method="get">
                <div class="hm-search-input-box">
                    <svg class="hm-icon-search" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#eb6723" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" name="search_keywords" placeholder="Search for jobs, companies, skills" autocomplete="off">
                </div>
                <div class="hm-search-location-box">
                    <svg class="hm-icon-location" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#eb6723" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <select name="search_location">
                        <option value="">Tokyo</option>
                        <option value="Ho Chi Minh City">Ho Chi Minh City</option>
                        <option value="Ha Noi">Ha Noi</option>
                        <option value="Da Nang">Da Nang</option>
                    </select>
                    <svg class="hm-icon-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
                <button type="submit" class="hm-search-submit-btn">SEARCH JOB</button>
            </form>
        </div>
    </div>
</section>
