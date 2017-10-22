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
  <title>HELPFit | Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway" rel="stylesheet">
  <link rel="stylesheet" href="profile.css">
  <link rel="stylesheet" href="nav.css">
  <link rel="icon" href="favicon.ico" type="image/x-icon"/>

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
      <a class="navbar-brand" href="member_main.php"><img src="icons/helpfitlogosmall.png"></a>
    </div>
    <div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <?php if (isset($_SESSION['member'])) {?>
            <li><a href="member_main.php">Home</a></li>
            <li><a href="profile.php" class="active-page">Profile</a></li>
            <li><a href="#">Join Sessions</a></li>
            <li><a href="#">View History</a></li>
          <?php }else{ ?>
            <li><a href="trainer_main.php">Home</a></li>
            <li><a href="profile.php" class="active-page">Profile</a></li>
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
        <h1><strong>Profile</strong></h1>
        <?php if (isset($_SESSION['success_edit'])) : ?>
          <div class="alert alert-success alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>
              <?php
                echo $_SESSION['success_edit'];
                unset($_SESSION['success_edit']);
              ?>
            </strong>
            </h1>
          </div>
        <?php endif ?>
        <div class="profile-form">
          <form id="profile" action="#" method="post" autocomplete="off" >

            <div class="display">
              <h2><?php echo $_SESSION['user']['name'];?></h2>
              <h4><?php echo $_SESSION['user']['user_type'];?></h4>
              <?php if (isset($_SESSION['member'])){ ?>
                <p><?php echo $_SESSION['member']['level']; ?> level</p>
              <?php } elseif (isset($_SESSION['trainer'])){
                if (empty($_SESSION['trainer']['specialty'])){ ?>
                  <p>unknown master</p>
                <?php }else{ ?>
                <p><?php echo $_SESSION['trainer']['specialty']; ?> master</p>
              <?php }} ?>
              <h5 id="username_disp">[ <?php echo $_SESSION['user']['username'];?> ]</h5>
              <br />
              <div class="chgpswd" id="chgpswd"><a href="change_password.php">Change Password</a></div>
            </div>
            <hr />
            <div class="form-group">
              <label for="name" class="label">FULL NAME</label>
              <input id="name" type="text" name="name" class="form-control" placeholder="Full Name" value="<?php echo $_SESSION['user']['name']; ?>" required>
            </div>
            <div class="form-group">
              <label for="email" class="label">E-MAIL</label>
              <input id="email" type="email" name="email" class="form-control" placeholder="E-mail" value="<?php echo $_SESSION['user']['email']; ?>" required>
            </div>

            <div id="member-edit">
              <label for="level" class="label" style="text-align:center">TRAINING LEVEL </label>
              <div class="row">
                <div class="col-sm-12 col-lg-4">
                  <label class="radio">
                    <input type="radio" id="beginner" name="level" value="beginner" <?php if ($_SESSION['member']['level'] == "beginner") print "checked"; ?>>
                    <div class="choice">Beginner</div>
                  </label>
                </div>
                <div class="col-sm-12 col-lg-4">
                  <label class="radio">
                    <input type="radio" id="intermediate" name="level" value="intermediate" <?php if ($_SESSION['member']['level'] == "intermediate") print "checked"; ?>>
                    <div class="choice">Intermediate</div>
                  </label>
                </div>
                <div class="col-sm-12 col-lg-4">
                  <label class="radio">
                    <input type="radio" id="expert" name="level" value="expert" <?php if ($_SESSION['member']['level'] == "expert") print "checked"; ?>>
                    <div class="choice">Expert</div>
                  </label>
                </div>
              </div>
            </div>

            <div id="trainer-edit">
              <label for="specialty" class="label" style="text-align:center">SPECIALTY</label>
              <input id="specialty" type="text" name="specialty" class="form-control" placeholder="Specialty" value="<?php echo $_SESSION['trainer']['specialty']; ?>">
            </div>
            <div class="form-group">
              <button type="submit" name="edit" class="button" style="margin-top:10px;">Confirm Edit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<footer class="text-center">
  <a class="up-arrow" href="#home" data-toggle="tooltip" title="TO TOP">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a><br><br>
  <p>Copyright &copy; 2017 HELPFit</p>
</footer>
<script>
<?php  if ($_SESSION['user']['user_type'] == "member"){ ?>
  document.getElementById('member-edit').style.display = 'block';
  document.getElementById('trainer-edit').style.display = 'none';
<?php  } else{ ?>
  document.getElementById('member-edit').style.display = 'none';
  document.getElementById('trainer-edit').style.display = 'block';
<?php  }; ?>
</script>
</body>
</html>
