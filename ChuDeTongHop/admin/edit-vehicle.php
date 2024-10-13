<?php
session_start();
error_reporting(0);
include('../includes/config.php');

if(strlen($_SESSION['alogin'])==0)
{
    header('location:index.php');
}
else {
    if(isset($_POST['submit'])) {
        $vehicletitle=$_POST['vehicletitle'];
        $brand=$_POST['brandname'];
        $vehicleoverview=$_POST['vehicleoverview'];
        $priceperday=$_POST['priceperday'];
        $modelyear=$_POST['modelyear'];
        $seatingcapacity=$_POST['seatingcapacity'];
        $id=intval($_GET['id']);

        $sql="UPDATE tblvehicles SET VehiclesTitle=:vehicletitle,VehiclesBrand=:brand,VehiclesOverview=:vehicleoverview,PricePerDay=:priceperday,ModelYear=:modelyear,SeatingCapacity=:seatingcapacity WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':vehicletitle',$vehicletitle,PDO::PARAM_STR);
        $query->bindParam(':brand',$brand,PDO::PARAM_STR);
        $query->bindParam(':vehicleoverview',$vehicleoverview,PDO::PARAM_STR);
        $query->bindParam(':priceperday',$priceperday,PDO::PARAM_STR);
        $query->bindParam(':modelyear',$modelyear,PDO::PARAM_STR);
        $query->bindParam(':seatingcapacity',$seatingcapacity,PDO::PARAM_STR);
        $query->bindParam(':id',$id,PDO::PARAM_STR);
        $query->execute();

        $msg="Data updated successfully";
    }
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="theme-color" content="#3e454c">
    <title>Bike Rental Portal | Admin Edit Vehicle Info</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
                        <h2 class="page-title">Edit Vehicle</h2>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                                        <?php
                                        $id=intval($_GET['id']);
                                        $sql ="SELECT tblvehicles.*,tblbrands.BrandName FROM tblvehicles JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand WHERE tblvehicles.id=:id";
                                        $query = $dbh -> prepare($sql);
                                        $query-> bindParam(':id', $id, PDO::PARAM_STR);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result) { ?>

                                                <form method="post" class="form-horizontal" enctype="multipart/form-data">

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <h4><b>Vehicle Images</b></h4>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-4">
                                                            Image 1 <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" width="300" height="200" style="border:solid 1px #000">
                                                            <a href="changeimage1.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 1</a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            Image 2<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage2);?>" width="300" height="200" style="border:solid 1px #000">
                                                            <a href="changeimage2.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 2</a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            Image 3<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage3);?>" width="300" height="200" style="border:solid 1px #000">
                                                            <a href="changeimage3.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 3</a>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-4">
                                                            Image 4<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage4);?>" width="300" height="200" style="border:solid 1px #000">
                                                            <a href="changeimage4.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 4</a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            Image 5
                                                            <?php if($result->Vimage5=="") {
                                                                echo htmlentities("File not available");
                                                            } else {?>
                                                                <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage5);?>" width="300" height="200" style="border:solid 1px #000">
                                                                <a href="changeimage5.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 5</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-8 col-sm-offset-2">
                                                            <button class="btn btn-primary" name="submit" type="submit" style="margin-top:4%">Save changes</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php } 
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
