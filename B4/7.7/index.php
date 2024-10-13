<?php
       

        // Check username and password
        $username = "";
        $password = "";
        $checkLogin = true;
        if(isset($_POST['submit_login'])) {
            if(isset($_POST['username_login']) && isset($_POST['password_login'])){
                $username = $_POST['username_login'];
                $password = $_POST['password_login'];
                if($username == "admin" && $password == "admin") {
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    header("Location: ./admin/index.php");
                }
                else {
                    $checkLogin = false;
                    $path = './pages/login.php'; 
                }
            }
        }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include './pages/head.php' ;?>
    <div class="content">
        <?php include './components/left.php' ;?>
        <div class="content-right">

            <?php   
                $page = isset($_GET['page']) ? $_GET['page'] : 'default';
                // Xác định đường dẫn trang cần bao gồm
                switch ($page) {
                    case 'Home':
                        $path = './pages/home.php';
                        break;
                    case 'Login':
                        $path = './pages/login.php';
                        break;
                    default:
                        $path ='./pages/login.php';
                        break;
                    }
                    if (file_exists($path)) {
                        include($path);
                    } else {
                        echo 'Trang không tồn tại.';
                    }
            ?>
        </div>
    </div>
    <?php include './components/footer.php' ;?>
</body>

</html>