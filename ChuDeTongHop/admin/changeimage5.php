<?php
session_start(); // Bắt đầu phiên làm việc
error_reporting(0); // Tắt hiển thị lỗi
include('../includes/config.php'); // Kết nối với cơ sở dữ liệu

// Kiểm tra xem quản trị viên đã đăng nhập chưa
if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php'); // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
} else {
    // Mã để cập nhật hình ảnh 5
    if(isset($_POST['update'])) {
        $vimage = $_FILES["img5"]["name"]; // Lấy tên tệp hình ảnh từ đầu vào
        $id = intval($_GET['imgid']); // Lấy ID xe từ tham số truy vấn
        // Di chuyển tệp hình ảnh đã tải lên đến thư mục chỉ định
        move_uploaded_file($_FILES["img5"]["tmp_name"], "img/vehicleimages/" . $_FILES["img5"]["name"]);

        // Chuẩn bị và thực thi câu lệnh SQL để cập nhật hình ảnh
        $sql = "UPDATE tblvehicles SET Vimage5=:vimage WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':vimage', $vimage, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();

        $msg = "Hình ảnh đã được cập nhật thành công"; // Thông báo thành công
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

    <title>Bike Rental Portal | Admin Update Image 5<title>

    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* Định dạng cho thông báo lỗi và thông báo thành công */
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
    <?php include('includes/header.php'); ?> 
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?> 
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Vehicle Image 5</h2>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Chi tiết Hình ảnh Xe 5</div>
                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                            <?php 
                                            // Hiển thị thông báo lỗi hoặc thành công
                                            if($error) { ?>
                                                <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
                                            <?php } else if($msg) { ?>
                                                <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
                                            <?php } ?>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Vehicle Image 5 Details</label>
                                                <?php
                                                $id = intval($_GET['imgid']); // Lấy ID xe từ tham số truy vấn
                                                // Truy vấn để lấy hình ảnh hiện tại từ cơ sở dữ liệu
                                                $sql = "SELECT Vimage5 FROM tblvehicles WHERE tblvehicles.id=:id";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':id', $id, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                
                                                if($query->rowCount() > 0) {
                                                    foreach($results as $result) { ?>
                                                        <div class="col-sm-8">
                                                            <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage5); ?>" width="300" height="200" style="border:solid 1px #000">
                                                        </div>
                                                    <?php }
                                                }
                                                ?>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Upload New Image 4<span style="color:red">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="img5" required> <!-- Tải lên tệp hình ảnh mới -->
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>

                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-4">
                                                    <button class="btn btn-primary" name="update" type="submit">Update</button> <!-- Nút cập nhật -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
