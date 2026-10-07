import json
import re

def slugify(text):
    text = text.lower().strip()
    text = re.sub(r'[^\w\s-]', '', text)
    text = re.sub(r'[\s_-]+', '-', text)
    text = re.sub(r'^-+|-+$', '', text)
    return text

def esc(text):
    if text is None:
        return "NULL"
    return "'" + text.replace("'", "''").replace("\\", "\\\\") + "'"

def generate_sql():
    sql = []
    sql.append("SET NAMES utf8mb4;")
    
    # 1. Categories & Job Categories
    categories = [
        ("Job Category", "job-category", "category"),
        ("Hotel Management", "hotel-management", "job_listing_category"),
        ("Hospitality", "hospitality", "job_listing_category"),
        ("Operations", "operations", "job_listing_category"),
        ("Information Technology", "information-technology", "job_listing_category"),
        ("Marketing & Sales", "marketing-sales", "job_listing_category"),
        ("Project Development", "project-development", "category"),
        ("News & Career Tips", "news-career-tips", "category")
    ]
    
    for name, slug, taxonomy in categories:
        sql.append(f"""
        INSERT INTO wp_terms (name, slug, term_group)
        SELECT {esc(name)}, {esc(slug)}, 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = {esc(slug)});

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, {esc(taxonomy)}, {esc(name)}, 0, 1
        FROM wp_terms t
        WHERE t.slug = {esc(slug)}
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = {esc(taxonomy)});
        """)

    # 2. Pages (Full 5 Pages for 5 Students group as per Excel sheet 2)
    about_content = """<h2>SHARE 'OMOTENASHI' WITH THE WORLD</h2>
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
"""

    contact_content = """<h2>LIÊN HỆ VỚI CHÚNG TÔI</h2>
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
"""

    home_content = """<h1>TÌM KIẾM VIỆC LÀM MƠ ƯỚC CÙNG JOBSCOUT</h1>
<p>Hệ thống kết nối việc làm thông minh với hàng trăm cơ hội nghề nghiệp hấp dẫn từ các tập đoàn công nghệ, khách sạn và dịch vụ hàng đầu.</p>

<h2>CƠ HỘI NGHỀ NGHIỆP NỔI BẬT</h2>
<p>Khám phá các vị trí việc làm chất lượng cao từ 5 tập đoàn đối tác chiến lược: Plan Do See, FPT Software, Viettel Solutions, VNG Corporation và Momo.</p>
"""

    pages = [
        ("Home", "home", home_content),
        ("About Us", "about-us", about_content),
        ("News", "news", "<p>Tổng hợp các tin tức tuyển dụng, kỹ năng phỏng vấn và xu hướng nghề nghiệp mới nhất.</p>"),
        ("Blog", "blog", "<p>Trang chia sẻ kinh nghiệm ứng tuyển và cẩm nang việc làm JobScout.</p>"),
        ("All Jobs", "all-jobs", "<p>Danh sách tất cả các vị trí việc làm đang tuyển dụng còn hạn.</p>"),
        ("Jobs", "jobs", "<p>Trang tìm kiếm việc làm chuyên sâu theo ngành nghề và khu vực.</p>"),
        ("Contact Us", "contact-us", contact_content)
    ]

    for title, slug, content in pages:
        sql.append(f"""
        -- Page: {title}
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), {esc(content)}, {esc(title)}, '',
            'publish', 'closed', 'closed', '', {esc(slug)}, '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = {esc(slug)} AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = {esc(content)},
            post_title = {esc(title)},
            post_status = 'publish'
        WHERE post_name = {esc(slug)} AND post_type = 'page';
        """)

    # 3. 5 Bài viết Blog/News theo yêu cầu Excel
    news_posts = [
        ("Bí Quyết Viết CV Chuyên Nghiệp Dành Cho Sinh Viên Mới Ra Trường", "bi-quyet-viet-cv-chuyen-nghiep-2026",
         "<p>Hướng dẫn chi tiết cách trình bày CV ấn tượng, làm nổi bật kỹ năng và dự án thực tế giúp bạn ghi điểm tuyệt đối trong mắt nhà tuyển dụng ngay từ vòng lọc hồ sơ đầu tiên.</p>"),
        ("Top 5 Kỹ Năng Quan Trọng Nhất Giúp Ứng Viên Vượt Qua Vòng Phỏng Vấn", "top-5-ky-nang-phong-van-thanh-cong",
         "<p>Khám phá cách trả lời câu hỏi hành vi theo mô hình STAR, cách đàm phán mức lương tự tin và xử lý các tình huống hóc búa từ hội đồng tuyển dụng.</p>"),
        ("Xu Hướng Tuyển Dụng Ngành Công Nghệ Thông Tin & Dịch Vụ 2026", "xu-huong-tuyen-dung-it-dich-vu-2026",
         "<p>Phân tích nhu cầu nhân lực trong các lĩnh vực Cloud, AI, DevOps, Quản trị nhà hàng khách sạn cao cấp và cơ hội phát triển sự nghiệp bền vững.</p>"),
        ("Nghệ Thuật Phục Vụ Tận Tâm 'Omotenashi' Trong Quản Trị Khách Sạn Cao Cấp", "nghe-thuat-phuc-vu-omotenashi-khach-san",
         "<p>Tìm hiểu triết lý hiếu khách Omotenashi của Nhật Bản và cách ứng dụng vào dịch vụ lưu trú 5 sao để nâng tầm trải nghiệm của khách hàng.</p>"),
        ("Lộ Trình Phát Triển Từ Lập Trình Viên Trở Thành Quản Lý Dự Án", "lo-trinh-tu-developer-len-project-manager",
         "<p>Chia sẻ kinh nghiệm thực tế về việc trau dồi kỹ năng quản trị, giao tiếp và giải quyết xung đột khi chuyển dịch từ vai trò kỹ thuật sang quản lý dự án chuyên nghiệp.</p>")
    ]

    for title, slug, content in news_posts:
        sql.append(f"""
        -- News Post: {title}
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), {esc(content)}, {esc(title)}, '',
            'publish', 'open', 'open', '', {esc(slug)}, '',
            '', NOW(), NOW(), '', 0, '',
            0, 'post', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = {esc(slug)} AND post_type = 'post');

        UPDATE wp_posts
        SET post_content = {esc(content)},
            post_title = {esc(title)},
            post_status = 'publish'
        WHERE post_name = {esc(slug)} AND post_type = 'post';
        """)

    # 4. 5 Công Ty x 5 Công Việc = 25 Công Việc (Đúng 100% Yêu Cầu Excel Sheet 1 & 2)
    companies = [
        {
            "name": "Plan Do See Global (PDS)",
            "tagline": "Tap doan quan ly chuoi khach san va resort 5 sao quoc te",
            "website": "https://plandosee.co.jp",
            "jobs": [
                ("CHIEF OPERATING OFFICER HOTEL / RESORT CHAIN", "coo-hotel-resort-chain", "Ho Chi Minh", "Hotel Management", "Full Time"),
                ("HOTEL GENERAL MANAGER", "hotel-general-manager-pds", "Ho Chi Minh", "Hotel Management", "Full Time"),
                ("BANQUET & EVENTS MANAGER", "banquet-events-manager-pds", "Ha Noi", "Hospitality", "Full Time"),
                ("FRONT DESK SUPERVISOR", "front-desk-supervisor-pds", "Da Nang", "Hospitality", "Full Time"),
                ("EXECUTIVE SOUS CHEF", "executive-sous-chef-pds", "Ho Chi Minh", "Operations", "Full Time")
            ]
        },
        {
            "name": "FPT Software Vietnam",
            "tagline": "Cong ty phan mem hang dau Dong Nam A voi hon 30.000 ky su",
            "website": "https://fptsoftware.com",
            "jobs": [
                ("SENIOR FULLSTACK DEVELOPER (PHP / REACT)", "senior-fullstack-dev-fpt", "Ho Chi Minh", "Information Technology", "Full Time"),
                ("CLOUD DEVOPS ENGINEER (AWS / DOCKER)", "cloud-devops-engineer-fpt", "Ha Noi", "Information Technology", "Full Time"),
                ("IT PROJECT MANAGER (PMP / AGILE)", "it-project-manager-fpt", "Da Nang", "Information Technology", "Full Time"),
                ("AI & DATA ENGINEER", "ai-data-engineer-fpt", "Ho Chi Minh", "Information Technology", "Full Time"),
                ("QUALITY ASSURANCE / AUTOMATION TESTER", "qa-automation-tester-fpt", "Can Tho", "Information Technology", "Full Time")
            ]
        },
        {
            "name": "Viettel Digital Solutions",
            "tagline": "Tong cong ty Dich vu so Viettel - Kien tao xa hoi so",
            "website": "https://viettel.vn",
            "jobs": [
                ("SOLUTION ARCHITECT - FINTECH PLATFORM", "solution-architect-viettel", "Ha Noi", "Information Technology", "Full Time"),
                ("SENIOR BACKEND DEVELOPER (JAVA / GO)", "senior-backend-dev-viettel", "Ho Chi Minh", "Information Technology", "Full Time"),
                ("CYBER SECURITY SPECIALIST", "cyber-security-specialist-viettel", "Ha Noi", "Information Technology", "Full Time"),
                ("PRODUCT OWNER - DIGITAL WALLET", "product-owner-digital-wallet-viettel", "Ho Chi Minh", "Operations", "Full Time"),
                ("DATA ANALYST & BUSINESS INTELLIGENCE", "data-analyst-bi-viettel", "Da Nang", "Information Technology", "Full Time")
            ]
        },
        {
            "name": "VNG Corporation",
            "tagline": "Ky lan cong nghe hang dau Viet Nam - Zalo, Zing, VNG Cloud",
            "website": "https://vng.com.vn",
            "jobs": [
                ("SENIOR GAME DEVELOPER (UNITY / C++)", "senior-game-developer-vng", "Ho Chi Minh", "Information Technology", "Full Time"),
                ("MOBILE APP DEVELOPER (FLUTTER / SWIFT)", "mobile-app-dev-vng", "Ho Chi Minh", "Information Technology", "Full Time"),
                ("SENIOR UI/UX PRODUCT DESIGNER", "senior-ui-ux-designer-vng", "Ho Chi Minh", "Marketing & Sales", "Full Time"),
                ("DIGITAL MARKETING LEAD", "digital-marketing-lead-vng", "Ha Noi", "Marketing & Sales", "Full Time"),
                ("SYSTEM OPERATIONS ENGINEER (SRE)", "system-operations-sre-vng", "Ho Chi Minh", "Operations", "Full Time")
            ]
        },
        {
            "name": "MoMo Financial Technology",
            "tagline": "Sieu ung dung thanh toan va tai chinh so hang dau Viet Nam",
            "website": "https://momo.vn",
            "jobs": [
                ("FINTECH PRODUCT MANAGER", "fintech-product-manager-momo", "Ho Chi Minh", "Operations", "Full Time"),
                ("LEAD FRONTEND ENGINEER (NEXTJS / VUE)", "lead-frontend-engineer-momo", "Ho Chi Minh", "Information Technology", "Full Time"),
                ("DATA SCIENTIST - FRAUD DETECTION", "data-scientist-fraud-detection-momo", "Ho Chi Minh", "Information Technology", "Full Time"),
                ("BUSINESS DEVELOPMENT MANAGER", "business-development-manager-momo", "Ha Noi", "Marketing & Sales", "Full Time"),
                ("CUSTOMER EXPERIENCE SUPERVISOR", "customer-experience-supervisor-momo", "Ho Chi Minh", "Operations", "Full Time")
            ]
        }
    ]

    job_description_template = """<h3>1. Mô Tả Công Việc</h3>
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
"""

    for comp in companies:
        c_name = comp["name"]
        c_tagline = comp["tagline"]
        c_web = comp["website"]
        
        for title, slug, loc, cat, j_type in comp["jobs"]:
            content = f"<h2>{title} - {c_name}</h2>\n<p><strong>Công ty:</strong> {c_name} ({c_tagline})</p>\n{job_description_template}"
            sql.append(f"""
            -- Job: {title} ({c_name})
            INSERT INTO wp_posts (
                post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
                post_status, comment_status, ping_status, post_password, post_name, to_ping,
                pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
                menu_order, post_type, post_mime_type, comment_count
            )
            SELECT 
                1, NOW(), NOW(), {esc(content)}, {esc(title)}, {esc(c_tagline)},
                'publish', 'closed', 'closed', '', {esc(slug)}, '',
                '', NOW(), NOW(), '', 0, '',
                0, 'job_listing', '', 0
            WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = {esc(slug)} AND post_type = 'job_listing');

            UPDATE wp_posts
            SET post_content = {esc(content)},
                post_title = {esc(title)},
                post_excerpt = {esc(c_tagline)},
                post_status = 'publish'
            WHERE post_name = {esc(slug)} AND post_type = 'job_listing';
            """)

            metas = [
                ('_job_location', loc),
                ('_company_name', c_name),
                ('_company_website', c_web),
                ('_company_tagline', c_tagline),
                ('_filled', '0'),
                ('_featured', '1' if 'CHIEF' in title or 'LEAD' in title or 'SENIOR' in title else '0'),
                ('_job_expires', '2028-12-31')
            ]
            for meta_k, meta_v in metas:
                sql.append(f"""
                DELETE FROM wp_postmeta WHERE meta_key = {esc(meta_k)} AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = {esc(slug)} AND post_type = 'job_listing');
                INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
                SELECT ID, {esc(meta_k)}, {esc(meta_v)}
                FROM wp_posts WHERE post_name = {esc(slug)} AND post_type = 'job_listing';
                """)

    return "\n".join(sql)

if __name__ == '__main__':
    sql_content = generate_sql()
    with open('import_job_design_data.sql', 'w', encoding='utf-8') as f:
        f.write(sql_content)
    print("Generated import_job_design_data.sql with 25 jobs across 5 companies successfully!")
