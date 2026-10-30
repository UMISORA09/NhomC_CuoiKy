<?php
defined( 'ABSPATH' ) || exit;
$args['widget_title'] = $args['widget_title'] ?? '';
extract( $args, EXTR_SKIP );
?>
<!-- 3. ALL JOBS MAIN CONTENT -->
<main class="aj-main-content">
    <div class="aj-container">
        <!-- Section Header -->
        <div class="aj-section-header">
            <h2 class="aj-section-title"><?php echo esc_html( $widget_title ?: 'ALL JOBS' ); ?></h2>
        <?php if ( $widget_description !== '' ) : ?><div class="nc-widget-description"><?php echo wpautop( esc_html( $widget_description ) ); ?></div><?php endif; ?>
            <div class="aj-sort-wrapper">
                <select class="aj-sort-select" id="jobSortSelect">
                    <option value="latest">Latest Jobs</option>
                    <option value="oldest">Oldest Jobs</option>
                    <option value="alpha">A to Z</option>
                </select>
                <i class="fa-solid fa-chevron-down aj-sort-icon"></i>
            </div>
        </div>

        <!-- 4. JOBS GRID (12 CARDS CO GIÃN TỰ ĐỘNG CHỐNG VỠ LAYOUT) -->
        <div class="aj-jobs-grid" id="jobsGrid">
            <?php
            // Định nghĩa 6 biểu tượng logo sắc nét
            $preset_brands = array(
                array(
                    'icon' => 'fa-solid fa-hotel',
                    'name' => 'THE SODOH',
                    'sub' => 'KYOTO',
                    'default_title' => 'HOTEL MANAGER',
                    'date' => 'Oct 20, 2022'
                ),
                array(
                    'icon' => 'fa-solid fa-tree',
                    'name' => 'FORTUNE',
                    'sub' => 'GARDEN',
                    'default_title' => 'GENERAL MANAGER - LEADING HOTEL CHAIN',
                    'date' => 'Oct 28, 2022'
                ),
                array(
                    'icon' => 'fa-solid fa-champagne-glasses',
                    'name' => 'BANQUET',
                    'sub' => 'EVENTS',
                    'default_title' => 'BANQUET MANAGER',
                    'date' => 'Oct 20, 2022'
                ),
                array(
                    'icon' => 'fa-solid fa-bell-concierge',
                    'name' => 'SEVEN',
                    'sub' => 'HOUSE',
                    'default_title' => 'BELLMAN',
                    'date' => 'Oct 28, 2022'
                ),
                array(
                    'icon' => 'fa-solid fa-utensils',
                    'name' => 'PHO THIN',
                    'sub' => 'TOKYO',
                    'default_title' => 'CHIEF OPERATING OFFICER HOTEL/ RESORT CHAIN',
                    'date' => 'Oct 20, 2022'
                ),
                array(
                    'icon' => 'fa-solid fa-compass',
                    'name' => 'STAND',
                    'sub' => 'GLOBAL',
                    'default_title' => 'LOSS PREVENTION OFFICER',
                    'date' => 'Oct 28, 2022'
                )
            );

            // Tạo danh sách card từ database seeder (mặc định hiện 12 card, Load More sẽ mở thêm)
            $total_display = max(count($db_jobs), 12);
            for ($i = 0; $i < $total_display; $i++) {
                $brand = $preset_brands[$i % 6];

                $title    = $brand['default_title'];
                $date     = $brand['date'];
                $type     = 'Fulltime';
                $category = 'Category Name';
                $location = 'Ho Chi Minh City';
                $link     = home_url('/job-detail/?job_id=19');

                // Lấy thông tin từ database nếu có
                if (isset($db_jobs[$i])) {
                    $title    = $db_jobs[$i]['title'];
                    $location = $db_jobs[$i]['location'];
                    $link     = $db_jobs[$i]['link'];
                    if (!empty($db_jobs[$i]['date']))     $date = $db_jobs[$i]['date'];
                    if (!empty($db_jobs[$i]['type']))     $type = $db_jobs[$i]['type'];
                    if (!empty($db_jobs[$i]['category'])) $category = $db_jobs[$i]['category'];
                    if (!empty($db_jobs[$i]['company'])) {
                        $brand['name'] = $db_jobs[$i]['company'];
                        $brand['sub']  = '';
                    }
                }

                $hidden_class = ($i >= 12) ? ' aj-card-hidden' : '';
            ?>
                <article class="aj-job-card<?php echo $hidden_class; ?>" data-title="<?php echo esc_attr($title); ?>" data-idx="<?php echo $i; ?>" onclick="window.location.href='<?php echo esc_url($link); ?>';" role="link" tabindex="0" onkeydown="if(event.key==='Enter') window.location.href='<?php echo esc_url($link); ?>';">
                    <div class="aj-card-logo-box">
                        <?php if ( $widget_image ) : ?><img class="nc-widget-image" src="<?php echo esc_url( $widget_image ); ?>" alt="<?php echo esc_attr( $brand['name'] ); ?>"><?php else : ?><i class="<?php echo esc_attr($brand['icon']); ?> aj-logo-vector-icon"></i><?php endif; ?>
                        <span class="aj-logo-vector-name"><?php echo esc_html($brand['name']); ?></span>
                        <span style="font-size: 8px; color: #888; letter-spacing: 0.5px;"><?php echo esc_html($brand['sub']); ?></span>
                    </div>

                    <div class="aj-card-body">
                        <h3 class="aj-card-title">
                            <a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a>
                        </h3>
                        <p class="aj-card-date">Created: <?php echo esc_html($date); ?></p>
                        <div class="aj-card-tags">
                            <span class="aj-tag-pill"><?php echo esc_html($type); ?></span>
                            <span class="aj-tag-sep">|</span>
                            <span class="aj-tag-pill"><?php echo esc_html($category); ?></span>
                            <span class="aj-tag-sep">|</span>
                            <span class="aj-tag-pill"><?php echo esc_html($location); ?></span>
                        </div>
                        <ul class="aj-card-perks">
                            <li>Be responsible for the effective operational management of the hotel</li>
                            <li>Excellent salary bonuses &amp; recognition activities</li>
                            <li>Foreign language allowance (up to 500USD/month)</li>
                        </ul>
                    </div>
                </article>
            <?php } ?>
        </div>

        <!-- 5. LOAD MORE BUTTON -->
        <div class="aj-load-more-wrap">
            <button class="aj-btn-loadmore" id="btnLoadMore">LOAD MORE JOBS</button>
        </div>
    </div>
</main>
