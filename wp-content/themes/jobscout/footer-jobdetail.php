<?php
/**
 * Footer template for NhomC Job Detail (Pixel-perfect matching mockup)
 * Tích hợp:
 * - Modal Ứng tuyển vị trí việc làm (Apply Job).
 * - Tải lên tệp CV định dạng PDF với giới hạn tối đa 5MB.
 * - Ràng buộc dữ liệu nghiêm ngặt (Validation: Họ tên tiếng Việt, Email, SĐT, đếm ký tự lời nhắn).
 * - Nút SHARE sao chép liên kết trực tiếp vào clipboard kèm hiệu ứng UI trực quan.
 * - Gửi dữ liệu AJAX an toàn đến WordPress Admin Backend.
 *
 * @package JobScout
 */
?>

<!-- Footer chung của toàn website Nhóm C -->
<?php get_template_part( 'template-parts/nhomc-footer' ); ?>

<!-- =========================================================================
     MODAL ỨNG TUYỂN VIỆC LÀM (APPLY JOB MODAL)
     ========================================================================= -->
<div id="nhomc-apply-modal" class="nhomc-modal-overlay">
    <div class="nhomc-modal-box">
        <!-- Nút đóng modal (x) -->
        <button class="nhomc-modal-close" onclick="nhomcCloseModal('nhomc-apply-modal')">&times;</button>
        
        <!-- Tiêu đề vị trí tuyển dụng lấy động từ Database -->
        <h3 class="nhomc-modal-title">Ứng Tuyển Vị Trí: <?php echo esc_html( get_the_title() ); ?></h3>

        <!-- Form nộp hồ sơ ứng tuyển qua AJAX -->
        <form class="nhomc-modal-form" onsubmit="event.preventDefault(); nhomcSubmitApplication(this);">
            <!-- ID của công việc hiện tại để liên kết hồ sơ -->
            <input type="hidden" name="job_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
            
            <!-- Mã Nonce bảo mật của WordPress chống tấn công CSRF -->
            <input type="hidden" name="apply_nonce" value="<?php echo esc_attr( wp_create_nonce( 'nhomc_apply_action' ) ); ?>">

            <!-- TRƯỜNG 1: HỌ VÀ TÊN (Ràng buộc: 2-70 ký tự, chỉ chứa chữ cái) -->
            <div class="nhomc-form-group">
                <label>Họ và Tên <span class="nhomc-required">*</span></label>
                <input type="text" name="applicant_name" placeholder="Nguyễn Văn A" required minlength="2" maxlength="70" autocomplete="name">
                <div class="nhomc-field-hint">Từ 2 đến 70 ký tự (chỉ dùng chữ cái, không nhập số hoặc ký tự đặc biệt)</div>
            </div>
            
            <!-- TRƯỜNG 2: EMAIL LIÊN HỆ (Ràng buộc: Tối đa 100 ký tự, đúng định dạng email) -->
            <div class="nhomc-form-group">
                <label>Email Liên Hệ <span class="nhomc-required">*</span></label>
                <input type="email" name="applicant_email" placeholder="ungvien@example.com" required maxlength="100" autocomplete="email">
            </div>

            <!-- TRƯỜNG 3: SỐ ĐIỆN THOẠI (Ràng buộc: Định dạng VN từ 9 đến 11 chữ số) -->
            <div class="nhomc-form-group">
                <label>Số Điện Thoại <span class="nhomc-required">*</span></label>
                <input type="tel" name="applicant_phone" placeholder="0912 345 678" required minlength="9" maxlength="15" autocomplete="tel">
                <div class="nhomc-field-hint">Định dạng 9 - 11 chữ số (ví dụ: 0912345678 hoặc +84912345678)</div>
            </div>

            <!-- TRƯỜNG 4: ĐÍNH KÈM CV / RESUME (Ràng buộc: Chỉ nhận file PDF, dung lượng <= 5MB) -->
            <div class="nhomc-form-group">
                <label>Đính Kèm CV / Hồ Sơ Ứng Tuyển (PDF, tối đa 5MB) <span class="nhomc-required">*</span></label>
                <div class="nhomc-file-upload-wrapper">
                    <!-- Thẻ input file ẩn được kích hoạt khi click vào dropzone -->
                    <input type="file" id="nhomc-cv-file" name="applicant_cv" accept=".pdf,application/pdf" style="display: none;" onchange="nhomcHandleFileSelect(this);">
                    
                    <!-- Khung kéo thả và chọn file trực quan -->
                    <div id="nhomc-upload-dropzone" class="nhomc-upload-dropzone" onclick="document.getElementById('nhomc-cv-file').click();">
                        <div class="nhomc-upload-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                        </div>
                        <div class="nhomc-upload-text">
                            <strong>Chọn tệp PDF</strong> hoặc kéo thả vào đây
                        </div>
                        <div class="nhomc-upload-hint">Chỉ nhận file .pdf (Tối đa 5MB)</div>
                    </div>

                    <!-- Khung xem trước thông tin tệp PDF sau khi đã chọn thành công -->
                    <div id="nhomc-file-preview-card" class="nhomc-file-preview-card" style="display: none;">
                        <div class="nhomc-file-preview-info">
                            <div class="nhomc-file-pdf-icon">
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                                    <rect width="24" height="24" rx="4" fill="#fee2e2"/>
                                    <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5z" stroke="#dc2626" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                    <polyline points="14 3 14 8 19 8" stroke="#dc2626" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                    <text x="6.5" y="16.5" fill="#dc2626" font-size="6" font-weight="800" font-family="sans-serif">PDF</text>
                                </svg>
                            </div>
                            <div class="nhomc-file-details">
                                <span id="nhomc-file-name" class="nhomc-file-name">cv-ung-vien.pdf</span>
                                <span id="nhomc-file-size" class="nhomc-file-size">1.5 MB</span>
                            </div>
                        </div>
                        <!-- Nút xóa file đã chọn để chọn lại file khác -->
                        <button type="button" class="nhomc-file-remove-btn" onclick="nhomcRemoveFile()" title="Xóa file đã chọn">&times;</button>
                    </div>

                    <!-- Hộp hiển thị thông báo lỗi khi file vượt quá 5MB hoặc sai định dạng -->
                    <div id="nhomc-file-error" class="nhomc-file-error-msg" style="display: none;"></div>
                </div>
            </div>

            <!-- TRƯỜNG 5: LỜI NHẮN / GIỚI THIỆU BẢN THÂN (Ràng buộc: Tối đa 500 ký tự có bộ đếm) -->
            <div class="nhomc-form-group">
                <label>Giới Thiệu Bản Thân / Lời Nhắn (Không bắt buộc)</label>
                <textarea name="applicant_notes" id="nhomc-notes-input" rows="2" maxlength="500" placeholder="Ghi chú thêm hoặc tóm tắt kinh nghiệm nổi bật... (Tối đa 500 ký tự)" oninput="nhomcUpdateNotesCount(this)"></textarea>
                <div class="nhomc-char-counter-row">
                    <span class="nhomc-field-hint">Ngắn gọn, súc tích</span>
                    <!-- Bộ đếm ký tự thời gian thực -->
                    <span class="nhomc-char-counter"><span id="nhomc-char-count">0</span>/500 ký tự</span>
                </div>
            </div>

            <!-- Nút gửi hồ sơ -->
            <button type="submit" id="nhomc-btn-submit-app">XÁC NHẬN NỘP HỒ SƠ</button>
        </form>
    </div>
</div>

<!-- Khung thông báo dạng Toast ở góc màn hình -->
<div id="nhomc-toast" class="nhomc-toast"></div>

<!-- =========================================================================
     JAVASCRIPT XỬ LÝ SỰ KIỆN & VALIDATION FORM
     ========================================================================= -->
<script>
/**
 * Mở modal nộp hồ sơ ứng tuyển
 */
function nhomcOpenApplyModal() {
    var modal = document.getElementById('nhomc-apply-modal');
    if (modal) modal.classList.add('active');
}

/**
 * Đóng modal theo ID phần tử
 * @param {string} id - ID của phần tử modal
 */
function nhomcCloseModal(id) {
    var modal = document.getElementById(id);
    if (modal) modal.classList.remove('active');
}

/**
 * Hiển thị thông báo Toast trong 3.5 giây
 * @param {string} msg - Nội dung thông báo
 */
function nhomcShowToast(msg) {
    var toast = document.getElementById('nhomc-toast');
    if (!toast) return;
    toast.innerText = msg;
    toast.style.display = 'block';
    setTimeout(function() {
        toast.style.display = 'none';
    }, 3500);
}

/**
 * Nút SHARE: Sao chép liên kết việc làm trực tiếp vào bộ nhớ tạm (clipboard)
 * - Đổi chữ nút thành "COPIED! ✓" trong 2 giây
 * - Tự động fallback sang textarea nếu trình duyệt không hỗ trợ navigator.clipboard
 * @param {HTMLElement} btn - Nút share được bấm
 */
function nhomcShareJob(btn) {
    var url = window.location.href;
    var shareBtn = btn || document.querySelector('.nhomc-btn-share');

    function onCopySuccess() {
        if (shareBtn) {
            var originalText = shareBtn.getAttribute('data-original-text') || shareBtn.innerText;
            if (!shareBtn.getAttribute('data-original-text')) {
                shareBtn.setAttribute('data-original-text', originalText);
            }
            // Đổi giao diện sang trạng thái đã copy
            shareBtn.innerText = 'COPIED! ✓';
            shareBtn.classList.add('copied');
            setTimeout(function() {
                shareBtn.innerText = originalText;
                shareBtn.classList.remove('copied');
            }, 2000);
        }
        nhomcShowToast('Đã sao chép liên kết việc làm vào bộ nhớ tạm!');
    }

    // Ưu tiên sử dụng Clipboard API hiện đại
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(function() {
            onCopySuccess();
        }).catch(function() {
            nhomcFallbackCopyText(url, onCopySuccess);
        });
    } else {
        // Fallback đa nền tảng
        nhomcFallbackCopyText(url, onCopySuccess);
    }
}

/**
 * Cơ chế Fallback sao chép clipboard cho các trình duyệt cũ / môi trường HTTP
 * @param {string} text - Văn bản cần sao chép
 * @param {function} callback - Hàm thực thi khi sao chép thành công
 */
function nhomcFallbackCopyText(text, callback) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    textArea.style.top = "-9999px";
    textArea.style.left = "-9999px";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        var successful = document.execCommand('copy');
        if (successful) {
            callback();
        } else {
            prompt('Sao chép liên kết:', text);
        }
    } catch (err) {
        prompt('Sao chép liên kết:', text);
    }
    document.body.removeChild(textArea);
}

/**
 * Xử lý khi ứng viên chọn tệp CV PDF:
 * 1. Kiểm tra định dạng (.pdf)
 * 2. Kiểm tra dung lượng (<= 5MB)
 * 3. Hiển thị Card xem trước tệp
 * @param {HTMLInputElement} input - Phần tử input file
 */
function nhomcHandleFileSelect(input) {
    var errorBox = document.getElementById('nhomc-file-error');
    var previewCard = document.getElementById('nhomc-file-preview-card');
    var dropzone = document.getElementById('nhomc-upload-dropzone');
    var fileNameElem = document.getElementById('nhomc-file-name');
    var fileSizeElem = document.getElementById('nhomc-file-size');

    if (!errorBox || !previewCard || !dropzone) return;

    errorBox.style.display = 'none';
    errorBox.innerText = '';

    if (!input.files || input.files.length === 0) {
        previewCard.style.display = 'none';
        dropzone.style.display = 'flex';
        return;
    }

    var file = input.files[0];
    var maxSizeBytes = 5 * 1024 * 1024; // Giới hạn 5MB

    // Kiểm tra định dạng file PDF
    var isPdf = file.name.toLowerCase().endsWith('.pdf') || file.type === 'application/pdf';
    if (!isPdf) {
        errorBox.innerText = 'Lỗi: Tệp không hợp lệ! Vui lòng chỉ chọn file định dạng PDF (.pdf).';
        errorBox.style.display = 'block';
        input.value = '';
        previewCard.style.display = 'none';
        dropzone.style.display = 'flex';
        return;
    }

    // Kiểm tra dung lượng file <= 5MB
    if (file.size > maxSizeBytes) {
        var sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        errorBox.innerText = 'Lỗi: Dung lượng file (' + sizeMB + ' MB) vượt quá giới hạn tối đa 5MB!';
        errorBox.style.display = 'block';
        input.value = '';
        previewCard.style.display = 'none';
        dropzone.style.display = 'flex';
        return;
    }

    // File hợp lệ: Hiển thị preview card
    fileNameElem.innerText = file.name;
    var sizeText = file.size >= 1024 * 1024 
        ? (file.size / (1024 * 1024)).toFixed(2) + ' MB'
        : (file.size / 1024).toFixed(1) + ' KB';
    fileSizeElem.innerText = sizeText;

    dropzone.style.display = 'none';
    previewCard.style.display = 'flex';
}

/**
 * Xóa file đã chọn và đưa giao diện về trạng thái ban đầu
 */
function nhomcRemoveFile() {
    var input = document.getElementById('nhomc-cv-file');
    var previewCard = document.getElementById('nhomc-file-preview-card');
    var dropzone = document.getElementById('nhomc-upload-dropzone');
    var errorBox = document.getElementById('nhomc-file-error');

    if (input) input.value = '';
    if (previewCard) previewCard.style.display = 'none';
    if (dropzone) dropzone.style.display = 'flex';
    if (errorBox) {
        errorBox.innerText = '';
        errorBox.style.display = 'none';
    }
}

/**
 * Hỗ trợ kéo thả (Drag and Drop) file PDF trực tiếp vào khung upload
 */
document.addEventListener('DOMContentLoaded', function() {
    var dropzone = document.getElementById('nhomc-upload-dropzone');
    if (!dropzone) return;

    ['dragenter', 'dragover'].forEach(function(evt) {
        dropzone.addEventListener(evt, function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('dragover');
        });
    });

    ['dragleave', 'drop'].forEach(function(evt) {
        dropzone.addEventListener(evt, function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('dragover');
        });
    });

    dropzone.addEventListener('drop', function(e) {
        var dt = e.dataTransfer;
        if (dt && dt.files && dt.files.length > 0) {
            var fileInput = document.getElementById('nhomc-cv-file');
            fileInput.files = dt.files;
            nhomcHandleFileSelect(fileInput);
        }
    });
});

/**
 * Cập nhật số lượng ký tự thời gian thực cho lời nhắn giới thiệu (Tối đa 500 ký tự)
 * @param {HTMLTextAreaElement} elem - Ô textarea nhập lời nhắn
 */
function nhomcUpdateNotesCount(elem) {
    var countSpan = document.getElementById('nhomc-char-count');
    if (!countSpan || !elem) return;
    var len = elem.value ? elem.value.length : 0;
    countSpan.innerText = len;
    if (len >= 500) {
        countSpan.style.color = '#ef4444';
        countSpan.style.fontWeight = 'bold';
    } else {
        countSpan.style.color = '';
        countSpan.style.fontWeight = '';
    }
}

/**
 * Xử lý kiểm tra dữ liệu (Validation) và nộp hồ sơ ứng tuyển qua AJAX:
 * 1. Kiểm tra Họ và Tên (2-70 ký tự, tiếng Việt chuẩn)
 * 2. Kiểm tra Email hợp lệ (<= 100 ký tự)
 * 3. Kiểm tra Số điện thoại (9-11 chữ số)
 * 4. Kiểm tra Lời nhắn (<= 500 ký tự)
 * 5. Kiểm tra File CV PDF (Bắt buộc, <= 5MB)
 * 6. Đóng gói FormData và gửi POST tới admin-ajax.php
 * @param {HTMLFormElement} form - Form nộp hồ sơ
 */
function nhomcSubmitApplication(form) {
    var fileInput = document.getElementById('nhomc-cv-file');
    var errorBox  = document.getElementById('nhomc-file-error');
    var submitBtn = document.getElementById('nhomc-btn-submit-app');

    if (errorBox) {
        errorBox.style.display = 'none';
        errorBox.innerText = '';
    }

    // 1. RÀNG BUỘC HỌ VÀ TÊN: Từ 2 đến 70 ký tự, chỉ chứa chữ cái tiếng Việt
    var name = (form.applicant_name ? form.applicant_name.value : '').trim();
    if (name.length < 2 || name.length > 70) {
        if (errorBox) {
            errorBox.innerText = 'Lỗi: Họ và tên phải từ 2 đến 70 ký tự (bạn đã nhập ' + name.length + ' ký tự)!';
            errorBox.style.display = 'block';
        }
        if (form.applicant_name) form.applicant_name.focus();
        return;
    }
    // Regex hỗ trợ chữ cái tiếng Việt có dấu, khoảng trắng, dấu gạch nối
    var nameRegex = /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\.\-]+$/;
    if (!nameRegex.test(name)) {
        if (errorBox) {
            errorBox.innerText = 'Lỗi: Họ và tên không được chứa số hoặc ký tự đặc biệt lạ!';
            errorBox.style.display = 'block';
        }
        if (form.applicant_name) form.applicant_name.focus();
        return;
    }

    // 2. RÀNG BUỘC EMAIL: Tối đa 100 ký tự và đúng cấu trúc email
    var email = (form.applicant_email ? form.applicant_email.value : '').trim();
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || !emailRegex.test(email) || email.length > 100) {
        if (errorBox) {
            errorBox.innerText = 'Lỗi: Email không hợp lệ hoặc quá dài (tối đa 100 ký tự)!';
            errorBox.style.display = 'block';
        }
        if (form.applicant_email) form.applicant_email.focus();
        return;
    }

    // 3. RÀNG BUỘC SỐ ĐIỆN THOẠI: Định dạng chuẩn 9-11 chữ số
    var phone = (form.applicant_phone ? form.applicant_phone.value : '').trim();
    var cleanPhone = phone.replace(/[\s\-\.]/g, '');
    var phoneRegex = /^(0|\+84)[0-9]{8,10}$/;
    if (!cleanPhone || !phoneRegex.test(cleanPhone)) {
        if (errorBox) {
            errorBox.innerText = 'Lỗi: Số điện thoại không hợp lệ (Vui lòng nhập định dạng 9 - 11 chữ số, ví dụ: 0912345678)!';
            errorBox.style.display = 'block';
        }
        if (form.applicant_phone) form.applicant_phone.focus();
        return;
    }

    // 4. RÀNG BUỘC LỜI NHẮN: Tối đa 500 ký tự (chống spam)
    var notes = (form.applicant_notes ? form.applicant_notes.value : '').trim();
    if (notes.length > 500) {
        if (errorBox) {
            errorBox.innerText = 'Lỗi: Lời nhắn vượt quá giới hạn 500 ký tự (bạn đã nhập ' + notes.length + ' ký tự)!';
            errorBox.style.display = 'block';
        }
        if (form.applicant_notes) form.applicant_notes.focus();
        return;
    }

    // 5. RÀNG BUỘC TỆP CV: Bắt buộc chọn file PDF <= 5MB
    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
        if (errorBox) {
            errorBox.innerText = 'Vui lòng đính kèm file CV của bạn (định dạng PDF, tối đa 5MB)!';
            errorBox.style.display = 'block';
        }
        return;
    }

    var file = fileInput.files[0];
    if (file.size > 5 * 1024 * 1024) {
        if (errorBox) {
            errorBox.innerText = 'Dung lượng file vượt quá giới hạn 5MB!';
            errorBox.style.display = 'block';
        }
        return;
    }

    // Tạo đối tượng FormData chứa toàn bộ thông tin form và file đính kèm
    var formData = new FormData(form);
    formData.append('action', 'nhomc_submit_application');

    // Chuyển nút bấm sang trạng thái đang tải
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.setAttribute('data-orig-text', submitBtn.innerText);
        submitBtn.innerText = 'ĐANG TẢI LÊN & NỘP HỒ SƠ...';
    }

    var ajaxUrl = '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';

    // Gửi request POST không đồng bộ qua Fetch API
    fetch(ajaxUrl, {
        method: 'POST',
        body: formData
    })
    .then(function(res) {
        return res.json();
    })
    .then(function(data) {
        // Khôi phục trạng thái nút bấm
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerText = submitBtn.getAttribute('data-orig-text') || 'XÁC NHẬN NỘP HỒ SƠ';
        }

        if (data && data.success) {
            // Đóng modal và hiển thị Toast thành công
            nhomcCloseModal('nhomc-apply-modal');
            var successMsg = (data.data && data.data.message) ? data.data.message : 'Nộp hồ sơ thành công!';
            nhomcShowToast(successMsg);
            form.reset();
            nhomcRemoveFile();
            var countSpan = document.getElementById('nhomc-char-count');
            if (countSpan) countSpan.innerText = '0';
        } else {
            // Hiển thị lỗi từ server trả về
            var msg = (data && data.data && data.data.message) ? data.data.message : 'Có lỗi xảy ra, vui lòng thử lại!';
            if (errorBox) {
                errorBox.innerText = msg;
                errorBox.style.display = 'block';
            } else {
                alert(msg);
            }
        }
    })
    .catch(function(err) {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerText = submitBtn.getAttribute('data-orig-text') || 'XÁC NHẬN NỘP HỒ SƠ';
        }
        if (errorBox) {
            errorBox.innerText = 'Lỗi kết nối máy chủ. Vui lòng thử lại sau!';
            errorBox.style.display = 'block';
        }
    });
}
</script>

<?php wp_footer(); ?>
</body>
</html>
