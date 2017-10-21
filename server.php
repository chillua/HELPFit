<?php

  session_start();

  // variable declaration
  $username = "";
  $name = "";
  $email    = "";
  $user ="";
  $level ="";
  $specialty="";
  $errors = array();
  $errors_login = array();


  //connect to the database
  $db = mysqli_connect('localhost','root','','helpfit');

  // REGISTER USER
if (isset($_POST['signup'])) {
	// receive all input values from the form
	$username = mysqli_real_escape_string($db, $_POST['username']);
  $name = trim(mysqli_real_escape_string($db, $_POST['name']));
	$email = trim(mysqli_real_escape_string($db, $_POST['email']));
	$password = mysqli_real_escape_string($db, $_POST['password']);
	$confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);
  $user = mysqli_real_escape_string($db, $_POST['user']);
  $level = mysqli_real_escape_string($db, $_POST['level']);
  $specialty = trim(mysqli_real_escape_string($db, $_POST['specialty']));

	// form validation: ensure that the form is correctly filled
  // in case user does not have javascript installed
	if (empty($username)) { array_push($errors, "Username is required."); }
  if (strlen($username) < 4) { array_push($errors, "Username must be at least 4 characters long.");}
  if (empty($name)) { array_push($errors, "Full Name is required."); }
	if (empty($email)) { array_push($errors, "Email is required."); }
	if (empty($password)) { array_push($errors, "Password is required."); }
  if (strlen($password) < 6) { array_push($errors, "Password must be at least 6 characters long.");}
  if (empty($user)) { array_push($errors, "Please choose to be a member or a trainer."); }
	if ($password != $confirm_password) {
		array_push($errors, "The passwords do not match.");
	}

  //checks if username is unique
  $check_unique = mysqli_query($db,"SELECT username FROM user WHERE username='$username'");
  if (mysqli_num_rows($check_unique)){
    array_push($errors, "Username is already taken.");
  }

	// register user if there are no errors in the form
	if (count($errors) == 0) {
    $password = md5($password);//encrypt the password before saving in the database
    $query = "INSERT INTO user (user_type, username, password ,name, email)
				  VALUES('$user','$username', '$password','$name','$email')";
		mysqli_query($db, $query);
    $id = mysqli_insert_id($db);
    if($user == "member")
    {
      $nquery = "INSERT INTO member (user_id, level)
            VALUES('$id', '$level')";
      mysqli_query($db, $nquery);
    }
    else if ($user == "trainer")
    {
      $nquery = "INSERT INTO trainer (user_id, specialty)
            VALUES('$id', '$specialty')";
      mysqli_query($db, $nquery);
    }

		$_SESSION['success_signup'] = "You have successfully signed up!";
		header('location: signup.php');
    exit();
	}

}


// LOGIN USER
if (isset($_POST['login'])) {
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['login-password']);

	if (empty($username)) {
		array_push($errors_login, "Username is required");
	}
	if (empty($password)) {
		array_push($errors_login, "Password is required");
	}

	if (count($errors_login) == 0) {
		$password = md5($password);

    // set cookie to remember the user
    if (isset($_POST["remember_me"])){
      if($_POST["remember_me"]=='1' || $_POST["remember_me"]=='on')
                  {
                  $hour = time() + 3600 * 24 * 30;
                  setcookie('username', $username, $hour);
                  setcookie('login-password', $password, $hour);
                  }
    }
		$query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) {
      // check if user is member or trainer
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'member') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "Welcome to HELPFit! Let's get started!";

        //get the level of member from the member table
        $user_id = $_SESSION['user']['user_id'];
        $curr_mem = mysqli_query($db,"SELECT * FROM member WHERE user_id='$user_id'");
        if (mysqli_num_rows($curr_mem) == 1) {
          $_SESSION['member'] = mysqli_fetch_assoc($curr_mem);
        }

				header('location: member_main.php');
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "Welcome to HELPFit! Let's get started!";

        //get the specialty of trainer from the trainer table
        $user_id = $_SESSION['user']['user_id'];
        $curr_trnr = mysqli_query($db,"SELECT * FROM trainer WHERE user_id='$user_id'");
        if (mysqli_num_rows($curr_trnr) == 1) {
          $_SESSION['trainer'] = mysqli_fetch_assoc($curr_trnr);
        }

				header('location: trainer_main.php');
			}
		}else {
			array_push($errors_login, "Wrong username and password combination.");
		}
	}
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</strong> </h1> </div>';
	}
}

function display_error_login(){
  global $errors_login;
  if (count($errors_login) > 0){
		echo '<div class="error-login">';
			foreach ($errors_login as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}


// UPDATE USER
if (isset($_POST['edit'])) {
	$name = trim(mysqli_real_escape_string($db, $_POST['name']));
	$email = trim(mysqli_real_escape_string($db, $_POST['email']));
  $level = mysqli_real_escape_string($db, $_POST['level']);
  $specialty = trim(mysqli_real_escape_string($db, $_POST['specialty']));

  $user_id = $_SESSION['user']['user_id'];

  $query = "UPDATE user SET name = '$name', email = '$email' WHERE user_id = '$user_id'";
  mysqli_query($db, $query);

  if ($_SESSION['user']['user_type'] == "member"){
      $nquery = "UPDATE member SET level = '$level' WHERE user_id = '$user_id'";
      mysqli_query($db, $nquery);

      //reset sessions
      unset($_SESSION['user']);
      unset($_SESSION['member']);

      $curr_user = mysqli_query($db,"SELECT * FROM user WHERE user_id='$user_id'");
      if (mysqli_num_rows($curr_user) == 1) {
        $_SESSION['user'] = mysqli_fetch_assoc($curr_user);
      }

      $curr_mem = mysqli_query($db,"SELECT * FROM member WHERE user_id='$user_id'");
      if (mysqli_num_rows($curr_mem) == 1) {
        $_SESSION['member'] = mysqli_fetch_assoc($curr_mem);
      }

    }
  else if ($_SESSION['user']['user_type'] == "trainer")
    {
      $nquery = "UPDATE trainer SET specialty = '$specialty' WHERE user_id = '$user_id'";
      mysqli_query($db, $nquery);

      // reset sessions
      unset($_SESSION['user']);
      unset($_SESSION['trainer']);

      $curr_user = mysqli_query($db,"SELECT * FROM user WHERE user_id='$user_id'");
      if (mysqli_num_rows($curr_user) == 1) {
        $_SESSION['user'] = mysqli_fetch_assoc($curr_user);
      }

      $curr_trnr = mysqli_query($db,"SELECT * FROM trainer WHERE user_id='$user_id'");
      if (mysqli_num_rows($curr_trnr) == 1) {
        $_SESSION['trainer'] = mysqli_fetch_assoc($curr_trnr);
      }
    }

		$_SESSION['success_edit'] = "Changes saved successfully!";
		header('location: profile.php');
    exit();
  }

  //UPDATE PASSWORD
if (isset($_POST['change_password'])) {
  $curr_password = mysqli_real_escape_string($db, $_POST['curr_password']);
  $new_password = mysqli_real_escape_string($db, $_POST['new_password']);
  $confirm_new_password = mysqli_real_escape_string($db, $_POST['confirm_new_password']);

  $curr_password = md5($curr_password);
  if ($curr_password != $_SESSION['user']['password']){
    array_push($errors, "Your current password was entered incorrectly.");
  }
  if ($new_password != $confirm_new_password) {
		array_push($errors, "The passwords do not match.");
	}
  if (strlen($new_password) < 6) { array_push($errors, "Password must be at least 6 characters long.");}

  $user_id = $_SESSION['user']['user_id'];
  if (count($errors) == 0) {
    $new_password = md5($new_password);
    $nquery = "UPDATE user SET password = '$new_password' WHERE user_id = '$user_id'";
    mysqli_query($db, $nquery);

    // reset session
    unset($_SESSION['user']);

    $curr_user = mysqli_query($db,"SELECT * FROM user WHERE user_id='$user_id'");
    if (mysqli_num_rows($curr_user) == 1) {
      $_SESSION['user'] = mysqli_fetch_assoc($curr_user);
    }
    $_SESSION['success_edit'] = "Changes saved successfully!";
		header('location: profile.php');
    exit();
  }
}

 ?>
