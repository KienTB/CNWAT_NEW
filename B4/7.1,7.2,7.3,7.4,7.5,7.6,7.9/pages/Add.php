<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add users</title>
        <script>
            function validateForm() {
                var username = document.getElementById("inputusername").value;
                if (username === "") {
                    alert("Username cannot be blank.");
                    return false; 
                }
                return true; 
            }
        </script>
    </head>
    
    <body>
        <?php require_once 'connect.php'; ?>

        <?php
        if (isset($_POST['add'])) {
            $role = $_POST['role'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $phonenumber = $_POST['phonenumber'];
            $email = $_POST['email'];

            // Kiểm tra từng trường dữ liệu đầu vào từ form
            if (empty($username)) {
                echo "<script>alert('Username cannot be empty!')</script>";
                return; 
            } else if (empty($password)) {
                echo "<script>alert('Password cannot be empty!')</script>";
            } else if (empty($email)) {
                echo "<script>alert('Email cannot be empty!')</script>";
                return; 
            } else if (empty($phonenumber)) {
                echo "<script>alert('PhoneNumber cannot be empty!')</script>";
                return; 
            } else {
                $sql = "SELECT * FROM information WHERE username = '$username' OR email = '$email'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<script>alert('Username or Email already exists!')</script>";
                    return false; 
                } else {
                    if ($conn->query("INSERT INTO information(username, password, email, phonenumber, role) 
                    VALUES ('$username', '$password', '$email','$phonenumber', '$role')")) {
                        echo "<script>alert('Add successfully!')</script>"; 
                    } else {
                        echo "<script>alert('More failure!')</script>"; 
                    }
                }
            }
        }

        // Đóng kết nối với cơ sở dữ liệu
        $conn->close();
        ?>

        <!-- Form nhập liệu để thêm mới người dùng -->
        <form method="POST" action="" onsubmit="return validateForm()">
            <legend>Add new user</legend>

            <!-- Trường nhập Tên người dùng -->
            <div class="form-row">
                <label for="username">Username</label>
                <input name="username" class="form-control" id="inputusername" placeholder="Username">
            </div>

            <div class="form-row">
                <label for="password">Password</label>
                <input name="password" class="form-control" id="inputpassword" placeholder="Password">
            </div>

            <div class="form-row">
                <label for="email">Email</label>
                <input name="email" type="text" class="form-control" id="inputemail" placeholder="Email">
            </div>

            <div class="form-row">
                <label for="sdt">Phone Number</label>
                <input name="sdt" class="form-control" id="inputsdt" placeholder="PhoneNumber">
            </div>

            <div class="form-row">
                <label for="role">Role</label>
                <select id="role" name="role" class="form-control">
                    <option selected>admin</option>
                    <option>user</option>
                </select>
            </div>

            <!-- Nút Nhập để gửi form -->
            <button type="submit" name="add" class="btn btn-primary">Enter</button>
        </form>
    </body>
</html>
