<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        // Hàm kiểm tra form khi submit
        function validateForm() {
            var id = document.getElementById("id").value;
            if (id === "") {
                alert("Id cannot be blank.");
                return false; 
            }
            return true; 
        }
    </script>
</head>

<body>
    <?php require_once 'connect.php'; ?>

    <?php
    // Biến hiển thị form tìm kiếm và cập nhật
    $show_form_find = true;
    $show_form = false;

    // Xử lý khi bấm vào nút cập nhật từ danh sách (khi có tham số 'id' trên URL)
    if (isset($_GET['id'])) {
        $show_form_find = false; // Ẩn form tìm kiếm
        $show_form = true; // Hiển thị form cập nhật

        $id = $_GET['id']; // Lấy id từ URL
        $query = "SELECT * FROM information WHERE id='$id'";
        $result = mysqli_query($conn, $query);

        // Nếu tìm thấy đúng một dòng kết quả
        if (mysqli_num_rows($result) == 1) {
            $row = $result->fetch_array(); // Lấy dữ liệu hàng
            $username = $row['username'];
            $password = $row['password'];
            $phonenumber = $row['phonenumber'];
            $email = $row['email'];
            $role = $row['role'];
        }
    }

    // Xử lý khi bấm vào nút tìm (khi submit form tìm kiếm)
    if (isset($_POST['Search'])) {
        $id_find = $_POST['id'];
        $username_find = $_POST['username'];

        // Tìm người dùng theo id hoặc username
        $query = "SELECT * FROM information WHERE id='$id_find' OR username='$username_find'";
        $result = mysqli_query($conn, $query);

        // Nếu tìm thấy đúng một dòng kết quả
        if (mysqli_num_rows($result) == 1) {
            $show_form = true; // Hiển thị form cập nhật
            $row = $result->fetch_array(); // Lấy dữ liệu hàng
            $id = $row['id'];
            $username = $row['username'];
            $password = $row['password'];
            $phonenumber = $row['phonenumber'];
            $email = $row['email'];
            $role = $row['role'];
        } else {
            echo "<script>alert('Id or Username not found')</script>";
        }
    }

    // Xử lý khi bấm vào nút cập nhật (khi submit form cập nhật)
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $query = "SELECT * FROM information WHERE id=$id";
        $result = mysqli_query($conn, $query);

        // Nếu tìm thấy đúng một dòng kết quả
        if (mysqli_num_rows($result) == 1) {
            // Cập nhật thông tin người dùng
            $username = $_POST['username'];
            $password = $_POST['password'];
            $phonenumber = $_POST['phonenumber'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            // Thực thi truy vấn cập nhật
            if ($conn->query("UPDATE information SET username='$username',password='$password', email='$email', role='$role', phonenumber='$phonenumber' WHERE id=$id")) {
                echo "<script>alert('Cập nhật thành công!')</script>";
            } else {
                echo "<script>alert('Cập nhật thất bại!')</script>";
            }
        } else {
            echo "<script>alert('Không có id')</script>";
        }
    }

    // Đóng kết nối cơ sở dữ liệu
    $conn->close();
    ?>

    <!-- Hiển thị form tìm kiếm nếu cần -->
    <?php if ($show_form_find): ?>
        <form method="POST" action="" onsubmit="return validateForm()">
            <legend>Chọn người dùng cần tìm kiếm</legend>
            <div class="form-row">
                <label for="id">Id</label>
                <input name="id" class="form-control" placeholder="Id">
            </div>
            <button type="submit" name="Search" class="btn btn-primary">Tìm</button>
        </form>
    <?php endif; ?>

    <!-- Hiển thị form cập nhật nếu cần -->
    <?php if ($show_form): ?>
        <form method="POST" action="" id="form-update">
            <legend>Nhập thông tin cần chỉnh sửa</legend>

            <div class="form-row">
                <label for="id">Id</label>
                <input readonly name="id" type="text" class="form-control" value="<?php echo isset($id) ? $id : ''; ?>">
            </div>
            <div class="form-row">
                <label for="username">Username</label>
                <input readonly name="username" type="text" class="form-control" value="<?php echo isset($username) ? $username : ''; ?>">
            </div>
            <div class="form-row">
                <label for="password">Password</label>
                <input name="password" type="text" class="form-control" value="<?php echo isset($password) ? $password : ''; ?>">
            </div>
            <div class="form-row">
                <label for="sdt">Phone Number</label>
                <input name="sdt" class="form-control" value="<?php echo isset($phonenumber) ? $phonenumber : ''; ?>">
            </div>
            <div class="form-row">
                <label for="email">Email</label>
                <input name="email" type="text" class="form-control" value="<?php echo isset($email) ? $email : ''; ?>">
            </div>
            <div class="form-row">
                <label for="role">Role</label>
                <select id="role" name="role" class="form-control">
                    <option value="admin" <?php echo isset($role) && $role == 'admin' ? 'selected' : ''; ?>>admin</option>
                    <option value="user" <?php echo isset($role) && $role == 'user' ? 'selected' : ''; ?>>user</option>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>
    <?php endif; ?>

</body>

</html>
