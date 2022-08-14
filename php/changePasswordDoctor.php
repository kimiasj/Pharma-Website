<?php
	session_start();
	include 'conn.php';

	if(empty($_SESSION['username']) || empty($_SESSION['password']))
		print("Access to database denied");
	else {
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
		$type = $_SESSION['type'];


		if($type == "Doctor") {
			$table = "Doctor";
			include '../includes/dheader.html';
		}

		if(isset($_POST["changePasswordButton"])) {
			$oldpassword = md5($_POST['oldpassword']);
			$newpassword = $_POST['newpassword'];

			if($oldpassword != $password)
				print("<p>Old password does not match</p>");
			else {
				$sql = $mysqli -> prepare("UPDATE $table SET password=? WHERE Dsin=?");
				$sql -> bind_param('ss', md5($newpassword), $username);
				$sql -> execute();

				if($sql -> errno)
					print("<p>Query failed</p>");
				else {
					print("<p>Password successfully changed</p>");
					$_SESSION['password'] = $newpassword;
				}
			}
		}
		else {
			include '../includes/changePasswordForm.html';
			include '../includes/footer.html';
		}
	}
	$mysqli -> close();
?>
