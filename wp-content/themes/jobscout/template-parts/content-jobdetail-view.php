<?php
/**
 * ============================================================================
 * TEMPLATE PART: CHI TIẾT VIỆC LÀM (JOB DETAIL VIEW)
 * Khớp chuẩn thiết kế Figma: 5-job detail.png
 * Toàn bộ dữ liệu được truy vấn động từ WordPress Database (MySQL)
 *
 * DANH SÁCH CHỨC NĂNG CHÍNH:
 * 1. Khởi tạo dữ liệu công việc, công ty, phân loại & thư viện ảnh.
 * 2. Nạp hệ thống Widgets động Nhóm C (Job Hero, Job Main, Other Jobs).
 * 3. Lightbox Modal Gallery: Xem ảnh công ty phóng to, có điều hướng chuyển ảnh & phím tắt.
 *
 * @package JobScout
 * ============================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Chặn truy cập trực tiếp vào file vì lý do bảo mật
}

// -----------------------------------------------------------------------------
// 1. KHỞI TẠO DỮ LIỆU CÔNG VIỆC TỪ DATABASE (POST META & TAXONOMY)
// -----------------------------------------------------------------------------

// Lấy ID của bài đăng việc làm hiện tại
$current_job_id = get_the_ID();

// Truy vấn tên công ty từ post meta '_company_name', nếu trống lấy mặc định 'THE SODOH'
$company_name   = get_post_meta( $current_job_id, '_company_name', true );
if ( empty( $company_name ) ) {
    $company_name = 'THE SODOH';
}

// Lấy thông tin các huy hiệu phân loại: Loại hình (Full time), Ngành nghề, Địa điểm làm việc
$badges       = nhomc_get_job_badges( $current_job_id );

// Lấy điểm số đánh giá nhân viên (Staff Rating) từ post meta '_staff_rating'
$staff_rating = get_post_meta( $current_job_id, '_staff_rating', true );
if ( empty( $staff_rating ) ) {
    $staff_rating = '4.0';
}

// Đường dẫn thư mục giao diện để tải ảnh minh họa công ty
$theme_uri  = get_template_directory_uri();
$photo_url  = $theme_uri . '/images/company-photo-1.jpg';

// Danh sách thư viện ảnh đại diện của doanh nghiệp (dùng cho Lightbox Modal)
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
$gallery_settings = nhomc_active_widget_settings( 'nhomc-job-detail', 'nhomc_job_main' );
foreach ( $company_gallery as $index => &$photo ) {
    if ( ! empty( $gallery_settings[ 'image_' . ( $index + 1 ) ] ) ) {
        $photo['url'] = $gallery_settings[ 'image_' . ( $index + 1 ) ];
    }
}
unset( $photo );
$photo_url = $company_gallery[0]['url'];
?>

<div class="nhomc-job-detail-wrapper">
    <!-- Nạp toàn bộ các widget động thuộc vùng 'nhomc-job-detail' (Job Hero, Job Main, Other Jobs) -->
    <?php nhomc_render_page_widgets( 'nhomc-job-detail', compact( 'current_job_id', 'company_name', 'badges', 'staff_rating', 'photo_url' ) ); ?>
</div>

<!-- =========================================================================
     2. CỬA SỔ PHÓNG TO ẢNH DOANH NGHIỆP (COMPANY PHOTOS LIGHTBOX MODAL)
     ========================================================================= -->
<div id="nhomcPhotoModal" class="nhomc-photo-modal" aria-hidden="true" role="dialog" aria-label="Company Photos Gallery">
    <!-- Lớp nền mờ overlay: Nhấp chuột ra ngoài để đóng modal -->
    <div class="nhomc-modal-overlay" onclick="nhomcClosePhotoModal()"></div>
    
    <div class="nhomc-photo-modal-container">
        <!-- Nút đóng dấu X -->
        <button type="button" class="nhomc-modal-close" onclick="nhomcClosePhotoModal()" aria-label="Đóng">&times;</button>
        
        <!-- Khung hiển thị ảnh lớn kèm 2 nút mũi tên điều hướng Previous/Next -->
        <div class="nhomc-lightbox-main">
            <button type="button" class="nhomc-nav-arrow prev" onclick="nhomcPrevPhoto()" aria-label="Ảnh trước">&#10094;</button>
            <div class="nhomc-main-img-box">
                <img id="nhomcActiveImg" src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $company_name ); ?>">
            </div>
            <button type="button" class="nhomc-nav-arrow next" onclick="nhomcNextPhoto()" aria-label="Ảnh kế tiếp">&#10095;</button>
        </div>

        <!-- Chú thích tiêu đề bức ảnh và bộ đếm chỉ mục (VD: 1 / 6) -->
        <div class="nhomc-lightbox-caption">
            <span id="nhomcPhotoTitle" class="nhomc-caption-text"><?php echo esc_html( $company_gallery[0]['title'] ); ?></span>
            <span id="nhomcPhotoCounter" class="nhomc-counter">1 / <?php echo count( $company_gallery ); ?></span>
        </div>

        <!-- Dải ảnh thu nhỏ (Thumbnails) phía dưới để chọn nhanh bức ảnh cần xem -->
        <div class="nhomc-lightbox-thumbs" id="nhomcPhotoThumbs">
            <?php foreach ( $company_gallery as $idx => $item ) : ?>
                <div class="nhomc-thumb-item <?php echo $idx === 0 ? 'active' : ''; ?>" onclick="nhomcSelectPhoto(<?php echo $idx; ?>)">
                    <img src="<?php echo esc_url( $item['url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- =========================================================================
     3. JAVASCRIPT ĐIỀU KHIỂN LIGHTBOX GALLERY & PHÍM TẮT BÀN PHÍM
     ========================================================================= -->
<script>
// Nạp dữ liệu mảng ảnh từ PHP sang biến JavaScript JSON
var nhomcGalleryData = <?php echo json_encode( $company_gallery ); ?>;
var nhomcCurrentPhotoIndex = 0; // Chỉ số ảnh đang hiển thị

/**
 * Mở cửa sổ Lightbox xem ảnh
 * @param {number} startIndex - Vị trí ảnh bắt đầu mở (mặc định là 0)
 */
function nhomcOpenPhotoModal(startIndex) {
    nhomcCurrentPhotoIndex = (typeof startIndex === 'number') ? startIndex : 0;
    var modal = document.getElementById('nhomcPhotoModal');
    if (!modal) return;
    modal.classList.add('active');
    document.body.style.overflow = 'hidden'; // Khóa cuộn trang khi mở modal
    nhomcRenderActivePhoto();
    nhomcUpdateActiveThumb();
}

/**
 * Đóng cửa sổ Lightbox và khôi phục cuộn trang
 */
function nhomcClosePhotoModal() {
    var modal = document.getElementById('nhomcPhotoModal');
    if (!modal) return;
    modal.classList.remove('active');
    document.body.style.overflow = ''; // Mở lại thanh cuộn của trang web
}

/**
 * Chuyển sang bức ảnh tiếp theo (Vòng lặp tuần hoàn)
 */
function nhomcNextPhoto() {
    if (!nhomcGalleryData || !nhomcGalleryData.length) return;
    nhomcCurrentPhotoIndex = (nhomcCurrentPhotoIndex + 1) % nhomcGalleryData.length;
    nhomcRenderActivePhoto();
    nhomcUpdateActiveThumb();
}

/**
 * Quay lại bức ảnh trước đó (Vòng lặp tuần hoàn)
 */
function nhomcPrevPhoto() {
    if (!nhomcGalleryData || !nhomcGalleryData.length) return;
    nhomcCurrentPhotoIndex = (nhomcCurrentPhotoIndex - 1 + nhomcGalleryData.length) % nhomcGalleryData.length;
    nhomcRenderActivePhoto();
    nhomcUpdateActiveThumb();
}

/**
 * Chọn trực tiếp một bức ảnh từ danh sách thumbnail thu nhỏ
 * @param {number} index - Vị trí của bức ảnh trong danh sách
 */
function nhomcSelectPhoto(index) {
    if (!nhomcGalleryData || index < 0 || index >= nhomcGalleryData.length) return;
    nhomcCurrentPhotoIndex = index;
    nhomcRenderActivePhoto();
    nhomcUpdateActiveThumb();
}

/**
 * Cập nhật đường dẫn ảnh lớn, tiêu đề và bộ đếm số thứ tự ảnh
 */
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

/**
 * Cập nhật trạng thái active cho ảnh thu nhỏ tương ứng và cuộn tới vị trí đó
 */
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

/**
 * Lắng nghe sự kiện bàn phím:
 * - Phím Escape (ESC): Đóng modal ảnh
 * - Phím Mũi tên Phải (ArrowRight): Chuyển ảnh kế tiếp
 * - Phím Mũi tên Trái (ArrowLeft): Lùi về ảnh trước
 */
document.addEventListener('keydown', function(e) {
    var modal = document.getElementById('nhomcPhotoModal');
    if (!modal || !modal.classList.contains('active')) return;
    if (e.key === 'Escape') nhomcClosePhotoModal();
    if (e.key === 'ArrowRight') nhomcNextPhoto();
    if (e.key === 'ArrowLeft') nhomcPrevPhoto();
});
</script>
