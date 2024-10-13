<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Trang chủ</title>
    <link rel="stylesheet" type="text/css" href="../index/style.css?v=<?php echo time(); ?>">
    
</head>
<body>
    <div class ='header'>
        <?php include '../pages/header.php'; ?>
    </div>
    <div class ="main">
        <div id ="menu" >
            <?php include '../pages/menu.php'; ?>
        </div>
        <div id ="center" >
        <?php
                // Kiểm tra xem tham số 'page' có tồn tại trong URL không
                $page = isset($_GET['page']) ? $_GET['page'] : 'default'; // Nếu không tồn tại, sẽ hiển thị trang mặc định

                // Xác định đường dẫn trang cần bao gồm
                switch ($page) {
                    case 'Add':
                        $path = '../pages/Add.php';
                        break;
                    case 'Edit':
                        $path = '../pages/Edit.php';
                        break;
                    case 'Delete':
                        $path = '../pages/Delete.php';
                        break;
                    case 'DrawTable':
                        $path = '../pages/DrawTable.php';
                        break;
                    case 'Loop':
                        $path = '../pages/Loop.php';
                        break;
                    case 'CaculationForm':
                        $path = '../pages/CaculationForm.php';
                        break;
                    case 'CalculateTotalScore':
                        $path = '../pages/CalculateTotalScore.php';
                        break;
                    case 'Arr1D':
                        $path = '../pages/Arr1D.php';
                        break;
                    case 'Matrix':
                        $path = '../pages/Matrix.php';
                        break;
                    case 'UploadFile':
                        $path = '../pages/UploadFile.php';
                        break; 
                    case 'AddStudentFile':
                        $path = '../pages/AddStudentFile.php';
                    case 'ListStudentFile':
                        $path = '../pages/ListStudentFile.php';
                    default:
                        $path = '../pages/ListOfUsers.php';
                        break;
                    }
                    if (file_exists($path)) {
                        include($path);
                    } else {
                        echo 'The page does not exist.';
                    }
            ?>
        </div>
        </div>
    </div>
</body>
</html>