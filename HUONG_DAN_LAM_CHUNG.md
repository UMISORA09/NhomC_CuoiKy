# HƯỚNG DẪN KẾT NỐI VÀ LÀM VIỆC CHUNG NHÓM C (FIT - TDC)
> **Dự án:** Hệ Thống Tuyển Dụng Việc Làm JobScout (Đồ Án Cuối Kỳ - Chuyên Đề CMS)  
> **Tài liệu tham chiếu:** Theo đúng yêu cầu trong tệp `7-huong-dan-jobwork.xlsx`

---

## 1. THÀNH VIÊN NHÓM C & PHÂN CÔNG VAI TRÒ
Hệ thống đã tích hợp sẵn tài khoản Quản trị viên (Administrator) cho từng thành viên với quyền hạn cao nhất:

| STT | Họ và Tên | Username | Email Đăng Nhập | Mật Khẩu Chung | Vai Trò & Phụ Trách |
| :---: | :--- | :--- | :--- | :---: | :--- |
| **1** | **Văn Nguyễn Xuân Hòa** | `xuanhoa` | `vhoa1682006@gmail.com` | `Password@123` | **Trưởng Nhóm** - Quản trị Git, DevOps, Docker |
| **2** | **Nguyễn Thanh Hiền** | `thanhhien` | `thenghien2006@gmail.com` | `Password@123` | **Thành viên** - UI/UX & Quản lý bài viết |
| **3** | **Huỳnh Văn Vinh Em** | `vinhem` | `trumvinh85@gmail.com` | `Password@123` | **Thành viên** - CSDL MySQL & Quản trị dữ liệu |
| **4** | **Nguyễn Anh Quý** | `anhquy` | `nguyquy67@gmail.com` | `Password@123` | **Thành viên** - Tùy biến Theme JobScout |
| **5** | **Đặng Đăng Nguyên** | `dangnguyen` | `dn1275102@gmail.com` | `Password@123` | **Thành viên** - Kiểm thử chức năng, Báo cáo |
| **6** | **Tài khoản Chung Nhóm** | `admin_nhomc` | `admin_nhomc@fit.tdc.edu.vn` | `Password@123` | Quản trị viên tổng hệ thống |

---

## 2. CẤU TRÚC PHÂN NHÁNH GIT & CSDL THEO ĐÚNG HÌNH ẢNH HƯỚNG DẪN

Theo đúng sơ đồ quy định trong tệp Excel của giảng viên:

```text
Local Branches / Origin:
├── 1-core    : Source core WordPress 6.0.2 sạch, KHÔNG ĐƯỢC CODE Ở ĐÂY
├── 1-master  : Source chính của nhóm (chứa toàn bộ giao diện & tính năng hoàn chỉnh)
├── 3-job     : Source phát triển công việc, trạng thái đang phát triển
└── main      : Nhánh mặc định sơ khai
```

- **Tên Cơ Sở Dữ Liệu (Database):** `wordpress_602_core` (và `wordpress`)
- **Tên miền VirtualHost (Bước 2):** `http://wordpress.local:8080` (hoặc `http://wordpressc:8080`)

---

## 3. QUY TRÌNH 1-CLICK DÀNH CHO THÀNH VIÊN MỚI (CHẠY LÀ CÓ NGAY)

Khi một thành viên trong nhóm clone project về máy cá nhân:

```bash
git clone git@github.com:UMISORA09/NhomC_CuoiKy.git
cd NhomC_CuoiKy
git checkout 1-master
```

### Bước 1: Thiết lập tên miền Virtual Host (Chỉ cần chạy 1 lần)
- Chuột phải vào file `setup-hosts.bat` chọn **Run as Administrator** (hoặc mở menu terminal gõ phím `H`).
- Script sẽ tự động thêm các tên miền vào file `hosts`:
  - `wordpress.local` (Chuẩn theo file Excel của giảng viên)
  - `wordpressc` & `WordpressC.local`

### Bước 2: Khởi động toàn diện hệ thống
- Nhấp đúp chuột vào tệp `start.bat`.
- Hệ thống sẽ:
  1. Tự động bật Docker containers (`wordpress_db`, `wordpress_app`, `wordpress_phpmyadmin`).
  2. Tự động nạp CSDL `wordpress` độc lập.
  3. Kích hoạt Theme JobScout và 5 Plugins chuẩn đồ án (bao gồm `wpjm-company-profile-page` - Company Profile Page for WPJM theo gợi ý dòng 549 trong Excel).
  4. Tạo 6 tài khoản Administrator cho các thành viên.
  5. Thiết lập sẵn 5 Hồ Sơ Doanh Nghiệp (Company Profiles) gắn liền với 25 tin tuyển dụng.
  5. Nạp toàn bộ 25 việc làm của 5 công ty và 5 bài viết cẩm nang nghề nghiệp.
  6. Mở **Cửa sổ điều khiển 2D WebOS** và trình duyệt web.

---

## 3. CÁC ĐỊA CHỈ TRUY CẬP HỆ THỐNG

| Dịch vụ | Tên miền Virtual Host (Khuyên dùng) | Địa chỉ phụ / Localhost |
| :--- | :--- | :--- |
| **Website JobScout** | `http://wordpress.local:8080` hoặc `http://wordpressc:8080` | `http://localhost:8080` |
| **Trang Quản trị WP-Admin** | `http://wordpress.local:8080/wp-admin` | `http://localhost:8080/wp-admin` |
| **phpMyAdmin Quản lý CSDL** | `http://wordpressc:8085` | `http://localhost:8085` |
| **Bảng điều khiển 2D WebOS** | `http://wordpressc:8080/dashboard.html` | `http://localhost:8080/dashboard.html` |

### Kết nối chung trong mạng nội bộ (LAN / WiFi cùng phòng):
Nếu các thành viên làm việc chung cùng mạng WiFi:
- Máy chủ (máy bật Docker) mở CMD gõ `ipconfig` lấy địa chỉ IPv4 (Ví dụ: `192.168.1.15`).
- Tất cả các máy thành viên khác có thể truy cập trực tiếp qua:
  `http://192.168.1.15:8080`
- Hệ thống đã được cấu hình nhận diện Domain động (`$_SERVER['HTTP_HOST']`), đảm bảo hiển thị đúng 100% hình ảnh, CSS và liên kết trên tất cả các máy kết nối.

---

## 4. BẢNG DỮ LIỆU ĐÃ NẠP (CHUẨN THEO FILE EXCEL 7-HUONG-DAN-JOBWORK)

### Danh sách 5 Công ty & 25 Vị trí việc làm còn hạn (Hạn nộp: 31/12/2028):
1. **Plan Do See Global (PDS):**
   - Chief Operating Officer Hotel / Resort Chain (TP.HCM)
   - Hotel General Manager (TP.HCM)
   - Banquet & Events Manager (Hà Nội)
   - Front Desk Supervisor (Đà Nẵng)
   - Executive Sous Chef (TP.HCM)
2. **FPT Software Vietnam:**
   - Senior Fullstack Developer (PHP / React) (TP.HCM)
   - Cloud DevOps Engineer (AWS / Docker) (Hà Nội)
   - IT Project Manager (PMP / Agile) (Đà Nẵng)
   - AI & Data Engineer (TP.HCM)
   - QA / Automation Tester (Cần Thơ)
3. **Viettel Digital Solutions:**
   - Solution Architect - Fintech Platform (Hà Nội)
   - Senior Backend Developer (Java / Go) (TP.HCM)
   - Cyber Security Specialist (Hà Nội)
   - Product Owner - Digital Wallet (TP.HCM)
   - Data Analyst & Business Intelligence (Đà Nẵng)
4. **VNG Corporation:**
   - Senior Game Developer (Unity / C++) (TP.HCM)
   - Mobile App Developer (Flutter / Swift) (TP.HCM)
   - Senior UI/UX Product Designer (TP.HCM)
   - Digital Marketing Lead (Hà Nội)
   - System Operations Engineer (SRE) (TP.HCM)
5. **MoMo Financial Technology:**
   - Fintech Product Manager (TP.HCM)
   - Lead Frontend Engineer (Next.js / Vue) (TP.HCM)
   - Data Scientist - Fraud Detection (TP.HCM)
   - Business Development Manager (Hà Nội)
   - Customer Experience Supervisor (TP.HCM)

### Các Trang bắt buộc dành cho Nhóm 5 Sinh viên (Sheet 2):
- **Trang Chủ:** `/home`
- **Trang Giới Thiệu (Bắt buộc với nhóm 5SV):** `/about-us`
- **Trang Liên Hệ (Bắt buộc với nhóm 5SV):** `/contact-us`
- **Trang Tìm kiếm việc làm:** `/jobs` (và `/all-jobs`)
- **Trang Tin tức / Blog:** `/blog` (và `/news`)
- **Hồ sơ Doanh nghiệp (Company Profiles - Plugin WPJM Company Profile Page):**
  - Quản lý công ty: Menu **Job Listings > Companies** trong WP Admin
  - VNG Corporation: `/company/vng-corporation/`
  - FPT Software Vietnam: `/company/fpt-software-vietnam/`
  - Viettel Digital Solutions: `/company/viettel-digital-solutions/`
  - MoMo Financial Technology: `/company/momo-financial-technology/`
  - Plan Do See Global (PDS): `/company/plan-do-see-global-pds/`
  - *Mỗi trang công ty tự động tổng hợp đầy đủ mô tả công ty, website chính thức và danh sách tất cả các việc làm của công ty đó!*

---

## 5. QUY TẮC LÀM VIỆC CHUNG TRÊN GIT

1. **Luôn làm việc trên nhánh `master`:**
   ```bash
   git checkout master
   git pull origin master
   ```
2. **Trước khi bắt đầu làm:**
   - Chạy `git pull origin master` để lấy những cập nhật mới nhất từ đồng đội.
3. **Khi thay đổi Database (thêm bài viết / tùy biến):**
   - Mở `start.bat` -> vào tab **CSDL & DOCKER** -> nhấn phím `[X]` để Backup CSDL tự động ra thư mục `backups/`.
   - File backup `.sql` được lưu kèm ngày giờ, cam kết không bị mất dữ liệu.
4. **Khi đẩy code lên Git:**
   ```bash
   git add .
   git commit -m "feat: [tên-bạn] mô tả công việc vừa làm"
   git push origin master
   ```
5. **Tuyệt đối không đụng chạm dự án FIT-TDC:**
   - Cơ sở dữ liệu của dự án này là `wordpress` (Cổng 3307).
   - Không can thiệp vào container `wordpressc_db` hoặc database `cms_nhomc` của môn học khác.
