SET NAMES utf8mb4;

        INSERT INTO wp_terms (name, slug, term_group)
        SELECT 'Job Category', 'job-category', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = 'job-category');

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'category', 'Job Category', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'job-category'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'category');
        

        INSERT INTO wp_terms (name, slug, term_group)
        SELECT 'Hotel Management', 'hotel-management', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = 'hotel-management');

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'job_listing_category', 'Hotel Management', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'hotel-management'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'job_listing_category');
        

        INSERT INTO wp_terms (name, slug, term_group)
        SELECT 'Hospitality', 'hospitality', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = 'hospitality');

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'job_listing_category', 'Hospitality', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'hospitality'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'job_listing_category');
        

        INSERT INTO wp_terms (name, slug, term_group)
        SELECT 'Operations', 'operations', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = 'operations');

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'job_listing_category', 'Operations', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'operations'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'job_listing_category');
        

        INSERT INTO wp_terms (name, slug, term_group)
        SELECT 'Information Technology', 'information-technology', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = 'information-technology');

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'job_listing_category', 'Information Technology', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'information-technology'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'job_listing_category');
        

        INSERT INTO wp_terms (name, slug, term_group)
        SELECT 'Marketing & Sales', 'marketing-sales', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = 'marketing-sales');

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'job_listing_category', 'Marketing & Sales', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'marketing-sales'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'job_listing_category');
        

        INSERT INTO wp_terms (name, slug, term_group)
        SELECT 'Project Development', 'project-development', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = 'project-development');

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'category', 'Project Development', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'project-development'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'category');
        

        INSERT INTO wp_terms (name, slug, term_group)
        SELECT 'News & Career Tips', 'news-career-tips', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = 'news-career-tips');

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'category', 'News & Career Tips', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'news-career-tips'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'category');
        

        -- Page: Home
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<h1>TÌM KIẾM VIỆC LÀM MƠ ƯỚC CÙNG JOBSCOUT</h1>
<p>Hệ thống kết nối việc làm thông minh với hàng trăm cơ hội nghề nghiệp hấp dẫn từ các tập đoàn công nghệ, khách sạn và dịch vụ hàng đầu.</p>

<h2>CƠ HỘI NGHỀ NGHIỆP NỔI BẬT</h2>
<p>Khám phá các vị trí việc làm chất lượng cao từ 5 tập đoàn đối tác chiến lược: Plan Do See, FPT Software, Viettel Solutions, VNG Corporation và Momo.</p>
', 'Home', '',
            'publish', 'closed', 'closed', '', 'home', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'home' AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = '<h1>TÌM KIẾM VIỆC LÀM MƠ ƯỚC CÙNG JOBSCOUT</h1>
<p>Hệ thống kết nối việc làm thông minh với hàng trăm cơ hội nghề nghiệp hấp dẫn từ các tập đoàn công nghệ, khách sạn và dịch vụ hàng đầu.</p>

<h2>CƠ HỘI NGHỀ NGHIỆP NỔI BẬT</h2>
<p>Khám phá các vị trí việc làm chất lượng cao từ 5 tập đoàn đối tác chiến lược: Plan Do See, FPT Software, Viettel Solutions, VNG Corporation và Momo.</p>
',
            post_title = 'Home',
            post_status = 'publish'
        WHERE post_name = 'home' AND post_type = 'page';
        

        -- Page: About Us
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<h2>SHARE ''OMOTENASHI'' WITH THE WORLD</h2>
<p><strong>GIỚI THIỆU VỀ JOBSCOUT & ĐỘI NGŨ PHÁT TRIỂN NHÓM C</strong></p>

<h3>Tầm Nhìn Của Chúng Tôi</h3>
<p>Xây dựng nền tảng kết nối ứng viên và nhà tuyển dụng hàng đầu, mang lại cơ hội nghề nghiệp chất lượng cao, minh bạch và hiệu quả nhất cho sinh viên và người đi làm.</p>

<h3>Sứ Mệnh</h3>
<p>Chia sẻ tinh thần phục vụ tận tâm, kết nối nhân tài với các doanh nghiệp uy tín hàng đầu trong và ngoài nước.</p>

<h3>Đội Ngũ Dự Án - Nhóm C (Khoa CNTT - FIT TDC)</h3>
<table class="table table-bordered">
<thead>
<tr><th>STT</th><th>Họ và Tên</th><th>MSSV / Email</th><th>Vai Trò Nhiệm Vụ</th></tr>
</thead>
<tbody>
<tr><td>1</td><td>Văn Nguyễn Xuân Hòa</td><td>vhoa1682006@gmail.com</td><td>Trưởng Nhóm / Lead DevOps & Fullstack</td></tr>
<tr><td>2</td><td>Nguyễn Thanh Hiền</td><td>thenghien2006@gmail.com</td><td>Thành Viên / UI-UX & Content Manager</td></tr>
<tr><td>3</td><td>Huỳnh Văn Vinh Em</td><td>trumvinh85@gmail.com</td><td>Thành Viên / Database & Backend Developer</td></tr>
<tr><td>4</td><td>Nguyễn Anh Quý</td><td>nguyquy67@gmail.com</td><td>Thành Viên / Frontend & Theme Customizer</td></tr>
<tr><td>5</td><td>Đặng Đăng Nguyên</td><td>dn1275102@gmail.com</td><td>Thành Viên / QA Testing & Documentation</td></tr>
</tbody>
</table>
', 'About Us', '',
            'publish', 'closed', 'closed', '', 'about-us', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'about-us' AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = '<h2>SHARE ''OMOTENASHI'' WITH THE WORLD</h2>
<p><strong>GIỚI THIỆU VỀ JOBSCOUT & ĐỘI NGŨ PHÁT TRIỂN NHÓM C</strong></p>

<h3>Tầm Nhìn Của Chúng Tôi</h3>
<p>Xây dựng nền tảng kết nối ứng viên và nhà tuyển dụng hàng đầu, mang lại cơ hội nghề nghiệp chất lượng cao, minh bạch và hiệu quả nhất cho sinh viên và người đi làm.</p>

<h3>Sứ Mệnh</h3>
<p>Chia sẻ tinh thần phục vụ tận tâm, kết nối nhân tài với các doanh nghiệp uy tín hàng đầu trong và ngoài nước.</p>

<h3>Đội Ngũ Dự Án - Nhóm C (Khoa CNTT - FIT TDC)</h3>
<table class="table table-bordered">
<thead>
<tr><th>STT</th><th>Họ và Tên</th><th>MSSV / Email</th><th>Vai Trò Nhiệm Vụ</th></tr>
</thead>
<tbody>
<tr><td>1</td><td>Văn Nguyễn Xuân Hòa</td><td>vhoa1682006@gmail.com</td><td>Trưởng Nhóm / Lead DevOps & Fullstack</td></tr>
<tr><td>2</td><td>Nguyễn Thanh Hiền</td><td>thenghien2006@gmail.com</td><td>Thành Viên / UI-UX & Content Manager</td></tr>
<tr><td>3</td><td>Huỳnh Văn Vinh Em</td><td>trumvinh85@gmail.com</td><td>Thành Viên / Database & Backend Developer</td></tr>
<tr><td>4</td><td>Nguyễn Anh Quý</td><td>nguyquy67@gmail.com</td><td>Thành Viên / Frontend & Theme Customizer</td></tr>
<tr><td>5</td><td>Đặng Đăng Nguyên</td><td>dn1275102@gmail.com</td><td>Thành Viên / QA Testing & Documentation</td></tr>
</tbody>
</table>
',
            post_title = 'About Us',
            post_status = 'publish'
        WHERE post_name = 'about-us' AND post_type = 'page';
        

        -- Page: News
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<p>Tổng hợp các tin tức tuyển dụng, kỹ năng phỏng vấn và xu hướng nghề nghiệp mới nhất.</p>', 'News', '',
            'publish', 'closed', 'closed', '', 'news', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'news' AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = '<p>Tổng hợp các tin tức tuyển dụng, kỹ năng phỏng vấn và xu hướng nghề nghiệp mới nhất.</p>',
            post_title = 'News',
            post_status = 'publish'
        WHERE post_name = 'news' AND post_type = 'page';
        

        -- Page: Blog
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<p>Trang chia sẻ kinh nghiệm ứng tuyển và cẩm nang việc làm JobScout.</p>', 'Blog', '',
            'publish', 'closed', 'closed', '', 'blog', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'blog' AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = '<p>Trang chia sẻ kinh nghiệm ứng tuyển và cẩm nang việc làm JobScout.</p>',
            post_title = 'Blog',
            post_status = 'publish'
        WHERE post_name = 'blog' AND post_type = 'page';
        

        -- Page: All Jobs
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<p>Danh sách tất cả các vị trí việc làm đang tuyển dụng còn hạn.</p>', 'All Jobs', '',
            'publish', 'closed', 'closed', '', 'all-jobs', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'all-jobs' AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = '<p>Danh sách tất cả các vị trí việc làm đang tuyển dụng còn hạn.</p>',
            post_title = 'All Jobs',
            post_status = 'publish'
        WHERE post_name = 'all-jobs' AND post_type = 'page';
        

        -- Page: Jobs
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<p>Trang tìm kiếm việc làm chuyên sâu theo ngành nghề và khu vực.</p>', 'Jobs', '',
            'publish', 'closed', 'closed', '', 'jobs', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'jobs' AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = '<p>Trang tìm kiếm việc làm chuyên sâu theo ngành nghề và khu vực.</p>',
            post_title = 'Jobs',
            post_status = 'publish'
        WHERE post_name = 'jobs' AND post_type = 'page';
        

        -- Page: Contact Us
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<h2>LIÊN HỆ VỚI CHÚNG TÔI</h2>
<p>Trung tâm Hỗ trợ Ứng viên & Nhà tuyển dụng JobScout - Nhóm C</p>

<h3>Văn Phòng Chính</h3>
<p><strong>Địa chỉ:</strong> 53 Võ Văn Ngân, Phường Linh Chiểu, TP. Thủ Đức, TP. Hồ Chí Minh (FIT - TDC)</p>

<h3>Dành Cho Nhà Tuyển Dụng</h3>
<p>Hotline Đăng tin: (028) 3896 6825<br>
Email hợp tác: admin_nhomc@fit.tdc.edu.vn<br>
Hỗ trợ trực tiếp từ đội ngũ Quản trị viên Nhóm C.</p>

<h3>Dành Cho Ứng Viên Tìm Việc</h3>
<p>Hỗ trợ ứng tuyển nhanh, tư vấn sửa CV miễn phí và nhận thông báo việc làm mới mỗi ngày.<br>
Hotline tư vấn nghề nghiệp: 1900 6868</p>
', 'Contact Us', '',
            'publish', 'closed', 'closed', '', 'contact-us', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'contact-us' AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = '<h2>LIÊN HỆ VỚI CHÚNG TÔI</h2>
<p>Trung tâm Hỗ trợ Ứng viên & Nhà tuyển dụng JobScout - Nhóm C</p>

<h3>Văn Phòng Chính</h3>
<p><strong>Địa chỉ:</strong> 53 Võ Văn Ngân, Phường Linh Chiểu, TP. Thủ Đức, TP. Hồ Chí Minh (FIT - TDC)</p>

<h3>Dành Cho Nhà Tuyển Dụng</h3>
<p>Hotline Đăng tin: (028) 3896 6825<br>
Email hợp tác: admin_nhomc@fit.tdc.edu.vn<br>
Hỗ trợ trực tiếp từ đội ngũ Quản trị viên Nhóm C.</p>

<h3>Dành Cho Ứng Viên Tìm Việc</h3>
<p>Hỗ trợ ứng tuyển nhanh, tư vấn sửa CV miễn phí và nhận thông báo việc làm mới mỗi ngày.<br>
Hotline tư vấn nghề nghiệp: 1900 6868</p>
',
            post_title = 'Contact Us',
            post_status = 'publish'
        WHERE post_name = 'contact-us' AND post_type = 'page';
        

        -- News Post: Bí Quyết Viết CV Chuyên Nghiệp Dành Cho Sinh Viên Mới Ra Trường
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<p>Hướng dẫn chi tiết cách trình bày CV ấn tượng, làm nổi bật kỹ năng và dự án thực tế giúp bạn ghi điểm tuyệt đối trong mắt nhà tuyển dụng ngay từ vòng lọc hồ sơ đầu tiên.</p>', 'Bí Quyết Viết CV Chuyên Nghiệp Dành Cho Sinh Viên Mới Ra Trường', '',
            'publish', 'open', 'open', '', 'bi-quyet-viet-cv-chuyen-nghiep-2026', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'post', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'bi-quyet-viet-cv-chuyen-nghiep-2026' AND post_type = 'post');

        UPDATE wp_posts
        SET post_content = '<p>Hướng dẫn chi tiết cách trình bày CV ấn tượng, làm nổi bật kỹ năng và dự án thực tế giúp bạn ghi điểm tuyệt đối trong mắt nhà tuyển dụng ngay từ vòng lọc hồ sơ đầu tiên.</p>',
            post_title = 'Bí Quyết Viết CV Chuyên Nghiệp Dành Cho Sinh Viên Mới Ra Trường',
            post_status = 'publish'
        WHERE post_name = 'bi-quyet-viet-cv-chuyen-nghiep-2026' AND post_type = 'post';
        

        -- News Post: Top 5 Kỹ Năng Quan Trọng Nhất Giúp Ứng Viên Vượt Qua Vòng Phỏng Vấn
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<p>Khám phá cách trả lời câu hỏi hành vi theo mô hình STAR, cách đàm phán mức lương tự tin và xử lý các tình huống hóc búa từ hội đồng tuyển dụng.</p>', 'Top 5 Kỹ Năng Quan Trọng Nhất Giúp Ứng Viên Vượt Qua Vòng Phỏng Vấn', '',
            'publish', 'open', 'open', '', 'top-5-ky-nang-phong-van-thanh-cong', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'post', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'top-5-ky-nang-phong-van-thanh-cong' AND post_type = 'post');

        UPDATE wp_posts
        SET post_content = '<p>Khám phá cách trả lời câu hỏi hành vi theo mô hình STAR, cách đàm phán mức lương tự tin và xử lý các tình huống hóc búa từ hội đồng tuyển dụng.</p>',
            post_title = 'Top 5 Kỹ Năng Quan Trọng Nhất Giúp Ứng Viên Vượt Qua Vòng Phỏng Vấn',
            post_status = 'publish'
        WHERE post_name = 'top-5-ky-nang-phong-van-thanh-cong' AND post_type = 'post';
        

        -- News Post: Xu Hướng Tuyển Dụng Ngành Công Nghệ Thông Tin & Dịch Vụ 2026
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<p>Phân tích nhu cầu nhân lực trong các lĩnh vực Cloud, AI, DevOps, Quản trị nhà hàng khách sạn cao cấp và cơ hội phát triển sự nghiệp bền vững.</p>', 'Xu Hướng Tuyển Dụng Ngành Công Nghệ Thông Tin & Dịch Vụ 2026', '',
            'publish', 'open', 'open', '', 'xu-huong-tuyen-dung-it-dich-vu-2026', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'post', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'xu-huong-tuyen-dung-it-dich-vu-2026' AND post_type = 'post');

        UPDATE wp_posts
        SET post_content = '<p>Phân tích nhu cầu nhân lực trong các lĩnh vực Cloud, AI, DevOps, Quản trị nhà hàng khách sạn cao cấp và cơ hội phát triển sự nghiệp bền vững.</p>',
            post_title = 'Xu Hướng Tuyển Dụng Ngành Công Nghệ Thông Tin & Dịch Vụ 2026',
            post_status = 'publish'
        WHERE post_name = 'xu-huong-tuyen-dung-it-dich-vu-2026' AND post_type = 'post';
        

        -- News Post: Nghệ Thuật Phục Vụ Tận Tâm 'Omotenashi' Trong Quản Trị Khách Sạn Cao Cấp
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<p>Tìm hiểu triết lý hiếu khách Omotenashi của Nhật Bản và cách ứng dụng vào dịch vụ lưu trú 5 sao để nâng tầm trải nghiệm của khách hàng.</p>', 'Nghệ Thuật Phục Vụ Tận Tâm ''Omotenashi'' Trong Quản Trị Khách Sạn Cao Cấp', '',
            'publish', 'open', 'open', '', 'nghe-thuat-phuc-vu-omotenashi-khach-san', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'post', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'nghe-thuat-phuc-vu-omotenashi-khach-san' AND post_type = 'post');

        UPDATE wp_posts
        SET post_content = '<p>Tìm hiểu triết lý hiếu khách Omotenashi của Nhật Bản và cách ứng dụng vào dịch vụ lưu trú 5 sao để nâng tầm trải nghiệm của khách hàng.</p>',
            post_title = 'Nghệ Thuật Phục Vụ Tận Tâm ''Omotenashi'' Trong Quản Trị Khách Sạn Cao Cấp',
            post_status = 'publish'
        WHERE post_name = 'nghe-thuat-phuc-vu-omotenashi-khach-san' AND post_type = 'post';
        

        -- News Post: Lộ Trình Phát Triển Từ Lập Trình Viên Trở Thành Quản Lý Dự Án
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<p>Chia sẻ kinh nghiệm thực tế về việc trau dồi kỹ năng quản trị, giao tiếp và giải quyết xung đột khi chuyển dịch từ vai trò kỹ thuật sang quản lý dự án chuyên nghiệp.</p>', 'Lộ Trình Phát Triển Từ Lập Trình Viên Trở Thành Quản Lý Dự Án', '',
            'publish', 'open', 'open', '', 'lo-trinh-tu-developer-len-project-manager', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'post', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'lo-trinh-tu-developer-len-project-manager' AND post_type = 'post');

        UPDATE wp_posts
        SET post_content = '<p>Chia sẻ kinh nghiệm thực tế về việc trau dồi kỹ năng quản trị, giao tiếp và giải quyết xung đột khi chuyển dịch từ vai trò kỹ thuật sang quản lý dự án chuyên nghiệp.</p>',
            post_title = 'Lộ Trình Phát Triển Từ Lập Trình Viên Trở Thành Quản Lý Dự Án',
            post_status = 'publish'
        WHERE post_name = 'lo-trinh-tu-developer-len-project-manager' AND post_type = 'post';
        

            -- Job: CHIEF OPERATING OFFICER HOTEL / RESORT CHAIN (Plan Do See Global (PDS))
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>CHIEF OPERATING OFFICER HOTEL / RESORT CHAIN - Plan Do See Global (PDS)</h2>
<p><strong>Công ty:</strong> Plan Do See Global (PDS) (Tap doan quan ly chuoi khach san va resort 5 sao quoc te)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'CHIEF OPERATING OFFICER HOTEL / RESORT CHAIN', 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te',
                'publish', 'closed', 'closed', '', 'coo-hotel-resort-chain', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>CHIEF OPERATING OFFICER HOTEL / RESORT CHAIN - Plan Do See Global (PDS)</h2>
<p><strong>Công ty:</strong> Plan Do See Global (PDS) (Tap doan quan ly chuoi khach san va resort 5 sao quoc te)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'CHIEF OPERATING OFFICER HOTEL / RESORT CHAIN',
                post_excerpt = 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te',
                post_status = 'publish'
            WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'Plan Do See Global (PDS)'
                FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://plandosee.co.jp'
                FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te'
                FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '1'
                FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain' AND post_type = 'job_listing';
                

            -- Job: HOTEL GENERAL MANAGER (Plan Do See Global (PDS))
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>HOTEL GENERAL MANAGER - Plan Do See Global (PDS)</h2>
<p><strong>Công ty:</strong> Plan Do See Global (PDS) (Tap doan quan ly chuoi khach san va resort 5 sao quoc te)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'HOTEL GENERAL MANAGER', 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te',
                'publish', 'closed', 'closed', '', 'hotel-general-manager-pds', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>HOTEL GENERAL MANAGER - Plan Do See Global (PDS)</h2>
<p><strong>Công ty:</strong> Plan Do See Global (PDS) (Tap doan quan ly chuoi khach san va resort 5 sao quoc te)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'HOTEL GENERAL MANAGER',
                post_excerpt = 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te',
                post_status = 'publish'
            WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'Plan Do See Global (PDS)'
                FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://plandosee.co.jp'
                FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te'
                FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'hotel-general-manager-pds' AND post_type = 'job_listing';
                

            -- Job: BANQUET & EVENTS MANAGER (Plan Do See Global (PDS))
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>BANQUET & EVENTS MANAGER - Plan Do See Global (PDS)</h2>
<p><strong>Công ty:</strong> Plan Do See Global (PDS) (Tap doan quan ly chuoi khach san va resort 5 sao quoc te)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'BANQUET & EVENTS MANAGER', 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te',
                'publish', 'closed', 'closed', '', 'banquet-events-manager-pds', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>BANQUET & EVENTS MANAGER - Plan Do See Global (PDS)</h2>
<p><strong>Công ty:</strong> Plan Do See Global (PDS) (Tap doan quan ly chuoi khach san va resort 5 sao quoc te)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'BANQUET & EVENTS MANAGER',
                post_excerpt = 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te',
                post_status = 'publish'
            WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ha Noi'
                FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'Plan Do See Global (PDS)'
                FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://plandosee.co.jp'
                FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te'
                FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'banquet-events-manager-pds' AND post_type = 'job_listing';
                

            -- Job: FRONT DESK SUPERVISOR (Plan Do See Global (PDS))
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>FRONT DESK SUPERVISOR - Plan Do See Global (PDS)</h2>
<p><strong>Công ty:</strong> Plan Do See Global (PDS) (Tap doan quan ly chuoi khach san va resort 5 sao quoc te)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'FRONT DESK SUPERVISOR', 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te',
                'publish', 'closed', 'closed', '', 'front-desk-supervisor-pds', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>FRONT DESK SUPERVISOR - Plan Do See Global (PDS)</h2>
<p><strong>Công ty:</strong> Plan Do See Global (PDS) (Tap doan quan ly chuoi khach san va resort 5 sao quoc te)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'FRONT DESK SUPERVISOR',
                post_excerpt = 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te',
                post_status = 'publish'
            WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Da Nang'
                FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'Plan Do See Global (PDS)'
                FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://plandosee.co.jp'
                FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te'
                FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'front-desk-supervisor-pds' AND post_type = 'job_listing';
                

            -- Job: EXECUTIVE SOUS CHEF (Plan Do See Global (PDS))
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>EXECUTIVE SOUS CHEF - Plan Do See Global (PDS)</h2>
<p><strong>Công ty:</strong> Plan Do See Global (PDS) (Tap doan quan ly chuoi khach san va resort 5 sao quoc te)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'EXECUTIVE SOUS CHEF', 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te',
                'publish', 'closed', 'closed', '', 'executive-sous-chef-pds', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>EXECUTIVE SOUS CHEF - Plan Do See Global (PDS)</h2>
<p><strong>Công ty:</strong> Plan Do See Global (PDS) (Tap doan quan ly chuoi khach san va resort 5 sao quoc te)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'EXECUTIVE SOUS CHEF',
                post_excerpt = 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te',
                post_status = 'publish'
            WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'Plan Do See Global (PDS)'
                FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://plandosee.co.jp'
                FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Tap doan quan ly chuoi khach san va resort 5 sao quoc te'
                FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'executive-sous-chef-pds' AND post_type = 'job_listing';
                

            -- Job: SENIOR FULLSTACK DEVELOPER (PHP / REACT) (FPT Software Vietnam)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>SENIOR FULLSTACK DEVELOPER (PHP / REACT) - FPT Software Vietnam</h2>
<p><strong>Công ty:</strong> FPT Software Vietnam (Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'SENIOR FULLSTACK DEVELOPER (PHP / REACT)', 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su',
                'publish', 'closed', 'closed', '', 'senior-fullstack-dev-fpt', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>SENIOR FULLSTACK DEVELOPER (PHP / REACT) - FPT Software Vietnam</h2>
<p><strong>Công ty:</strong> FPT Software Vietnam (Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'SENIOR FULLSTACK DEVELOPER (PHP / REACT)',
                post_excerpt = 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su',
                post_status = 'publish'
            WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'FPT Software Vietnam'
                FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://fptsoftware.com'
                FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su'
                FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '1'
                FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'senior-fullstack-dev-fpt' AND post_type = 'job_listing';
                

            -- Job: CLOUD DEVOPS ENGINEER (AWS / DOCKER) (FPT Software Vietnam)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>CLOUD DEVOPS ENGINEER (AWS / DOCKER) - FPT Software Vietnam</h2>
<p><strong>Công ty:</strong> FPT Software Vietnam (Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'CLOUD DEVOPS ENGINEER (AWS / DOCKER)', 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su',
                'publish', 'closed', 'closed', '', 'cloud-devops-engineer-fpt', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>CLOUD DEVOPS ENGINEER (AWS / DOCKER) - FPT Software Vietnam</h2>
<p><strong>Công ty:</strong> FPT Software Vietnam (Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'CLOUD DEVOPS ENGINEER (AWS / DOCKER)',
                post_excerpt = 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su',
                post_status = 'publish'
            WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ha Noi'
                FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'FPT Software Vietnam'
                FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://fptsoftware.com'
                FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su'
                FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'cloud-devops-engineer-fpt' AND post_type = 'job_listing';
                

            -- Job: IT PROJECT MANAGER (PMP / AGILE) (FPT Software Vietnam)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>IT PROJECT MANAGER (PMP / AGILE) - FPT Software Vietnam</h2>
<p><strong>Công ty:</strong> FPT Software Vietnam (Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'IT PROJECT MANAGER (PMP / AGILE)', 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su',
                'publish', 'closed', 'closed', '', 'it-project-manager-fpt', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>IT PROJECT MANAGER (PMP / AGILE) - FPT Software Vietnam</h2>
<p><strong>Công ty:</strong> FPT Software Vietnam (Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'IT PROJECT MANAGER (PMP / AGILE)',
                post_excerpt = 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su',
                post_status = 'publish'
            WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Da Nang'
                FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'FPT Software Vietnam'
                FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://fptsoftware.com'
                FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su'
                FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'it-project-manager-fpt' AND post_type = 'job_listing';
                

            -- Job: AI & DATA ENGINEER (FPT Software Vietnam)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>AI & DATA ENGINEER - FPT Software Vietnam</h2>
<p><strong>Công ty:</strong> FPT Software Vietnam (Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'AI & DATA ENGINEER', 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su',
                'publish', 'closed', 'closed', '', 'ai-data-engineer-fpt', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>AI & DATA ENGINEER - FPT Software Vietnam</h2>
<p><strong>Công ty:</strong> FPT Software Vietnam (Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'AI & DATA ENGINEER',
                post_excerpt = 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su',
                post_status = 'publish'
            WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'FPT Software Vietnam'
                FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://fptsoftware.com'
                FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su'
                FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'ai-data-engineer-fpt' AND post_type = 'job_listing';
                

            -- Job: QUALITY ASSURANCE / AUTOMATION TESTER (FPT Software Vietnam)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>QUALITY ASSURANCE / AUTOMATION TESTER - FPT Software Vietnam</h2>
<p><strong>Công ty:</strong> FPT Software Vietnam (Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'QUALITY ASSURANCE / AUTOMATION TESTER', 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su',
                'publish', 'closed', 'closed', '', 'qa-automation-tester-fpt', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>QUALITY ASSURANCE / AUTOMATION TESTER - FPT Software Vietnam</h2>
<p><strong>Công ty:</strong> FPT Software Vietnam (Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'QUALITY ASSURANCE / AUTOMATION TESTER',
                post_excerpt = 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su',
                post_status = 'publish'
            WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Can Tho'
                FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'FPT Software Vietnam'
                FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://fptsoftware.com'
                FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su'
                FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'qa-automation-tester-fpt' AND post_type = 'job_listing';
                

            -- Job: SOLUTION ARCHITECT - FINTECH PLATFORM (Viettel Digital Solutions)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>SOLUTION ARCHITECT - FINTECH PLATFORM - Viettel Digital Solutions</h2>
<p><strong>Công ty:</strong> Viettel Digital Solutions (Tong cong ty Dich vu so Viettel - Kien tao xa hoi so)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'SOLUTION ARCHITECT - FINTECH PLATFORM', 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so',
                'publish', 'closed', 'closed', '', 'solution-architect-viettel', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>SOLUTION ARCHITECT - FINTECH PLATFORM - Viettel Digital Solutions</h2>
<p><strong>Công ty:</strong> Viettel Digital Solutions (Tong cong ty Dich vu so Viettel - Kien tao xa hoi so)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'SOLUTION ARCHITECT - FINTECH PLATFORM',
                post_excerpt = 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so',
                post_status = 'publish'
            WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ha Noi'
                FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'Viettel Digital Solutions'
                FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://viettel.vn'
                FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so'
                FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'solution-architect-viettel' AND post_type = 'job_listing';
                

            -- Job: SENIOR BACKEND DEVELOPER (JAVA / GO) (Viettel Digital Solutions)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>SENIOR BACKEND DEVELOPER (JAVA / GO) - Viettel Digital Solutions</h2>
<p><strong>Công ty:</strong> Viettel Digital Solutions (Tong cong ty Dich vu so Viettel - Kien tao xa hoi so)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'SENIOR BACKEND DEVELOPER (JAVA / GO)', 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so',
                'publish', 'closed', 'closed', '', 'senior-backend-dev-viettel', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>SENIOR BACKEND DEVELOPER (JAVA / GO) - Viettel Digital Solutions</h2>
<p><strong>Công ty:</strong> Viettel Digital Solutions (Tong cong ty Dich vu so Viettel - Kien tao xa hoi so)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'SENIOR BACKEND DEVELOPER (JAVA / GO)',
                post_excerpt = 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so',
                post_status = 'publish'
            WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'Viettel Digital Solutions'
                FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://viettel.vn'
                FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so'
                FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '1'
                FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'senior-backend-dev-viettel' AND post_type = 'job_listing';
                

            -- Job: CYBER SECURITY SPECIALIST (Viettel Digital Solutions)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>CYBER SECURITY SPECIALIST - Viettel Digital Solutions</h2>
<p><strong>Công ty:</strong> Viettel Digital Solutions (Tong cong ty Dich vu so Viettel - Kien tao xa hoi so)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'CYBER SECURITY SPECIALIST', 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so',
                'publish', 'closed', 'closed', '', 'cyber-security-specialist-viettel', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>CYBER SECURITY SPECIALIST - Viettel Digital Solutions</h2>
<p><strong>Công ty:</strong> Viettel Digital Solutions (Tong cong ty Dich vu so Viettel - Kien tao xa hoi so)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'CYBER SECURITY SPECIALIST',
                post_excerpt = 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so',
                post_status = 'publish'
            WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ha Noi'
                FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'Viettel Digital Solutions'
                FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://viettel.vn'
                FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so'
                FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'cyber-security-specialist-viettel' AND post_type = 'job_listing';
                

            -- Job: PRODUCT OWNER - DIGITAL WALLET (Viettel Digital Solutions)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>PRODUCT OWNER - DIGITAL WALLET - Viettel Digital Solutions</h2>
<p><strong>Công ty:</strong> Viettel Digital Solutions (Tong cong ty Dich vu so Viettel - Kien tao xa hoi so)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'PRODUCT OWNER - DIGITAL WALLET', 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so',
                'publish', 'closed', 'closed', '', 'product-owner-digital-wallet-viettel', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>PRODUCT OWNER - DIGITAL WALLET - Viettel Digital Solutions</h2>
<p><strong>Công ty:</strong> Viettel Digital Solutions (Tong cong ty Dich vu so Viettel - Kien tao xa hoi so)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'PRODUCT OWNER - DIGITAL WALLET',
                post_excerpt = 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so',
                post_status = 'publish'
            WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'Viettel Digital Solutions'
                FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://viettel.vn'
                FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so'
                FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'product-owner-digital-wallet-viettel' AND post_type = 'job_listing';
                

            -- Job: DATA ANALYST & BUSINESS INTELLIGENCE (Viettel Digital Solutions)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>DATA ANALYST & BUSINESS INTELLIGENCE - Viettel Digital Solutions</h2>
<p><strong>Công ty:</strong> Viettel Digital Solutions (Tong cong ty Dich vu so Viettel - Kien tao xa hoi so)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'DATA ANALYST & BUSINESS INTELLIGENCE', 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so',
                'publish', 'closed', 'closed', '', 'data-analyst-bi-viettel', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>DATA ANALYST & BUSINESS INTELLIGENCE - Viettel Digital Solutions</h2>
<p><strong>Công ty:</strong> Viettel Digital Solutions (Tong cong ty Dich vu so Viettel - Kien tao xa hoi so)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'DATA ANALYST & BUSINESS INTELLIGENCE',
                post_excerpt = 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so',
                post_status = 'publish'
            WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Da Nang'
                FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'Viettel Digital Solutions'
                FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://viettel.vn'
                FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Tong cong ty Dich vu so Viettel - Kien tao xa hoi so'
                FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'data-analyst-bi-viettel' AND post_type = 'job_listing';
                

            -- Job: SENIOR GAME DEVELOPER (UNITY / C++) (VNG Corporation)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>SENIOR GAME DEVELOPER (UNITY / C++) - VNG Corporation</h2>
<p><strong>Công ty:</strong> VNG Corporation (Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'SENIOR GAME DEVELOPER (UNITY / C++)', 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud',
                'publish', 'closed', 'closed', '', 'senior-game-developer-vng', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>SENIOR GAME DEVELOPER (UNITY / C++) - VNG Corporation</h2>
<p><strong>Công ty:</strong> VNG Corporation (Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'SENIOR GAME DEVELOPER (UNITY / C++)',
                post_excerpt = 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud',
                post_status = 'publish'
            WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'VNG Corporation'
                FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://vng.com.vn'
                FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud'
                FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '1'
                FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'senior-game-developer-vng' AND post_type = 'job_listing';
                

            -- Job: MOBILE APP DEVELOPER (FLUTTER / SWIFT) (VNG Corporation)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>MOBILE APP DEVELOPER (FLUTTER / SWIFT) - VNG Corporation</h2>
<p><strong>Công ty:</strong> VNG Corporation (Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'MOBILE APP DEVELOPER (FLUTTER / SWIFT)', 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud',
                'publish', 'closed', 'closed', '', 'mobile-app-dev-vng', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>MOBILE APP DEVELOPER (FLUTTER / SWIFT) - VNG Corporation</h2>
<p><strong>Công ty:</strong> VNG Corporation (Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'MOBILE APP DEVELOPER (FLUTTER / SWIFT)',
                post_excerpt = 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud',
                post_status = 'publish'
            WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'VNG Corporation'
                FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://vng.com.vn'
                FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud'
                FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'mobile-app-dev-vng' AND post_type = 'job_listing';
                

            -- Job: SENIOR UI/UX PRODUCT DESIGNER (VNG Corporation)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>SENIOR UI/UX PRODUCT DESIGNER - VNG Corporation</h2>
<p><strong>Công ty:</strong> VNG Corporation (Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'SENIOR UI/UX PRODUCT DESIGNER', 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud',
                'publish', 'closed', 'closed', '', 'senior-ui-ux-designer-vng', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>SENIOR UI/UX PRODUCT DESIGNER - VNG Corporation</h2>
<p><strong>Công ty:</strong> VNG Corporation (Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'SENIOR UI/UX PRODUCT DESIGNER',
                post_excerpt = 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud',
                post_status = 'publish'
            WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'VNG Corporation'
                FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://vng.com.vn'
                FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud'
                FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '1'
                FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'senior-ui-ux-designer-vng' AND post_type = 'job_listing';
                

            -- Job: DIGITAL MARKETING LEAD (VNG Corporation)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>DIGITAL MARKETING LEAD - VNG Corporation</h2>
<p><strong>Công ty:</strong> VNG Corporation (Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'DIGITAL MARKETING LEAD', 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud',
                'publish', 'closed', 'closed', '', 'digital-marketing-lead-vng', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>DIGITAL MARKETING LEAD - VNG Corporation</h2>
<p><strong>Công ty:</strong> VNG Corporation (Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'DIGITAL MARKETING LEAD',
                post_excerpt = 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud',
                post_status = 'publish'
            WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ha Noi'
                FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'VNG Corporation'
                FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://vng.com.vn'
                FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud'
                FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '1'
                FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'digital-marketing-lead-vng' AND post_type = 'job_listing';
                

            -- Job: SYSTEM OPERATIONS ENGINEER (SRE) (VNG Corporation)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>SYSTEM OPERATIONS ENGINEER (SRE) - VNG Corporation</h2>
<p><strong>Công ty:</strong> VNG Corporation (Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'SYSTEM OPERATIONS ENGINEER (SRE)', 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud',
                'publish', 'closed', 'closed', '', 'system-operations-sre-vng', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>SYSTEM OPERATIONS ENGINEER (SRE) - VNG Corporation</h2>
<p><strong>Công ty:</strong> VNG Corporation (Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'SYSTEM OPERATIONS ENGINEER (SRE)',
                post_excerpt = 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud',
                post_status = 'publish'
            WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'VNG Corporation'
                FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://vng.com.vn'
                FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud'
                FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'system-operations-sre-vng' AND post_type = 'job_listing';
                

            -- Job: FINTECH PRODUCT MANAGER (MoMo Financial Technology)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>FINTECH PRODUCT MANAGER - MoMo Financial Technology</h2>
<p><strong>Công ty:</strong> MoMo Financial Technology (Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'FINTECH PRODUCT MANAGER', 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam',
                'publish', 'closed', 'closed', '', 'fintech-product-manager-momo', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>FINTECH PRODUCT MANAGER - MoMo Financial Technology</h2>
<p><strong>Công ty:</strong> MoMo Financial Technology (Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'FINTECH PRODUCT MANAGER',
                post_excerpt = 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam',
                post_status = 'publish'
            WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'MoMo Financial Technology'
                FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://momo.vn'
                FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam'
                FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'fintech-product-manager-momo' AND post_type = 'job_listing';
                

            -- Job: LEAD FRONTEND ENGINEER (NEXTJS / VUE) (MoMo Financial Technology)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>LEAD FRONTEND ENGINEER (NEXTJS / VUE) - MoMo Financial Technology</h2>
<p><strong>Công ty:</strong> MoMo Financial Technology (Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'LEAD FRONTEND ENGINEER (NEXTJS / VUE)', 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam',
                'publish', 'closed', 'closed', '', 'lead-frontend-engineer-momo', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>LEAD FRONTEND ENGINEER (NEXTJS / VUE) - MoMo Financial Technology</h2>
<p><strong>Công ty:</strong> MoMo Financial Technology (Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'LEAD FRONTEND ENGINEER (NEXTJS / VUE)',
                post_excerpt = 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam',
                post_status = 'publish'
            WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'MoMo Financial Technology'
                FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://momo.vn'
                FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam'
                FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '1'
                FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'lead-frontend-engineer-momo' AND post_type = 'job_listing';
                

            -- Job: DATA SCIENTIST - FRAUD DETECTION (MoMo Financial Technology)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>DATA SCIENTIST - FRAUD DETECTION - MoMo Financial Technology</h2>
<p><strong>Công ty:</strong> MoMo Financial Technology (Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'DATA SCIENTIST - FRAUD DETECTION', 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam',
                'publish', 'closed', 'closed', '', 'data-scientist-fraud-detection-momo', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>DATA SCIENTIST - FRAUD DETECTION - MoMo Financial Technology</h2>
<p><strong>Công ty:</strong> MoMo Financial Technology (Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'DATA SCIENTIST - FRAUD DETECTION',
                post_excerpt = 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam',
                post_status = 'publish'
            WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'MoMo Financial Technology'
                FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://momo.vn'
                FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam'
                FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'data-scientist-fraud-detection-momo' AND post_type = 'job_listing';
                

            -- Job: BUSINESS DEVELOPMENT MANAGER (MoMo Financial Technology)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>BUSINESS DEVELOPMENT MANAGER - MoMo Financial Technology</h2>
<p><strong>Công ty:</strong> MoMo Financial Technology (Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'BUSINESS DEVELOPMENT MANAGER', 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam',
                'publish', 'closed', 'closed', '', 'business-development-manager-momo', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>BUSINESS DEVELOPMENT MANAGER - MoMo Financial Technology</h2>
<p><strong>Công ty:</strong> MoMo Financial Technology (Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'BUSINESS DEVELOPMENT MANAGER',
                post_excerpt = 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam',
                post_status = 'publish'
            WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ha Noi'
                FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'MoMo Financial Technology'
                FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://momo.vn'
                FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam'
                FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'business-development-manager-momo' AND post_type = 'job_listing';
                

            -- Job: CUSTOMER EXPERIENCE SUPERVISOR (MoMo Financial Technology)
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), '<h2>CUSTOMER EXPERIENCE SUPERVISOR - MoMo Financial Technology</h2>
<p><strong>Công ty:</strong> MoMo Financial Technology (Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
', 'CUSTOMER EXPERIENCE SUPERVISOR', 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam',
                'publish', 'closed', 'closed', '', 'customer-experience-supervisor-momo', '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = '<h2>CUSTOMER EXPERIENCE SUPERVISOR - MoMo Financial Technology</h2>
<p><strong>Công ty:</strong> MoMo Financial Technology (Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam)</p>
<h3>1. Mô Tả Công Việc</h3>
<p>• Tham gia vào quy trình quản lý, phát triển sản phẩm và vận hành dịch vụ cốt lõi của công ty.<br>
• Phối hợp chặt chẽ với các phòng ban liên quan để tối ưu hóa quy trình làm việc và nâng cao hiệu quả.<br>
• Báo cáo tiến độ và đề xuất giải pháp cải tiến chất lượng dịch vụ định kỳ.</p>

<h3>2. Yêu Cầu Ứng Viên</h3>
<p>• Tốt nghiệp Đại học, Cao đẳng chuyên ngành liên quan (CNTT, Quản trị Khách sạn, Kinh tế).<br>
• Có từ 1-3 năm kinh nghiệm ở vị trí tương đương (chấp nhận sinh viên mới ra trường tiềm năng).<br>
• Kỹ năng làm việc nhóm, tư duy giải quyết vấn đề và giao tiếp tốt.<br>
• Tinh thần trách nhiệm cao, nhiệt huyết và chủ động trong công việc.</p>

<h3>3. Quyền Lợi & Đãi Ngộ</h3>
<p>• Mức lương cạnh tranh từ 15.000.000 - 45.000.000 VNĐ/tháng (thỏa thuận theo năng lực).<br>
• Lương tháng 13, thưởng hiệu quả kinh doanh và thưởng dự án định kỳ.<br>
• Đóng đầy đủ BHXH, BHYT, BHTN theo luật định cùng gói bảo hiểm sức khỏe cao cấp.<br>
• Được đào tạo bài bản, cơ hội thăng tiến rõ ràng và môi trường làm việc trẻ trung, sáng tạo.</p>
',
                post_title = 'CUSTOMER EXPERIENCE SUPERVISOR',
                post_excerpt = 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam',
                post_status = 'publish'
            WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing';
            

                DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_location', 'Ho Chi Minh'
                FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_name', 'MoMo Financial Technology'
                FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_website' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_website', 'https://momo.vn'
                FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_company_tagline' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_company_tagline', 'Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam'
                FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_filled', '0'
                FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_featured', '0'
                FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing';
                

                DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, '_job_expires', '2028-12-31'
                FROM wp_posts WHERE post_name = 'customer-experience-supervisor-momo' AND post_type = 'job_listing';
                