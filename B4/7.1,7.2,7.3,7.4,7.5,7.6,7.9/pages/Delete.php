<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
        // Hàm kiểm tra xem ID có rỗng hay không trước khi submit form
        function validateForm() {
            var username = document.getElementById("inputid").value;
            if (username === "") {
                alert("Id cannot be empty.");
                return false; // Ngăn việc submit nếu ID rỗng
            }
            return true; // Cho phép submit
        }
        </script>
    </head>
    <body>

        <!-- Kết nối cơ sở dữ liệu -->
        <?php require_once 'connect.php';?>

        <?php
            // Biến điều khiển hiển thị các form
            $show_form_find = true;  // Hiển thị form tìm kiếm ban đầu
            $show_form = false;      // Hiển thị form chi tiết sau khi tìm thấy người dùng

            // Xử lý khi bấm vào nút cập nhật trên trang center (GET request với ID)
            if (isset($_GET['id'])) {
                $show_form_find = false;
                $show_form = true;
                $id = $_GET['id'];
                $query = "SELECT * FROM information WHERE id='$id'";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) == 1) {
                    $row = $result->fetch_array();
                    $username = $row['username'];
                    $password = $row['password'];
                    $sdt = $row['phonenumber'];
                    $email = $row['email'];
                    $role = $row['role'];
                }
            }

            // Xử lý khi người dùng bấm nút "Search" trong form tìm kiếm (POST request)
            if (isset($_POST['Search'])) {
                $id_find = $_POST['id'];
                $query = "SELECT * FROM information WHERE id='$id_find'";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) == 1) {
                    $show_form = true;  // Hiển thị form chỉnh sửa nếu tìm thấy người dùng
                    $row = $result->fetch_array();
                    $id = $row['id'];
                    $username = $row['username'];
                    $password = $row['password'];
                    $sdt = $row['phonenumber'];
                    $email = $row['email'];
                    $role = $row['role'];
                } else {
                    echo "<script>alert('Id or Username not found')</script>";
                }
            }

            // Xử lý xóa người dùng khi bấm nút "Delete"
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];
                $result = $conn->query("SELECT * FROM information WHERE id=$id");
                
                if ($result->num_rows > 0) {
                    $conn->query("DELETE FROM information WHERE id=$id");
                    echo "<script>alert('Delete successfully!')</script>";
                } else {
                    echo "<script>alert('Id not found!')</script>";
                }
            }

            // Đóng kết nối cơ sở dữ liệu
            $conn->close();
        ?>

        <!-- Form tìm kiếm người dùng -->
        <?php if ($show_form_find): ?>
        <form method="POST" action="" onsubmit="return validateForm()">
            <div class="form-row">
                <label for="id">Id you want to delete?</label>
                <input name="id" class="form-control" id="inputid" placeholder="Id">
            </div>
            <button type="submit" name="Search" class="btn btn-primary">Search</button>
        </form>
        <?php endif; ?>

        <!-- Form hiển thị thông tin chi tiết người dùng khi tìm thấy -->
        <?php if ($show_form): ?>
        <form method="POST" action="" id='form-update'>
            <legend>Enter the information to be edited</legend>
            
            <div class="form-row">
                <label for="id">Id</label>
                <input readonly name="id" type="text" class="form-control" id="inputid" value="<?php echo isset($id) ? $id : ''; ?>">
            </div>
            
            <div class="form-row">
                <label for="username">Username</label>
                <input readonly name="username" type="text" class="form-control" id="inputusername" placeholder="Username" value="<?php echo isset($username) ? $username : ''; ?>">
            </div>
            
            <div class="form-row">
                <label for="password">Password</label>
                <input name="password" type="text" class="form-control" id="inputpassword" placeholder="Mật khẩu" value="<?php echo isset($password) ? $password : ''; ?>">
            </div>

            <div class="form-row">
                <label for="sdt">Phone Number</label>
                <input name="sdt" class="form-control" id="inputsdt" placeholder="Số điện thoại" value="<?php echo isset($sdt) ? $sdt : ''; ?>">
            </div>

            <div class="form-row">
                <label for="email">Email</label>
                <input name="email" type="text" class="form-control" id="inputemail" placeholder="Email" value="<?php echo isset($email) ? $email : ''; ?>">
            </div>

            <div class="form-row">
                <label for="role">Role</label>
                <select id="role" name="role" class="form-control">
                    <option value="admin" <?php echo isset($role) && $role == 'admin' ? 'selected' : ''; ?>>admin</option>
                    <option value="user" <?php echo isset($role) && $role == 'user' ? 'selected' : ''; ?>>user</option>
                </select>
            </div>

            <button type="submit" name="delete" class="btn btn-primary">Delete</button>
        </form>
        <?php endif; ?>

    </body>
</html>
