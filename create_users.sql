-- Script tao va cap nhat 6 tai khoan Administrator cho Nhom C
SET NAMES utf8mb4;

-- Cap nhat mat khau Password@123 va thong tin cho cac user hien co
UPDATE wp_users 
SET user_pass = MD5('Password@123'),
    user_email = 'vhoa1682006@gmail.com',
    display_name = 'Văn Nguyễn Xuân Hòa'
WHERE user_login = 'xuanhoa';

UPDATE wp_users 
SET user_pass = MD5('Password@123'),
    user_email = 'thenghien2006@gmail.com',
    display_name = 'Nguyễn Thanh Hiền'
WHERE user_login = 'thanhhien';

UPDATE wp_users 
SET user_pass = MD5('Password@123'),
    user_email = 'trumvinh85@gmail.com',
    display_name = 'Huỳnh Văn Vinh Em'
WHERE user_login = 'vinhem';

UPDATE wp_users 
SET user_pass = MD5('Password@123'),
    user_email = 'nguyquy67@gmail.com',
    display_name = 'Nguyễn Anh Quý'
WHERE user_login = 'anhquy';

UPDATE wp_users 
SET user_pass = MD5('Password@123'),
    user_email = 'dn1275102@gmail.com',
    display_name = 'Đặng Đăng Nguyên'
WHERE user_login = 'dangnguyen';

UPDATE wp_users 
SET user_pass = MD5('Password@123'),
    user_email = 'admin_nhomc@fit.tdc.edu.vn',
    display_name = 'Quản Trị Viên Nhóm C'
WHERE user_login = 'admin_nhomc';

-- Neu chua co user nao thi them moi
INSERT INTO wp_users (user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, display_name)
SELECT 'xuanhoa', MD5('Password@123'), 'xuanhoa', 'vhoa1682006@gmail.com', '', NOW(), '', 0, 'Văn Nguyễn Xuân Hòa'
WHERE NOT EXISTS (SELECT 1 FROM wp_users WHERE user_login = 'xuanhoa');

INSERT INTO wp_users (user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, display_name)
SELECT 'thanhhien', MD5('Password@123'), 'thanhhien', 'thenghien2006@gmail.com', '', NOW(), '', 0, 'Nguyễn Thanh Hiền'
WHERE NOT EXISTS (SELECT 1 FROM wp_users WHERE user_login = 'thanhhien');

INSERT INTO wp_users (user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, display_name)
SELECT 'vinhem', MD5('Password@123'), 'vinhem', 'trumvinh85@gmail.com', '', NOW(), '', 0, 'Huỳnh Văn Vinh Em'
WHERE NOT EXISTS (SELECT 1 FROM wp_users WHERE user_login = 'vinhem');

INSERT INTO wp_users (user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, display_name)
SELECT 'anhquy', MD5('Password@123'), 'anhquy', 'nguyquy67@gmail.com', '', NOW(), '', 0, 'Nguyễn Anh Quý'
WHERE NOT EXISTS (SELECT 1 FROM wp_users WHERE user_login = 'anhquy');

INSERT INTO wp_users (user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, display_name)
SELECT 'dangnguyen', MD5('Password@123'), 'dangnguyen', 'dn1275102@gmail.com', '', NOW(), '', 0, 'Đặng Đăng Nguyên'
WHERE NOT EXISTS (SELECT 1 FROM wp_users WHERE user_login = 'dangnguyen');

INSERT INTO wp_users (user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, display_name)
SELECT 'admin_nhomc', MD5('Password@123'), 'admin_nhomc', 'admin_nhomc@fit.tdc.edu.vn', '', NOW(), '', 0, 'Quản Trị Viên Nhóm C'
WHERE NOT EXISTS (SELECT 1 FROM wp_users WHERE user_login = 'admin_nhomc');

-- Xoa cap quyen cu cua 6 user nay de tranh trung lap
DELETE FROM wp_usermeta 
WHERE meta_key IN ('wp_capabilities', 'wp_user_level', 'nickname', 'first_name', 'last_name')
  AND user_id IN (
    SELECT ID FROM wp_users WHERE user_login IN ('xuanhoa', 'thanhhien', 'vinhem', 'anhquy', 'dangnguyen', 'admin_nhomc')
  );

-- Gan quyen Administrator (wp_capabilities)
INSERT INTO wp_usermeta (user_id, meta_key, meta_value)
SELECT ID, 'wp_capabilities', 'a:1:{s:13:"administrator";b:1;}'
FROM wp_users 
WHERE user_login IN ('xuanhoa', 'thanhhien', 'vinhem', 'anhquy', 'dangnguyen', 'admin_nhomc');

-- Gan cap do 10 (wp_user_level)
INSERT INTO wp_usermeta (user_id, meta_key, meta_value)
SELECT ID, 'wp_user_level', '10'
FROM wp_users 
WHERE user_login IN ('xuanhoa', 'thanhhien', 'vinhem', 'anhquy', 'dangnguyen', 'admin_nhomc');

-- Gan nickname
INSERT INTO wp_usermeta (user_id, meta_key, meta_value)
SELECT ID, 'nickname', user_login
FROM wp_users 
WHERE user_login IN ('xuanhoa', 'thanhhien', 'vinhem', 'anhquy', 'dangnguyen', 'admin_nhomc');
