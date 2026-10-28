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
<?php nhomc_render_page_widgets( 'nhomc-job-detail', compact( 'current_job_id', 'company_name', 'badges', 'staff_rating', 'photo_url' ) ); ?>
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
