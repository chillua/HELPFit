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
  $db = mysqli_connect('localhost','root','','helpfit')

  // REGISTER USER
if (isset($_POST['signup'])) {
	// receive all input values from the form
	$username = mysqli_real_escape_string($db, $_POST['username']);
  $name = mysqli_real_escape_string($db, $_POST['name']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password = mysqli_real_escape_string($db, $_POST['password']);
	$confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);
  $user = mysqli_real_escape_string($db, $_POST['user']);
  $level = mysqli_real_escape_string($db, $_POST['level']);
  $specialty = mysqli_real_escape_string($db, $_POST['specialty']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { array_push($errors, "Username is required."); }
  if (empty($name)) { array_push($errors, "Full Name is required."); }
	if (empty($email)) { array_push($errors, "Email is required."); }
	if (empty($password)) { array_push($errors, "Password is required."); }
  if (empty($user)) { array_push($errors, "Please choose to be a member or a trainer."); }

	if ($password != $confirm_password) {
		array_push($errors, "The passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
    $password = md5($password_1);//encrypt the password before saving in the database
    $query = "INSERT INTO user (username, password ,name, email)
				  VALUES('$username', '$password','$name','$email')";
		mysqli_query($db, $query);
    if($user == "member")
    {
      $query = "INSERT INTO member (user_id, level)
            VALUES('$user_id', '$level')";
      mysqli_query($db, $query);
    }
    else if ($user == "trainer")
    {
      $query = "INSERT INTO trainer (user_id, specialty)
            VALUES('$user_id', '$specialty')";
      mysqli_query($db, $query);
    }

		$_SESSION['username'] = $username;
		$_SESSION['success'] = "You are now logged in";
		header('location: signup.php');
	}

}
 ?>
