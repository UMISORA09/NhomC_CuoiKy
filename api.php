<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$action = isset($_GET['action']) ? $_GET['action'] : 'status';

$host = 'db:3306';
$user = 'wordpress';
$pass = 'wordpresspassword';
$dbname = 'wordpress';

$conn = @new mysqli('db', $user, $pass, $dbname, 3306);

if ($conn->connect_error) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Không thể kết nối CSDL: ' . $conn->connect_error
    ]);
    exit;
}

$conn->set_charset('utf8mb4');

if ($action === 'status') {
    // Dem so tables
    $tableRes = $conn->query("SHOW TABLES");
    $tables = $tableRes ? $tableRes->num_rows : 0;

    // Kiem tra theme
    $themeRes = $conn->query("SELECT option_value FROM wp_options WHERE option_name = 'stylesheet' LIMIT 1");
    $theme = ($themeRes && $row = $themeRes->fetch_assoc()) ? $row['option_value'] : 'unknown';

    // Dem so users
    $userRes = $conn->query("SELECT COUNT(*) as cnt FROM wp_users");
    $users = ($userRes && $row = $userRes->fetch_assoc()) ? (int)$row['cnt'] : 0;

    // Dem so posts
    $postRes = $conn->query("SELECT COUNT(*) as cnt FROM wp_posts WHERE post_status = 'publish'");
    $posts = ($postRes && $row = $postRes->fetch_assoc()) ? (int)$row['cnt'] : 0;

    // Site Title
    $titleRes = $conn->query("SELECT option_value FROM wp_options WHERE option_name = 'blogname' LIMIT 1");
    $blogname = ($titleRes && $row = $titleRes->fetch_assoc()) ? $row['option_value'] : 'WordPress';

    echo json_encode([
        'status' => 'ok',
        'db_name' => $dbname,
        'tables_count' => $tables,
        'active_theme' => $theme,
        'users_count' => $users,
        'posts_count' => $posts,
        'site_title' => $blogname,
        'php_version' => phpversion(),
        'server_time' => date('Y-m-d H:i:s')
    ]);
    exit;
}

if ($action === 'sync_brand') {
    $conn->query("UPDATE wp_options SET option_value = 'JobScout' WHERE option_name = 'blogname'");
    $conn->query("UPDATE wp_options SET option_value = 'Find Your Dream Jobs' WHERE option_name = 'blogdescription'");
    $conn->query("UPDATE wp_options SET option_value = 'page' WHERE option_name = 'show_on_front'");
    
    $homeRes = $conn->query("SELECT ID FROM wp_posts WHERE post_name = 'home' AND post_type = 'page' LIMIT 1");
    if ($homeRes && $row = $homeRes->fetch_assoc()) {
        $conn->query("UPDATE wp_options SET option_value = '{$row['ID']}' WHERE option_name = 'page_on_front'");
    }
    
    $newsRes = $conn->query("SELECT ID FROM wp_posts WHERE post_name = 'news' AND post_type = 'page' LIMIT 1");
    if ($newsRes && $row = $newsRes->fetch_assoc()) {
        $conn->query("UPDATE wp_options SET option_value = '{$row['ID']}' WHERE option_name = 'page_for_posts'");
    }

    echo json_encode(['status' => 'ok', 'message' => 'Đã cập nhật thương hiệu JobScout và Front Page!']);
    exit;
}

if ($action === 'activate_theme') {
    $conn->query("UPDATE wp_options SET option_value = 'jobscout' WHERE option_name IN ('template', 'stylesheet')");
    $conn->query("UPDATE wp_options SET option_value = 'JobScout' WHERE option_name = 'current_theme'");
    $active_plugins = 'a:4:{i:0;s:27:"wp-job-manager/wp-job-manager.php";i:1;s:31:"wpjm-extra-fields/wpjm-extra-fields.php";i:2;s:37:"raratheme-companion/raratheme-companion.php";i:3;s:45:"rara-one-click-demo-import/rara-one-click-demo-import.php";}';
    $stmt = $conn->prepare("UPDATE wp_options SET option_value = ? WHERE option_name = 'active_plugins'");
    $stmt->bind_param("s", $active_plugins);
    $stmt->execute();

    echo json_encode(['status' => 'ok', 'message' => 'Đã kích hoạt Theme JobScout và 4 Plugin thành công!']);
    exit;
}

echo json_encode(['status' => 'unknown_action']);
