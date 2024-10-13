<?php
session_start(); 
error_reporting(0); 
include('../includes/config.php'); 

// Kiểm tra xem người dùng đã đăng nhập chưa
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php'); 
} else {
    // Xử lý việc cập nhật thương hiệu
    if (isset($_POST['submit'])) {
        $brand = $_POST['brand']; // Lấy tên thương hiệu từ biểu mẫu
        $id = $_GET['id']; // Lấy ID thương hiệu từ URL

        // Câu lệnh SQL để cập nhật thương hiệu trong cơ sở dữ liệu
        $sql = "UPDATE tblbrands SET BrandName = :brand WHERE id = :id";
        $query = $dbh->prepare($sql); // Chuẩn bị câu lệnh SQL
        $query->bindParam(':brand', $brand, PDO::PARAM_STR); // Liên kết tham số thương hiệu
        $query->bindParam(':id', $id, PDO::PARAM_STR); // Liên kết tham số ID
        $query->execute(); // Thực thi câu lệnh SQL

        $msg = "Brand updated successfully"; 
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

    <title>Bike Rental Portal | Admin Update Brand</title>

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
                        <h2 class="page-title">Update Brand</h2> 
                        <div class="row">
                            <div class="col-md-10">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Form fields</div> 
                                    <div class="panel-body">
                                        <form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">
                                            <?php if ($error) { ?> <!-- Hiển thị thông báo lỗi nếu có -->
                                                <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
                                            <?php } else if ($msg) { ?> <!-- Hiển thị thông báo thành công nếu có -->
                                                <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
                                            <?php } ?>

                                            <?php
                                            $id = $_GET['id']; // Lấy ID từ URL
                                            $ret = "SELECT * FROM tblbrands WHERE id = :id"; // Câu lệnh SQL để lấy thương hiệu theo ID
                                            $query = $dbh->prepare($ret); // Chuẩn bị câu lệnh SQL
                                            $query->bindParam(':id', $id, PDO::PARAM_STR); // Liên kết tham số ID
                                            $query->execute(); // Thực thi câu lệnh SQL
                                            $results = $query->fetchAll(PDO::FETCH_OBJ); // Lấy tất cả kết quả
                                            $cnt = 1;

                                            // Nếu có kết quả, hiển thị thông tin thương hiệu
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {
                                            ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Brand Name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" value="<?php echo htmlentities($result->BrandName); ?>" name="brand" id="brand" required>
                                                        </div>
                                                    </div>
                                                    <div class="hr-dashed"></div>
                                            <?php
                                                }
                                            }
                                            ?>

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
