<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Mã hóa mật khẩu bằng MD5

    // Truy vấn để kiểm tra email và mật khẩu trong cơ sở dữ liệu
    $sql = "SELECT EmailId, Password, FullName FROM tblusers WHERE EmailId=:email AND Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    
    // Lấy kết quả của truy vấn
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    // Kiểm tra xem có kết quả hay không (tức là thông tin hợp lệ)
    if ($query->rowCount() > 0) {
        $_SESSION['login'] = $email; // Lưu thông tin đăng nhập vào session
        $_SESSION['fname'] = $results[0]->FullName; // Lưu tên đầy đủ vào session

        // Refresh lại trang hiện tại sau khi đăng nhập thành công
        $currentpage = $_SERVER['REQUEST_URI'];
        echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
    } else {
        // Nếu thông tin không hợp lệ, hiển thị thông báo lỗi
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>

<!-- Modal form đăng nhập -->
<div class="modal fade" id="loginform">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Login</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="login_wrap">
                        <div class="col-md-12 col-sm-6">
                            <form method="post">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Email address*" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password*" required>
                                </div>
                                <div class="form-group checkbox">
                                    <input type="checkbox" id="remember">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="login" value="Login" class="btn btn-block">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <p>Don't have an account? <a href="#signupform" data-toggle="modal" data-dismiss="modal">Signup Here</a></p>
            </div>
        </div>
    </div>
</div>
