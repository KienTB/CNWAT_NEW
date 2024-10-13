<?php
session_start();
include('includes/config.php'); 
error_reporting(0); 
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>Bike Rental Portal | Bike Listing</title>

    <!-- Các file CSS cho giao diện và kiểu dáng -->
    <link rel="stylesheet" href="assets/switcher/css/switcher.css" id="switcher-css">
    <link rel="alternate stylesheet" href="assets/switcher/css/red.css" title="red">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/styles.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link rel="stylesheet" href="assets/css/slick.css" type="text/css">
    <link rel="stylesheet" href="assets/css/bootstrap-slider.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" type="text/css">

    <!-- Favicon và các biểu tượng khác -->
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet" type="text/css">
</head>

<body>

<?php include('includes/header.php'); ?>

<section class="page-header listing_page">
    <div class="container">
        <div class="page-header_wrap">
            <div class="page-heading">
                <h1>Bike Listing</h1>
            </div>
            <ul class="coustom-breadcrumb">
                <li><a href="#">Home</a></li>
                <li>Bike Listing</li>
            </ul>
        </div>
    </div>
    <div class="dark-overlay"></div>
</section>

<section class="listing-page">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3">
                <div class="result-sorting-wrapper">
                    <div class="sorting-count">

                    <!-- Xử lý tìm kiếm xe dựa trên thương hiệu và giá -->
                    <?php
                    $brand = isset($_POST['brand']) ? $_POST['brand'] : ''; // Lấy giá trị thương hiệu từ form
                    $price = isset($_POST['price']) ? $_POST['price'] : ''; // Lấy giá trị giá từ form

                    // Câu truy vấn cơ bản
                    $sql = "SELECT tblvehicles.*, tblbrands.BrandName FROM tblvehicles 
                            JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand WHERE 1=1";

                    // Kiểm tra nếu có chọn thương hiệu
                    if (!empty($brand)) {
                        $sql .= " AND tblbrands.id = :brand";
                    }

                    // Kiểm tra nếu có chọn khoảng giá
                    if (!empty($price)) {
                        if ($price == 'low') {
                            $sql .= " AND tblvehicles.PricePerDay <= 10";
                        } elseif ($price == 'medium') {
                            $sql .= " AND tblvehicles.PricePerDay BETWEEN 10 AND 20";
                        } elseif ($price == 'high') {
                            $sql .= " AND tblvehicles.PricePerDay > 20";
                        }
                    }

                    // Chuẩn bị truy vấn
                    $query = $dbh->prepare($sql);

                    // Gán giá trị cho biến brand nếu có
                    if (!empty($brand)) {
                        $query->bindParam(':brand', $brand, PDO::PARAM_STR);
                    }

                    // Thực thi truy vấn
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ); // Lấy kết quả dưới dạng object
                    $cnt = $query->rowCount(); // Đếm số lượng kết quả trả về
                    ?>

                    <p><span><?php echo htmlentities($cnt); ?> Listings found</span></p>
                    </div>
                </div>

                <!-- Hiển thị danh sách xe -->
                <?php
                if ($cnt > 0) {
                    foreach ($results as $result) { ?>
                        <div class="product-listing-m gray-bg">
                            <div class="product-listing-img">
                                <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive" alt="Image"/>
                            </div>
                            <div class="product-listing-content">
                              <h5><a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                                  <?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?>
                              </a></h5>
                              <p class="list-price">$<?php echo htmlentities($result->PricePerDay); ?>Price Per Day</p>
                              <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="btn">View Details <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                            </div>
                        </div>
                    <?php }
                } else {
                    echo "<p>No vehicles found matching your criteria.</p>";
                }
                ?>
            </div>

            <aside class="col-md-3 col-md-pull-9">
                <div class="sidebar_widget">
                    <div class="widget_heading">
                        <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your Bike</h5>
                    </div>
                    <div class="sidebar_filter">
                        <form action="bike-listing.php" method="post">
                            <!-- Bộ lọc thương hiệu -->
                            <div class="form-group select">
                                <select class="form-control" name="brand">
                                    <option value="">Select Brand</option>
                                    <?php
                                    $sql = "SELECT * FROM tblbrands"; // Truy vấn lấy tất cả thương hiệu
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $brands = $query->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($brands as $brand) { ?>
                                        <option value="<?php echo htmlentities($brand->id); ?>">
                                            <?php echo htmlentities($brand->BrandName); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Bộ lọc khoảng giá -->
                            <div class="form-group select">
                                <select class="form-control" name="price">
                                    <option value="">Select Price Range</option>
                                    <option value="low">Below $10/day</option>
                                    <option value="medium">$10 - $20/day</option>
                                    <option value="high">Above $20/day</option>
                                </select>
                            </div>

                            <!-- Nút tìm kiếm -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-block">
                                    <i class="fa fa-search" aria-hidden="true"></i> Search Bike
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>
<?php include('includes/login.php'); ?>
<?php include('includes/registration.php'); ?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
</body>
</html>
