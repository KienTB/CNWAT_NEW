<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ar1Chieu</title>
    <style>
        /* Thiết lập chiều rộng và khoảng cách giữa các ô nhập số */
        input[type="number"] {
            width: 100px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <h2>Thao tac tren mang 1 chieu:</h2>
    <p>Bai toan: Nhap vao chuoi so: tinh tong cac so, gia tri trung binh, tim min, max, trung binh cong.</p>

    <!-- Form dùng để nhập dãy số -->
    <form method="post">
        <?php
        // Tạo 10 ô nhập số, mỗi ô là một phần tử trong mảng
        for ($i = 0; $i < 10; $i++) {
            echo '<input type="number" name="numbers[]" required>';
        }
        ?>
        <br>
        <!-- Nút reset để xóa các giá trị đã nhập -->
        <button type="reset">Reset</button>

        <!-- Nút submit để gửi dữ liệu đến máy chủ và xử lý -->
        <button type="submit">Calculate</button>
    </form>

    <?php
    // Kiểm tra xem form đã được submit hay chưa
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Nhận mảng các giá trị từ form
        $numbers = $_POST['numbers'];

        // Tính tổng các phần tử trong mảng
        $sum = array_sum($numbers);

        // Tính giá trị trung bình của mảng
        $average = $sum / count($numbers);

        // Tìm giá trị nhỏ nhất trong mảng
        $min = min($numbers);

        // Tìm giá trị lớn nhất trong mảng
        $max = max($numbers);

        // Làm tròn giá trị trung bình đến 2 chữ số thập phân
        $averageRound = round($average, 2);

        // Hiển thị kết quả ra màn hình
        echo "<div>";
        echo "KET QUA";
        echo "Tong: $sum <br>";
        echo "Trung binh: $averageRound <br>";
        echo "Min: $min <br>";
        echo "Max: $max <br>";
        echo "</div>";
    }
    ?>
</body>
</html>
