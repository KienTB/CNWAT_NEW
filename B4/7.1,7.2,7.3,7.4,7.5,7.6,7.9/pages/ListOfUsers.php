<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
</head>
<body>

<script>
    // Hàm chuyển hướng đến trang khác và truyền tham số 'page' qua URL
    function loadPage(page) {
        window.location.href = "../index/index.php?page=" + encodeURIComponent(page);
    }
</script>

<!-- Bảng hiển thị thông tin người dùng -->
<table id='main'>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Password</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Role</th>
        <th>Chức năng</th>
    </tr>

    <!-- Kết nối đến cơ sở dữ liệu -->
    <?php require_once 'connect.php';?>

<?php
// Kiểm tra nếu kết nối cơ sở dữ liệu thành công
if ($conn) {
    // Truy vấn tất cả dữ liệu từ bảng 'information'
    $sql = "SELECT * FROM information";
    $result = mysqli_query($conn, $sql); // Thực thi truy vấn

    // Kiểm tra nếu có dữ liệu trả về
    if (mysqli_num_rows($result) > 0) {
        // Lặp qua từng dòng dữ liệu và hiển thị ra bảng
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["password"] . "</td>";
            echo "<td>" . $row["phonenumber"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["role"] . "</td>";
            
            // Cung cấp chức năng Xóa và Cập nhật cho từng người dùng
            echo "<td>";
            echo "<a href='../index/index.php?page=delete&id=" . $row['id'] . "'>Delete</a>";
            echo " || ";
            echo "<a href='../index/index.php?page=sua&id=" . $row['id'] . "'>Update</a>";
            echo "</td>";
            
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No records found.</td></tr>";
    }
} else {
    echo "<tr><td colspan='7'>Database connection failed.</td></tr>";
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
</table>

<!-- Thanh phân trang (hiển thị trang đầu, trang sau, v.v.) -->
<ul>
    <li>First page</li>
    <li>1</li>
    <li>2</li>
    <li>3</li>
    <li>Next page</li>
    <li>Last page</li>
</ul>

</body>
</html>
