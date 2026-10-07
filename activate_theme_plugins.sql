USE cms_nhomc;
UPDATE wp_options SET option_value = 'jobscout' WHERE option_name IN ('template', 'stylesheet');
UPDATE wp_options SET option_value = 'JobScout' WHERE option_name = 'current_theme';
UPDATE wp_options SET option_value = 'a:4:{i:0;s:27:"wp-job-manager/wp-job-manager.php";i:1;s:31:"wpjm-extra-fields/wpjm-extra-fields.php";i:2;s:37:"raratheme-companion/raratheme-companion.php";i:3;s:45:"rara-one-click-demo-import/rara-one-click-demo-import.php";}' WHERE option_name = 'active_plugins';
