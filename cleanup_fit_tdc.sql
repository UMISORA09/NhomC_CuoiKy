USE cms_nhomc;

-- 1. Xoa bo toan bo bai viet va trang FIT TDC cu
DELETE FROM wp_postmeta 
WHERE post_id IN (SELECT ID FROM wp_posts WHERE ID BETWEEN 68 AND 79 OR ID IN (2, 3, 96, 97, 98));

DELETE FROM wp_term_relationships 
WHERE object_id IN (SELECT ID FROM wp_posts WHERE ID BETWEEN 68 AND 79 OR ID IN (2, 3, 96, 97, 98));

DELETE FROM wp_comments 
WHERE comment_post_ID IN (SELECT ID FROM wp_posts WHERE ID BETWEEN 68 AND 79 OR ID IN (2, 3, 96, 97, 98));

DELETE FROM wp_posts 
WHERE ID BETWEEN 68 AND 79 OR ID IN (2, 3, 96, 97, 98);

-- 2. Cap nhat Site Title va Tagline theo JobScout mockup
UPDATE wp_options SET option_value = 'JobScout' WHERE option_name = 'blogname';
UPDATE wp_options SET option_value = 'Find Your Dream Jobs' WHERE option_name = 'blogdescription';

-- 3. Thiet lap Front page la trang Home va Blog page la News
UPDATE wp_options SET option_value = 'page' WHERE option_name = 'show_on_front';
UPDATE wp_options 
SET option_value = (SELECT ID FROM wp_posts WHERE post_name = 'home' AND post_type = 'page' LIMIT 1) 
WHERE option_name = 'page_on_front';

UPDATE wp_options 
SET option_value = (SELECT ID FROM wp_posts WHERE post_name = 'news' AND post_type = 'page' LIMIT 1) 
WHERE option_name = 'page_for_posts';

-- 4. Xoa cac chuyen muc FIT TDC khong lien quan
DELETE FROM wp_terms WHERE slug IN ('tin-tuc', 'tuyen-sinh', 'dao-tao', 'sinh-vien', 'hoat-dong', 'noi-bat', 'chua-phan-loai');
