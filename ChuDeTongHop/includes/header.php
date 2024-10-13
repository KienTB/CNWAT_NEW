<header>
  <div class="default-header">
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-10">
          <div class="header_info">

            <div class="header_widgets">
              <div class="circle_icon">
                <i class="fa fa-envelope" aria-hidden="true"></i>
              </div>
              <p class="uppercase_text">For Support Mail Us:</p>
              <a href="mailto:btkien141203@gmail.com">btkien141203@gmail.com</a>
            </div>

            <div class="header_widgets">
              <div class="circle_icon">
                <i class="fa fa-phone" aria-hidden="true"></i>
              </div>
              <p class="uppercase_text">Service Helpline Call Us:</p>
              <a href="tel:0346-013-061">0346 013 061</a>
            </div>

            <div class="social-follow">
              <ul>
                <li><a href="https://code-projects.org/"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                <li><a href="https://code-projects.org/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
              </ul>
            </div>

            <?php if (strlen($_SESSION['login']) == 0)?>
              <div class="login_btn">
                <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login / Register</a>
              </div>
            <?php ?>
          </div>
        </div>
      </div>
    </div>
  </div>


  <nav id="navigation_bar" class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button id="menu_slide" class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>


      <div class="header_wrap">
        <div class="user_login">
          <ul>
            <li class="dropdown">
              <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle" aria-hidden="true"></i>
                <?php
                $email = $_SESSION['login'];
                $sql = "SELECT FullName FROM tblusers WHERE EmailId=:email";
                $query = $dbh->prepare($sql);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                  foreach ($results as $result) {
                    echo htmlentities($result->FullName);
                  }
                }
                ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </a>

              <ul class="dropdown-menu">
                <?php if ($_SESSION['login']) { ?>
                  <li><a href="profile.php">Profile Settings</a></li>
                  <li><a href="my-booking.php">My Booking</a></li>
                  <li><a href="logout.php">Sign Out</a></li>
                <?php } else { ?>
                  <li><a href="#loginform" data-toggle="modal" data-dismiss="modal">Profile Settings</a></li>
                  <li><a href="#loginform" data-toggle="modal" data-dismiss="modal">My Booking</a></li>
                  <li><a href="#loginform" data-toggle="modal" data-dismiss="modal">Sign Out</a></li>
                <?php } ?>
              </ul>
            </li>
          </ul>
        </div>

        <div class="header_search">
          <div id="search_toggle">
            <i class="fa fa-search" aria-hidden="true"></i>
          </div>
          <form action="#" method="get" id="header-search-form">
            <input type="text" placeholder="Search..." class="form-control">
            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
          </form>
        </div>
      </div>


      <div class="collapse navbar-collapse" id="navigation">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="page.php?type=aboutus">About Us</a></li>
          <li><a href="bike-listing.php">Bike Listing</a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>
