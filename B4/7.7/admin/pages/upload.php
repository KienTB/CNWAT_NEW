<?php
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="http://localhost/CNPM/PHP-7.7/css/center.css">
    <style>
        input[type="file"] {
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div>
        <form class='update' method="post" enctype="multipart/form-data">
            <?php
            // Tạo 10 ô nhập để tải lên tệp
            for ($i = 0; $i < 10; $i++) {
                echo '<label for="files">File ' . ($i + 1) . ':</label>';
                echo '<input type="file" name="files[]" ><br>';
            }
            ?>
            
            <button type="submit" name="upload">Upload</button>
            <button type="reset" name="reset">Reset</button>

        </form>
    </div>
    <div class='show'>
        <?php
        // Thư mục lưu trữ tệp đã tải lên
        $uploadDir = '../uploads/';

        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Kiểm tra xem có tệp nào được tải lên không
        if (isset($_POST['upload'])) {
            $fileNames = $_FILES['files']['name'];
            $filePaths = [];

            // Duyệt qua các tệp và lưu vào thư mục
            foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
                $filePath = $uploadDir . basename($fileNames[$key]);

                // Di chuyển tệp từ thư mục tạm vào thư mục đã chỉ định
                if (move_uploaded_file($tmpName, $filePath)) {
                    $filePaths[] = $filePath; // Lưu đường dẫn tệp
                } else {
                    if(empty($fileNames[$key])){
                        
                    }
                    else{
                        echo "Có lỗi khi tải lên tệp: " . htmlspecialchars($fileNames[$key]) . "<br>";

                    }
                }
            }

            // Hiển thị tên và đường dẫn tệp
            if (!empty($filePaths)) {
                echo "<h3>Các file đã tải lên:</h3>";
                foreach ($filePaths as $filePath) {
                    echo "Download File:" . htmlspecialchars(basename($filePath)) .  " - <a href='" . htmlspecialchars($filePath) . "' download>Tải xuống</a><br>";
                }
            }
        }
        ?>
    </div>
    
</body>
</html>
