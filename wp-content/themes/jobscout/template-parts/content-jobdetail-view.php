<?php
/**
 * ============================================================================
 * TEMPLATE PART: CHI TIẾT VIỆC LÀM (JOB DETAIL VIEW)
 * Khớp chuẩn thiết kế Figma: 5-job detail.png
 * Toàn bộ dữ liệu được truy vấn động từ WordPress Database (MySQL)
 *
 * DANH SÁCH CHỨC NĂNG CHÍNH:
 * 1. Khởi tạo dữ liệu công việc, công ty, phân loại & thư viện ảnh.
 * 2. Breadcrumbs: Thanh điều hướng trang (Home > All Jobs > Job Detail).
 * 3. Job Hero Card: Logo, tiêu đề, ngày tạo, tags phân loại, nút Share & Apply Job.
 * 4. Two-Column Layout:
 *    - Cột trái: Mô tả chi tiết việc làm (Company Overview, Skills, Benefits, Location).
 *    - Cột phải: Đánh giá nhân viên (Staff Rating) & Thư viện ảnh (Company Photos preview).
 * 5. Other Jobs Section: Truy vấn 6 việc làm liên quan khác từ Database.
 * 6. Lightbox Modal Gallery: Xem ảnh công ty phóng to, có điều hướng chuyển ảnh & phím tắt.
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
?>

<div class="nhomc-job-detail-wrapper">
    <!-- =====================================================================
         2. BREADCRUMBS: THANH ĐIỀU HƯỚNG PHÂN CẤP
         ===================================================================== -->
    <div class="nhomc-container">
        <nav class="nhomc-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <span class="sep">/</span>
            <a href="<?php echo esc_url( home_url( '/all-jobs/' ) ); ?>">All Jobs</a>
            <span class="sep">/</span>
            <span class="current">Job Detail</span>
        </nav>
    </div>

    <!-- =====================================================================
         3. MAIN JOB HERO CARD: KHỐI THÔNG TIN NỔI BẬT ĐẦU TRANG
         Gồm: Logo doanh nghiệp, Tiêu đề, Ngày tạo, Bộ thẻ phân loại & Nút thao tác
         ===================================================================== -->
    <div class="nhomc-container">
        <div class="nhomc-job-hero-card">
            <div class="nhomc-job-hero-left">
                <!-- Chức năng hiển thị Logo doanh nghiệp chuẩn tỉ lệ -->
                <div class="nhomc-company-logo-box">
                    <?php echo nhomc_get_company_logo( $company_name, $current_job_id, 'large' ); ?>
                </div>

                <!-- Tiêu đề công việc và siêu dữ liệu (Metadata) -->
                <div class="nhomc-job-hero-info">
                    <!-- Tên vị trí tuyển dụng lấy trực tiếp từ tiêu đề bài viết -->
                    <h1 class="nhomc-job-title"><?php the_title(); ?></h1>
                    
                    <!-- Ngày đăng bài việc làm (Định dạng: Month Day, Year) -->
                    <div class="nhomc-job-meta-row">
                        <span class="nhomc-meta-date">Created: <?php echo date( 'M d, Y', strtotime( get_post_field( 'post_date', $current_job_id ) ) ); ?></span>
                    </div>

                    <!-- Danh sách các Tags phân loại: Loại hình | Ngành nghề | Khu vực -->
                    <div class="nhomc-job-tags-row">
                        <span class="nhomc-tag-item"><?php echo esc_html( $badges['type'] ); ?></span>
                        <span class="nhomc-tag-sep">|</span>
                        <span class="nhomc-tag-item"><?php echo esc_html( $badges['category'] ); ?></span>
                        <span class="nhomc-tag-sep">|</span>
                        <span class="nhomc-tag-item"><?php echo esc_html( $badges['location'] ); ?></span>
                    </div>
                </div>
            </div>

            <!-- Nhóm nút hành động nhanh: Chia sẻ liên kết (Share) & Nộp hồ sơ (Apply) -->
            <div class="nhomc-job-hero-right">
                <!-- Nút sao chép liên kết việc làm vào bộ nhớ tạm (Clipboard) -->
                <button type="button" class="nhomc-btn-share" onclick="nhomcShareJob(this)">SHARE</button>
                <!-- Nút mở cửa sổ Modal ứng tuyển nộp hồ sơ CV -->
                <button type="button" class="nhomc-btn-apply" onclick="nhomcOpenApplyModal()">APPLY JOB</button>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         4. BỐ CỤC 2 CỘT NỘI DUNG CHÍNH (TWO-COLUMN MAIN CONTENT)
         - Cột trái: Chi tiết nội dung công việc
         - Cột phải: Thanh bên tiện ích (Staff Rating + Thư viện ảnh)
         ===================================================================== -->
    <div class="nhomc-container">
        <div class="nhomc-job-columns">
            <!-- CỘT TRÁI: NỘI DUNG MÔ TẢ CÔNG VIỆC TỪ DATABASE -->
            <div class="nhomc-job-col-left">
                <article class="nhomc-card-content">
                    <?php
                    // Lấy nội dung bài viết từ Database
                    $raw_content = get_the_content();

                    if ( ! empty( $raw_content ) ) {
                        // Hiển thị nội dung đã được xử lý đoạn văn (wpautop) và parse shortcodes
                        echo wpautop( do_shortcode( wp_kses_post( $raw_content ) ) );
                    } else {
                        // Nội dung mẫu dự phòng chuẩn theo thiết kế Figma nếu bài đăng chưa có bài viết
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

            <!-- CỘT PHẢI: CÁC TIỆN ÍCH BÊN PHẢI (SIDEBAR WIDGETS) -->
            <div class="nhomc-job-col-right">
                <!-- Tiện ích 1: Đánh giá nhân viên nội bộ (Staff Rating) -->
                <div class="nhomc-sidebar-card">
                    <h3 class="nhomc-sidebar-title">Staff Rating</h3>
                    <div class="nhomc-rating-box">
                        <!-- Biểu tượng các ngôi sao đánh giá (4 sao đầy, 1 sao rỗng) -->
                        <div class="nhomc-stars" aria-label="Rating: 4.0 out of 5 stars">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star empty">☆</span>
                        </div>
                        <!-- Điểm số thực tế hiển thị cạnh số sao -->
                        <span class="nhomc-rating-score"><?php echo esc_html( $staff_rating ); ?></span>
                    </div>
                </div>

                <!-- Tiện ích 2: Bộ sưu tập ảnh công ty (Company Photos Preview) -->
                <div class="nhomc-sidebar-card">
                    <h3 class="nhomc-sidebar-title">Company Photos</h3>
                    <!-- Nhấp chuột vào ảnh sẽ kích hoạt Lightbox phóng to xem toàn bộ thư viện -->
                    <div class="nhomc-photos-preview" id="nhomcCompanyPhotosTrigger" onclick="nhomcOpenPhotoModal(0)" role="button" tabindex="0" title="Click để xem toàn bộ ảnh công ty">
                        <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $company_name ); ?> Photos">
                        <!-- Huy hiệu đếm số ảnh còn lại (+5) -->
                        <div class="nhomc-photo-badge">+5</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         5. KHỐI CÁC VIỆC LÀM KHÁC (OTHER JOBS SECTION)
         Truy vấn động 6 vị trí việc làm khác từ MySQL để người tìm việc tham khảo
         ===================================================================== -->
    <section class="nhomc-other-jobs-section">
        <div class="nhomc-container">
            <h2 class="nhomc-section-heading">OTHER JOBS</h2>

            <div class="nhomc-other-jobs-grid">
                <?php
                // Truy vấn 6 bài đăng việc làm (job_listing) đang phát hành, loại trừ công việc hiện tại
                $other_jobs = get_posts( array(
                    'post_type'      => 'job_listing',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'post__not_in'   => array( $current_job_id ),
                    'orderby'        => 'ID',
                    'order'          => 'ASC',
                ) );

                // Trường hợp hệ thống có ít hơn 6 bài loại trừ, truy vấn bài viết mới nhất bổ sung
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
                        <!-- Thẻ công việc liên quan: Click bất kỳ đâu trên thẻ để chuyển hướng -->
                        <div class="nhomc-other-job-card" onclick="window.location.href='<?php echo esc_url( $oj_link ); ?>';" style="cursor: pointer;">
                            <div class="nhomc-oj-top">
                                <!-- Logo công ty kích thước nhỏ gọn -->
                                <div class="nhomc-oj-logo">
                                    <?php echo nhomc_get_company_logo( $oj_company, $oj_id, 'small' ); ?>
                                </div>

                                <!-- Tiêu đề công việc và siêu dữ liệu -->
                                <div class="nhomc-oj-info">
                                    <h3 class="nhomc-oj-title">
                                        <a href="<?php echo esc_url( $oj_link ); ?>">
                                            <?php echo esc_html( $job_item->post_title ); ?>
                                        </a>
                                    </h3>

                                    <div class="nhomc-oj-date">Created: <?php echo esc_html( $oj_date ); ?></div>

                                    <!-- Bộ 3 thẻ phân loại: Loại hình | Ngành nghề | Địa điểm -->
                                    <div class="nhomc-oj-tags">
                                        <span class="nhomc-oj-tag-item"><?php echo esc_html( $oj_badges['type'] ); ?></span>
                                        <span class="nhomc-oj-sep">|</span>
                                        <span class="nhomc-oj-tag-item"><?php echo esc_html( $oj_badges['category'] ); ?></span>
                                        <span class="nhomc-oj-sep">|</span>
                                        <span class="nhomc-oj-tag-item"><?php echo esc_html( $oj_badges['location'] ); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- 3 gạch đầu dòng điểm nhấn công việc trích xuất tự động -->
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

<!-- =========================================================================
     6. CỬA SỔ PHÓNG TO ẢNH DOANH NGHIỆP (COMPANY PHOTOS LIGHTBOX MODAL)
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
     7. JAVASCRIPT ĐIỀU KHIỂN LIGHTBOX GALLERY & PHÍM TẮT BÀN PHÍM
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
