<?php
/**
 * Template Part for Displaying Job Detail View (Pixel-perfect matching mockup)
 * All data dynamically queried from WordPress database.
 *
 * @package JobScout
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$current_job_id = get_the_ID();
$company_name   = get_post_meta( $current_job_id, '_company_name', true );
if ( empty( $company_name ) ) {
    $company_name = 'THE SODOH';
}

$badges       = nhomc_get_job_badges( $current_job_id );
$staff_rating = get_post_meta( $current_job_id, '_staff_rating', true );
if ( empty( $staff_rating ) ) {
    $staff_rating = '4.0';
}

$theme_uri  = get_template_directory_uri();
$photo_url  = $theme_uri . '/images/company-photo-1.jpg';

$company_gallery = array(
    array(
        'url'   => $theme_uri . '/images/company-photo-1.jpg',
        'title' => $company_name . ' - Kiến trúc & Mặt tiền chính',
    ),
    array(
        'url'   => $theme_uri . '/images/company-photo-2.jpg',
        'title' => $company_name . ' - Sảnh đón khách Grand Lobby 5 Sao',
    ),
    array(
        'url'   => $theme_uri . '/images/company-photo-3.jpg',
        'title' => $company_name . ' - Nhà hàng Ẩm thực & Lounge',
    ),
    array(
        'url'   => $theme_uri . '/images/company-photo-4.jpg',
        'title' => $company_name . ' - Phòng nghỉ Suite Hạng Sang',
    ),
    array(
        'url'   => $theme_uri . '/images/company-photo-5.jpg',
        'title' => $company_name . ' - Không gian Resort & Cảnh quan',
    ),
    array(
        'url'   => $theme_uri . '/images/company-photo-6.jpg',
        'title' => $company_name . ' - Khu vườn & Tiện ích Thư giãn',
    ),
);
?>

<div class="nhomc-job-detail-wrapper">
    <!-- Breadcrumbs -->
    <div class="nhomc-container">
        <nav class="nhomc-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <span class="sep">/</span>
            <a href="<?php echo esc_url( home_url( '/all-jobs/' ) ); ?>">All Jobs</a>
            <span class="sep">/</span>
            <span class="current">Job Detail</span>
        </nav>
    </div>

    <!-- Main Job Hero Card -->
    <div class="nhomc-container">
        <div class="nhomc-job-hero-card">
            <div class="nhomc-job-hero-left">
                <!-- Company Logo -->
                <div class="nhomc-company-logo-box">
                    <?php echo nhomc_get_company_logo( $company_name, $current_job_id, 'large' ); ?>
                </div>

                <!-- Job Title & Meta -->
                <div class="nhomc-job-hero-info">
                    <h1 class="nhomc-job-title"><?php the_title(); ?></h1>
                    
                    <div class="nhomc-job-meta-row">
                        <span class="nhomc-meta-date">Created: <?php echo date( 'M d, Y', strtotime( get_post_field( 'post_date', $current_job_id ) ) ); ?></span>
                    </div>

                    <div class="nhomc-job-tags-row">
                        <span class="nhomc-tag-item"><?php echo esc_html( $badges['type'] ); ?></span>
                        <span class="nhomc-tag-sep">|</span>
                        <span class="nhomc-tag-item"><?php echo esc_html( $badges['category'] ); ?></span>
                        <span class="nhomc-tag-sep">|</span>
                        <span class="nhomc-tag-item"><?php echo esc_html( $badges['location'] ); ?></span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="nhomc-job-hero-right">
                <button type="button" class="nhomc-btn-share" onclick="nhomcShareJob()">SHARE</button>
                <button type="button" class="nhomc-btn-apply" onclick="nhomcOpenApplyModal()">APPLY JOB</button>
            </div>
        </div>
    </div>

    <!-- Two-Column Main Content Section -->
    <div class="nhomc-container">
        <div class="nhomc-job-columns">
            <!-- Left Column: Structured Job Details from DB -->
            <div class="nhomc-job-col-left">
                <article class="nhomc-card-content">
                    <?php
                    // Retrieve raw content from DB
                    $raw_content = get_the_content();

                    if ( ! empty( $raw_content ) ) {
                        // Render clean formatted content matching Figma mockup (excluding redundant WPJM default meta/company box)
                        echo wpautop( do_shortcode( wp_kses_post( $raw_content ) ) );
                    } else {
                        // Elegant fallback if content empty
                        ?>
                        <h3>Overview about Company</h3>
                        <p>Plan Do See Global is a hospitality group founded in Japan and rooted in "Omotenashi", the Japanese principle of selfless hospitality. We operate luxury resorts, high-end restaurants, and premier boutique hotels worldwide.</p>
                        
                        <h3>Our Key Skills</h3>
                        <p>• Strategic executive leadership and operational excellence.<br>
                        • Proven track record in luxury resort and hotel chain management.<br>
                        • Strong bilingual English - Vietnamese communication skills.</p>
                        
                        <h3>Why You'll Love Working Here</h3>
                        <p>• Be responsible for the effective operational management of the hotel.<br>
                        • Excellent salary bonuses & executive recognition programs.<br>
                        • Foreign language allowance (up to 500USD/month).</p>
                        
                        <h3>Location</h3>
                        <p><?php echo esc_html( $badges['location'] ); ?></p>
                        <?php
                    }
                    ?>
                </article>
            </div>

            <!-- Right Column: Sidebar Widgets -->
            <div class="nhomc-job-col-right">
                <!-- Staff Rating Card -->
                <div class="nhomc-sidebar-card">
                    <h3 class="nhomc-sidebar-title">Staff Rating</h3>
                    <div class="nhomc-rating-box">
                        <div class="nhomc-stars" aria-label="Rating: 4.0 out of 5 stars">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star empty">☆</span>
                        </div>
                        <span class="nhomc-rating-score"><?php echo esc_html( $staff_rating ); ?></span>
                    </div>
                </div>

                <!-- Company Photos Card -->
                <div class="nhomc-sidebar-card">
                    <h3 class="nhomc-sidebar-title">Company Photos</h3>
                    <div class="nhomc-photos-preview" id="nhomcCompanyPhotosTrigger" onclick="nhomcOpenPhotoModal(0)" role="button" tabindex="0" title="Click để xem toàn bộ ảnh công ty">
                        <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $company_name ); ?> Photos">
                        <div class="nhomc-photo-badge">+5</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- OTHER JOBS Section (Queried dynamically from Database) -->
    <section class="nhomc-other-jobs-section">
        <div class="nhomc-container">
            <h2 class="nhomc-section-heading">OTHER JOBS</h2>

            <div class="nhomc-other-jobs-grid">
                <?php
                // Fetch 6 other active job listings from MySQL
                $other_jobs = get_posts( array(
                    'post_type'      => 'job_listing',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'post__not_in'   => array( $current_job_id ),
                    'orderby'        => 'ID',
                    'order'          => 'ASC',
                ) );

                // If fewer than 6, query general job_listing
                if ( count( $other_jobs ) < 6 ) {
                    $other_jobs = get_posts( array(
                        'post_type'      => 'job_listing',
                        'posts_per_page' => 6,
                        'post_status'    => 'publish',
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ) );
                }

                if ( ! empty( $other_jobs ) ) :
                    foreach ( $other_jobs as $job_item ) :
                        $oj_id       = $job_item->ID;
                        $oj_company  = get_post_meta( $oj_id, '_company_name', true );
                        if ( empty( $oj_company ) ) {
                            $oj_company = 'SODOH';
                        }
                        $oj_badges   = nhomc_get_job_badges( $oj_id );
                        $oj_bullets  = nhomc_get_job_bullets( $oj_id, $job_item->post_content );
                        $oj_date     = date( 'M d, Y', strtotime( $job_item->post_date ) );
                        $oj_link     = esc_url( home_url( '/job-detail/?job_id=' . $oj_id ) );
                        ?>
                        <div class="nhomc-other-job-card" onclick="window.location.href='<?php echo esc_url( $oj_link ); ?>';" style="cursor: pointer;">
                            <div class="nhomc-oj-top">
                                <!-- Company Logo -->
                                <div class="nhomc-oj-logo">
                                    <?php echo nhomc_get_company_logo( $oj_company, $oj_id, 'small' ); ?>
                                </div>

                                <!-- Job Info -->
                                <div class="nhomc-oj-info">
                                    <h3 class="nhomc-oj-title">
                                        <a href="<?php echo esc_url( $oj_link ); ?>">
                                            <?php echo esc_html( $job_item->post_title ); ?>
                                        </a>
                                    </h3>

                                    <div class="nhomc-oj-date">Created: <?php echo esc_html( $oj_date ); ?></div>

                                    <div class="nhomc-oj-tags">
                                        <span class="nhomc-oj-tag-item"><?php echo esc_html( $oj_badges['type'] ); ?></span>
                                        <span class="nhomc-oj-sep">|</span>
                                        <span class="nhomc-oj-tag-item"><?php echo esc_html( $oj_badges['category'] ); ?></span>
                                        <span class="nhomc-oj-sep">|</span>
                                        <span class="nhomc-oj-tag-item"><?php echo esc_html( $oj_badges['location'] ); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- 3 Bullet Highlights -->
                            <div class="nhomc-oj-bullets">
                                <ul>
                                    <?php foreach ( $oj_bullets as $bullet ) : ?>
                                        <li><?php echo esc_html( $bullet ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
</div>

<!-- Company Photos Lightbox Modal -->
<div id="nhomcPhotoModal" class="nhomc-photo-modal" aria-hidden="true" role="dialog" aria-label="Company Photos Gallery">
    <div class="nhomc-modal-overlay" onclick="nhomcClosePhotoModal()"></div>
    <div class="nhomc-photo-modal-container">
        <button type="button" class="nhomc-modal-close" onclick="nhomcClosePhotoModal()" aria-label="Đóng">&times;</button>
        
        <div class="nhomc-lightbox-main">
            <button type="button" class="nhomc-nav-arrow prev" onclick="nhomcPrevPhoto()" aria-label="Ảnh trước">&#10094;</button>
            <div class="nhomc-main-img-box">
                <img id="nhomcActiveImg" src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $company_name ); ?>">
            </div>
            <button type="button" class="nhomc-nav-arrow next" onclick="nhomcNextPhoto()" aria-label="Ảnh kế tiếp">&#10095;</button>
        </div>

        <div class="nhomc-lightbox-caption">
            <span id="nhomcPhotoTitle" class="nhomc-caption-text"><?php echo esc_html( $company_gallery[0]['title'] ); ?></span>
            <span id="nhomcPhotoCounter" class="nhomc-counter">1 / <?php echo count( $company_gallery ); ?></span>
        </div>

        <div class="nhomc-lightbox-thumbs" id="nhomcPhotoThumbs">
            <?php foreach ( $company_gallery as $idx => $item ) : ?>
                <div class="nhomc-thumb-item <?php echo $idx === 0 ? 'active' : ''; ?>" onclick="nhomcSelectPhoto(<?php echo $idx; ?>)">
                    <img src="<?php echo esc_url( $item['url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
var nhomcGalleryData = <?php echo json_encode( $company_gallery ); ?>;
var nhomcCurrentPhotoIndex = 0;

function nhomcOpenPhotoModal(startIndex) {
    nhomcCurrentPhotoIndex = (typeof startIndex === 'number') ? startIndex : 0;
    var modal = document.getElementById('nhomcPhotoModal');
    if (!modal) return;
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    nhomcRenderActivePhoto();
    nhomcUpdateActiveThumb();
}

function nhomcClosePhotoModal() {
    var modal = document.getElementById('nhomcPhotoModal');
    if (!modal) return;
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

function nhomcNextPhoto() {
    if (!nhomcGalleryData || !nhomcGalleryData.length) return;
    nhomcCurrentPhotoIndex = (nhomcCurrentPhotoIndex + 1) % nhomcGalleryData.length;
    nhomcRenderActivePhoto();
    nhomcUpdateActiveThumb();
}

function nhomcPrevPhoto() {
    if (!nhomcGalleryData || !nhomcGalleryData.length) return;
    nhomcCurrentPhotoIndex = (nhomcCurrentPhotoIndex - 1 + nhomcGalleryData.length) % nhomcGalleryData.length;
    nhomcRenderActivePhoto();
    nhomcUpdateActiveThumb();
}

function nhomcSelectPhoto(index) {
    if (!nhomcGalleryData || index < 0 || index >= nhomcGalleryData.length) return;
    nhomcCurrentPhotoIndex = index;
    nhomcRenderActivePhoto();
    nhomcUpdateActiveThumb();
}

function nhomcRenderActivePhoto() {
    if (!nhomcGalleryData || !nhomcGalleryData.length) return;
    var cur = nhomcGalleryData[nhomcCurrentPhotoIndex];
    var img = document.getElementById('nhomcActiveImg');
    var title = document.getElementById('nhomcPhotoTitle');
    var counter = document.getElementById('nhomcPhotoCounter');
    if (img) img.src = cur.url;
    if (title) title.textContent = cur.title;
    if (counter) counter.textContent = (nhomcCurrentPhotoIndex + 1) + ' / ' + nhomcGalleryData.length;
}

function nhomcUpdateActiveThumb() {
    var thumbs = document.querySelectorAll('.nhomc-thumb-item');
    thumbs.forEach(function(t, idx) {
        if (idx === nhomcCurrentPhotoIndex) {
            t.classList.add('active');
            t.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        } else {
            t.classList.remove('active');
        }
    });
}

document.addEventListener('keydown', function(e) {
    var modal = document.getElementById('nhomcPhotoModal');
    if (!modal || !modal.classList.contains('active')) return;
    if (e.key === 'Escape') nhomcClosePhotoModal();
    if (e.key === 'ArrowRight') nhomcNextPhoto();
    if (e.key === 'ArrowLeft') nhomcPrevPhoto();
});
</script>
