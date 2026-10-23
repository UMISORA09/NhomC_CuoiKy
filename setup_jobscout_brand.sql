-- Cap nhat Site Title va Tagline theo NhomC mockup
UPDATE wp_options SET option_value = 'NhomC' WHERE option_name = 'blogname';
UPDATE wp_options SET option_value = 'Recruiting & Career Opportunities' WHERE option_name = 'blogdescription';
UPDATE wp_options SET option_value = 'http://wordpressc:8080' WHERE option_name IN ('siteurl', 'home');

-- Thiet lap Front page la trang Home va Blog page la News
UPDATE wp_options SET option_value = 'page' WHERE option_name = 'show_on_front';
UPDATE wp_options 
SET option_value = (SELECT ID FROM wp_posts WHERE post_name = 'home' AND post_type = 'page' LIMIT 1) 
WHERE option_name = 'page_on_front';

UPDATE wp_options 
SET option_value = (SELECT ID FROM wp_posts WHERE post_name = 'news' AND post_type = 'page' LIMIT 1) 
WHERE option_name = 'page_for_posts';

-- Dam bao trang News Detail (xuanhoa/6-newsdetail) luon ton tai trong CSDL tren moi may tinh
INSERT INTO wp_posts (post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count)
SELECT 1, NOW(), NOW(), '', 'News Detail', '', 'publish', 'closed', 'closed', 'news-detail', '', '', NOW(), NOW(), '', 0, 'http://localhost:8080/?page_id=985', 0, 'page', '', 0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_name = 'news-detail' AND post_type = 'page');

INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
SELECT ID, '_wp_page_template', 'template-news-detail.php'
FROM wp_posts
WHERE post_name = 'news-detail' AND post_type = 'page'
AND NOT EXISTS (
    SELECT 1 FROM wp_postmeta WHERE post_id = wp_posts.ID AND meta_key = '_wp_page_template'
);

-- Cau hinh trang Submit Job (VinhEm/submitjob) - Nhom C
UPDATE wp_options SET option_value = '0' WHERE option_name = 'job_manager_user_requires_account';
UPDATE wp_options SET option_value = '1' WHERE option_name = 'job_manager_enable_categories';
UPDATE wp_options SET option_value = '1' WHERE option_name = 'job_manager_enable_salary';
UPDATE wp_options SET option_value = '0' WHERE option_name = 'job_manager_submission_requires_approval';
UPDATE wp_posts SET post_name = 'post-a-job' WHERE ID = 982;


