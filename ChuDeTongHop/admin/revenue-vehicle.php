<?php
session_start();
include('../includes/config.php');

// Kiểm tra nếu admin chưa đăng nhập, điều hướng về trang đăng nhập
if(strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else {
    // Truy vấn tổng doanh thu theo loại xe
    $sql = "SELECT SUM(b.price) as totalRevenue, v.VehiclesTitle 
        FROM tblbooking b 
        JOIN tblvehicles v ON b.VehicleId = v.id 
        WHERE b.status = 1 
        GROUP BY v.VehiclesTitle
        ORDER BY totalRevenue DESC";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
}
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Admin | Revenue Statistics by Vehicle</title>

    <!-- Các thư viện CSS cho Bootstrap, Font-awesome, Datatables, v.v. -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="container-fluid">
                <h2 class="page-title">Revenue Statistics by Vehicle</h2>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Vehicle Title</th>
                            <th>Total Revenue ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($results) {
                            foreach($results as $result) { ?>
                                <tr>
                                    <td><?php echo htmlentities($result->VehiclesTitle); ?></td>
                                    <td><?php echo htmlentities($result->totalRevenue); ?></td>
                                </tr>
                        <?php } } else { ?>
                                <tr>
                                    <td colspan="2">No data found</td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <!-- Chèn các file JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
