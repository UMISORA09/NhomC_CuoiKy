# TỔNG HỢP DANH SÁCH FILE CODE - TÍNH NĂNG TRANG CHỦ (HOME PAGE)
> **Sinh viên phụ trách:** Nguyễn Thanh Hiền  
> **Nhánh (Branch):** `Hien/1-home`  
> **Nhiệm vụ trong đồ án:** Tính năng 1 - Giao diện Trang Chủ chuẩn bản vẽ thiết kế `job-design/1-home.png`  
> *(Toàn bộ mã nguồn bên trong từng file PHP đã được gắn chú thích chi tiết từng dòng bằng tiếng Việt)*

---

## 📌 DANH SÁCH CÁC FILE PHP CỦA HIỀN

| STT | Tên File PHP | Chức năng chính |
| :---: | :--- | :--- |
| **1** | `template-home.php` | **File đầu não:** Truy vấn CSDL lấy 6 việc làm & 4 bài blog mới nhất, gán 6 logo thương hiệu và ghép nối giao diện trang chủ. |
| **2** | `front-page.php` | **Bộ điều hướng:** Tự động kích hoạt nạp `template-home.php` làm trang chủ mặc định của toàn bộ website. |
| **3** | `page-home.php` | **Trang tĩnh:** Nạp trang chủ khi người dùng truy cập qua đường dẫn tĩnh `/home/`. |
| **4** | `home-hero.php` | **Khối Banner & Search:** Banner ảnh lớn và form tìm kiếm việc làm theo từ khóa, địa điểm (SEARCH JOB). |
| **5** | `home-jobs.php` | **Khối Top Jobs:** Hiển thị lưới 6 việc làm tiêu biểu với logo đối tác, click toàn thẻ mở trang chi tiết việc làm. |
| **6** | `home-career.php` | **Khối Career:** Khung nền ảnh lớn giới thiệu cơ hội nghề nghiệp và tuyển dụng (CAREER WITH US). |
| **7** | `nhomc-career-content.php` | **Nội dung Career:** Bản văn mẫu về tinh thần Omotenashi và nút điều hướng "MORE ABOUT US". |
| **8** | `home-blogs.php` | **Khối Newest Blogs:** Hiển thị 4 bài blog mới nhất có ảnh đại diện vuông 180x180px và nút "Read More". |

---

## 🎯 CÂU HỎI & TRẢ LỜI MẪU KHI BẢO VỆ ĐỒ ÁN

* **Khi được hỏi: "Phần này em làm những gì?"**
  * 👉 **Trả lời:** *"Dạ em là Nguyễn Thanh Hiền, phụ trách Tính năng 1: Lập trình giao diện Trang Chủ (Home Page) theo chuẩn bản vẽ thiết kế `1-home.png`. Em xử lý truy vấn dữ liệu động từ WordPress để lấy 6 việc làm mới nhất và 4 bài blog mới nhất, chia các khối giao diện dạng Widget động (Hero Search, Top Jobs, Career With Us, Newest Blogs) và tạo kiểu CSS chuẩn màu cam thương hiệu của nhóm."*

* **Khi được hỏi: "Khi click vào thẻ việc làm ở trang chủ thì code hoạt động thế nào?"**
  * 👉 **Trả lời:** *"Dạ trong file `home-jobs.php`, mỗi thẻ việc làm em gắn sự kiện `onclick="window.location.href='...'"` dẫn sang trang xem chi tiết kèm theo mã ID công việc (`/job-detail/?job_id=...`), click vào bất kỳ đâu trên thẻ đều mở trang chi tiết."*
