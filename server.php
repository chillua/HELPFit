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
  $_SESSION['success'] = "";


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
  if (empty($name)) { array_push($errors, "Full Name is required."); }
	if (empty($email)) { array_push($errors, "Email is required."); }
	if (empty($password)) { array_push($errors, "Password is required."); }
  if (empty($user)) { array_push($errors, "Please choose to be a member or a trainer."); }

	if ($password != $confirm_password) {
		array_push($errors, "The passwords do not match");
	}

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

		//$_SESSION['username'] = $username;
		//$_SESSION['success'] = "You have successfully signed up!";
		header('location: signup.php');
	}

}


// LOGIN USER
if (isset($_POST['login'])) {
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['login-password']);

	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	if (count($errors) == 0) {
		$password = md5($password);
		$query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) {
      // check if user is member or trainer
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'member') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: member_main.php');
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: trainer_main.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

 ?>
