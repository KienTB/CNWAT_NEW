<?php
session_start();
error_reporting(0); 
include('../includes/config.php'); 

// Kiểm tra người dùng đã đăng nhập chưa
if(strlen($_SESSION['alogin'])==0) {
    header('location:index.php'); 
} else {

    // Xóa dữ liệu khi nhận yêu cầu xóa với tham số 'del'
    if(isset($_REQUEST['del'])) {
        $delid = intval($_GET['del']); // Lấy id của phương tiện cần xóa
        $sql = "DELETE FROM tblvehicles WHERE id=:delid"; // Câu lệnh SQL xóa (đã sửa lỗi từ SET thành DELETE)
        $query = $dbh->prepare($sql); 
        $query->bindParam(':delid', $delid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Vehicle record deleted successfully"; // Thông báo khi xóa thành công
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

    <title>Bike Rental Portal | Admin Manage Vehicles</title>

    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
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
    <?php include('includes/header.php');?>

    <div class="ts-main-content">
        <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Manage Vehicles</h2>

                        <!-- Hiển thị bảng phương tiện -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Vehicle Details</div>
                            <div class="panel-body">
                                <!-- Hiển thị thông báo lỗi hoặc thành công -->
                                <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
                                else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                                
                                <!-- Bảng hiển thị dữ liệu phương tiện -->
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Vehicle Title</th>
                                            <th>Brand</th>
                                            <th>Price Per day</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Vehicle Title</th>
                                            <th>Brand</th>
                                            <th>Price Per day</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <!-- Lấy dữ liệu từ cơ sở dữ liệu và hiển thị -->
                                        <?php 
                                        $sql = "SELECT tblvehicles.VehiclesTitle, tblbrands.BrandName, tblvehicles.PricePerDay, tblvehicles.id FROM tblvehicles JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand";
                                        $query = $dbh->prepare($sql); // Chuẩn bị truy vấn
                                        $query->execute(); // Thực thi truy vấn
                                        $results = $query->fetchAll(PDO::FETCH_OBJ); // Lấy tất cả dữ liệu
                                        $cnt = 1; // Khởi tạo biến đếm
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result) { ?> 
                                            <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                                <td><?php echo htmlentities($result->VehiclesTitle);?></td>
                                                <td><?php echo htmlentities($result->BrandName);?></td>
                                                <td><?php echo htmlentities($result->PricePerDay);?></td>
                                                <td>
                                                    <a href="edit-vehicle.php?id=<?php echo $result->id;?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                    <a href="manage-vehicles.php?del=<?php echo $result->id;?>" onclick="return confirm('Do you want to delete?');"><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>
                                            <?php $cnt = $cnt + 1; } // Tăng biến đếm lên 1 sau mỗi lần lặp
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>
</html>
<?php } ?>
