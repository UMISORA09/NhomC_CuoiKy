<?php
/**
 * ==============================================================================
 * TẬP TIN: page-all-jobs.php
 * DỰ ÁN: CỔNG TUYỂN DỤNG JOBSCOUT - FIT TDC (ĐỒ ÁN CUỐI KỲ NHÓM C)
 * NHÁNH: VinhEm/4-alljob
 * TÁC GIẢ: VinhEm (trumvinh85@gmail.com)
 * ==============================================================================
 * MÔ TẢ:
 * File định tuyến template trang WordPress cho slug "/all-jobs".
 * Khi người dùng truy cập đường dẫn http://domain/all-jobs, WordPress sẽ nạp file này.
 * File tự động nhúng template giao diện tổng hợp danh sách việc làm "template-all-jobs.php".
 * ==============================================================================
 */

// Nạp trực tiếp file template-all-jobs.php trong thư mục theme hiện tại
require_once get_template_directory() . '/template-all-jobs.php';
