<?php
session_start();

// Xóa tất cả các biến session
$_SESSION = array();

// Nếu session đang sử dụng cookie, xóa cookie của session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params(); // Lấy thông tin cookie của session
    setcookie(session_name(), '', time() - 60*60, // Đặt lại thời gian hết hạn cookie (quá hạn để xóa)
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"]
    );
}

unset($_SESSION['login']);

// Hủy toàn bộ session
session_destroy();

// Chuyển hướng người dùng về trang chủ
header("location:index.php"); 
exit; 
?>
