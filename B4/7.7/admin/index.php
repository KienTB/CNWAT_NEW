<?php
    session_start();
   


    $rootDir = realpath($_SERVER["DOCUMENT_ROOT"])."/7.7/";
    if(isset($_POST["submitUpload"])) {
        if(isset($_FILES['fileToUpload'])){
            $files = $_FILES['fileToUpload'];      
            $names = $files['name'];
            $types = $files['type'];
            $tmp_names = $files['tmp_name'];
            $errors = $files['error'];
            $sizes = $files['size'];

            //Số file được upload
            $numitems = count($names);
            $numfiles = 0;       
        }
        for ($i = 0; $i < $numitems; $i++) {
            if ($errors[$i] == 0) {
                $numfiles++;
                move_uploaded_file($tmp_names[$i], $rootDir.'uploads/'.$names[$i]);
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
    <link rel="stylesheet" href="../css/index.css?v=1.1">
</head>

<body>
    <div class="container-app">
        <?php include './pages/head.php';?>
        <div class="content">
            <?php include './pages/left.php' ;?>
            <div class="content-right">
                <?php   
                $page = isset($_GET['page']) ? $_GET['page'] : 'default';
                // Xác định đường dẫn trang cần bao gồm
                switch ($page) {
                    case 'Return_Home':
                        header('location: ../index.php?v=<?php echo time(); ?>');

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
        <?php include '../components/footer.php' ;?>
    </div>
</body>

</html>