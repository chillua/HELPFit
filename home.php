<?php
include('server.php');
if (isset($_SESSION['user'])) {
  header('location: member_main.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>HELPFit | Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="home.css">
  <link rel="stylesheet" href="login.css">
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
          <li><a href="#home">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#benefits">Benefits</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <a><button class="btn navbar-btn nav-login" data-toggle="modal" data-target="#loginModal"><strong>Log In</strong></button></a>
					<a href="signup.php"><button class="btn navbar-btn nav-signup" ><strong>Sign Up</strong></button></a>
				</ul>
      </div>
    </div>
  </div>
</nav>
<div id="home" class="container main-container" data-type="background" data-speed="5">
  <div class = "main-header" id="main-header">
    <h3>HELPFit</h3>
    <br> Practice build brains <br> in your muscles. <br>

    <a href="signup.php"><button class="btn">JOIN US</button></a>
    <br><br><br><br>
  </div>
</div>

<div class="modal fade" id="loginModal"><!-- Login Modal -->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="login-wrap">
          <div class="login-container">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><strong>Log In</strong></h3>
            <div class="login-form">

              <form id="login" method="post" autocomplete="off">
                <div class="form-group">
                  <label for="username" class="label">Username</label>
                  <input id="username" type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                  <label for="login-password" class="label">Password</label>

                  <input id="login-password" type="password" name="login-password" class="form-control" placeholder="Password" required>
                </div>
                <?php echo display_error_login(); ?>
                <div class="form-group">
                  <button type="submit" name="login" class="button" >Log In</button>
                </div>
              </form>
              <div class="checkbox">
                <input type="checkbox" value="on" id="checkbox" name="remember_me" checked> <label for="checkbox"></label>
              </div>
              Remember me | <a href="#forgot">Forgot Password?</a>
              <div class="sign-up">
                <p>New to HELPFit?</p>
                <a href="signup.php"><input type="submit" class="button" value="Sign Up"></a>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- End of Login Modal -->


<div id="about" class="container-fluid">
  <h1>About Us</h1>
  <div class="col-xs-12 col-sm-12 col-sm-offset-0 col-lg-6 col-lg-offset-3 slideanim">
  <p>We are a company that is motivated to bring fitness into your daily life unlike any other company. We act as a platform to connect fitness trainers and fitness enthusiasts - You are able to sign up as a fitness member or a fitness trainer.
    <br><br>For members, we will help you experience training under a trainer with just one click of a button. You will be able to join personal or group trainings such as dance, MMA or sport. Not enough money for a gym subscription? Not enough time to travel places? HELPFit is here to solve your problems!
    <br><br>For trainers, you will be able to set up training sessions according to your schedule and get customers with just one click! You are also able to keep track of your schedule all the time.
	<br><br><br><img src="icons/helpfitlogosmall.png"></p>
  <br><br><br>
</div>
</div>

<div id="services" class="container-fluid" data-type="background" data-speed="5">
  <h1>Our Services</h1>
  <div class="container slideanim">
    <div id="outer-div-member" class="col-sm-6">
      <h2><b>Be a Member</b></h2>
      <div class="col-sm-6">
        <img src="icons/book.png">
        <h4>Book Sessions</h4>
        <p>Book yourself onto any of our available training sessions.</p>
      </div>
      <div class="col-sm-6">
        <img src="icons/rate.png">
        <h4>Review Trainer</h4>
        <p>Rate your experience with your trainers.</p>
      </div>
    </div>
    <div id="outer-div-trainer" class="col-sm-6">
      <h2><b>Be a Trainer</b></h2>
      <div class="col-sm-6">
        <img src="icons/create.png">
        <h4>Create Sessions</h4>
        <p>Create a new training sessions and get going right away!</p>
      </div>
      <div class="col-sm-6">
        <img src="icons/feedback.png">
        <h4>Receive Feedback</h4>
        <p>Receive feedbacks from your sessions to know if you've done well!</p>
      </div>
    </div>
  </div>
</div>

<div id="benefits" class="container-fluid">
  <h1>Why Us?</h1>
  <div class="col-sm-4">
    <h3><strong>Easy Access</strong></h3><hr>
    <img id="ben1" src="images/ben1.jpg" class="img-circle service slideanim">
    <div class="moreinfo slideanim">
      <p>This website is easily accessible through most of your daily devices.</p>
    </div>
  </div>
  <div class="col-sm-4">
    <h3><strong>Flexibility</strong></h3><hr>
    <img id="ben2" src="images/ben2.jpg" class="img-circle service slideanim">
    <div class="moreinfo slideanim">
      <p>You can access this anytime and anywhere you wish to.</p>
    </div>
  </div>
  <div class="col-sm-4">
    <h3><strong>Time-Saving</strong></h3><hr>
    <img id="ben3" src="images/ben3.jpg" class="img-circle service slideanim">
    <div class="moreinfo slideanim">
      <p>With the convenience at hand its obvious that with this website you are bound to save your precious time.</p>
    </div>
  </div>
</div>


<div id="contact" class="container-fluid" data-type="background" data-speed="5">
  <h1>Contact Us</h1>
  <div class="container">
    <div class="col-md-4">
      <p>Any Questions? Any problems? Contact us!</p>
      <p><span class="glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;KL, Malaysia</p>
      <p><span class="glyphicon glyphicon-phone"></span>&nbsp;&nbsp;Phone: +60 10000000</p>
      <p><span class="glyphicon glyphicon-envelope"></span>&nbsp;&nbsp;E-mail: mail@mail.com</p>
    </div>
    <div class="col-md-8">
      <form action = "#" method="post" autocomplete="off">
        <div class="row">
          <div class="col-sm-6 form-group">
            <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
          </div>
          <div class="col-sm-6 form-group">
            <input class="form-control" id="email" name="email" placeholder="E-mail" type="email" required>
          </div>
          <div class="col-md-12 form-group">
            <input class="form-control" id="subject" name="subject" placeholder="Subject" type="text" required>
          </div>
        </div>

        <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea>
        <div id="contact-btn" class="row">
          <div class="col-md-12 form-group">
            <button class="btn" type="submit">Send</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<footer class="text-center">
  <a class="up-arrow" href="#home" data-toggle="tooltip" title="TO TOP">
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
<?php  if (count($errors_login) > 0) : ?>
  $('#loginModal').modal('show');
<?php  endif ?>

$(document).ready(function(){
  $('body').scrollspy({target: ".navbar", offset: 50});
  $("#myNavbar a, footer a[href='#home']").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
        window.location.hash = hash;
      });
    }
  });

  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });
});
$(document).ready(function(){

  var $window = $(window); //You forgot this line in the above example

  $('div[data-type="background"]').each(function(){
    var $bgobj = $(this); // assigning the object
    $(window).scroll(function() {
      var yPos = -( ($window.scrollTop() - $bgobj.offset().top) / $bgobj.data('speed'));
      // Put together our final background position
      var coords = '50% '+ yPos + 'px';
      // Move the background
      $bgobj.css({ backgroundPosition: coords,
                  '-webkit-background-size': 'cover',
                  '-moz-background-size': 'cover',
                  '-o-background-size': 'cover',
                  'background-size': 'cover'
      });
    });
  });
});

$(document).click(function (event) {
    var clickover = $(event.target);
    var $navbar = $(".navbar-collapse");
    var _opened = $navbar.hasClass("in");
    if (_opened === true && !clickover.hasClass("navbar-toggle")) {
        $navbar.collapse('hide');
    }
});

</script>

</body>
</html>
