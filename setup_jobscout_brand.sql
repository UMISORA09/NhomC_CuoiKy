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
