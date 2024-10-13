<?php
session_start();
error_reporting(0);
include('../includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM tblbrands WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $msg = "Brand deleted successfully";  
    }
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Bike Rental Portal | Admin Manage Brands</title>

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
            margin-bottom: 20px;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px rgba(0,0,0,.1);
        }
        .succWrap {
            padding: 10px;
            margin-bottom: 20px;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px rgba(0,0,0,.1);
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
                        <h2 class="page-title">Manage Brands</h2>

                        <div class="panel panel-default">
                            <div class="panel-heading">Listed Brands</div>
                            <div class="panel-body">
                                <?php if($error) { ?>
                                    <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
                                <?php } else if($msg) { ?>
                                    <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div>
                                <?php } ?>

                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Brand Name</th>
                                            <th>Creation Date</th>
                                            <th>Updation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Brand Name</th>
                                            <th>Creation Date</th>
                                            <th>Updation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    $sql = "SELECT * FROM tblbrands";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;  
                                    
                                    if($query->rowCount() > 0) {
                                        foreach($results as $result) {
                                    ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt); ?></td>
                                                <td><?php echo htmlentities($result->BrandName); ?></td>
                                                <td><?php echo htmlentities($result->CreationDate); ?></td>
                                                <td><?php echo htmlentities($result->UpdationDate); ?></td>
                                                <td>
                                                    <a href="edit-brand.php?id=<?php echo $result->id; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                    <a href="manage-brands.php?del=<?php echo $result->id; ?>" onclick="return confirm('Do you want to delete?');"><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>
                                    <?php $cnt++; }} ?>
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
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
<?php } ?>
