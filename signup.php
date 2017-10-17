<?php include('server.php'); ?>
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
  <link rel="stylesheet" href="signup.css">
  <link rel="stylesheet" href="nav.css">
  <link rel="stylesheet" href="login.css">

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
        <a class="navbar-brand" href="home.php">HELPFit</a>
      </div>
      <div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li><a href="home.php#home">Home</a></li>
            <li><a href="home.php#about">About</a></li>
            <li><a href="home.php#services">Services</a></li>
            <li><a href="home.php#benefits">Benefits</a></li>
            <li><a href="home.php#contact">Contact</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <a><button class="btn navbar-btn nav-login" data-toggle="modal" data-target="#loginModal"><strong>Log In</strong></button></a>
  					<a href="signup.php"><button class="btn navbar-btn nav-signup" ><strong>Sign Up</strong></button></a>
  				</ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="modal fade" id="loginModal"><!-- Login Modal -->
  		<div class="modal-dialog">
  			<div class="modal-content">
  				<div class="login-wrap">
  					<div class="login-container">
  						<h3><strong>Log In</strong></h3>
  						<div class="login-form">

  							<form id="login" action="home.php" method="post" autocomplete="off">

  								<div class="form-group">
  									<label for="username" class="label">Username</label>
  									<input id="username" type="text" name="username" class="form-control" placeholder="Username" required>
  								</div>
  								<div class="form-group">
  									<label for="login-password" class="label">Password</label>

  									<input id="login-password" type="password" name="login-password" class="form-control" placeholder="Password" required>
  								</div>

  								<div class="form-group">
  									<button type="submit" name="login" class="button">Log In</button>
  								</div>
  							</form>
                <div class="checkbox">
                  <input type="checkbox" value="" id="checkbox" checked> <label for="checkbox"></label>
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

  <div class="container" id="top">
    <div class="col-xs-12 col-sm-12 col-sm-offset-0 col-lg-6 col-lg-offset-3">
      <div class="signup-wrap">
        <div class="signup-container">
          <h1><strong>Sign Up</strong></h1>
          <div class="signup-form">
            <form id="signup" action="#" method="post" autocomplete="off" >
              <<?php include('errors.php') ?>
              <div class="form-group">
                <label for="username" class="label">USERNAME</label>
                <input id="username" type="text" name="username" class="form-control" placeholder="Username" required>
              </div>
              <div class="form-group">
                <label for="name" class="label">FULL NAME</label>
                <input id="name" type="text" name="name" class="form-control" placeholder="Full Name" required>
              </div>
              <div class="form-group">
                <label for="email" class="label">E-MAIL</label>
                <input id="email" type="email" name="email" class="form-control" placeholder="E-mail" required>
              </div>
              <div class="form-group">
                <label for="password" class="label">PASSWORD</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="Password (Minimum of 6 characters)" required>
              </div>
              <div class="form-group">
                <label for="password" class="label">CONFIRM PASSWORD</label>
                <input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
              </div>
              <div class="form-group">
    						<label for="user" class="label label-center">JOIN AS A?</label>
    						<div class="row">
    							<div class="col-sm-12 col-lg-6">
    								<label class="radio">
    								  <input type="radio" id="radio-member" name="user" value="member" onclick="showMember(); showErrorMsg();"required>
    								  <div class="choice">Member</div>
    								</label>
    							</div>
    							<div class="col-sm-12 col-lg-6">
    								<label class="radio">
    								  <input type="radio" id="radio-trainer" name="user" value="trainer"  onclick="showTrainer(); showErrorMsg();" required>
    								  <div class="choice">Trainer</div>
    								</label>
    							</div>
    						</div>
    					</div>

    					<div id="member-signup">
    						<label for="level" class="label" style="text-align:center">TRAINING LEVEL </label>
    						<label class="radio">
    						  <input type="radio" id="beginner" name="level" value="beginner" checked>
    						  <div class="choice">Beginner</div>
    						</label>
    						<label class="radio">
    						  <input type="radio" id="intermediate" name="level" value="intermediate">
    						  <div class="choice">Intermediate</div>
    						</label>
    						<label class="radio">
    						  <input type="radio" id="expert" name="level" value="expert">
    						  <div class="choice">Expert</div>
    						</label>
    					</div>

    					<div id="trainer-signup">
    						<label for="specialty" class="label" style="text-align:center">SPECIALTY</label>
    						<input id="specialty" type="text" name="specialty" class="form-control" placeholder="Specialty">
    					</div>
              <div id="error-msg-mt">Please select to be a member or a trainer.</div>
              <div class="form-group">
                <button type="submit" name="signup" class="button" style="margin-top:10px;" onclick="showErrorMsg();">Sign Up</button>
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
// validate password
var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function checkLength(){
  if(password.value.length < 6){
    password.setCustomValidity("Minimum of 6 characters");
  }
  else {
    password.setCustomValidity('');
  }
}

password.onchange = checkLength;
password.onkeyup = checkLength;

function validatePassword(){
  if (password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}
password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

// to check if the radio buttons are selected
function showErrorMsg(){
  if(!document.getElementById("radio-trainer").checked && !document.getElementById("radio-member").checked) {
    document.getElementById('error-msg-mt').style.display = 'block';
  }else{
    document.getElementById('error-msg-mt').style.display = 'none';
  }
}


// display options
function showMember(){
  document.getElementById('member-signup').style.display = 'block';
  document.getElementById('trainer-signup').style.display = 'none';
}
function showTrainer(){
  document.getElementById('member-signup').style.display = 'none';
  document.getElementById('trainer-signup').style.display = 'block';
}

// smooth scrolling
$(document).ready(function(){
  $('body').scrollspy({target: ".footer", offset: 50});

  $("footer a[href='#top']").on('click', function(event) {
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

// to collapse navigation bar on mobile
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
