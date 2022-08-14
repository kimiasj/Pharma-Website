<?php
	session_start();
	include 'conn.php';

/*
	if($mysqli->connect_errno)
		echo 'not connected to database: '.$mysqli->connect_error;
	else
		echo 'connected';
*/

	if(empty($_POST['username']) || empty($_POST['password']))
		header('Location: ../index.html');
	else {
    		if(isset($_POST['login'])) {

			$username = $_POST['username'];
			$password = $_POST['password'];
		        $choice = $_POST['choice'];
			$password = md5($password);

			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			
			if($choice == 'Patient'){

			$sql = $mysqli -> prepare("SELECT * FROM Patient
			 WHERE PSIN=? AND Password=?");
			$sql -> bind_param('ss', $username, $password);
			$sql -> execute();
			$result = $sql -> get_result();

			if($result -> num_rows == 1) {
			
				$_SESSION['type'] = "Patient";
				include '../includes/pheader.html';
				print("<p>Welcome</p>");
				
				include '../includes/footer.html';
			}}
			if($choice == 'Doctor'){
				$sql = $mysqli -> prepare("SELECT * FROM Doctor
			 WHERE Dsin=? AND password=?");
				$sql -> bind_param('ss', $username, $password);
				$sql -> execute();
				$result = $sql -> get_result();

				if($result -> num_rows == 1) {
					$_SESSION['type'] = "Doctor";
					include '../includes/dheader.html';
					print("<p>Welcome </p>");
					include '../includes/footer.html';
			}}
			if($choice == 'pharmacist') {
				$sql = $mysqli -> prepare("SELECT * FROM pharmacist
			 WHERE phsin=? AND password=?");
				$sql -> bind_param('ss', $username, $password);
				$sql -> execute();
				$result = $sql -> get_result();

				if($result -> num_rows == 1) {
					$_SESSION['type'] = "pharmacist";
					include '../includes/phheader.html';
					print("<p>Welcome </p>");
					include '../includes/footer.html';
				}
				else {
					header('Location: ../index.html');
				}
				
			}
			

		}
    		
	}

	
	$mysqli -> close();
?>

