<?php
/**
 * ==============================================================================
 * TẬP TIN: page-home.php
 * DỰ ÁN: CỔNG TUYỂN DỤNG JOBSCOUT - FIT TDC (ĐỒ ÁN CUỐI KỲ NHÓM C)
 * NHÁNH: Hien/1-home
 * TÁC GIẢ: Nguyễn Thanh Hiền (thenghien2006@gmail.com)
 * VAI TRÒ: Phụ trách Tính năng 1 - Giao diện Trang Chủ (Home Page)
 * ==============================================================================
 * MÔ TẢ CHI TIẾT:
 * Template dành riêng cho đường dẫn tĩnh (Slug: /home/).
 * Giúp người dùng hoặc quản trị viên khi truy cập trực tiếp đường dẫn URL
 * http://domain.com/home/ thì hệ thống vẫn chuyển hướng và nạp đúng 100%
 * giao diện chuẩn đồ án của file template-home.php.
 * ==============================================================================
 */

// Chống truy cập trực tiếp vào tập tin qua URL trình duyệt nếu không thông qua môi trường WordPress
defined( 'ABSPATH' ) || exit;

// Nạp tập tin template giao diện Trang Chủ do Nguyễn Thanh Hiền phụ trách
include get_template_directory() . '/template-home.php';

