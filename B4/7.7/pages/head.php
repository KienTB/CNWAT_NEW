<?php
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/head.css?v=1.1">



</head>

<body>
    <div class="header-container">
        <img class="img-header" src="./images/header-small.jpg" alt="">
        <nav class="pages">
            <div>
                <a href="#" onclick= "loadPage('Home')">Home</a>
                <a href="#" onclick= "loadPage('Login')">Login</a>
            </div>
        </nav>
    </div>
<script>
    function loadPage(page) {
        window.location.href = "./index.php?page=" + encodeURIComponent(page);
    }
</script>
</body>

</html>