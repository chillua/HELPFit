<?php
  include('server.php');
  if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "You must log in first";
  	header('location: home.php');
  }

	if (isset($_GET['logout'])) {
		session_destroy();
    session_unset();
		header("location: home.php");
	}


?>
<!DOCTYPE html>
<html>
<head>
  <title>HELPFit</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway" rel="stylesheet">
  <link rel="stylesheet" href="profile.css">
  <link rel="stylesheet" href="nav.css">

</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="member_main.php">HELPFit</a>
    </div>
    <div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <?php if (isset($_SESSION['member'])) {?>
            <li><a href="member_main.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="#">Join Sessions</a></li>
            <li><a href="#">View History</a></li>
          <?php }else{ ?>
            <li><a href="trainer_main.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="createsession.php">Create Sessions</a></li>
            <li><a href="#">Manage Sessions</a></li>
            <li><a href="#">View History</a></li>
          <?php } ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <a href="member_main.php?logout='1'"><button class="btn navbar-btn nav-logout"><strong>Log Out</strong></button></a>
				</ul>
      </div>
    </div>
  </div>
</nav>

<div class="container main-container">
  <div class="col-xs-12 col-sm-12 col-sm-offset-0 col-lg-6 col-lg-offset-3">
    <div class="profile-wrap">
      <div class="profile-container">
        <h1><strong>Change Password</strong></h1>
        <?php echo display_error(); ?>
        <div class="profile-form">
          <form id="chgpassword" action="#" method="post" autocomplete="off" >
            <div class="form-group">
              <label for="curr_password" class="label">CURRENT PASSWORD</label>
              <input id="curr_password" type="password" name="curr_password" class="form-control" placeholder="Current Password" required>
            </div>
            <div class="form-group">
              <label for="new-password" class="label">NEW PASSWORD</label>
              <input id="new_password" type="password" name="new_password" class="form-control" placeholder="Password (Minimum of 6 characters)" required>
            </div>
            <div class="form-group">
              <label for="confirm-new-password" class="label">CONFIRM PASSWORD</label>
              <input id="confirm_new_password" type="password" name="confirm_new_password" class="form-control" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
              <button type="submit" name="change_password" class="button" style="margin-top:10px;">Change Password</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
</script>
</body>
</html>