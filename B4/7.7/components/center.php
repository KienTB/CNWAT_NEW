<?php
      if(isset($_SESSION['username'])) {
        echo "Welcome to Admin Page<br>";
        echo "Username: " . $_SESSION['username'] .'<br>';
        echo "<a href='./pages/logout.php'>Logout</a>";
    }
        $pageCenter = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include './head.php' ;?>
    <div class="content">
        <?php include './left.php' ;?>
        <div class="content-right">
            <?php include $pageCenter ;?>
            <?php   
                $page = isset($_GET['page']) ? $_GET['page'] : 'default';
                // Xác định đường dẫn trang cần bao gồm
                switch ($page) {
                    case 'Return_Home':
                        $path = '../pages/home.php';
                        break;
                    case 'Admin_Home':
                        $path = './pages/adminHome.php';
                        break;
                    case 'Logout':
                        $path = './pages/logout.php';
                        break;
                    case 'Upload':
                        $path = './pages/upload.php';
                        break;
                    default:
                        $path ='./pages/adminHome.php';
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
    <?php include './footer.php' ;?>
</body>

</html>