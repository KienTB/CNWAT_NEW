<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính tổng điểm</title>
</head>

<body>
    <div>
        <form action="" method="POST">
            <fieldset>
                <legend>Nhập Form</legend>

                <div>
                    <label for="fullname">Họ và tên</label>
                    <input type="text" id="ho_ten" name="ho_ten">
                </div>

                <div>
                    <label for="class">Lớp</label>
                    <input type="text" id="lop" name="lop">
                </div>

                <div>
                    <label for="diem_M1">Điểm M1</label>
                    <input type="number" id="diem_M1" name="diem_M1" min="1" max="10">
                </div>

                <div>
                    <label for="diem_M2">Điểm M2</label>
                    <input type="number" id="diem_M2" name="diem_M2" min="1" max="10">
                </div>

                <div>
                    <label for="diem_M3">Điểm M3</label>
                    <input type="number" id="diem_M3" name="diem_M3" min="1" max="10">
                </div>

                <input type="submit" name="submit" value="Ok">
                <input type="reset" value="Nhập Lại"> 
            </fieldset>
        </form>
    </div>

    <?php
    // Xử lý khi bấm nút submit
    if (isset($_POST['submit'])) {
        $fullname = $_POST['fullname'];
        $class = $_POST['class'];
        $diem_M1 = $_POST['diem_M1'];
        $diem_M2 = $_POST['diem_M2'];
        $diem_M3 = $_POST['diem_M3'];

        // Tính tổng điểm
        $tong_diem = $diem_M1 + $diem_M2 + $diem_M3;

        // Hiển thị kết quả
        echo "<h2>Kết quả</h2>";
        echo "Họ và tên: $fullname<br>";
        echo "Lớp: $class<br>";
        echo "Điểm M1: $diem_M1<br>";
        echo "Điểm M2: $diem_M2<br>";
        echo "Điểm M3: $diem_M3<br>";
        echo "Tổng điểm: $tong_diem<br>";
    }
    ?>
</body>

</html>
