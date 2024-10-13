<?php
// Khởi động session và kiểm tra quyền truy cập admin
session_start();
error_reporting(0);
include('../includes/config.php');

// Nếu không đăng nhập, chuyển hướng về trang đăng nhập
if(strlen($_SESSION['alogin'])==0) {
    header('location:index.php');
} else {

    // Xử lý cập nhật ảnh khi form được submit
    if(isset($_POST['update'])) {
        // Lấy tên ảnh mới từ form upload
        $vimage1 = $_FILES["img1"]["name"];
        $id = intval($_GET['imgid']);

        // Di chuyển file ảnh vào thư mục chỉ định
        move_uploaded_file($_FILES["img1"]["tmp_name"], "img/vehicleimages/".$_FILES["img1"]["name"]);

        // Cập nhật ảnh trong cơ sở dữ liệu
        $sql = "UPDATE tblvehicles SET Vimage1=:vimage1 WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':vimage1', $vimage1, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();

        // Thông báo cập nhật thành công
        $msg = "Image updated successfully";
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Bike Rental Portal | Admin Update Image 1</title>

    <!-- Liên kết CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        .errorWrap {
            padding: 10px;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap {
            padding: 10px;
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
                        <h2 class="page-title">Vehicle Image 1</h2>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Vehicle Image 1 Details</div>
                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                            <!-- Hiển thị thông báo thành công hoặc lỗi -->
                                            <?php if($error) { ?>
                                                <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                                            <?php } else if($msg) { ?>
                                                <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                                            <?php } ?>

                                            <!-- Hiển thị ảnh hiện tại -->
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Current Image1</label>
                                                <?php
                                                $id = intval($_GET['imgid']);
                                                $sql = "SELECT Vimage1 FROM tblvehicles WHERE tblvehicles.id=:id";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':id', $id, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                if($query->rowCount() > 0) {
                                                    foreach($results as $result) {
                                                ?>
                                                <div class="col-sm-8">
                                                    <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" width="300" height="200" style="border:solid 1px #000">
                                                </div>
                                                <?php } } ?>
                                            </div>

                                            <!-- Form upload ảnh mới -->
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Upload New Image 1<span style="color:red">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="img1" required>
                                                </div>
                                            </div>

                                            <!-- Nút cập nhật -->
                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-4">
                                                    <button class="btn btn-primary" name="update" type="submit">Update</button>
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

    <!-- Liên kết các file JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
