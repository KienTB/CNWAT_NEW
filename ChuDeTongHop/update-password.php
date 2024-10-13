<?php
session_start();
error_reporting(0);

include('includes/config.php');

// Kiểm tra người dùng đã đăng nhập hay chưa, nếu chưa thì điều hướng về trang index.php
if(strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    // Xử lý khi người dùng submit form thay đổi mật khẩu
    if(isset($_POST['update'])) {
        // Mã hóa mật khẩu hiện tại và mật khẩu mới bằng md5
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $email = $_SESSION['login'];

        // Kiểm tra mật khẩu hiện tại của người dùng trong database
        $sql = "SELECT Password FROM tblusers WHERE EmailId=:email AND Password=:password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        // Nếu mật khẩu hiện tại khớp
        if($query->rowCount() > 0) {
            // Cập nhật mật khẩu mới cho người dùng
            $con = "UPDATE tblusers SET Password=:newpassword WHERE EmailId=:email";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            $msg = "Your Password successfully changed";
        } else {
            $error = "Your current password is wrong";
        }
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>BikeForYou - Update Password</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/bootstrap-slider.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/switcher/css/switcher.css">
    <link rel="alternate stylesheet" href="assets/switcher/css/red.css" title="red">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900">
    <!-- Script kiểm tra xem mật khẩu mới và mật khẩu xác nhận có khớp không -->
    <script type="text/javascript">
        function valid() {
            if(document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                alert("New Password and Confirm Password Field do not match!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
    <style>
        .errorWrap { padding: 10px; margin: 0 0 20px 0; background: #fff; border-left: 4px solid #dd3d36; box-shadow: 0 1px 1px 0 rgba(0,0,0,.1); }
        .succWrap { padding: 10px; margin: 0 0 20px 0; background: #fff; border-left: 4px solid #5cb85c; box-shadow: 0 1px 1px 0 rgba(0,0,0,.1); }
    </style>
</head>
<body>

<?php include('includes/header.php'); ?>

<!-- Page Header -->
<section class="page-header profile_page">
    <div class="container">
        <div class="page-header_wrap">
            <div class="page-heading">
                <h1>Update Password</h1>
            </div>
            <ul class="coustom-breadcrumb">
                <li><a href="#">Home</a></li>
                <li>Update Password</li>
            </ul>
        </div>
    </div>
    <div class="dark-overlay"></div>
</section>
<!-- End Page Header -->

<?php
// Lấy thông tin người dùng từ database dựa trên email
$useremail = $_SESSION['login'];
$sql = "SELECT * FROM tblusers WHERE EmailId=:useremail";
$query = $dbh->prepare($sql);
$query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0) {
    foreach($results as $result) {
?>

<section class="user_profile inner_pages">
    <div class="container">
        <div class="user_profile_info gray-bg padding_4x4_40">
            <div class="upload_user_logo">
                <img src="assets/images/dealer-logo.jpg" alt="image">
            </div>
            <div class="dealer_info">
                <h5><?php echo htmlentities($result->FullName); ?></h5>
                <p><?php echo htmlentities($result->Address); ?><br>
                   <?php echo htmlentities($result->City); ?>, <?php echo htmlentities($result->Country); ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <?php include('includes/sidebar.php'); ?>
            </div>
            <div class="col-md-6 col-sm-8">
                <div class="profile_wrap">
                    <form name="chngpwd" method="post" onsubmit="return valid();">
                        <div class="gray-bg field-title">
                            <h6>Update Password</h6>
                        </div>
                        <!-- Thông báo lỗi hoặc thành công -->
                        <?php if($error){ ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div><?php } 
                        else if($msg){ ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div><?php } ?>

                        <!-- Các trường nhập mật khẩu -->
                        <div class="form-group">
                            <label class="control-label">Current Password</label>
                            <input class="form-control white_bg" id="password" name="password" type="password" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">New Password</label>
                            <input class="form-control white_bg" id="newpassword" type="password" name="newpassword" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Confirm Password</label>
                            <input class="form-control white_bg" id="confirmpassword" type="password" name="confirmpassword" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Update" name="update" id="submit" class="btn btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    }
}
?>

<?php include('includes/footer.php'); ?>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
