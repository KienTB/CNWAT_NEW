<?php
session_start(); 

// Xóa tất cả các biến phiên
$_SESSION = array();

// Kiểm tra xem cookie phiên có đang được sử dụng không
if (ini_get("session.use_cookies")) {
    // Lấy các tham số cookie hiện tại
    $params = session_get_cookie_params();
    
    // Thiết lập cookie phiên để hết hạn
    setcookie(session_name(), '', time() - 3600,  // Thời gian hết hạn là 1 giờ trước
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// Xóa biến phiên 'login' nếu có
unset($_SESSION['login']);

// Hủy phiên
session_destroy(); 

// Chuyển hướng người dùng về trang index.php
header("Location: index.php"); 
exit; 
?>
