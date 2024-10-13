<?php
session_start();
error_reporting(0);

include('../includes/config.php');

// Kiểm tra nếu admin chưa đăng nhập, điều hướng về trang đăng nhập
if(strlen($_SESSION['alogin'])==0) {
    header('location:index.php');
} else {
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

    <title>Bike Rental Portal | Admin Dashboard</title>

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
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Dashboard</h2>

                        <div class="row">
                            <!-- Đếm số lượng người dùng đã đăng ký -->
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-primary text-light">
                                        <div class="stat-panel text-center">
                                            <?php
                                            // Truy vấn số lượng người dùng đã đăng ký
                                            $sql = "SELECT id FROM tblusers";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $regusers = $query->rowCount(); 
                                            ?>
                                            <div class="stat-panel-number h1"><?php echo htmlentities($regusers); ?></div>
                                            <div class="stat-panel-title text-uppercase">Registered Users</div>
                                        </div>
                                    </div>
                                    <a href="reg-users.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <!-- Đếm số lượng phương tiện được liệt kê -->
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-success text-light">
                                        <div class="stat-panel text-center">
                                            <?php
                                            // Truy vấn số lượng phương tiện được liệt kê
                                            $sql1 = "SELECT id FROM tblvehicles";
                                            $query1 = $dbh->prepare($sql1);
                                            $query1->execute();
                                            $totalvehicle = $query1->rowCount();
                                            ?>
                                            <div class="stat-panel-number h1"><?php echo htmlentities($totalvehicle); ?></div>
                                            <div class="stat-panel-title text-uppercase">Listed Vehicles</div>
                                        </div>
                                    </div>
                                    <a href="manage-vehicles.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <!-- Đếm tổng số lượt đặt xe -->
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-info text-light">
                                        <div class="stat-panel text-center">
                                            <?php
                                            // Truy vấn số lượt đặt xe
                                            $sql2 = "SELECT id FROM tblbooking";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $bookings = $query2->rowCount();
                                            ?>
                                            <div class="stat-panel-number h1"><?php echo htmlentities($bookings); ?></div>
                                            <div class="stat-panel-title text-uppercase">Total Bookings</div>
                                        </div>
                                    </div>
                                    <a href="manage-bookings.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <!-- Đếm số lượng thương hiệu xe được liệt kê -->
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-warning text-light">
                                        <div class="stat-panel text-center">
                                            <?php
                                            // Truy vấn số thương hiệu xe
                                            $sql3 = "SELECT id FROM tblbrands";
                                            $query3 = $dbh->prepare($sql3);
                                            $query3->execute();
                                            $brands = $query3->rowCount();
                                            ?>
                                            <div class="stat-panel-number h1"><?php echo htmlentities($brands); ?></div>
                                            <div class="stat-panel-title text-uppercase">Listed Brands</div>
                                        </div>
                                    </div>
                                    <a href="manage-brands.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>

</body>
</html>
<?php } ?>
