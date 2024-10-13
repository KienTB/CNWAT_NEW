<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CalculationForm</title>
    
</head>
<body>
    <div>
        <form action="" method="POST" >
            <fieldset>
                <legend>Mời nhập </legend>
                <div>
                    <label for="rows">a:</label>
                    <input type="number" id="a" name="a" min="1" >
                </div>
                <div>
                    <label for="rows">b:</label>
                    <input type="number" id="b" name="b" min="1" >
                </div>
                <div>
                    <p>Phép Tính:</p>
                    <input type="radio" id="Cong" name="TinhToan" value="Cong">
                    <label for="Cong">Cộng</label><br>
                    <input type="radio" id="Tru" name="TinhToan" value="Tru">
                    <label for="Tru">Trừ</label><br>
                    <input type="radio" id="Nhan" name="TinhToan" value="Nhan">
                    <label for="Nhan">Nhân</label><br>
                    <input type="radio" id="Chia" name="TinhToan" value="Chia">
                    <label for="Chia">Chia</label><br>
                </div>
                <div>
                    <input type="submit" name="submit" value="Tính toán">
                    <input type="submit" name="Nhap Lai" value="Nhap Lai">
                </div>

            </fieldset>
        </form>
    </div>
    <?php
    if (isset($_POST['submit'])) {
        $a = $_POST['a'];
        $b = $_POST['b'];
        $TinhToan = $_POST['TinhToan'];
        if ($TinhToan=='Cong') {
            echo "Kết quả: " . ($a + $b);
        }
        if ($TinhToan=='Tru') {
            echo "Kết quả: " . ($a - $b);
        }
        if ($TinhToan=='Nhan') {
            echo "Kết quả: " . ($a * $b);
        }
        if ($TinhToan=='Chia') {
            echo "Kết quả: " . ($a / $b);
        }
    }
    ?>

</body>
</html>