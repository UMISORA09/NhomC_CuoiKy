# TỔNG HỢP DANH SÁCH FILE CODE - TÍNH NĂNG TIN TỨC (NEWS / BLOG PAGE)
> **Sinh viên phụ trách:** Nguyễn Xuân Hòa  
> **Email:** `vhoa1682006@gmail.com`  
> **Nhánh (Branch):** `xuanhoa/3-news`  
> **Nhiệm vụ trong đồ án:** Tính năng 3 - Giao diện Trang Tin Tức chuẩn bản vẽ thiết kế `job-design/3-news.png`  
> *(Toàn bộ mã nguồn bên trong từng file PHP đã được gắn chú thích chi tiết từng dòng bằng tiếng Việt)*

---

## 📌 DANH SÁCH CÁC FILE PHP CỦA XUÂN HÒA (TÍNH NĂNG 3)

| STT | Tên File PHP | Đường dẫn file | Chức năng chính |
| :---: | :--- | :--- | :--- |
| **1** | `template-news.php` | `wp-content/themes/jobscout/template-news.php` | **File đầu não trang Tin tức:** Khởi tạo danh mục 8 bài viết mẫu chuẩn thiết kế kèm fallback truy vấn CSDL WordPress (`get_posts`), tích hợp Header, Footer dùng chung, hàm chuẩn `wp_body_open()` và kết nối vùng Widget động `nhomc-blog`. |
| **2** | `blog-hero.php` | `wp-content/themes/jobscout/template-parts/widgets/blog-hero.php` | **Khối Banner PDS NEWS:** Hiển thị ảnh bìa sắc nét kích thước lớn với tiêu đề "PDS NEWS", tích hợp trực tiếp vào Customizer (Sửa giao diện). |
| **3** | `blog-list.php` | `wp-content/themes/jobscout/template-parts/widgets/blog-list.php` | **Khối Danh sách Tin tức:** Hiển thị lưới bài viết 2 cột chuẩn thiết kế với tiêu đề động "NEWEST BLOG ENTRIES", ảnh đại diện 200x200, mô tả tiếng Việt và nút "Read More" dẫn trực tiếp sang trang chi tiết (`/news-detail/?post=...`). Toàn thẻ card có hiệu ứng hover và click mở bài viết. |
| **4** | `page-news.php` | `wp-content/themes/jobscout/page-news.php` | **Bộ điều hướng URL:** Tự động nạp `template-news.php` khi người dùng truy cập qua đường dẫn tĩnh `/news/` hoặc `/blog/`. |

---

## 🎨 TÍNH NĂNG "SỬA GIAO DIỆN" (WORDPRESS THEME CUSTOMIZER)
- Khi quản trị viên đăng nhập vào website và xem trang Tin tức, thanh công cụ WordPress Admin Bar trên cùng hiển thị nút **[Biểu tượng cây cọ] Sửa giao diện** (`/wp-admin/customize.php`).
- Trong giao diện Tùy biến, mục **Cấu hình cột tiện ích** hiển thị vùng widget riêng biệt:
  - **Nhóm C — Blog — Banner và bài viết** (`nhomc-blog`):
    1. *Khối Banner Blog:* Banner ảnh PDS NEWS sắc nét chuẩn bản vẽ 3-news.png.
    2. *Khối Danh sách bài viết Blog:* Quản trị viên có thể đổi tiêu đề (mặc định là `NEWEST BLOG ENTRIES`), sắp xếp lại thứ tự hoặc nhúng thêm các khối nội dung HTML tùy biến theo ý muốn.
- Hỗ trợ đầy đủ hook `wp_body_open()` và `wp_head()`, `wp_footer()` giúp khung Preview của Customizer cập nhật thời gian thực không bị giật lag hay mất thanh công cụ.

---

## 🎯 CÂU HỎI & TRẢ LỜI MẪU KHI BẢO VỆ ĐỒ ÁN (VẤN ĐÁP)

* **Câu hỏi 1: "Em phụ trách phần nào trong đồ án và đã làm được những gì?"**
  * 👉 **Trả lời:** *"Dạ em là Nguyễn Xuân Hòa, phụ trách Tính năng 3: Lập trình giao diện Trang Tin tức (News / Blog Page) theo chuẩn bản vẽ thiết kế `3-news.png`. Em đã hoàn thành giao diện chuẩn 100% bản vẽ gồm banner PDS NEWS, lưới 8 bài viết mới nhất có tóm tắt tiếng Việt giàu ngữ cảnh, hiệu ứng rê chuột nổi bật và nút Read More. Đồng thời em tích hợp trang vào hệ thống Widget 'nhomc-blog' để quản trị viên có thể dùng tính năng 'Sửa giao diện' (Customizer) chỉnh sửa tiêu đề và bố cục trực quan."*

* **Câu hỏi 2: "Tại sao khi click vào bài viết hoặc nút Read More thì mở đúng nội dung chi tiết?"**
  * 👉 **Trả lời:** *"Dạ trong file `template-news.php` và `blog-list.php`, mỗi bài viết em gắn đường dẫn động kèm tham số định danh định dạng `home_url('/news-detail/?post=' . urlencode($slug))`. Khi người dùng click vào thẻ hoặc nút Read More, hệ thống sẽ chuyển hướng sang trang Tính năng 6 (`/news-detail/`), nơi tham số `post` được đọc để hiển thị chính xác tiêu đề, ảnh thumbnail, danh mục và 3 đoạn văn bản chi tiết tương ứng của bài viết đó."*

* **Câu hỏi 3: "Trang tin tức này kết nối với tính năng Sửa giao diện (Customizer) của WordPress như thế nào?"**
  * 👉 **Trả lời:** *"Dạ em sử dụng kiến trúc Widget chuẩn của WordPress thông qua hàm `nhomc_render_page_widgets('nhomc-blog', compact('news_items'))`. Vùng widget này đã đăng ký 2 khối: banner hero và danh sách bài viết. Khi vào Customizer qua nút 'Sửa giao diện', mục 'Cấu hình cột tiện ích' cho phép thay đổi tiêu đề 'NEWEST BLOG ENTRIES' hoặc cấu hình thêm HTML mà không cần sửa trực tiếp vào file code."*
