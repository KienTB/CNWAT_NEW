<?php
// Định nghĩa các thông tin kết nối cơ sở dữ liệu.
define('DB_HOST','localhost');  
define('DB_USER','root');       
define('DB_PASS','');           
define('DB_NAME','bikerental'); 
define('DB_PORT', 3307);        

// Thiết lập kết nối cơ sở dữ liệu bằng PDO (PHP Data Objects).
try {
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
?>
