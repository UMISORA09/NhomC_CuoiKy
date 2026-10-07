<?php
/**
 * Footer template for NhomC Job Detail (Pixel-perfect matching mockup)
 *
 * @package JobScout
 */
?>

<!-- Newsletter Subscription Section -->
<section class="nhomc-newsletter-section">
    <div class="nhomc-container">
        <div class="nhomc-newsletter-wrap">
            <div class="nhomc-nl-title">
                Subscribe To<br>Our Newsletter
            </div>
            <form class="nhomc-nl-form" onsubmit="event.preventDefault(); nhomcSubscribeNewsletter(this);">
                <div class="nhomc-nl-input-group">
                    <span class="nhomc-nl-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </span>
                    <input type="email" placeholder="Input your email address" required aria-label="Email address">
                </div>
                <button type="submit" class="nhomc-btn-subscribe">SUBSCRIBE</button>
            </form>
        </div>
    </div>
</section>

<!-- Footer Main Area -->
<footer class="nhomc-site-footer">
    <div class="nhomc-container">
        <!-- Brand Logo -->
        <div class="nhomc-footer-brand">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nhomc-brand-logo" rel="home">
                <div class="nhomc-logo-badge">
                    <span class="nhomc-logo-title">NHOM C<span class="orange-dot">.</span></span>
                    <span class="nhomc-logo-sub">RECRUITING</span>
                </div>
            </a>
        </div>

        <!-- Footer Navigation Links -->
        <nav class="nhomc-footer-nav" aria-label="Footer Menu">
            <a href="<?php echo esc_url( home_url( '/all-jobs/' ) ); ?>">JOBS</a>
            <a href="<?php echo esc_url( home_url( '/all-jobs/' ) ); ?>">COMPANIES</a>
            <a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">BLOG</a>
            <a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">ABOUT</a>
            <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">CONTACT</a>
        </nav>

        <!-- Social Media Buttons -->
        <div class="nhomc-social-links">
            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="social-circle fb" title="Facebook">f</a>
            <a href="https://google.com" target="_blank" rel="noopener noreferrer" class="social-circle gplus" title="Google">G</a>
            <a href="https://line.me" target="_blank" rel="noopener noreferrer" class="social-circle line" title="LINE">LINE</a>
            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="social-circle tw" title="Twitter">𝕏</a>
        </div>
    </div>

    <!-- Sub Footer Bottom Bar -->
    <div class="nhomc-sub-footer">
        <div class="nhomc-container">
            <p>© 2026 Nhom C - FIT TDC. All Rights Reserved. Hệ Thống Tuyển Dụng JobScout</p>
        </div>
    </div>
</footer>

<!-- Application Modal -->
<div id="nhomc-apply-modal" class="nhomc-modal-overlay">
    <div class="nhomc-modal-box">
        <button class="nhomc-modal-close" onclick="nhomcCloseModal('nhomc-apply-modal')">&times;</button>
        <h3 class="nhomc-modal-title">Ứng Tuyển Vị Trí: <?php echo esc_html( get_the_title() ); ?></h3>
        <form class="nhomc-modal-form" onsubmit="event.preventDefault(); nhomcSubmitApplication(this);">
            <label>Họ và Tên (*)</label>
            <input type="text" placeholder="Nguyễn Văn A" required>
            
            <label>Email Liên Hệ (*)</label>
            <input type="email" placeholder="ungvien@example.com" required>

            <label>Số Điện Thoại (*)</label>
            <input type="tel" placeholder="0912 345 678" required>

            <label>Giới Thiệu Bản Thân / Link CV (*)</label>
            <textarea rows="3" placeholder="Đính kèm link CV Google Drive hoặc giới thiệu kỹ năng nổi bật..." required></textarea>

            <button type="submit">XÁC NHẬN NỘP HỒ SƠ</button>
        </form>
    </div>
</div>

<!-- Toast Notification -->
<div id="nhomc-toast" class="nhomc-toast"></div>

<script>
function nhomcOpenApplyModal() {
    var modal = document.getElementById('nhomc-apply-modal');
    if (modal) modal.classList.add('active');
}
function nhomcCloseModal(id) {
    var modal = document.getElementById(id);
    if (modal) modal.classList.remove('active');
}
function nhomcShowToast(msg) {
    var toast = document.getElementById('nhomc-toast');
    if (!toast) return;
    toast.innerText = msg;
    toast.style.display = 'block';
    setTimeout(function() {
        toast.style.display = 'none';
    }, 3000);
}
function nhomcShareJob() {
    var url = window.location.href;
    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(function() {
            nhomcShowToast('Đã sao chép liên kết việc làm vào bộ nhớ tạm!');
        });
    } else {
        nhomcShowToast('Liên kết: ' + url);
    }
}
function nhomcSubscribeNewsletter(form) {
    nhomcShowToast('Cảm ơn bạn đã đăng ký nhận bản tin tuyển dụng NhomC!');
    form.reset();
}
function nhomcSubmitApplication(form) {
    nhomcCloseModal('nhomc-apply-modal');
    nhomcShowToast('Nộp hồ sơ ứng tuyển thành công! Nhà tuyển dụng sẽ sớm liên hệ.');
    form.reset();
}
</script>

<?php wp_footer(); ?>
</body>
</html>
