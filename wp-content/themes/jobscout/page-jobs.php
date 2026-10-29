<?php
/**
 * ==============================================================================
 * TẬP TIN: page-jobs.php
 * DỰ ÁN: CỔNG TUYỂN DỤNG JOBSCOUT - FIT TDC (ĐỒ ÁN CUỐI KỲ NHÓM C)
 * NHÁNH: VinhEm/4-alljob
 * TÁC GIẢ: VinhEm (trumvinh85@gmail.com)
 * ==============================================================================
 * MÔ TẢ:
 * File định tuyến template trang WordPress cho slug rút gọn "/jobs".
 * Giúp người dùng hoặc menu điều hướng truy cập http://domain/jobs vẫn hiển thị
 * đúng giao diện All Jobs mà không bị lỗi 404 (Page Not Found).
 * ==============================================================================
 */

// Nạp trực tiếp file template-all-jobs.php trong thư mục theme hiện tại
require_once get_template_directory() . '/template-all-jobs.php';
