<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add user file</title>
        <script>
            function validateForm() {
                var username = document.getElementById("inputusername").value;
                if (username === "") {
                    alert("Username cannot be blank.");
                    return false; 
                }
                return true; 
            }
        </script>
    <style>
        .container {
            width: 50%;
            margin: 0 auto;
            float:left; 
        }
        .header {
            text-align: center;
            background-color: #f2f2f2;
            padding: 20px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"], .form-group input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-actions {
            text-align: center;
        }
        .form-actions input[type="submit"], .form-actions input[type="reset"] {
            padding: 10px 20px;
            border: none;
            background-color: #555555;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php require_once 'connect.php'; ?>

    <div class="container">
        <div class="header">
            <h2>Thêm sinh viên mới</h2>
        </div>
        <form action="AddStudentFile.php" method="POST">
            <div class="form-group">
                <label for="name">Tên</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="age">Tuổi</label>
                <input type="number" id="age" name="age" required>
            </div>
            <div class="form-actions">
                <input type="submit" value="Ghi">
                <input type="reset" value="Nhập Lại">
            </div>
        </form>
    </div>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $address = $_POST['address'];
    $age = $_POST['age'];

    // Tạo dòng dữ liệu
    $data = "$name, $address, $age\n";

    // Ghi dữ liệu vào file
    $file = fopen("students.txt", "a");
    if ($file) {
        fwrite($file, $data);
        fclose($file);
        echo "Lưu thành công!";
    } else {
        echo "Không thể mở file!";
    }
}
?>
