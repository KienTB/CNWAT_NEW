<?php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','123456');
define('DB_NAME','cnwat');
define('DB_PORT', 3307);

// Kết nối tới cơ sở dữ liệu với MySQLi
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
