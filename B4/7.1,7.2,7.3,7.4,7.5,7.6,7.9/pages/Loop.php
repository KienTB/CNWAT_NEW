<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draw Table</title>
</head>
<body>
    <!-- Form để nhập số vòng lặp -->
    <div>
        <form action="" method="POST">
            <fieldset>
                <legend>Mời nhập vòng lặp</legend>
                <div>
                    <label for="number">Số vòng lặp:</label>
                    <input type="number" id="number" name="number" min="1">
                </div>
                <input type="submit" name="submit" value="Draw loop">
                <input type="submit" name="re-enter" value="re-enter">
            </fieldset>
        </form>
    </div>

    <?php
    // Kiểm tra nếu người dùng nhấn nút "Draw loop"
    if (isset($_POST['submit'])) {
        $number = $_POST['number']; // Lấy giá trị từ form
        
        echo "<h2>Kết quả loop</h2>";

        // Vẽ bằng vòng lặp for
        echo "<h3>Vẽ bằng For</h3>";
        for ($i = 1; $i <= $number; $i++) {
            for ($j = 1; $j <= $i; $j++) {
                echo "* "; // In dấu sao theo số vòng lặp
            }
            echo "<br>"; // Xuống dòng sau mỗi lần in xong
        }

        // Vẽ bằng vòng lặp while
        echo "<h3>Vẽ bằng While</h3>";
        $k = 1;
        while ($k <= $number) {
            for ($i = 1; $i <= $k; $i++) {
                echo "* "; // In dấu sao theo số vòng lặp
            }
            echo "<br>"; // Xuống dòng sau mỗi lần in xong
            $k++; // Tăng giá trị biến đếm
        }

        // Vẽ bằng vòng lặp do...while
        echo "<h3>Vẽ bằng Do...While</h3>";
        $k = 1;
        do {
            for ($i = 1; $i <= $k; $i++) {
                echo "* "; // In dấu sao theo số vòng lặp
            }
            echo "<br>"; // Xuống dòng sau mỗi lần in xong
            $k++; // Tăng giá trị biến đếm
        } while ($k <= $number); // Điều kiện để tiếp tục vòng lặp
    }
    ?>
</body>
</html>
