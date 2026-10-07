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
    sql.append("USE cms_nhomc;")
    
    # 1. Categories
    categories = [
        ("Job Category", "job-category"),
        ("Hotel Management", "hotel-management"),
        ("Hospitality", "hospitality"),
        ("Operations", "operations"),
        ("News", "news"),
        ("Project Development", "project-development")
    ]
    
    for name, slug in categories:
        sql.append(f"""
        INSERT INTO wp_terms (name, slug, term_group)
        SELECT {esc(name)}, {esc(slug)}, 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = {esc(slug)});

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'category', {esc(name)}, 0, 1
        FROM wp_terms t
        WHERE t.slug = {esc(slug)}
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'category');
        """)

    # 2. Pages
    about_content = """<h2>SHARE 'OMOTENASHI' WITH THE WORLD</h2>
<p><strong>ABOUT US</strong></p>

<h3>Our Vision</h3>
<p>Create hotels and restaurants around the world that offer memorable experiences while building a lasting, positive relationship together with our guests, partners, team members and communities.</p>

<h3>Our Mission</h3>
<p>Share "Omotenashi" with the world.</p>

<h3>Our Core Value</h3>
<p><strong>"If I were the guest"</strong> - To provide guests with the hospitality you would want to receive as a guest.</p>

<h3>Hotels, Restaurants, Banquets/Weddings Management</h3>
<p>Plan Do See developed and operates 17 properties worldwide including 3 award-winning resorts in Japan; 17 restaurants of diverse cuisines in cities including New York, Miami and Los Angeles; and other countries including Japan, Indonesia, Malaysia and Bali.</p>
<p>Each venue carries its own concept and design. Many of them are originally historical landmarks that were loved by the local people.</p>

<table class="table table-bordered">
<tbody>
<tr><td><strong>Established since:</strong></td><td>April 1993</td></tr>
<tr><td><strong>Head Office:</strong></td><td>Marunouchi 2-1-1, Chiyoda, Tokyo</td></tr>
<tr><td><strong>Capital:</strong></td><td>JPY</td></tr>
<tr><td><strong>CEO:</strong></td><td>Yutaka Noda</td></tr>
<tr><td><strong>Number of Employees:</strong></td><td>Full time: 830 / Total: 1,600</td></tr>
</tbody>
</table>
"""

    contact_content = """<h2>CONTACT US</h2>

<h3>Our Headquarters Address</h3>
<p><strong>60 Nguyen Van Thu, Ward Da Kao, District 1, Ho Chi Minh City, Viet Nam</strong></p>

<h3>For Employers</h3>
<p>Call our Sales Hotline:<br>
• Ho Chi Minh City<br>
• Ha Noi<br>
Request a call from one of our Customer Love Account Managers. We're ready to help you grow!</p>

<h3>For Jobseekers</h3>
<p>Ask a question on our Facebook page.<br>
Read our blog posts on interview and CV tips.<br>
Call us at our support hotline.</p>
"""

    home_content = """<h1>FIND YOUR DREAM JOBS</h1>
<p>The secret behind our company is simple: to always put ourselves in others' shoes - employee, guest, partner. This allows us to see the world through their eyes, anticipate their needs.</p>

<h2>CAREER WITH US</h2>
<p>Plan Do See Global is a hospitality group founded in Japan and rooted in "Omotenashi", the Japanese principle of selfless hospitality. We strive to deliver unforgettable experiences, understand local cultures like locals, to provide service that is warm but not intrusive, and to foresee guests' every need at all times. That is our mission and purpose.</p>
<p>We are experts in all stages of project development: concept, design, implementation and management. We love to find unique ways to create experiences that surprise and delight guests and customers.</p>
"""

    pages = [
        ("Home", "home", home_content),
        ("About Us", "about-us", about_content),
        ("News", "news", "<p>Latest news, updates and articles from PDS.</p>"),
        ("All Jobs", "all-jobs", "<p>Explore all available career opportunities.</p>"),
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

    # 3. News Posts
    news_detail_content = """<p>CHIEF OPERATING OFFICER HOTEL / RESORT CHAIN - PDS NEWS UPDATE.</p>
<p>Plan Do See operates 17 properties worldwide including 3 award-winning resorts in Japan, and 17 restaurants of diverse cuisines worldwide. Our executives and leadership ensure optimal hospitality standards, exceptional customer experiences, and premier resort management.</p>
<p>We believe in selfless hospitality ("Omotenashi") and empower all team members to deliver unforgettable service across all destinations.</p>
"""

    news_posts = [
        ("Project Development", "project-development", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. We are experts in all stages of project development: concept, design, implementation and management."),
        ("Hospitality Consulting", "hospitality-consulting", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Providing warm, non-intrusive service and anticipating customer needs."),
        ("Restaurant & Hotel Management And Operations", "restaurant-hotel-management-and-operations", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Operational excellence across luxury venues."),
        ("Venue And Interior Design", "venue-and-interior-design", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Each venue carries its own unique concept and authentic aesthetic."),
        ("Chief Operating Officer Hotel/ Resort Chain Update", "coo-hotel-resort-chain-update", news_detail_content)
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

    # 4. Jobs for WP Job Manager
    coo_job_content = """<h3>Overview about Company</h3>
<p>Plan Do See Global is a hospitality group founded in Japan and rooted in "Omotenashi", the Japanese principle of selfless hospitality. We operate award-winning resorts in Japan, premier restaurants worldwide, and high-end banquet properties.</p>

<h3>Our Key Skills</h3>
<p>• Strategic executive management and resort operational excellence.<br>
• Experience leading multi-unit hospitality chains.<br>
• Proven track record in guest satisfaction, revenue growth, and staff leadership.<br>
• Strong bilingual communication skills.</p>

<h3>Why You'll Love Working Here</h3>
<p>• Be responsible for the effective operational management of luxury hotel and resort chains.<br>
• Excellent salary, performance bonuses & executive recognition programs.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Global mobility and career advancement opportunities across international properties.</p>

<h3>Location</h3>
<p>Ho Chi Minh City, Viet Nam.</p>
"""

    standard_job_content = """<h3>Job Responsibilities</h3>
<p>• Be responsible for the effective operational management of the hotel.<br>
• Coordinate with department heads to maintain outstanding guest satisfaction.<br>
• Ensure high compliance with hospitality safety, hygiene, and service standards.</p>

<h3>Benefits & Compensation</h3>
<p>• Excellent salary bonuses & recognition activities.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Dynamic, professional Japanese hospitality working environment.</p>
"""

    jobs = [
        {
            "title": "HOTEL MANAGER",
            "slug": "hotel-manager",
            "company": "S 0TbEoH",
            "location": "Ho Chi Minh City / Tokyo",
            "type": "Full Time",
            "content": standard_job_content,
            "category": "Hotel Management"
        },
        {
            "title": "GENERAL MANAGER - LEADING HOTEL CHAIN",
            "slug": "general-manager-leading-hotel-chain",
            "company": "GARDEN",
            "location": "Ho Chi Minh City",
            "type": "Full Time",
            "content": standard_job_content,
            "category": "Hotel Management"
        },
        {
            "title": "BANQUET MANAGER",
            "slug": "banquet-manager",
            "company": "The Seygn House",
            "location": "Ho Chi Minh City",
            "type": "Full Time",
            "content": standard_job_content,
            "category": "Hospitality"
        },
        {
            "title": "BELLMAN",
            "slug": "bellman",
            "company": "PDS Luxury Hotel",
            "location": "Ho Chi Minh City",
            "type": "Full Time",
            "content": standard_job_content,
            "category": "Hospitality"
        },
        {
            "title": "LOSS PREVENTION OFFICER",
            "slug": "loss-prevention-officer",
            "company": "PHd THIN",
            "location": "Ho Chi Minh City",
            "type": "Full Time",
            "content": standard_job_content,
            "category": "Operations"
        },
        {
            "title": "CHIEF OPERATING OFFICER HOTEL/ RESORT CHAIN",
            "slug": "chief-operating-officer-hotel-resort-chain",
            "company": "SODOH",
            "location": "Ho Chi Minh City",
            "type": "Full Time",
            "content": coo_job_content,
            "category": "Hotel Management"
        }
    ]

    for j in jobs:
        sql.append(f"""
        -- Job: {j['title']}
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), {esc(j['content'])}, {esc(j['title'])}, '',
            'publish', 'closed', 'closed', '', {esc(j['slug'])}, '',
            '', NOW(), NOW(), '', 0, '',
            0, 'job_listing', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = {esc(j['slug'])} AND post_type = 'job_listing');

        UPDATE wp_posts
        SET post_content = {esc(j['content'])},
            post_title = {esc(j['title'])},
            post_status = 'publish'
        WHERE post_name = {esc(j['slug'])} AND post_type = 'job_listing';
        """)

        # Job Meta (WP Job Manager fields)
        metas = [
            ('_job_location', j['location']),
            ('_company_name', j['company']),
            ('_filled', '0'),
            ('_featured', '1' if 'CHIEF' in j['title'] or 'GENERAL' in j['title'] else '0'),
            ('_job_expires', '2028-12-31')
        ]
        for meta_k, meta_v in metas:
            sql.append(f"""
            DELETE FROM wp_postmeta WHERE meta_key = {esc(meta_k)} AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = {esc(j['slug'])} AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, {esc(meta_k)}, {esc(meta_v)}
            FROM wp_posts WHERE post_name = {esc(j['slug'])} AND post_type = 'job_listing';
            """)

    return "\n".join(sql)

if __name__ == '__main__':
    sql_content = generate_sql()
    with open('import_job_design_data.sql', 'w', encoding='utf-8') as f:
        f.write(sql_content)
    print("Generated import_job_design_data.sql successfully!")
