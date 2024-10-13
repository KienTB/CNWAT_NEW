<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Danh sách Sinh Viên</title>
    <style>
        .container {
            width: 50%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            background-color: #f2f2f2;
            padding: 20px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
    </style>
    <?php
    include("menu.php");
    ?>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Danh sách Sinh Viên</h2>
        </div>
        <table>
            <tr>
                <th>Tên</th>
                <th>Địa chỉ</th>
                <th>Tuổi</th>
            </tr>
            <?php
            // Mở file và đọc dữ liệu
            $file = fopen("students.txt", "r");
            if ($file) {
                while (($line = fgets($file)) !== false) {
                    
                    $student = explode(", ", $line);
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($student[0]) . "</td>";
                    echo "<td>" . htmlspecialchars($student[1]) . "</td>";
                    echo "<td>" . htmlspecialchars($student[2]) . "</td>";
                    echo "</tr>";
                }
                fclose($file);
            } else {
                echo "<tr><td colspan='3'>Không có dữ liệu</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
