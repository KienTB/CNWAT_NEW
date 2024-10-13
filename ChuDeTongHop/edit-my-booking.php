<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    // Lấy thông tin hóa đơn để cập nhật
    $bookingId = intval($_GET['id']);
    if(isset($_POST['update'])) {
        $fromDate = $_POST['fromDate'];
        $toDate = $_POST['toDate'];
        $message = $_POST['message'];

        $sql = "UPDATE tblbooking SET FromDate=:fromDate, ToDate=:toDate, message=:message WHERE id=:bookingId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fromDate', $fromDate, PDO::PARAM_STR);
        $query->bindParam(':toDate', $toDate, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);
        $query->bindParam(':bookingId', $bookingId, PDO::PARAM_STR);
        $query->execute();

        if($query) {
            echo "<script>alert('Booking updated successfully');</script>";
            header('location:my-booking.php');
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }

    // Truy vấn thông tin hóa đơn
    $sql = "SELECT * FROM tblbooking WHERE id=:bookingId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bookingId', $bookingId, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Booking</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<!-- Form chỉnh sửa -->
<form method="post">
    <label for="fromDate">From Date:</label>
    <input type="date" name="fromDate" value="<?php echo htmlentities($result->FromDate); ?>" required>

    <label for="toDate">To Date:</label>
    <input type="date" name="toDate" value="<?php echo htmlentities($result->ToDate); ?>" required>

    <label for="message">Message:</label>
    <textarea name="message" required><?php echo htmlentities($result->message); ?></textarea>

    <button type="submit" name="update">Update</button>
</form>

<!-- JavaScript -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
