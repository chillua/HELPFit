<?php
  include('server.php');
  if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "You must log in first";
  	header('location: home.php');
  }

  if ($_SESSION['user']['user_type'] == 'member'){
    header('location: member_main.php');
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
  <link rel="stylesheet" href="createsession.css">
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
      <a class="navbar-brand" href="#home">HELPFit</a>
    </div>
    <div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="trainer_main.php">Home</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="createsession.php" class="active-page">Create Sessions</a></li>
          <li><a href="#">Manage Sessions</a></li>
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
  <div class="col-xs-12 col-sm-12 col-sm-offset-0 col-lg-6 col-lg-offset-3">
    <div class="profile-wrap">
      <div class="profile-container">
        <h1><strong>New Training Session</strong></h1>
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
        <div class="session-form">
          <form id="session" action="#" method="post" autocomplete="off" >
            <div class="form-group">
              <label for="training_type" class="label">TRAINING TYPE</label>
              <div class="row">
                <div class="col-sm-12 col-lg-6">
                  <label class="radio">
                    <input type="radio" id="radio-personal" name="training_type" value="personal" onclick="showPersonal(); showErrorMsg();" required>
                    <div class="choice">Personal Training</div>
                  </label>
                </div>
                <div class="col-sm-12 col-lg-6">
                  <label class="radio">
                    <input type="radio" id="radio-group" name="training_type" value="group"  onclick="showGroup(); showErrorMsg();" required>
                    <div class="choice">Group Training</div>
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="title" class="label">TITLE</label>
              <input id="title" type="text" name="name" class="form-control" placeholder="Title" required>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12 col-lg-6">
                <label for="date" class="label">DATE</label>
                <input id="date" type="date" name="date" class="form-control" required>
              </div>
                <div class="col-sm-12 col-lg-6">
                <label for="time" class="label">TIME</label>
                <input id="time" type="time" name="time" class="form-control" required>
              </div>
              </div>
            </div>
            <div class="form-group">
              <label for="fee" class="label">FEE</label>
              <input id="fee" type="number" name="fee" class="form-control" placeholder="Fee" required>
            </div>
            <div id="group-training">
            <div class="form-group">
                <label for="max_pax" class="label">MAX PARTICIPANTS</label>
              <input id="max_pax" type="number" name="max_pax" class="form-control" placeholder="Maximum Participants" required>
            </div>
            <div class="form-group">
              <label for="class_type" class="label label-center">CLASS TYPE</label>
              <div class="row">
                <div class="col-sm-12 col-lg-4">
                  <label class="radio">
                    <input type="radio" id="radio-sport" name="class_type" value="sport" onclick="showMember(); showErrorMsg();"required>
                    <div class="choice">Sport</div>
                  </label>
                </div>
                <div class="col-sm-12 col-lg-4">
                  <label class="radio">
                    <input type="radio" id="radio-dance" name="class_type" value="dance" onclick="showMember(); showErrorMsg();"required>
                    <div class="choice">Dance</div>
                  </label>
                </div>
                <div class="col-sm-12 col-lg-4">
                  <label class="radio">
                    <input type="radio" id="radio-mma" name="class_type" value="mma" onclick="showMember(); showErrorMsg();"required>
                    <div class="choice">MMA</div>
                  </label>
                </div>
              </div>
            </div>
          </div>
            <div class="form-group">
              <button type="submit" name="createsession" class="button" style="margin-top:10px;" onclick="showErrorMsg();">Create</button>
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
// to check if the radio buttons are selected
function showErrorMsg(){
  if(!document.getElementById("radio-trainer").checked && !document.getElementById("radio-member").checked) {
    document.getElementById('error-msg-mt').style.display = 'block';
  }else{
    document.getElementById('error-msg-mt').style.display = 'none';
  }
}


// display options
function showPersonal(){
  document.getElementById('group-training').style.display = 'none';
}
function showGroup(){
  document.getElementById('group-training').style.display = 'block';
}
</script>
</body>
</html>
