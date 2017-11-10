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
  <script src="myApp.js"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="nav.css">
  <link rel="stylesheet" href="view_sessions.css">
  <link rel="icon" href="favicon.ico" type="image/x-icon"/>
  <style>body{background-image: url(images/viewreviews.jpg);}</style>
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
          <li><a href="view_history_trainer.php">Manage Sessions</a></li>
          <li><a href="view_reviews.php" class="active-page">View Reviews</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <a href="trainer_main.php?logout='1'"><button class="btn navbar-btn nav-logout"><strong>Log Out</strong></button></a>
				</ul>
      </div>
    </div>
  </div>
</nav>
<div class="container main-container">
  <h1>Your Reviews</h1>
  <div class="col-xs-12 col-sm-12 col-sm-offset-0 col-lg-10 col-lg-offset-1">
    <hr />
    <div class="training-container">
      <div class="training-container details">
        <div class="row">
          <div class="col-xs-6 avg-disp">
            <?php //calculate trainer's average rating
            $trainer_id = $_SESSION['user']['user_id'];
            $query = mysqli_query_or_die("SELECT avg(rating) AS avg_rating FROM review WHERE trainer_id = '$trainer_id'");
            $data = mysqli_fetch_assoc($query);
            $avg_rating = round($data['avg_rating'],2); ?>
            <p class="det_label">Average Rating</p>
            <span class="stars" data-rating="<?php echo $avg_rating; ?>" data-num-stars="5" ></span>
            <p class="avg_num_wrap">(<p id="avg_num"></p>)</p>
          </div>
          <div class="col-xs-6 num-disp">
            <?php //calculate trainer's no. of reviews
            $trainer_id = $_SESSION['user']['user_id'];
            $query = mysqli_query_or_die("SELECT count(*) AS numReviews FROM review WHERE trainer_id = '$trainer_id'");
            $data = mysqli_fetch_assoc($query);
            $num_reviews = $data['numReviews']; ?>
            <p class="det_label">Total Reviews</p>
            <h3 class="num"><?php echo $num_reviews; ?></h3>
          </div>
        </div>
      </div>
      <hr />
      <section class="accordion" role="tablist" aria-multiselectable="false">
      <?php echo printReviews(); ?>
      </section>
    </div>
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

var num = <?php echo $avg_rating; ?>;
document.getElementById('avg_num').innerHTML = parseFloat(Math.round(num * 100) / 100).toFixed(2);

</script>
</body>
</html>
