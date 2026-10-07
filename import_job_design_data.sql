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
        SELECT t.term_id, 'category', 'Hotel Management', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'hotel-management'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'category');
        

        INSERT INTO wp_terms (name, slug, term_group)
        SELECT 'Hospitality', 'hospitality', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = 'hospitality');

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'category', 'Hospitality', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'hospitality'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'category');
        

        INSERT INTO wp_terms (name, slug, term_group)
        SELECT 'Operations', 'operations', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = 'operations');

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'category', 'Operations', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'operations'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'category');
        

        INSERT INTO wp_terms (name, slug, term_group)
        SELECT 'News', 'news', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = 'news');

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'category', 'News', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'news'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'category');
        

        INSERT INTO wp_terms (name, slug, term_group)
        SELECT 'Project Development', 'project-development', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_terms WHERE slug = 'project-development');

        INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count)
        SELECT t.term_id, 'category', 'Project Development', 0, 1
        FROM wp_terms t
        WHERE t.slug = 'project-development'
        AND NOT EXISTS (SELECT 1 FROM wp_term_taxonomy WHERE term_id = t.term_id AND taxonomy = 'category');
        

        -- Page: Home
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<h1>FIND YOUR DREAM JOBS</h1>
<p>The secret behind our company is simple: to always put ourselves in others'' shoes - employee, guest, partner. This allows us to see the world through their eyes, anticipate their needs.</p>

<h2>CAREER WITH US</h2>
<p>Plan Do See Global is a hospitality group founded in Japan and rooted in "Omotenashi", the Japanese principle of selfless hospitality. We strive to deliver unforgettable experiences, understand local cultures like locals, to provide service that is warm but not intrusive, and to foresee guests'' every need at all times. That is our mission and purpose.</p>
<p>We are experts in all stages of project development: concept, design, implementation and management. We love to find unique ways to create experiences that surprise and delight guests and customers.</p>
', 'Home', '',
            'publish', 'closed', 'closed', '', 'home', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'home' AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = '<h1>FIND YOUR DREAM JOBS</h1>
<p>The secret behind our company is simple: to always put ourselves in others'' shoes - employee, guest, partner. This allows us to see the world through their eyes, anticipate their needs.</p>

<h2>CAREER WITH US</h2>
<p>Plan Do See Global is a hospitality group founded in Japan and rooted in "Omotenashi", the Japanese principle of selfless hospitality. We strive to deliver unforgettable experiences, understand local cultures like locals, to provide service that is warm but not intrusive, and to foresee guests'' every need at all times. That is our mission and purpose.</p>
<p>We are experts in all stages of project development: concept, design, implementation and management. We love to find unique ways to create experiences that surprise and delight guests and customers.</p>
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
', 'About Us', '',
            'publish', 'closed', 'closed', '', 'about-us', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'about-us' AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = '<h2>SHARE ''OMOTENASHI'' WITH THE WORLD</h2>
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
            1, NOW(), NOW(), '<p>Latest news, updates and articles from PDS.</p>', 'News', '',
            'publish', 'closed', 'closed', '', 'news', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'news' AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = '<p>Latest news, updates and articles from PDS.</p>',
            post_title = 'News',
            post_status = 'publish'
        WHERE post_name = 'news' AND post_type = 'page';
        

        -- Page: All Jobs
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<p>Explore all available career opportunities.</p>', 'All Jobs', '',
            'publish', 'closed', 'closed', '', 'all-jobs', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'all-jobs' AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = '<p>Explore all available career opportunities.</p>',
            post_title = 'All Jobs',
            post_status = 'publish'
        WHERE post_name = 'all-jobs' AND post_type = 'page';
        

        -- Page: Contact Us
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<h2>CONTACT US</h2>

<h3>Our Headquarters Address</h3>
<p><strong>60 Nguyen Van Thu, Ward Da Kao, District 1, Ho Chi Minh City, Viet Nam</strong></p>

<h3>For Employers</h3>
<p>Call our Sales Hotline:<br>
• Ho Chi Minh City<br>
• Ha Noi<br>
Request a call from one of our Customer Love Account Managers. We''re ready to help you grow!</p>

<h3>For Jobseekers</h3>
<p>Ask a question on our Facebook page.<br>
Read our blog posts on interview and CV tips.<br>
Call us at our support hotline.</p>
', 'Contact Us', '',
            'publish', 'closed', 'closed', '', 'contact-us', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'page', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'contact-us' AND post_type = 'page');

        UPDATE wp_posts
        SET post_content = '<h2>CONTACT US</h2>

<h3>Our Headquarters Address</h3>
<p><strong>60 Nguyen Van Thu, Ward Da Kao, District 1, Ho Chi Minh City, Viet Nam</strong></p>

<h3>For Employers</h3>
<p>Call our Sales Hotline:<br>
• Ho Chi Minh City<br>
• Ha Noi<br>
Request a call from one of our Customer Love Account Managers. We''re ready to help you grow!</p>

<h3>For Jobseekers</h3>
<p>Ask a question on our Facebook page.<br>
Read our blog posts on interview and CV tips.<br>
Call us at our support hotline.</p>
',
            post_title = 'Contact Us',
            post_status = 'publish'
        WHERE post_name = 'contact-us' AND post_type = 'page';
        

        -- News Post: Project Development
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. We are experts in all stages of project development: concept, design, implementation and management.', 'Project Development', '',
            'publish', 'open', 'open', '', 'project-development', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'post', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'project-development' AND post_type = 'post');

        UPDATE wp_posts
        SET post_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. We are experts in all stages of project development: concept, design, implementation and management.',
            post_title = 'Project Development',
            post_status = 'publish'
        WHERE post_name = 'project-development' AND post_type = 'post';
        

        -- News Post: Hospitality Consulting
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Providing warm, non-intrusive service and anticipating customer needs.', 'Hospitality Consulting', '',
            'publish', 'open', 'open', '', 'hospitality-consulting', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'post', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'hospitality-consulting' AND post_type = 'post');

        UPDATE wp_posts
        SET post_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Providing warm, non-intrusive service and anticipating customer needs.',
            post_title = 'Hospitality Consulting',
            post_status = 'publish'
        WHERE post_name = 'hospitality-consulting' AND post_type = 'post';
        

        -- News Post: Restaurant & Hotel Management And Operations
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Operational excellence across luxury venues.', 'Restaurant & Hotel Management And Operations', '',
            'publish', 'open', 'open', '', 'restaurant-hotel-management-and-operations', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'post', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'restaurant-hotel-management-and-operations' AND post_type = 'post');

        UPDATE wp_posts
        SET post_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Operational excellence across luxury venues.',
            post_title = 'Restaurant & Hotel Management And Operations',
            post_status = 'publish'
        WHERE post_name = 'restaurant-hotel-management-and-operations' AND post_type = 'post';
        

        -- News Post: Venue And Interior Design
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Each venue carries its own unique concept and authentic aesthetic.', 'Venue And Interior Design', '',
            'publish', 'open', 'open', '', 'venue-and-interior-design', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'post', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'venue-and-interior-design' AND post_type = 'post');

        UPDATE wp_posts
        SET post_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Each venue carries its own unique concept and authentic aesthetic.',
            post_title = 'Venue And Interior Design',
            post_status = 'publish'
        WHERE post_name = 'venue-and-interior-design' AND post_type = 'post';
        

        -- News Post: Chief Operating Officer Hotel/ Resort Chain Update
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<p>CHIEF OPERATING OFFICER HOTEL / RESORT CHAIN - PDS NEWS UPDATE.</p>
<p>Plan Do See operates 17 properties worldwide including 3 award-winning resorts in Japan, and 17 restaurants of diverse cuisines worldwide. Our executives and leadership ensure optimal hospitality standards, exceptional customer experiences, and premier resort management.</p>
<p>We believe in selfless hospitality ("Omotenashi") and empower all team members to deliver unforgettable service across all destinations.</p>
', 'Chief Operating Officer Hotel/ Resort Chain Update', '',
            'publish', 'open', 'open', '', 'coo-hotel-resort-chain-update', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'post', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'coo-hotel-resort-chain-update' AND post_type = 'post');

        UPDATE wp_posts
        SET post_content = '<p>CHIEF OPERATING OFFICER HOTEL / RESORT CHAIN - PDS NEWS UPDATE.</p>
<p>Plan Do See operates 17 properties worldwide including 3 award-winning resorts in Japan, and 17 restaurants of diverse cuisines worldwide. Our executives and leadership ensure optimal hospitality standards, exceptional customer experiences, and premier resort management.</p>
<p>We believe in selfless hospitality ("Omotenashi") and empower all team members to deliver unforgettable service across all destinations.</p>
',
            post_title = 'Chief Operating Officer Hotel/ Resort Chain Update',
            post_status = 'publish'
        WHERE post_name = 'coo-hotel-resort-chain-update' AND post_type = 'post';
        

        -- Job: HOTEL MANAGER
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<h3>Job Responsibilities</h3>
<p>• Be responsible for the effective operational management of the hotel.<br>
• Coordinate with department heads to maintain outstanding guest satisfaction.<br>
• Ensure high compliance with hospitality safety, hygiene, and service standards.</p>

<h3>Benefits & Compensation</h3>
<p>• Excellent salary bonuses & recognition activities.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Dynamic, professional Japanese hospitality working environment.</p>
', 'HOTEL MANAGER', '',
            'publish', 'closed', 'closed', '', 'hotel-manager', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'job_listing', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'hotel-manager' AND post_type = 'job_listing');

        UPDATE wp_posts
        SET post_content = '<h3>Job Responsibilities</h3>
<p>• Be responsible for the effective operational management of the hotel.<br>
• Coordinate with department heads to maintain outstanding guest satisfaction.<br>
• Ensure high compliance with hospitality safety, hygiene, and service standards.</p>

<h3>Benefits & Compensation</h3>
<p>• Excellent salary bonuses & recognition activities.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Dynamic, professional Japanese hospitality working environment.</p>
',
            post_title = 'HOTEL MANAGER',
            post_status = 'publish'
        WHERE post_name = 'hotel-manager' AND post_type = 'job_listing';
        

            DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'hotel-manager' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_job_location', 'Ho Chi Minh City / Tokyo'
            FROM wp_posts WHERE post_name = 'hotel-manager' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'hotel-manager' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_company_name', 'S 0TbEoH'
            FROM wp_posts WHERE post_name = 'hotel-manager' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'hotel-manager' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_filled', '0'
            FROM wp_posts WHERE post_name = 'hotel-manager' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'hotel-manager' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_featured', '0'
            FROM wp_posts WHERE post_name = 'hotel-manager' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'hotel-manager' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_job_expires', '2028-12-31'
            FROM wp_posts WHERE post_name = 'hotel-manager' AND post_type = 'job_listing';
            

        -- Job: GENERAL MANAGER - LEADING HOTEL CHAIN
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<h3>Job Responsibilities</h3>
<p>• Be responsible for the effective operational management of the hotel.<br>
• Coordinate with department heads to maintain outstanding guest satisfaction.<br>
• Ensure high compliance with hospitality safety, hygiene, and service standards.</p>

<h3>Benefits & Compensation</h3>
<p>• Excellent salary bonuses & recognition activities.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Dynamic, professional Japanese hospitality working environment.</p>
', 'GENERAL MANAGER - LEADING HOTEL CHAIN', '',
            'publish', 'closed', 'closed', '', 'general-manager-leading-hotel-chain', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'job_listing', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'general-manager-leading-hotel-chain' AND post_type = 'job_listing');

        UPDATE wp_posts
        SET post_content = '<h3>Job Responsibilities</h3>
<p>• Be responsible for the effective operational management of the hotel.<br>
• Coordinate with department heads to maintain outstanding guest satisfaction.<br>
• Ensure high compliance with hospitality safety, hygiene, and service standards.</p>

<h3>Benefits & Compensation</h3>
<p>• Excellent salary bonuses & recognition activities.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Dynamic, professional Japanese hospitality working environment.</p>
',
            post_title = 'GENERAL MANAGER - LEADING HOTEL CHAIN',
            post_status = 'publish'
        WHERE post_name = 'general-manager-leading-hotel-chain' AND post_type = 'job_listing';
        

            DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'general-manager-leading-hotel-chain' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_job_location', 'Ho Chi Minh City'
            FROM wp_posts WHERE post_name = 'general-manager-leading-hotel-chain' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'general-manager-leading-hotel-chain' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_company_name', 'GARDEN'
            FROM wp_posts WHERE post_name = 'general-manager-leading-hotel-chain' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'general-manager-leading-hotel-chain' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_filled', '0'
            FROM wp_posts WHERE post_name = 'general-manager-leading-hotel-chain' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'general-manager-leading-hotel-chain' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_featured', '1'
            FROM wp_posts WHERE post_name = 'general-manager-leading-hotel-chain' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'general-manager-leading-hotel-chain' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_job_expires', '2028-12-31'
            FROM wp_posts WHERE post_name = 'general-manager-leading-hotel-chain' AND post_type = 'job_listing';
            

        -- Job: BANQUET MANAGER
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<h3>Job Responsibilities</h3>
<p>• Be responsible for the effective operational management of the hotel.<br>
• Coordinate with department heads to maintain outstanding guest satisfaction.<br>
• Ensure high compliance with hospitality safety, hygiene, and service standards.</p>

<h3>Benefits & Compensation</h3>
<p>• Excellent salary bonuses & recognition activities.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Dynamic, professional Japanese hospitality working environment.</p>
', 'BANQUET MANAGER', '',
            'publish', 'closed', 'closed', '', 'banquet-manager', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'job_listing', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'banquet-manager' AND post_type = 'job_listing');

        UPDATE wp_posts
        SET post_content = '<h3>Job Responsibilities</h3>
<p>• Be responsible for the effective operational management of the hotel.<br>
• Coordinate with department heads to maintain outstanding guest satisfaction.<br>
• Ensure high compliance with hospitality safety, hygiene, and service standards.</p>

<h3>Benefits & Compensation</h3>
<p>• Excellent salary bonuses & recognition activities.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Dynamic, professional Japanese hospitality working environment.</p>
',
            post_title = 'BANQUET MANAGER',
            post_status = 'publish'
        WHERE post_name = 'banquet-manager' AND post_type = 'job_listing';
        

            DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'banquet-manager' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_job_location', 'Ho Chi Minh City'
            FROM wp_posts WHERE post_name = 'banquet-manager' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'banquet-manager' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_company_name', 'The Seygn House'
            FROM wp_posts WHERE post_name = 'banquet-manager' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'banquet-manager' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_filled', '0'
            FROM wp_posts WHERE post_name = 'banquet-manager' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'banquet-manager' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_featured', '0'
            FROM wp_posts WHERE post_name = 'banquet-manager' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'banquet-manager' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_job_expires', '2028-12-31'
            FROM wp_posts WHERE post_name = 'banquet-manager' AND post_type = 'job_listing';
            

        -- Job: BELLMAN
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<h3>Job Responsibilities</h3>
<p>• Be responsible for the effective operational management of the hotel.<br>
• Coordinate with department heads to maintain outstanding guest satisfaction.<br>
• Ensure high compliance with hospitality safety, hygiene, and service standards.</p>

<h3>Benefits & Compensation</h3>
<p>• Excellent salary bonuses & recognition activities.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Dynamic, professional Japanese hospitality working environment.</p>
', 'BELLMAN', '',
            'publish', 'closed', 'closed', '', 'bellman', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'job_listing', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'bellman' AND post_type = 'job_listing');

        UPDATE wp_posts
        SET post_content = '<h3>Job Responsibilities</h3>
<p>• Be responsible for the effective operational management of the hotel.<br>
• Coordinate with department heads to maintain outstanding guest satisfaction.<br>
• Ensure high compliance with hospitality safety, hygiene, and service standards.</p>

<h3>Benefits & Compensation</h3>
<p>• Excellent salary bonuses & recognition activities.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Dynamic, professional Japanese hospitality working environment.</p>
',
            post_title = 'BELLMAN',
            post_status = 'publish'
        WHERE post_name = 'bellman' AND post_type = 'job_listing';
        

            DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'bellman' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_job_location', 'Ho Chi Minh City'
            FROM wp_posts WHERE post_name = 'bellman' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'bellman' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_company_name', 'PDS Luxury Hotel'
            FROM wp_posts WHERE post_name = 'bellman' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'bellman' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_filled', '0'
            FROM wp_posts WHERE post_name = 'bellman' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'bellman' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_featured', '0'
            FROM wp_posts WHERE post_name = 'bellman' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'bellman' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_job_expires', '2028-12-31'
            FROM wp_posts WHERE post_name = 'bellman' AND post_type = 'job_listing';
            

        -- Job: LOSS PREVENTION OFFICER
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<h3>Job Responsibilities</h3>
<p>• Be responsible for the effective operational management of the hotel.<br>
• Coordinate with department heads to maintain outstanding guest satisfaction.<br>
• Ensure high compliance with hospitality safety, hygiene, and service standards.</p>

<h3>Benefits & Compensation</h3>
<p>• Excellent salary bonuses & recognition activities.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Dynamic, professional Japanese hospitality working environment.</p>
', 'LOSS PREVENTION OFFICER', '',
            'publish', 'closed', 'closed', '', 'loss-prevention-officer', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'job_listing', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'loss-prevention-officer' AND post_type = 'job_listing');

        UPDATE wp_posts
        SET post_content = '<h3>Job Responsibilities</h3>
<p>• Be responsible for the effective operational management of the hotel.<br>
• Coordinate with department heads to maintain outstanding guest satisfaction.<br>
• Ensure high compliance with hospitality safety, hygiene, and service standards.</p>

<h3>Benefits & Compensation</h3>
<p>• Excellent salary bonuses & recognition activities.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Dynamic, professional Japanese hospitality working environment.</p>
',
            post_title = 'LOSS PREVENTION OFFICER',
            post_status = 'publish'
        WHERE post_name = 'loss-prevention-officer' AND post_type = 'job_listing';
        

            DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'loss-prevention-officer' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_job_location', 'Ho Chi Minh City'
            FROM wp_posts WHERE post_name = 'loss-prevention-officer' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'loss-prevention-officer' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_company_name', 'PHd THIN'
            FROM wp_posts WHERE post_name = 'loss-prevention-officer' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'loss-prevention-officer' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_filled', '0'
            FROM wp_posts WHERE post_name = 'loss-prevention-officer' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'loss-prevention-officer' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_featured', '0'
            FROM wp_posts WHERE post_name = 'loss-prevention-officer' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'loss-prevention-officer' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_job_expires', '2028-12-31'
            FROM wp_posts WHERE post_name = 'loss-prevention-officer' AND post_type = 'job_listing';
            

        -- Job: CHIEF OPERATING OFFICER HOTEL/ RESORT CHAIN
        INSERT INTO wp_posts (
            post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
            post_status, comment_status, ping_status, post_password, post_name, to_ping,
            pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid,
            menu_order, post_type, post_mime_type, comment_count
        )
        SELECT 
            1, NOW(), NOW(), '<h3>Overview about Company</h3>
<p>Plan Do See Global is a hospitality group founded in Japan and rooted in "Omotenashi", the Japanese principle of selfless hospitality. We operate award-winning resorts in Japan, premier restaurants worldwide, and high-end banquet properties.</p>

<h3>Our Key Skills</h3>
<p>• Strategic executive management and resort operational excellence.<br>
• Experience leading multi-unit hospitality chains.<br>
• Proven track record in guest satisfaction, revenue growth, and staff leadership.<br>
• Strong bilingual communication skills.</p>

<h3>Why You''ll Love Working Here</h3>
<p>• Be responsible for the effective operational management of luxury hotel and resort chains.<br>
• Excellent salary, performance bonuses & executive recognition programs.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Global mobility and career advancement opportunities across international properties.</p>

<h3>Location</h3>
<p>Ho Chi Minh City, Viet Nam.</p>
', 'CHIEF OPERATING OFFICER HOTEL/ RESORT CHAIN', '',
            'publish', 'closed', 'closed', '', 'chief-operating-officer-hotel-resort-chain', '',
            '', NOW(), NOW(), '', 0, '',
            0, 'job_listing', '', 0
        WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'chief-operating-officer-hotel-resort-chain' AND post_type = 'job_listing');

        UPDATE wp_posts
        SET post_content = '<h3>Overview about Company</h3>
<p>Plan Do See Global is a hospitality group founded in Japan and rooted in "Omotenashi", the Japanese principle of selfless hospitality. We operate award-winning resorts in Japan, premier restaurants worldwide, and high-end banquet properties.</p>

<h3>Our Key Skills</h3>
<p>• Strategic executive management and resort operational excellence.<br>
• Experience leading multi-unit hospitality chains.<br>
• Proven track record in guest satisfaction, revenue growth, and staff leadership.<br>
• Strong bilingual communication skills.</p>

<h3>Why You''ll Love Working Here</h3>
<p>• Be responsible for the effective operational management of luxury hotel and resort chains.<br>
• Excellent salary, performance bonuses & executive recognition programs.<br>
• Foreign language allowance (up to 500 USD / month).<br>
• Global mobility and career advancement opportunities across international properties.</p>

<h3>Location</h3>
<p>Ho Chi Minh City, Viet Nam.</p>
',
            post_title = 'CHIEF OPERATING OFFICER HOTEL/ RESORT CHAIN',
            post_status = 'publish'
        WHERE post_name = 'chief-operating-officer-hotel-resort-chain' AND post_type = 'job_listing';
        

            DELETE FROM wp_postmeta WHERE meta_key = '_job_location' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'chief-operating-officer-hotel-resort-chain' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_job_location', 'Ho Chi Minh City'
            FROM wp_posts WHERE post_name = 'chief-operating-officer-hotel-resort-chain' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_company_name' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'chief-operating-officer-hotel-resort-chain' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_company_name', 'SODOH'
            FROM wp_posts WHERE post_name = 'chief-operating-officer-hotel-resort-chain' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_filled' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'chief-operating-officer-hotel-resort-chain' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_filled', '0'
            FROM wp_posts WHERE post_name = 'chief-operating-officer-hotel-resort-chain' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_featured' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'chief-operating-officer-hotel-resort-chain' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_featured', '1'
            FROM wp_posts WHERE post_name = 'chief-operating-officer-hotel-resort-chain' AND post_type = 'job_listing';
            

            DELETE FROM wp_postmeta WHERE meta_key = '_job_expires' AND post_id IN (SELECT ID FROM wp_posts WHERE post_name = 'chief-operating-officer-hotel-resort-chain' AND post_type = 'job_listing');
            INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
            SELECT ID, '_job_expires', '2028-12-31'
            FROM wp_posts WHERE post_name = 'chief-operating-officer-hotel-resort-chain' AND post_type = 'job_listing';
            