<?php
    // Lấy thông tin từ Biến Môi Trường (Azure) hoặc dùng giá trị mặc định (local)
    $db_host = getenv('DB_HOST') ?: 'localhost';
    $db_user = getenv('DB_USER') ?: 'guha'; // Dùng giá trị cũ 'guha' làm fallback
    $db_pass = getenv('DB_PASS') ?: '030204'; // Dùng giá trị cũ '030204' làm fallback
    $db_name = getenv('DB_NAME') ?: 'dbperfume_new';

    // Kết nối
    $mysqli = mysqli_init();
    
    // Nếu là Azure (có DB_HOST trong env), sử dụng SSL
    if (getenv('DB_HOST')) {
        $mysqli->ssl_set(NULL, NULL, NULL, NULL, NULL);
        $mysqli->real_connect($db_host, $db_user, $db_pass, $db_name, 3306, NULL, MYSQLI_CLIENT_SSL);
    } else {
        // Local connection không cần SSL
        $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    }

    // Check connection
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }
?>
