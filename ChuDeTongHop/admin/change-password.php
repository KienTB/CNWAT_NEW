<?php
session_start(); // Bắt đầu session để duy trì trạng thái đăng nhập của người dùng
error_reporting(0); // Tắt báo cáo lỗi

include('../includes/config.php'); // Kết nối với file config để lấy thông tin cơ sở dữ liệu

// Kiểm tra nếu người dùng chưa đăng nhập thì chuyển hướng về trang đăng nhập
if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    // Xử lý khi người dùng bấm nút submit để thay đổi mật khẩu
    if(isset($_POST['submit'])) {
        // Lấy mật khẩu cũ và mật khẩu mới, mã hóa bằng hàm md5
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $username = $_SESSION['alogin'];

        // Kiểm tra mật khẩu hiện tại của người dùng
        $sql = "SELECT Password FROM admin WHERE UserName=:username AND Password=:password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();

        // Nếu mật khẩu cũ đúng, cập nhật mật khẩu mới
        if($query->rowCount() > 0) {
            $con = "UPDATE admin SET Password=:newpassword WHERE UserName=:username";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':username', $username, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            $msg = "Your Password has been successfully changed"; // Thông báo thành công
        } else {
            $error = "Your current password is not valid."; // Thông báo lỗi nếu mật khẩu hiện tại không đúng
        }
    }
}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Bike Rental Portal | Admin Change Password</title>

    <!-- Các liên kết đến file CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">

    <script type="text/javascript">
        // Hàm kiểm tra mật khẩu mới và mật khẩu xác nhận có khớp hay không
        function valid() {
            if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                alert("New Password and Confirm Password Field do not match!!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>

    <!-- Các định dạng CSS cho thông báo lỗi và thành công -->
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <h2 class="page-title">Change Password</h2>

                        <div class="row">
                            <div class="col-md-10">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Form fields</div>
                                    <div class="panel-body">
                                        <form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">

                                            <!-- Hiển thị thông báo lỗi hoặc thành công -->
                                            <?php if($error){ ?>
                                                <div class="errorWrap">
                                                    <strong>ERROR</strong>:<?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } else if($msg){ ?>
                                                <div class="succWrap">
                                                    <strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?>
                                                </div>
                                            <?php } ?>

                                            <!-- Trường nhập mật khẩu hiện tại -->
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Current Password</label>
                                                <div class="col-sm-8">
                                                    <input type="password" class="form-control" name="password" id="password" required>
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>

                                            <!-- Trường nhập mật khẩu mới -->
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">New Password</label>
                                                <div class="col-sm-8">
                                                    <input type="password" class="form-control" name="newpassword" id="newpassword" required>
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>

                                            <!-- Trường nhập lại mật khẩu mới để xác nhận -->
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Confirm Password</label>
                                                <div class="col-sm-8">
                                                    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required>
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>

                                            <!-- Nút bấm lưu thay đổi -->
                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-4">
                                                    <button class="btn btn-primary" name="submit" type="submit">Save changes</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Các script cho giao diện -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
<?php ?>
