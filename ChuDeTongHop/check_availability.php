<?php
require_once("includes/config.php"); 

if (!empty($_POST["emailid"])) {
    $email = $_POST["emailid"];
    
    // Kiểm tra định dạng email có hợp lệ không
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo "error: You did not enter a valid email."; 
    } else {
        // Truy vấn cơ sở dữ liệu để kiểm tra xem email đã tồn tại hay chưa
        $sql = "SELECT EmailId FROM tblusers WHERE EmailId=:email";
        $query = $dbh->prepare($sql); // Chuẩn bị truy vấn SQL
        $query->bindParam(':email', $email, PDO::PARAM_STR); // Liên kết tham số email
        $query->execute(); // Thực thi truy vấn
        $results = $query->fetchAll(PDO::FETCH_OBJ); // Lấy kết quả dưới dạng đối tượng

        // Kiểm tra xem có bản ghi nào trả về hay không
        if ($query->rowCount() > 0) {
            echo "<span style='color:red'> Email already exists.</span>"; // Email đã tồn tại
            echo "<script>$('#submit').prop('disabled', true);</script>"; // Vô hiệu hóa nút submit
        } else {
            echo "<span style='color:green'> Email available for Registration.</span>"; // Email có thể sử dụng
            echo "<script>$('#submit').prop('disabled', false);</script>"; // Kích hoạt nút submit
        }
    }
}
?>
