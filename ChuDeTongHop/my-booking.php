<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Kiểm tra đăng nhập
if(strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    // Xử lý xóa hóa đơn
    if(isset($_GET['del'])) {
        $bookingId = $_GET['del'];
        $sql = "DELETE FROM tblbooking WHERE id=:bookingId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookingId', $bookingId, PDO::PARAM_STR);
        $query->execute();

        if($query) {
            echo "<script>alert('Booking deleted successfully');</script>";
            header('location:my-booking.php');
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }

    // Xử lý sửa hóa đơn
    if(isset($_POST['update'])) {
        $bookingId = $_POST['bookingId'];
        $fromDate = $_POST['fromDate'];
        $toDate = $_POST['toDate'];
        $message = $_POST['message'];

        $sql = "UPDATE tblbooking SET FromDate=:fromDate, ToDate=:toDate, message=:message WHERE id=:bookingId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fromDate', $fromDate, PDO::PARAM_STR);
        $query->bindParam(':toDate', $toDate, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);
        $query->bindParam(':bookingId', $bookingId, PDO::PARAM_STR);
        $query->execute();

        if($query) {
            echo "<script>alert('Booking updated successfully');</script>";
            header('location:my-booking.php');
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Booking | BikeForYou</title>
    
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

<!-- Header -->
<?php include('includes/header.php'); ?>

<!-- Danh sách hoá đơn -->
<section class="user_profile inner_pages">
  <div class="container">
    <h5 class="uppercase underline">My Booking</h5>
    <div class="my_vehicles_list">
      <ul class="vehicle_listing">
        <?php
        // Truy vấn các hóa đơn thuê xe
        $useremail = $_SESSION['login'];
        $sql = "SELECT tblvehicles.Vimage1 as Vimage1, tblvehicles.VehiclesTitle, tblvehicles.id as vid, tblbrands.BrandName, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.Status, tblbooking.id as bookingId, tblbooking.Price
                FROM tblbooking 
                JOIN tblvehicles ON tblbooking.VehicleId=tblvehicles.id 
                JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand 
                WHERE tblbooking.userEmail=:useremail";
        $query = $dbh->prepare($sql);
        $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if($query->rowCount() > 0) {
            foreach($results as $result) {
        ?>
        <li>
          <div class="vehicle_img">
            <a href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>">
              <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="vehicle image">
            </a>
          </div>
          <div class="vehicle_title">
            <h6>
              <a href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>">
                <?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->VehiclesTitle); ?>
              </a>
            </h6>
            <p>
              <b>From date:</b> <?php echo htmlentities($result->FromDate); ?><br>
              <b>To Date:</b> <?php echo htmlentities($result->ToDate); ?><br>
              <b>Price:</b> <?php echo htmlentities($result->Price); ?>$
            </p>
          </div>
          <div class="vehicle_status">
            <?php if($result->Status == 1) { ?>
            <a href="#" class="btn outline btn-xs active-btn">Confirmed</a>
            <?php } else if($result->Status == 2) { ?>
            <a href="#" class="btn outline btn-xs">Cancelled</a>
            <?php } else { ?>
            <a href="#" class="btn outline btn-xs">Not Confirmed</a>
            <?php } ?>
            <div class="clearfix"></div>
          </div>
          <div>
            <a href="edit-my-booking.php?id=<?php echo htmlentities($result->bookingId); ?>">Edit</a>
            <a href="my-booking.php?del=<?php echo htmlentities($result->bookingId); ?>" onclick="return confirm('Do you really want to delete?');">Delete</a>
          </div>
        </li>
        <?php }} ?>
      </ul>
    </div>
  </div>
</section>

<!-- Các popup đăng nhập, đăng ký, quên mật khẩu -->
 <?php include('includes/footer.php'); ?>
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
<?php } ?>
