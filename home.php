<?php
include('server.php');
if (isset($_SESSION['user'])) {
  header('location: member_main.php');
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
  <link rel="stylesheet" href="home.css">
  <link rel="stylesheet" href="login.css">
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
<div id="home" class="container main-container ">
  <div class = "main-header">
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
  <p>Click on the different Section links in the navbar to see the smooth scrolling effect.</p>
  <br><br><br>
</div>

<div id="services" class="container-fluid">
  <h1>Our Services</h1>
  <div id="outer-div-member" class="col-sm-6">
    <h2><b>Be a Member</b></h2>
    <div class="col-sm-6">
      <img src="icons/book.png">
      <h4>Book Sessions</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
    <div class="col-sm-6">
      <img src="icons/rate.png">
      <h4>Review Trainer</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
  </div>
  <div id="outer-div-trainer" class="col-sm-6">
    <h2><b>Be a Trainer</b></h2>
    <div class="col-sm-6">
      <img src="icons/create.png">
      <h4>Create Sessions</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
    <div class="col-sm-6">
      <img src="icons/feedback.png">
      <h4>Receive Feedback</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
  </div>
</div>

<div id="benefits" class="container-fluid">
  <h1>Why Us?</h1>
  <div class="col-sm-4">
    <h3><strong>Easy Access</strong></h3><hr>
    <div class="img-wrapper">
      <img src="images/ben1.jpg" class="img-circle service">
      <div class="moreinfo">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <h3><strong>Flexibility</strong></h3><hr>
    <div class="img-wrapper">
      <img src="images/ben2.jpg" class="img-circle service">
      <div class="moreinfo">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <h3><strong>Time-Saving</strong></h3><hr>
    <div class="img-wrapper">
      <img src="images/ben3.jpg" class="img-circle service">
      <div class="moreinfo">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
      </div>
    </div>
  </div>
</div>


<div id="contact" class="container-fluid">
  <h1>Contact Us</h1>
  <div class="row test">
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
  <p>Copyright &copy; 2017 HELPFit</p>
</footer>

<script>
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
