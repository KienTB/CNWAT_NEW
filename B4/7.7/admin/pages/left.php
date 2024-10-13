<?php
    $isLogin = true;
    if(empty($_SESSION['username']) || empty($_SESSION['password'])) {       
        $isLogin = false;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="http://localhost/CNPM/PHP-7.7/css/left.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
        
    ?>
    <div class="left-container">
        <form action="<?php
        echo htmlspecialchars($_SERVER['PHP_SELF']);
    ?>" method="POST">
            <?php
                if(!$isLogin) {
                    echo "
                    <a href='#' class='btn btn-primary'  onclick='loadPage(\"Return_Home\")'>Return Home</a>
                    <a href='#' class='btn btn-primary' >Admin Home</a>
                    <a href='#' class='btn btn-primary' >Logout</a>
                    <a href='#' class='btn btn-primary' >Upload</a>      
                    ";

                }
                else {
                    echo "
                        <a href='#' class='btn btn-primary'  onclick='loadPage(\"Return_Home\")'>Return Home</a>
                        <a href='#' class='btn btn-primary' onclick='loadPage(\"Admin_Home\")'>Admin Home</a>
                        <a href='#' class='btn btn-primary' onclick='loadPage(\"Logout\")'>Logout</a>
                        <a href='#' class='btn btn-primary' onclick='loadPage(\"Upload\")'>Upload</a>      
                    ";
                }
            ?>

        </form>
    </div>
    <script>
    function loadPage(page) {
        window.location.href = "./index.php?page=" + encodeURIComponent(page);
    }
</script>
</body>

</html>