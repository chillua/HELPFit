<?php
  include('server.php');
  if (!isset($_SESSION['user'])) {
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

  if (!isset($_SESSION['training'])){
    header('location: view_history_trainer.php');
  }

?>
<!DOCTYPE html>
<html>
<head>
  <title>HELPFit | Create Training Session</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway|Cabin" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="createsession.css">
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
      <a class="navbar-brand" href="#home"><img src="icons/helpfitlogosmall.png"></a>
    </div>
    <div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="trainer_main.php">Home</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="createsession.php" >Create Sessions</a></li>
          <li><a href="view_history_trainer.php">Manage Sessions</a></li>
          <li><a href="#">View Reviews</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <a href="trainer_main.php?logout='1'"><button class="btn navbar-btn nav-logout"><strong>Log Out</strong></button></a>
				</ul>
      </div>
    </div>
  </div>
</nav>
<div class="container main-container">
  <div class="col-xs-12 col-sm-12 col-sm-offset-0 col-lg-7 col-lg-offset-5">
    <div class="profile-wrap">
      <div class="profile-container">
        <h1><strong>EDIT SESSION</strong></h1>
        <hr>
        <?php echo display_error(); ?>
        <?php if (isset($_SESSION['success_editsession'])) : ?>
          <div class="alert alert-success alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>
              <?php
                echo $_SESSION['success_editsession'];
                unset($_SESSION['success_editsession']);
              ?>
            </strong>
            </h1>
          </div>
        <?php endif ?>
        <div class="session-form">
          <form id="session" action="#" method="post" autocomplete="off" >
            <div class="form-group">
              <label for="training_type" class="label">TRAINING TYPE</label>
              <?php if (isset($_SESSION['personal'])) {
                echo '<p id="stype"> Personal Training </p>';
              }else if (isset($_SESSION['group'])){
                echo '<p id="stype"> Group Training </p>';
              } ?>
            </div>
            <div class="form-group">
              <label for="title" class="label">TITLE</label>
              <input id="title" type="text" name="title" class="form-control" placeholder="Title" required value="<?php echo $_SESSION['training']['title']; ?>">
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12 col-lg-6">
                <label for="date" class="label">DATE</label>
                <input id="date" type="text" name="date" class="form-control" required value="<?php echo DateTime::createFromFormat('Y-m-d', $_SESSION['training']['date'])->format('d/m/Y'); ?>">
              </div>
                <div class="col-sm-12 col-lg-6">
                <label for="time" class="label">TIME</label>
                <input id="time" type="time" name="time" class="form-control" required value="<?php echo $_SESSION['training']['time']; ?>">
              </div>
              </div>
            </div>
            <div class="form-group">
              <label for="fee" class="label">FEE</label>
              <input id="fee" type="number" name="fee" class="form-control" placeholder="0.00" required value="<?php echo $_SESSION['training']['fee']; ?>">
            </div>
            <?php if (isset($_SESSION['group'])){ ?>
              <div id="group-training" style="display:block;">
              <div class="form-group">
                  <label for="max_pax" class="label">MAX PARTICIPANTS</label>
                <input id="max_pax" type="number" name="max_pax" class="form-control" placeholder="e.g. 30" value="<?php echo $_SESSION['group']['max_pax']; ?>" />
              </div>
              <div class="form-group">
                <label for="class_type" class="label label-center">CLASS TYPE</label>
                <div class="row">
                  <div class="col-sm-12 col-lg-4">
                    <label class="radio">
                      <input type="radio" id="radio-sport" name="class_type" value="sport" <?php if ($_SESSION['group']['class_type'] == "sport") print "checked"; ?> />
                      <div class="choice">Sport</div>
                    </label>
                  </div>
                  <div class="col-sm-12 col-lg-4">
                    <label class="radio">
                      <input type="radio" id="radio-dance" name="class_type" value="dance" <?php if ($_SESSION['group']['class_type'] == "dance") print "checked"; ?> />
                      <div class="choice">Dance</div>
                    </label>
                  </div>
                  <div class="col-sm-12 col-lg-4">
                    <label class="radio">
                      <input type="radio" id="radio-mma" name="class_type" value="mma" <?php if ($_SESSION['group']['class_type'] == "mma") print "checked"; ?> />
                      <div class="choice">MMA</div>
                    </label>
                  </div>
                </div>
              </div>
            </div>
        <?php }else{ ?>
          <div class="form-group">
              <label for="notes" class="label">NOTES</label>
            <textarea id="notes" style="height:200px;" name="notes" class="form-control" placeholder="Enter training details here..." ><?php echo $_SESSION['personal']['notes']; ?></textarea>
          </div>
        <?php } ?>
        <div class="form-group">
          <label for="class_type" class="label label-center">STATUS</label>
          <div class="row">
            <div class="col-sm-12 col-lg-6">
              <label class="radio">
                <input type="radio" id="radio-ava" name="status" value="available" <?php if ($_SESSION['training']['status'] == "available") print "checked"; ?> />
                <div class="choice">Available</div>
              </label>
            </div>
            <div class="col-sm-12 col-lg-6">
              <label class="radio">
                <input type="radio" id="radio-comp" name="status" value="completed" <?php if ($_SESSION['training']['status'] == "completed") print "checked"; ?> />
                <div class="choice">Completed</div>
              </label>
            </div>
          </div>
        </div>
            <div class="form-group">
              <button type="submit" name="editsession" class="button" style="margin-top:10px;" onclick="showErrorMsgSdm();">EDIT</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<footer class="text-center">
  <a class="up-arrow" href="#top" data-toggle="tooltip" title="TO TOP">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a><br><br>
  <p>Copyright &copy; 2017 HELPFit</p>
</footer>

<script>

$('#radio-group').change(function () {
    if($(this).is(':checked')) {
        $('#radio-sport').prop('required',true);
        $('#max_pax').prop('required',true);
    }
});

$('#radio-personal').change(function () {
    if($(this).is(':checked')) {
      $('#radio-sport').prop('required',false);
      $('#max_pax').prop('required',false);
    }
});

$(function() {
    $("#date").datepicker({minDate: 0,
      dateFormat: 'dd/mm/yy',
      defaultDate: '00/00/00'
    });
});
$("#date").attr( 'readOnly' , 'true' );

</script>
</body>
</html>
