<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrix Operations</title>
    <style>
        /* Thiết lập kiểu cho input để nhập số */
        input[type="number"] {
            width: 100px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <h2>Thao tác trên mảng 2 chiều:</h2>
    <p>Bài toán: Nhập vào chuỗi số, tính tổng, hiệu của các số trong 2 ma trận 3x3.</p>
    
    <!-- Form để nhập giá trị cho 2 ma trận -->
    <form method="POST" action="">
        <!-- Ma trận 1 -->
        <p>Ma trận 1:</p>
        <?php
        // Vòng lặp để tạo input cho ma trận 1 (3x3)
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                echo '<input type="number" name="numbers1[' . $i . '][' . $j . ']" required>';
            }
            echo '<br>'; // Xuống dòng sau mỗi hàng
        }
        ?>

        <!-- Ma trận 2 -->
        <p>Ma trận 2:</p>
        <?php
        // Vòng lặp để tạo input cho ma trận 2 (3x3)
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                echo '<input type="number" name="numbers2[' . $i . '][' . $j . ']" required>';
            }
            echo '<br>'; // Xuống dòng sau mỗi hàng
        }
        ?>
        
        <br>
        <!-- Nút để reset form -->
        <button type="reset">Reset</button>
        <!-- Nút để tính toán các phép toán trên ma trận -->
        <button type="submit" name="calculate">Calculate</button>
    </form>

    <?php
    // Xử lý khi người dùng nhấn nút 'Calculate'
    if (isset($_POST['calculate'])) {
        // Lấy dữ liệu từ form cho hai ma trận
        $numbers1 = $_POST['numbers1'];
        $numbers2 = $_POST['numbers2'];
        
        // Khởi tạo ma trận để lưu kết quả tổng và hiệu
        $result_tong = [];
        $result_hieu = [];

        // Tính tổng của hai ma trận
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $result_tong[$i][$j] = $numbers1[$i][$j] + $numbers2[$i][$j];
            }
        }

        // Tính hiệu của hai ma trận
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $result_hieu[$i][$j] = $numbers1[$i][$j] - $numbers2[$i][$j];
            }
        }

        // Hiển thị kết quả ma trận tổng
        echo "<div>";
        echo "Ma trận Tổng: <br>";
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                echo $result_tong[$i][$j] . " ";
            }
            echo "<br>"; // Xuống dòng sau mỗi hàng
        }
        echo "</div>";

        // Hiển thị kết quả ma trận hiệu
        echo "<div>";
        echo "Ma trận Hiệu: <br>";
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                echo $result_hieu[$i][$j] . " ";
            }
            echo "<br>"; // Xuống dòng sau mỗi hàng
        }
        echo "</div>";
    }
    ?>
</body>
</html>
