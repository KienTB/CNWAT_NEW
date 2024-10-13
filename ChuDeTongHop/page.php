<?php
session_start(); 
error_reporting(0); 
include('includes/config.php'); 
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <title>Bike Rental Portal | Page Details</title>

    <!-- Các file CSS cho giao diện và kiểu dáng -->
    <link rel="stylesheet" href="assets/switcher/css/switcher.css" id="switcher-css">
    <link rel="alternate stylesheet" href="assets/switcher/css/red.css" title="red">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/styles.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link rel="stylesheet" href="assets/css/slick.css" type="text/css">
    <link rel="stylesheet" href="assets/css/bootstrap-slider.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" type="text/css">

    <!-- Liên kết icon và font Google -->
    <link rel="apple-touch-icon" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/24x24.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>

<body>

    <!-- Header -->
    <?php include('includes/header.php'); ?>

    <!-- Lấy dữ liệu trang dựa trên tham số 'type' từ URL -->
    <?php
    $pagetype = $_GET['type'];
    $sql = "SELECT type, detail, PageName FROM tblpages WHERE type = :pagetype";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    // Hiển thị dữ liệu nếu có kết quả từ truy vấn
    if ($query->rowCount() > 0) {
        foreach ($results as $result) { ?>

            <!-- Phần hiển thị tiêu đề trang -->
            <section class="page-header aboutus_page">
                <div class="container">
                    <div class="page-header_wrap">
                        <div class="page-heading">
                            <h1><?php echo htmlentities($result->PageName); ?></h1>
                        </div>
                        <ul class="coustom-breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li><?php echo htmlentities($result->PageName); ?></li>
                        </ul>
                    </div>
                </div>
                <!-- Hiệu ứng lớp phủ -->
                <div class="dark-overlay"></div>
            </section>

            <!-- Hiển thị nội dung trang -->
            <section class="about_us section-padding">
                <div class="container">
                    <div class="section-header text-center">
                        <h2><?php echo htmlentities($result->PageName); ?></h2>
                        <p><?php echo $result->detail; ?></p>
                    </div>
                </div>
            </section>

    <?php }
    } ?>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <!-- Back to top -->
    <div id="back-top" class="back-top">
        <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
    </div>

    <!-- Các form liên quan đến đăng nhập, đăng ký và quên mật khẩu -->
    <?php include('includes/login.php'); ?>
    <?php include('includes/registration.php'); ?>
    <?php include('includes/forgotpassword.php'); ?>

    <!-- Liên kết các file JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/interface.js"></script>
    <script src="assets/switcher/js/switcher.js"></script>
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>

</body>

</html>
