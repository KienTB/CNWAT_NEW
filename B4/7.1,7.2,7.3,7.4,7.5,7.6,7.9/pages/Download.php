<?php
// Kiểm tra nếu có yêu cầu tải xuống tệp thông qua query string
if (isset($_GET['file'])) {
    // Lấy tên file từ query string
    $file = basename($_GET['file']);
    
    // Đường dẫn tới thư mục chứa tệp tải lên
    $filePath = '../uploads/' . $file;

    // Kiểm tra tệp có tồn tại trong thư mục hay không
    if (file_exists($filePath)) {
        // Cài đặt header để tải tệp về
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Đọc và xuất nội dung tệp ra để tải về
        readfile($filePath);
        exit;
    } else {
        // Thông báo lỗi nếu tệp không tồn tại
        echo "Tệp không tồn tại.";
    }
} else {
    // Thông báo lỗi nếu không có tệp được chỉ định
    echo "Không có tệp nào được chỉ định để tải xuống.";
}
?>
