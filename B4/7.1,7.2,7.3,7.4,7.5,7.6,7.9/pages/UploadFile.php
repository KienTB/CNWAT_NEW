<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>associateArray</title>
    <style>
        /* Thiết lập khoảng cách cho input kiểu file */
        input[type="file"] {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h2>Tải lên Tệp</h2>

    <!-- Form tải lên tệp -->
    <form method="post" enctype="multipart/form-data">
        <?php
        // Tạo 10 ô nhập để tải lên tệp
        for ($i = 0; $i < 10; $i++) {
            echo '<label for="files">File ' . ($i + 1) . ':</label>';
            echo '<input type="file" name="files[]" ><br>';
        }
        ?>
        <!-- Nút để tải lên và reset -->
        <button type="submit" name="upload">Upload</button>
        <button type="reset" name="reset">Reset</button>
    </form>

    <?php
    // Đường dẫn tới thư mục lưu trữ tệp đã tải lên
    $uploadDir = '../uploads/';

    // Kiểm tra và tạo thư mục nếu chưa tồn tại
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Tạo thư mục với quyền 0777
    }

    // Kiểm tra nếu người dùng đã nhấn nút "Upload"
    if (isset($_POST['upload'])) {
        // Mảng chứa tên các tệp đã được tải lên
        $fileNames = $_FILES['files']['name'];

        // Mảng chứa đường dẫn của các tệp đã tải lên thành công
        $filePaths = [];

        // Duyệt qua từng tệp đã tải lên
        foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
            // Đường dẫn đầy đủ để lưu tệp
            $filePath = $uploadDir . basename($fileNames[$key]);

            // Kiểm tra và di chuyển tệp từ thư mục tạm vào thư mục đích
            if (move_uploaded_file($tmpName, $filePath)) {
                $filePaths[] = $filePath; // Lưu đường dẫn của tệp đã tải lên thành công
            } else {
                // Xử lý trường hợp không có tên tệp (người dùng không chọn tệp)
                if (empty($fileNames[$key])) {
                    // Không có tệp nào được chọn, bỏ qua
                } else {
                    // Báo lỗi nếu tệp không được tải lên thành công
                    echo "Có lỗi khi tải lên tệp: " . htmlspecialchars($fileNames[$key]) . "<br>";
                }
            }
        }

        // Nếu có tệp đã tải lên thành công, hiển thị danh sách tệp
        if (!empty($filePaths)) {
            echo "<h3>Các file đã tải lên:</h3>";
            foreach ($filePaths as $filePath) {
                // Hiển thị tên tệp và liên kết tải xuống
                echo "Download File: " . htmlspecialchars(basename($filePath)) . " - <a href='download.php?file=" . urlencode(basename($filePath)) . "'>Tải xuống</a><br>";

            }
        }
    }
    ?>
</body>
</html>
