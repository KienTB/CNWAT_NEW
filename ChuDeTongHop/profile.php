<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Kiểm tra xem người dùng đã đăng nhập chưa, nếu chưa thì chuyển hướng về trang index
if(strlen($_SESSION['login'])==0) {
    header('location:index.php');
} else {
    // Xử lý cập nhật thông tin người dùng khi người dùng nhấn nút cập nhật
    if(isset($_POST['updateprofile'])) {
        $name = $_POST['fullname'];
        $mobileno = $_POST['mobilenumber'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $email = $_SESSION['login'];

        // Câu lệnh SQL cập nhật thông tin người dùng
        $sql = "UPDATE tblusers SET FullName=:name, ContactNo=:mobileno, dob=:dob, Address=:address, City=:city, Country=:country WHERE EmailId=:email";
        $query = $dbh->prepare($sql);

        // Bind các tham số vào câu lệnh SQL
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);

        // Thực hiện câu truy vấn
        $query->execute();
        $msg = "Profile Updated Successfully"; // Thông báo khi cập nhật thành công
    }

    // Lấy thông tin người dùng từ cơ sở dữ liệu để hiển thị lên trang
    $useremail = $_SESSION['login'];
    $sql = "SELECT * FROM tblusers WHERE EmailId=:useremail";
    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Bike Rental Portal | My Profile</title>

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/styles.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/slick.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- Switcher -->
    <link rel="alternate stylesheet" href="assets/switcher/css/red.css" title="red" media="all" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon-icon/24x24.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

    <!-- Custom Styles for Error/Success Messages -->
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>

<body>

<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header -->

<!--Page Header-->
<section class="page-header profile_page">
    <div class="container">
        <div class="page-header_wrap">
            <div class="page-heading">
                <h1>Your Profile</h1>
            </div>
            <ul class="coustom-breadcrumb">
                <li><a href="#">Home</a></li>
                <li>Profile</li>
            </ul>
        </div>
    </div>
    <div class="dark-overlay"></div>
</section>
<!-- /Page Header-->

<!-- User Profile -->
<section class="user_profile inner_pages">
    <div class="container">
        <!-- User Info -->
        <div class="user_profile_info gray-bg padding_4x4_40">
            <div class="upload_user_logo">
                <img src="assets/images/dealer-logo.jpg" alt="image">
            </div>
            <div class="dealer_info">
                <h5><?php echo htmlentities($result->FullName);?></h5>
                <p><?php echo htmlentities($result->Address);?><br>
                    <?php echo htmlentities($result->City);?>, <?php echo htmlentities($result->Country);?>
                </p>
            </div>
        </div>
        
        <!-- Profile Form -->
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <?php include('includes/sidebar.php');?>
            </div>
            <div class="col-md-6 col-sm-8">
                <div class="profile_wrap">
                    <h5 class="uppercase underline">General Settings</h5>

                    <!-- Success/Error Message -->
                    <?php if($msg){?>
                        <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                    <?php }?>

                    <!-- Form to Update Profile -->
                    <form method="post">
                        <div class="form-group">
                            <label class="control-label">Reg Date -</label>
                            <?php echo htmlentities($result->RegDate);?>
                        </div>
                        <?php if($result->UpdationDate!=""){?>
                            <div class="form-group">
                                <label class="control-label">Last Update at -</label>
                                <?php echo htmlentities($result->UpdationDate);?>
                            </div>
                        <?php } ?>

                        <!-- Form Fields -->
                        <div class="form-group">
                            <label class="control-label">Full Name</label>
                            <input class="form-control white_bg" name="fullname" value="<?php echo htmlentities($result->FullName);?>" id="fullname" type="text" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email Address</label>
                            <input class="form-control white_bg" name="emailid" value="<?php echo htmlentities($result->EmailId);?>" id="email" type="email" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input class="form-control white_bg" name="mobilenumber" value="<?php echo htmlentities($result->ContactNo);?>" id="phone-number" type="text" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Date of Birth (dd/mm/yyyy)</label>
                            <input class="form-control white_bg" value="<?php echo htmlentities($result->dob);?>" name="dob" id="birth-date" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Your Address</label>
                            <textarea class="form-control white_bg" name="address" rows="4"><?php echo htmlentities($result->Address);?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Country</label>
                            <input class="form-control white_bg" name="country" value="<?php echo htmlentities($result->Country);?>" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <input class="form-control white_bg" name="city" value="<?php echo htmlentities($result->City);?>" type="text">
                        </div>

                        <!-- Save Changes Button -->
                        <div class="form-group">
                            <button type="submit" name="updateprofile" class="btn">Save Changes <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/Profile-setting-->

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer-->

<!--Back to top-->
<div id="back-top" class="back-top">
    <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
</div>
<!--/Back to top-->

<!--Login Form -->
<?php include('includes/login.php');?>
<!--/Login Form -->

<!--Register Form -->
<?php include('includes/registration.php');?>
<!--/Register Form -->

<!--Forgot Password Form -->
<?php include('includes/forgotpassword.php');?>
<!--/Forgot Password Form -->

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<script src="assets/switcher/js/switcher.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>

<?php } ?>
