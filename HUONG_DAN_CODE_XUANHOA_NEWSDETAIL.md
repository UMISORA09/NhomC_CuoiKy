# TỔNG HỢP DANH SÁCH FILE CODE - TÍNH NĂNG CHI TIẾT TIN TỨC (NEWS DETAIL PAGE)
> **Sinh viên phụ trách:** Nguyễn Xuân Hòa  
> **Email:** `vhoa1682006@gmail.com`  
> **Nhánh (Branch):** `xuanhoa/6-newsdetail`  
> **Nhiệm vụ trong đồ án:** Tính năng 6 - Giao diện Trang Chi Tiết Tin Tức chuẩn bản vẽ thiết kế `job-design/6-news detail.png`  
> *(Toàn bộ mã nguồn bên trong từng file PHP đã được gắn chú thích chi tiết từng dòng bằng tiếng Việt)*

---

## 📌 DANH SÁCH CÁC FILE PHP CỦA XUÂN HÒA (TÍNH NĂNG 6)

| STT | Tên File PHP | Đường dẫn file | Chức năng chính |
| :---: | :--- | :--- | :--- |
| **1** | `template-news-detail.php` | `wp-content/themes/jobscout/template-news-detail.php` | **File đầu não chi tiết bài viết:** Xử lý nhận diện bài viết động qua tham số URL `$_GET['post']`, nạp dữ liệu từ kho `articles_catalog` hoặc WordPress single post, hiển thị Breadcrumb, Header Card, nội dung 2 cột (bài viết, quote, tags, nút chia sẻ Clipboard và cột phải cơ hội việc làm), lưới 4 bài viết liên quan, tích hợp Header, Footer dùng chung và hàm `wp_body_open()`. |
| **2** | `page-news-detail.php` | `wp-content/themes/jobscout/page-news-detail.php` | **Bộ điều hướng URL:** Nạp tự động `template-news-detail.php` khi truy cập đường dẫn tĩnh `/news-detail/`. |

---

## 🎨 TÍNH NĂNG "SỬA GIAO DIỆN" (WORDPRESS THEME CUSTOMIZER)
- Trang Chi tiết tin tức được tích hợp hoàn toàn chuẩn mực với hệ sinh thái WordPress thông qua việc gọi đầy đủ các hook tiêu chuẩn:
  - `<?php wp_head(); ?>` trong thẻ `<head>` để nạp đầy đủ CSS, font và script hệ thống.
  - `<?php wp_body_open(); ?>` ngay sau thẻ `<body>` giúp hiển thị thanh quản trị WordPress Admin Bar với nút **[Biểu tượng cây cọ] Sửa giao diện** (`customize.php`).
  - `<?php get_template_part( 'template-parts/nhomc-header' ); ?>` và `<?php get_template_part( 'template-parts/nhomc-footer' ); ?>` bảo đảm giao diện toàn website luôn đồng bộ 100% với Header, Menu và Footer chung của nhóm.
  - `<?php wp_footer(); ?>` trước thẻ đóng `</body>`.
- Khi bấm **Sửa giao diện**, khung xem trước (Preview) của Customizer hiển thị trọn vẹn trang chi tiết bài viết, cho phép tùy chỉnh màu sắc, menu điều hướng, logo và nhận diện trang web trực quan.

---

## 🎯 CÂU HỎI & TRẢ LỜI MẪU KHI BẢO VỆ ĐỒ ÁN (VẤN ĐÁP)

* **Câu hỏi 1: "Em phụ trách tính năng gì và cơ chế hiển thị chi tiết bài viết hoạt động như thế nào?"**
  * 👉 **Trả lời:** *"Dạ em là Nguyễn Xuân Hòa, phụ trách Tính năng 6: Lập trình giao diện Trang Chi tiết tin tức (News Detail Page) chuẩn bản vẽ `6-news detail.png`. Khi người dùng click vào một bài viết từ trang danh sách tin tức (Tính năng 3) hoặc các bài viết liên quan, hệ thống truyền tham số slug qua URL (ví dụ: `/news-detail/?post=project-development`). Trong file `template-news-detail.php`, em dùng `$_GET['post']` để truy xuất mảng dữ liệu `articles_catalog` tương ứng nhằm lấy đúng tiêu đề, ngày đăng, ảnh thumbnail và 3 đoạn văn bản chi tiết phong phú."*

* **Câu hỏi 2: "Nếu người dùng truy cập trực tiếp đường dẫn /news-detail/ mà không có tham số ?post= thì hiển thị gì?"**
  * 👉 **Trả lời:** *"Dạ em đã thiết lập cơ chế fallback mặc định: Nếu không có tham số `?post=`, trang sẽ hiển thị bài viết chuẩn mẫu 100% theo bản vẽ thiết kế `6-news detail.png` là bài 'CHIEF OPERATING OFFICER HOTEL/ RESORT CHAIN' với đầy đủ hình ảnh và thông tin chi tiết, đảm bảo trang không bao giờ bị lỗi 404 hay khoảng trống trắng."*

* **Câu hỏi 3: "Nút Share bài viết hoạt động như thế nào?"**
  * 👉 **Trả lời:** *"Dạ trong JavaScript của `template-news-detail.php`, em viết hàm `shareArticle()` sử dụng `navigator.clipboard.writeText(window.location.href)` để tự động sao chép đường link bài viết hiện tại vào bộ nhớ đệm (clipboard) của người dùng, đồng thời kích hoạt hiển thị thông báo Toast đẹp mắt góc dưới màn hình 'Đã sao chép liên kết bài viết vào bộ nhớ tạm!' trong 3 giây."*
