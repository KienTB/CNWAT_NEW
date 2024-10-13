<?php
session_start(); 
error_reporting(0); 
include('../includes/config.php'); 

// Kiểm tra xem quản trị viên đã đăng nhập chưa
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php'); 
} else {
    // Xử lý việc tạo thương hiệu mới
    if (isset($_POST['submit'])) {
        $brand = $_POST['brand']; // Lấy tên thương hiệu từ biểu mẫu

        // Chuẩn bị câu lệnh SQL để chèn thương hiệu mới vào cơ sở dữ liệu
        $sql = "INSERT INTO tblbrands (BrandName) VALUES (:brand)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':brand', $brand, PDO::PARAM_STR);
        $query->execute(); // Thực thi câu lệnh SQL

        $lastInsertId = $dbh->lastInsertId(); // Lấy ID của bản ghi vừa chèn
        // Kiểm tra xem bản ghi có được chèn thành công không
        if ($lastInsertId) {
            $msg = "The brand has been successfully created"; 
        } else {
            $error = "An error occurred. Please try again"; 
        }
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

    <title>Bike Rental Portal | Admin Create a Brand</title>

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
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
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
                        <h2 class="page-title">Create Brand</h2>

                        <div class="row">
                            <div class="col-md-10">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Form fields</div>
                                    <div class="panel-body">
                                        <form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">
                                            <?php 
                                            // Hiển thị thông báo lỗi hoặc thông báo thành công
                                            if ($error) { ?>
                                                <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
                                            <?php } else if ($msg) { ?>
                                                <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
                                            <?php } ?>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Brand Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="brand" id="brand" required> <!-- Trường nhập tên thương hiệu -->
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>

                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-4">
                                                    <button class="btn btn-primary" name="submit" type="submit">Submit</button> <!-- Nút gửi -->
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
