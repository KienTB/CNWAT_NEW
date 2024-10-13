<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draw Table</title>
    <style>
        form {
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        /* Điều chỉnh width và height của ô */
        td {
            width: 30px;  /* Chiều rộng của ô */
            height: 30px;  /* Chiều cao của ô */
        }
    </style>
</head>
<body>
    <!-- Form để người dùng nhập số dòng và cột -->
    <div>
        <form action="" method="POST">
            <fieldset>
                <legend>Draw Table</legend>

                <div>
                    <label for="rows">Số dòng:</label>
                    <input type="number" id="rows" name="rows" min="1">
                </div>

                <div>
                    <label for="cols">Số cột:</label>
                    <input type="number" id="cols" name="cols" min="1">
                </div>
                
                <input type="submit" name="submit" value="Draw Table">

                <input type="submit" name="re-enter" value="re-enter">
            </fieldset>
        </form>
    </div>

    <?php
    // Kiểm tra nếu người dùng đã nhấn nút "Draw Table"
    if (isset($_POST['submit'])) {
        $rows = $_POST['rows'];  // Lấy giá trị số dòng từ input
        $cols = $_POST['cols'];  // Lấy giá trị số cột từ input

        // Kiểm tra nếu số dòng và cột lớn hơn 0
        if ($rows > 0 && $cols > 0) {
            echo "<h3>Kết quả bảng</h3>";
            echo "<table border='1' cellspacing='0' cellpadding='10'>";

            // Tạo bảng theo số dòng và cột đã nhập
            for ($i = 1; $i <= $rows; $i++) {
                echo "<tr>";  // Bắt đầu một hàng mới

                for ($j = 1; $j <= $cols; $j++) {
                    // Nếu số cột nhỏ hơn hoặc bằng số dòng hiện tại, hiển thị số cột
                    if ($j <= $i) {
                        echo "<td>$j</td>";  // Hiển thị giá trị của cột
                    } else {
                        echo "<td></td>";  // Để trống nếu cột lớn hơn dòng
                    }
                }

                echo "</tr>";  // Kết thúc một hàng
            }

            echo "</table>";  // Kết thúc bảng
        }
    }
    ?>
</body>
</html>
