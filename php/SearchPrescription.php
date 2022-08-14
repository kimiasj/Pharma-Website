<?php
	session_start();
	include 'conn.php';

	if(empty($_SESSION['username']) || empty($_SESSION['password']))
		print("Access to database denied");
	else {
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
		$type = $_SESSION['type'];

		if($type == "Patient") {
			include '../includes/pheader.html';
		}
		if($type == "Doctor") {
			include '../includes/dheader.html';
		}

		if(isset($_POST["Prescription"])) {
		
		$sql = $mysqli -> prepare("SELECT * FROM Patient WHERE PSIN=?");
			        $sql -> bind_param('s',$username);
			        $result = $sql -> execute();
			        $result = $sql -> get_result();
			        $row = $result -> fetch_object();
			        $PSIN = $row -> PSIN;
                                
			       
			$Doctor = $_POST['Doctor'];
			
			$sql = $mysqli -> prepare("SELECT * FROM prescription WHERE PSIN =? and dname=?");

			
			$sql -> bind_param('ss', $PSIN, $Doctor);
			$sql -> execute();
			$result = $sql -> get_result();

			if(!$result)
				print("<p>Select query failed</p>");
			else {
				if($result -> num_rows == 0)
					print("<p>No match found</p>");
        		else {
					print("<h1>Results</h1><table>");
	      			print("<tr><th>Doctor</th><th>Drug</th><th>Quantity</th></tr>");
					while($row = $result -> fetch_object()) {
						echo '<tr>';
						echo '<td>'.$row -> dname.'</td>';
						echo '<td>'.$row -> drugname.'</td>';
						echo '<td>'.$row -> quantity.'</td>';
						echo '</tr>';
					}
					print("</table>");
				}
			}
		}
		else {
			include '../includes/SearchPrescriptionForm.html';
			include '../includes/footer.html';
		}
	}
	$mysqli -> close();
?>
