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

		if(isset($_POST["Appointment"])) {
			
			$date = $_POST['date'];
			
			
			$sql = $mysqli -> prepare("Select * From Appointment join Doctor on Appointment.dname=Doctor.Dname and date=?");

			
			$sql -> bind_param('s',$date);
			$sql -> execute();
			$result = $sql -> get_result();

			if(!$result)
				print("<p>Select query failed</p>");
			else {
				if($result -> num_rows == 0)
					print("<p>No match found </p>");
        		else {
					print("<h1>Results</h1><table>");
	      			print("<tr><th>Patient</th><th>Date</th><th>Time</th></tr>");
					while($row = $result -> fetch_object()) {
						echo '<tr>';
						echo '<td>'.$row -> pname.'</td>';
						echo '<td>'.$row -> date.'</td>';
						echo '<td>'.$row -> time.'</td>';
						
						echo '</tr>';
					}
					print("</table>");
				}
			}
		}
		else {
			include '../includes/AppointmentSchedule.html';
			include '../includes/footer.html';
		}
	}
	$mysqli -> close();
?>
