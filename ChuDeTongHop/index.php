<?php
// Bắt đầu session và kết nối với cơ sở dữ liệu
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bike Rental Portal</title>

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

    <!-- Favicon và các biểu tượng khác -->
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet" type="text/css">
</head>

<body>
    <?php include('includes/header.php'); ?>

    <!-- Phần banner với tiêu đề và thông điệp -->
    <section id="banner" class="banner-section">
        <div class="container">
            <div class="div_zindex">
                <div class="row">
                </div>
            </div>
        </div>
    </section>

    <!-- Phần hiển thị danh sách xe đạp -->
    <section class="section-padding gray-bg">
        <div class="container">
            <div class="section-header text-center">
                <h2>Find the best bicycle for you!</h2>
                <p>Experience your trip with the best bikes.</p>
            </div>

            <div class="row">
                <!-- Tab mới hiển thị danh sách xe đạp mới -->
                <div class="recent-tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#resentnewcar" role="tab" data-toggle="tab">New bike</a></li>
                    </ul>
                </div>

                <div class="tab-content">
                    <!-- Tab danh sách xe đạp -->
                    <div role="tabpanel" class="tab-pane active" id="resentnewcar">
                        <?php
                        // Truy vấn lấy thông tin xe từ cơ sở dữ liệu
                        $sql = "SELECT tblvehicles.VehiclesTitle, tblbrands.BrandName, tblvehicles.PricePerDay, 
                                       tblvehicles.id, 
                                       tblvehicles.VehiclesOverview, tblvehicles.Vimage1 
                                FROM tblvehicles 
                                JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand";

                        // Chuẩn bị và thực thi truy vấn
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                        // Kiểm tra nếu có kết quả trả về
                        if ($query->rowCount() > 0) {
                            // Hiển thị từng xe đạp trong danh sách
                            foreach ($results as $result) {
                        ?>
                                <div class="col-list-3">
                                    <div class="recent-car-list">
                                        <!-- Hình ảnh xe và thông tin cơ bản -->
                                        <div class="car-info-box">
                                            <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                                                <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" 
                                                     class="img-responsive" alt="image">
                                            </a>
                                        </div>
                                        <!-- Tiêu đề xe và giá thuê -->
                                        <div class="car-title-m">
                                            <h6>
                                                <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                                                    <?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?>
                                                </a>
                                            </h6>
                                            <span class="price">$<?php echo htmlentities($result->PricePerDay); ?> /Day</span>
                                        </div>
                                        <!-- Mô tả ngắn về xe -->
                                        <div class="inventory_info_m">
                                            <p><?php echo substr($result->VehiclesOverview, 0, 70); ?></p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer của trang web -->
    <?php include('includes/footer.php'); ?>

    <!-- Nút back to top -->
    <div id="back-top" class="back-top">
        <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
    </div>

    <!-- Các popup đăng nhập, đăng ký, quên mật khẩu -->
    <?php include('includes/login.php'); ?>
    <?php include('includes/registration.php'); ?>
    <?php include('includes/forgotpassword.php'); ?>

    <!-- Các file JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/interface.js"></script>
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>
