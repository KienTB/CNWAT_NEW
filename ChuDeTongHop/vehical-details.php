<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Kiểm tra xem có gửi biểu mẫu đặt chỗ không
if (isset($_POST['submit'])) {
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $message = $_POST['message'];
    $useremail = $_SESSION['login']; 
    $status = 0;
    $vhid = $_GET['vhid']; // ID xe từ URL

    // Truy xuất giá PricePerDay từ tblvehicles
    $sqlPrice = "SELECT PricePerDay FROM tblvehicles WHERE id = :vhid";
    $queryPrice = $dbh->prepare($sqlPrice);
    $queryPrice->bindParam(':vhid', $vhid, PDO::PARAM_STR);
    $queryPrice->execute();
    $resultPrice = $queryPrice->fetch(PDO::FETCH_OBJ);
    $pricePerDay = $resultPrice->PricePerDay;

    // Chèn thông tin đặt chỗ vào tblbooking, bao gồm PricePerDay
    $sql = "INSERT INTO tblbooking(userEmail, VehicleId, FromDate, ToDate, message, Status, Price) 
            VALUES(:useremail, :vhid, :fromdate, :todate, :message, :status, :price)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':price', $pricePerDay, PDO::PARAM_STR); // Thêm giá vào cột Price
    $query->execute();

    $lastInsertId = $dbh->lastInsertId(); // Lấy ID bản ghi vừa chèn

    if ($lastInsertId) {
        echo "<script>alert('Booked the bike successfully.');</script>";
    } else {
        echo "<script>alert('Something\'s not right. Please try again.');</script>";
    }
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Bike Rental Port | Vehicle Details</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/styles.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/24x24.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<body>

<!-- Header -->
<?php include('includes/header.php'); ?>
<!-- /Header -->

<!-- Slider hình ảnh xe -->
<?php
$vhid = intval($_GET['vhid']); // Lấy ID xe từ URL
$sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid 
        FROM tblvehicles 
        JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
        WHERE tblvehicles.id = :vhid";
$query = $dbh->prepare($sql);
$query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        $_SESSION['brndid'] = $result->bid; // Lưu ID thương hiệu vào phiên
        ?>

        <section id="listing_img_slider">
            <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
            <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
            <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage3); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
            <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage4); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
            <?php if ($result->Vimage5 != "") { ?>
                <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage5); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
            <?php } ?>
        </section>
        <!--/Slider hình ảnh-->

        <!-- Chi tiết xe -->
        <section class="listing-detail">
            <div class="container">
                <div class="listing_detail_head row">
                    <div class="col-md-9">
                        <h2><?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?></h2>
                    </div>
                    <div class="col-md-3">
                        <div class="price_info">
                            <p>$<?php echo htmlentities($result->PricePerDay); ?> </p>Per Day
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="listing_more_info">
                            <div class="listing_detail_wrap">
                                <!-- Tabs -->
                                <ul class="nav nav-tabs gray-bg" role="tablist">
                                    <li role="presentation" class="active"><a href="#vehicle-overview" aria-controls="vehicle-overview" role="tab" data-toggle="tab">Vehicle Overview</a></li>
                                </ul>

                                <!-- Nội dung tab -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="vehicle-overview">
                                        <h5>Vehicle Overview</h5>
                                        <p><?php echo htmlentities($result->VehiclesOverview); ?></p>
                                    </div>
                                </div>
                                <!-- Kết thúc tab -->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="listing_form">
                            <h3>Booking</h3>
                            <form method="post">
                                <div class="form-group">
                                    <label>From Date</label>
                                    <input type="date" name="fromdate" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>To Date</label>
                                    <input type="date" name="todate" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea name="message" class="form-control" rows="3" required></textarea>
                                </div>
                                <button type="submit" name="submit" class="btn">Book Now</button>
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

<!-- Footer -->
<?php include('includes/footer.php'); ?>
<!-- /Footer -->

<!-- Javascript -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/slider.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>
