<?php
  include('server2.php');
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

  if (isset($_GET['upcoming'])) {
    unset($_GET['upcoming']);
		$_SESSION['type'] = 'upcoming';
	}
  if (isset($_GET['completed'])){
    unset($_GET['completed']);
    $_SESSION['type'] = 'completed';
  }

?>
<!DOCTYPE html>
<html>
<head>
  <title>HELPFit Member | Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway|Cabin" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="view_sessions.css">
  <link rel="stylesheet" href="nav.css">
  <link rel="icon" href="favicon.ico" type="image/x-icon"/>
  <style>body{background-image: url(images/viewhistory.jpg);}</style>
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
          <li><a href="trainer_main.php">Home</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="createsession.php">Create Sessions</a></li>
          <li><a href="view_history_trainer.php" class="active-page">Manage Sessions</a></li>
          <li><a href="view_reviews.php">View Reviews</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <a href="trainer_main.php?logout='1'"><button class="btn navbar-btn nav-logout"><strong>Log Out</strong></button></a>
				</ul>
      </div>
    </div>
  </div>
</nav>
<div class="container main-container">
  <h1>Your Training Sessions</h1>
  <div class="col-xs-12 col-sm-12 col-sm-offset-0 col-lg-10 col-lg-offset-1">
    <hr />
    <?php if (isset($_SESSION['success_cancel'])) : ?>
      <div class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>
          <?php
            echo $_SESSION['success_cancel'];
            unset($_SESSION['success_cancel']);
          ?><a class="link" href="view_sessions.php">&nbsp;View your Reviews >></a>
        </strong>
      </div>
    <?php endif ?>
    <div class="row">
      <div class="col-xs-12 col-xs-6">
        <?php if (!isset($_SESSION['type'])){ ?>
          <div class="choice ini" style="margin-bottom:50px;"><a href="view_history_trainer.php?upcoming='1'" id="personal" name="type" value="upcoming"><img src="icons/upcoming.png"><br/>
        <?php }else if (isset($_SESSION['type']) && $_SESSION['type']=='upcoming'){ ?>
          <a href="view_history_trainer.php?upcoming='1'" class="choice chosen" id="personal" name="type" value="upcoming">
        <?php }else { ?>
          <a href="view_history_trainer.php?upcoming='1'" class="choice" id="personal" name="type" value="upcoming">
        <?php } ?>
          Upcoming
        </a>
        <?php if (!isset($_SESSION['type'])){ ?>
          </div>
        <?php } ?>
    </div>
      <div class="col-xs-12 col-xs-6">
        <?php if (!isset($_SESSION['type'])){ ?>
          <div class="choice ini" style="margin-bottom:50px;"><a href="view_history_trainer.php?completed='1'" id="group" name="type" value="completed"><img src="icons/completed.png"><br/>
        <?php }else if (isset($_SESSION['type']) && $_SESSION['type']=='completed'){ ?>
          <a href="view_history_trainer.php?completed='1'" class="choice chosen" id="group" name="type" value="completed">
        <?php }else { ?>
          <a href="view_history_trainer.php?completed='1'" class="choice" id="group" name="type" value="completed">
        <?php } ?>
          Completed
        </a>
    </div>
    <?php if (!isset($_SESSION['type'])){ ?>
      </div>
    <?php } ?>
    </div>
    <form id="join_form" method="post">
      <?php echo printTrainerHistory(); ?>
    </form>
      <div class="cd-popup" role="alert">
          <div class="cd-popup-container">
              <p>Are you sure you want to cancel training session <a style="color:#aaa;" id="t_name">sessionName</a>?</p>
              <ul class="cd-buttons">
                  <li><button class="confirm_submit" id="confirm_join">Yes</li>
                  <li><button class="confirm_submit confirm_close">No</li>
              </ul>
              <a href="#0" class="cd-popup-close img-replace">Close</a>
          </div> <!-- cd-popup-container -->
      </div> <!-- cd-popup -->
  </div>
</div>
<footer class="text-center">
  <a class="up-arrow" href="#top" data-toggle="tooltip" title="TO TOP">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a><br><br>
  <div class="footer-social-icons">
    <h4 class="_12">Follow us on</h4>
    <ul class="social-icons">
        <li><a href="" class="social-icon"> <i class="fa fa-facebook"></i></a></li>
        <li><a href="" class="social-icon"> <i class="fa fa-twitter"></i></a></li>
        <li><a href="" class="social-icon"> <i class="fa fa-rss"></i></a></li>
        <li><a href="" class="social-icon"> <i class="fa fa-youtube"></i></a></li>
        <li><a href="" class="social-icon"> <i class="fa fa-linkedin"></i></a></li>
        <li><a href="" class="social-icon"> <i class="fa fa-google-plus"></i></a></li>
    </ul>
  </div>
  <div class="f_cont">
    <h4 class="_12">Stay Connected</h4>
    <p><span class="glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;KL, Malaysia</p>
    <p><span class="glyphicon glyphicon-phone"></span>&nbsp;&nbsp;Phone: +60 10000000</p>
    <p><span class="glyphicon glyphicon-envelope"></span>&nbsp;&nbsp;E-mail: mail@mail.com</p>
  </div>
  <p style="display:inline;">Privacy Policy</p> |<p style="display:inline;"> Copyright &copy; 2017 HELPFit</p>

</footer>

<script>
$.fn.stars = function() {
    return $(this).each(function() {

        var rating = $(this).data("rating");

        var numStars = $(this).data("numStars");

        var fullStar = new Array(Math.floor(rating + 1)).join('<i class="fa fa-star"></i>');

        var halfStar = ((rating%1) !== 0) ? '<i class="fa fa-star-half-empty"></i>': '';

        var noStar = new Array(Math.floor(numStars + 1 - rating)).join('<i class="fa fa-star-o"></i>');

        $(this).html(fullStar + halfStar + noStar);

    });
}

$('.stars').stars();

$('.rate').hide();

$('input[name=edit]').on('change', function() {
    $("#join_form").submit();
});


jQuery(document).ready(function($){
    //open popup
    $("input[data-sid]").on('change', function(event) {
        event.preventDefault();
        $('.cd-popup').addClass('is-visible');
        $('#t_name').text($(this).attr("data-sid"));
    });

    //close popup
    $('.cd-popup').on('click', function(event){
        if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') || $(event.target).is('.confirm_close')) {
            event.preventDefault();
            $(this).removeClass('is-visible');
            $("input:radio").prop('checked', false);
        }
    });


    $('#confirm_join').on('click', function(event){
         // when the submit button in the modal is clicked, submit the form
        $("#join_form").submit();
    });

    //close popup when clicking the esc keyboard button
    $(document).keyup(function(event){
        if(event.which=='27'){
            $('.cd-popup').removeClass('is-visible');
        }
    });
});


</script>
</body>
</html>
