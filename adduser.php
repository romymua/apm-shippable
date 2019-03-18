<?php

//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("db.php");

//If user Actually clicked register button
if(isset($_POST)) {

	//Escape Special Characters In String First
	$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
	$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	//Encrypt Password
	$password = base64_encode(strrev(md5($password)));

	//sql query to check if email already exists or not
	$sql = "SELECT email FROM user WHERE email='$email'";
	$result = $conn->query($sql);

	//if email not found then we can insert new data
	if($result->num_rows == 0) {
		//sql new registration insert query
		$sql = "INSERT INTO user (firstname, lastname, email, password) VALUES ('$firstname', '$lastname', '$email', '$password')";

		if($conn->query($sql)===TRUE) {			
			$_SESSION['registerCompleted'] = true;
			header("Location: login.php");
			exit();
		} else {
			//If data failed to insert then show that error. Note: This condition should not come unless we as a developer make mistake or someone tries to hack their way in and mess up :D
			echo "Error " . $sql . "<br>" . $conn->error;
		}
	} else {
		//if email found in database then show email already exists error.
		$_SESSION['registerError'] = true;
		header("Location: signup.php");
		exit();
	}
	//Close database connection. Not compulsory but good practice.
	$conn->close();
} else {
	//redirect them back to register page if they didn't click register button
	header("Location: signup.php");
	exit();
}