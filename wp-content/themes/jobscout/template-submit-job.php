<?php
/**
 * Template Name: Submit Job (NhomC Design)
 * Template Post Type: page
 *
 * Giao diện trang Đăng Tin Tuyển Dụng (Post a Job / Submit Job) chuẩn đồ án JobScout - Nhóm C (FIT - TDC)
 * Đã tối ưu Responsive đa thiết bị, đồng bộ 100% trường dữ liệu với trang Jobs.
 */

get_header( 'jobdetail' );
?>

<!-- Banner Đầu Trang -->
<section class="nhomc-submitjob-hero">
    <div class="nhomc-submitjob-hero-inner">
        <div class="nhomc-submitjob-breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
            <span class="sep">/</span>
            <a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>">JOBS</a>
            <span class="sep">/</span>
            <span class="current">POST A JOB</span>
        </div>
        <h1 class="nhomc-submitjob-title">ĐĂNG TIN TUYỂN DỤNG</h1>
        <p class="nhomc-submitjob-subtitle">Dễ dàng tạo tin tuyển dụng và tiếp cận hàng ngàn ứng viên tiềm năng trên hệ thống JobScout</p>
    </div>
</section>

<!-- Khung Form Đăng Tuyển Chuẩn Nhóm C -->
<main class="nhomc-submitjob-main">
    <div class="nhomc-submitjob-container">
        <div class="nhomc-submitjob-card">
            <?php
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    $content = get_the_content();
                    if ( empty( trim( $content ) ) || strpos( $content, '[submit_job_form]' ) === false ) {
                        echo do_shortcode( '[submit_job_form]' );
                    } else {
                        the_content();
                    }
                }
            } else {
                echo do_shortcode( '[submit_job_form]' );
            }
            ?>
        </div>
    </div>
</main>

<style>
/* === CSS CHUẨN DESIGN NHÓM C CHO SUBMIT JOB === */
.nhomc-submitjob-hero {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: #ffffff;
    padding: 48px 20px;
    text-align: center;
    position: relative;
    border-bottom: 3px solid #ff6600;
}
.nhomc-submitjob-hero-inner {
    max-width: 900px;
    margin: 0 auto;
}
.nhomc-submitjob-breadcrumb {
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 12px;
    color: #94a3b8;
}
.nhomc-submitjob-breadcrumb a {
    color: #cbd5e1;
    text-decoration: none;
    transition: color 0.2s ease;
}
.nhomc-submitjob-breadcrumb a:hover {
    color: #ff6600;
}
.nhomc-submitjob-breadcrumb .sep {
    margin: 0 8px;
    color: #64748b;
}
.nhomc-submitjob-breadcrumb .current {
    color: #ff6600;
}
.nhomc-submitjob-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 32px;
    font-weight: 800;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    color: #ffffff;
}
.nhomc-submitjob-subtitle {
    font-size: 15px;
    color: #cbd5e1;
    font-weight: 400;
    max-width: 650px;
    margin: 0 auto;
}

/* === MAIN CARD CONTAINER === */
.nhomc-submitjob-main {
    background-color: #f8fafc;
    padding: 40px 16px 70px;
    min-height: 60vh;
}
.nhomc-submitjob-container {
    max-width: 920px;
    margin: 0 auto;
}
.nhomc-submitjob-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
    padding: 36px 44px;
}

/* === FORM STYLING FOR WP JOB MANAGER === */
.job-manager-form {
    font-family: 'Montserrat', sans-serif;
}
.job-manager-form h2 {
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
    margin: 32px 0 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 8px;
}
.job-manager-form h2::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 20px;
    background: #ff6600;
    border-radius: 2px;
}
.job-manager-form fieldset {
    border: none;
    padding: 0;
    margin: 0 0 22px 0;
}
.job-manager-form fieldset > label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
}
.job-manager-form fieldset > label small {
    font-size: 12px;
    font-weight: 400;
    color: #94a3b8;
}
.job-manager-form .field small.description {
    display: block;
    font-size: 12px;
    color: #64748b;
    margin-top: 6px;
    font-style: normal;
}
.job-manager-form input[type="text"],
.job-manager-form input[type="email"],
.job-manager-form input[type="url"],
.job-manager-form input[type="password"],
.job-manager-form select,
.job-manager-form textarea {
    width: 100%;
    padding: 12px 14px;
    font-size: 14px;
    font-family: inherit;
    color: #1e293b;
    background-color: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    box-sizing: border-box;
    transition: all 0.2s ease;
    outline: none;
}
.job-manager-form input[type="text"]:focus,
.job-manager-form input[type="email"]:focus,
.job-manager-form input[type="url"]:focus,
.job-manager-form select:focus,
.job-manager-form textarea:focus {
    border-color: #ff6600;
    box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.15);
}
.job-manager-form select {
    background-color: #ffffff;
    cursor: pointer;
}

/* Checkbox remote position */
.job-manager-form .fieldset-type-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}
.job-manager-form .fieldset-type-checkbox label {
    margin-bottom: 0;
    cursor: pointer;
}
.job-manager-form .fieldset-type-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-top: 2px;
    accent-color: #ff6600;
    cursor: pointer;
}

/* File Upload */
.job-manager-form input[type="file"] {
    font-size: 13px;
    color: #475569;
}

/* Buttons */
.job-manager-form input[type="submit"],
.job-manager-form .button,
.job-manager-form input.button {
    background: #ff6600 !important;
    color: #ffffff !important;
    font-size: 14px !important;
    font-weight: 700 !important;
    letter-spacing: 0.5px !important;
    text-transform: uppercase !important;
    padding: 14px 32px !important;
    border: none !important;
    border-radius: 6px !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    box-shadow: 0 4px 12px rgba(255, 102, 0, 0.25) !important;
}
.job-manager-form input[type="submit"]:hover,
.job-manager-form .button:hover,
.job-manager-form input.button:hover {
    background: #e65c00 !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(255, 102, 0, 0.35) !important;
}
.job-manager-form .button.secondary,
.job-manager-form input.secondary {
    background: #64748b !important;
    box-shadow: none !important;
    margin-right: 12px;
}
.job-manager-form .button.secondary:hover {
    background: #475569 !important;
}

/* Preview page controls */
.job-manager-form #job_preview {
    margin-bottom: 30px;
    padding: 24px;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

/* Success notification message */
.job-manager-message {
    padding: 18px 22px;
    margin-bottom: 24px;
    background-color: #ecfdf5;
    border-left: 4px solid #10b981;
    border-radius: 6px;
    color: #065f46;
    font-weight: 500;
    font-size: 15px;
}
.job-manager-message a {
    color: #ff6600;
    font-weight: 700;
    text-decoration: underline;
}
.job-manager-error {
    padding: 18px 22px;
    margin-bottom: 24px;
    background-color: #fef2f2;
    border-left: 4px solid #ef4444;
    border-radius: 6px;
    color: #991b1b;
    font-size: 14px;
}

@media (max-width: 768px) {
    .nhomc-submitjob-card {
        padding: 24px 20px;
    }
    .nhomc-submitjob-title {
        font-size: 26px;
    }
}
</style>

<?php get_footer( 'jobdetail' ); ?>
