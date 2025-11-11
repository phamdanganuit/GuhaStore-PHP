<?php
    // Lấy thông tin từ Biến Môi Trường (Azure) hoặc dùng giá trị mặc định (local)
    $db_host = getenv('DB_HOST') ?: 'localhost';
    $db_user = getenv('DB_USER') ?: 'guha'; // Dùng giá trị cũ 'guha' làm fallback
    $db_pass = getenv('DB_PASS') ?: '030204'; // Dùng giá trị cũ '030204' làm fallback
    $db_name = getenv('DB_NAME') ?: 'dbperfume_new';

    // Kết nối
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check connection
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }
?>
