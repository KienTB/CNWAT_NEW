<?php
session_start();
error_reporting(0);

include('../includes/config.php');

// Kiểm tra người dùng đã đăng nhập hay chưa, nếu chưa thì điều hướng về trang đăng nhập
if(strlen($_SESSION['alogin'])==0)
{
    header('location:index.php');
}
else {
    // Nếu có yêu cầu hủy booking
    if(isset($_REQUEST['eid']))
    {
        $eid = intval($_GET['eid']); // Lấy ID booking từ URL
        $status = "2"; // Set trạng thái là "2" (Hủy)
        
        // Cập nhật trạng thái của booking trong cơ sở dữ liệu
        $sql = "UPDATE tblbooking SET Status=:status WHERE id=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();

        // Thông báo thành công
        $msg = "Booking Successfully Cancelled";
    }

    // Nếu có yêu cầu xác nhận booking
    if(isset($_REQUEST['aeid']))
    {
        $aeid = intval($_GET['aeid']); // Lấy ID booking từ URL
        $status = 1; // Set trạng thái là "1" (Xác nhận)
        
        // Cập nhật trạng thái của booking trong cơ sở dữ liệu
        $sql = "UPDATE tblbooking SET Status=:status WHERE id=:aeid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
        $query->execute();

        // Thông báo thành công
        $msg = "Booking Successfully Confirmed";
    }
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>Bike Rental Portal | Admin Manage Bookings</title>

    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
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
                        <h2 class="page-title">Manage Bookings</h2>

                        <!-- Bảng hiển thị danh sách booking -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Bookings Info</div>
                            <div class="panel-body">
                                <?php if($error){?>
                                    <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                                <?php } else if($msg){?>
                                    <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                                <?php }?>

                                <!-- Bảng dữ liệu booking -->
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Vehicle</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Posting date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Vehicle</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Posting date</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <!-- Truy vấn và hiển thị danh sách booking -->
                                        <?php
                                        $sql = "SELECT tblusers.FullName, tblbrands.BrandName, tblvehicles.VehiclesTitle, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.VehicleId as vid, tblbooking.Status, tblbooking.PostingDate, tblbooking.id  
                                                FROM tblbooking 
                                                JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId 
                                                JOIN tblusers ON tblusers.EmailId=tblbooking.userEmail 
                                                JOIN tblbrands ON tblvehicles.VehiclesBrand=tblbrands.id";

                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;

                                        // Duyệt qua kết quả và hiển thị từng hàng
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result) { ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt);?></td>
                                                    <td><?php echo htmlentities($result->FullName);?></td>
                                                    <td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid);?>"><?php echo htmlentities($result->BrandName);?>, <?php echo htmlentities($result->VehiclesTitle);?></a></td>
                                                    <td><?php echo htmlentities($result->FromDate);?></td>
                                                    <td><?php echo htmlentities($result->ToDate);?></td>
                                                    <td><?php echo htmlentities($result->message);?></td>
                                                    <td><?php 
                                                        if($result->Status==0) {
                                                            echo htmlentities('Not Confirmed yet');
                                                        } else if ($result->Status==1) {
                                                            echo htmlentities('Confirmed');
                                                        } else {
                                                            echo htmlentities('Cancelled');
                                                        }
                                                    ?></td>
                                                    <td><?php echo htmlentities($result->PostingDate);?></td>
                                                    <td>
                                                        <a href="manage-bookings.php?aeid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Confirm this booking')"> Confirm</a> /
                                                        <a href="manage-bookings.php?eid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Cancel this Booking')"> Cancel</a>
                                                    </td>
                                                </tr>
                                        <?php $cnt++; }
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
