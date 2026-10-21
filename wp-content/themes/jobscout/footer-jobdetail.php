<?php
/**
 * Footer template for NhomC Job Detail (Pixel-perfect matching mockup)
 *
 * @package JobScout
 */
?>

<!-- Unified Nhom C Footer (Pixel-perfect) -->
<?php get_template_part( 'template-parts/nhomc-footer' ); ?>

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
function nhomcSubmitApplication(form) {
    nhomcCloseModal('nhomc-apply-modal');
    nhomcShowToast('Nộp hồ sơ ứng tuyển thành công! Nhà tuyển dụng sẽ sớm liên hệ.');
    form.reset();
}
</script>

<?php wp_footer(); ?>
</body>
</html>
