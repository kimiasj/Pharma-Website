<?php
	session_start();
	include 'conn.php';

	if(empty($_SESSION['username']) || empty($_SESSION['password']))
		print("Access to database denied");
	else {
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
		$type = $_SESSION['type'];

		if($type != "Doctor") {
			include '../includes/pheader.html';
			      
		}
		else {
			include '../includes/dheader.html';

			if(isset($_POST["Prescription"])) {
			$sql = $mysqli -> prepare("SELECT * FROM Doctor WHERE Dsin=?");
			        $sql -> bind_param('s',$username);
			        $result = $sql -> execute();
			        $result = $sql -> get_result();
			        $row = $result -> fetch_object();
			        $Doctor = $row -> Dname;
			
				$PSIN = $_POST['PSIN'];
				$drugname = $_POST['drugname'];
				$Date = $_POST['Date'];
				$quantity = $_POST['quantity'];
				
				
				$sql = $mysqli -> prepare("INSERT INTO prescription( PSIN, dname, drugname, date, quantity) VALUES ( ?, ?, ?, ?, ?)");
				$sql -> bind_param('sssss', $PSIN, $Doctor, $drugname, $Date, $quantity);
				$sql -> execute();

				if($sql -> errno)
					print("<p>Insert query failed</p>");
				else {
				
				print("<p>You Prescribed $quantity of $drugname for Patient with Sin number $PSIN on $Date</p>");
			}
			
		}
		else {
				include '../includes/PrescribeForm.html';
				include '../includes/footer.html';
		}
	}
}
	$mysqli -> close();
?>
