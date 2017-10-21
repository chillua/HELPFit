<?php
  include('server.php');
  if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "You must log in first";
  	header('location: home.php');
  }

  if ($_SESSION['user']['user_type'] == 'trainer'){
    header('location: trainer_main.php');
  }

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
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
  <link rel="stylesheet" href="user_main.css">
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
          <li><a href="member_main.php" class="active-page">Home</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="#">Join Sessions</a></li>
          <li><a href="#">View History</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <a href="member_main.php?logout='1'"><button class="btn navbar-btn nav-logout"><strong>Log Out</strong></button></a>
				</ul>
      </div>
    </div>
  </div>
</nav>

<div class="container main-container">

		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
      <div class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>
					<?php
						echo $_SESSION['success'];
						unset($_SESSION['success']);
					?>
        </strong>
				</h1>
			</div>
		<?php endif ?>

		<!-- logged in user information -->
		<?php  if (isset($_SESSION['user'])) : ?>
			<h1>Hello,<br> <strong><?php echo $_SESSION['user']['name']; ?></strong></h1>
		<?php endif ?>
	</div>
  <footer class="text-center">
    <a class="up-arrow" href="#home" data-toggle="tooltip" title="TO TOP">
      <span class="glyphicon glyphicon-chevron-up"></span>
    </a><br><br>
    <p>Copyright &copy; 2017 HELPFit</p>
  </footer>
</body>
</html>