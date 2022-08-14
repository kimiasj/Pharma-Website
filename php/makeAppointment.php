<?php
	session_start();
	include 'conn.php';
	
	

	if(empty($_SESSION['username']) || empty($_SESSION['password']))
		print("Access to database denied");
	else {
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
		$type = $_SESSION['type'];

		if($type != "Patient") {
			include '../includes/pheader.html';
			print("<p>Insufficient privileges to add titles to catalogue</p>");      
		}
		else {
			include '../includes/pheader.html';
			
			
			        

			if(isset($_POST["Appointment"])) {
			
			       
			        $sql = $mysqli -> prepare("SELECT * FROM Patient WHERE PSIN=?");
			        $sql -> bind_param('s',$username);
			        $result = $sql -> execute();
			        $result = $sql -> get_result();
			        $row = $result -> fetch_object();
			        $Patient = $row -> PName;
                                
			        $Doctor = $_POST['Doctor'];
				$Date = $_POST['Date'];
				$Time = $_POST['Time'];
				
				
				
				
				$sql = $mysqli -> prepare("INSERT INTO Appointment(pname,dname,date,time) VALUES (?, ?, ?, ?)");
				$sql -> bind_param('ssss',$Patient,$Doctor, $Date, $Time);
				$sql -> execute();

				if($sql -> errno)
					print("<p>Insert query failed</p>");
				else
					print("<p>Your Appointment with Dr. $Doctor is at $Time on $Date</p>");
			}
			else {
				include '../includes/makeAppointmentForm.html';
				include '../includes/footer.html';
			}
			
		}
	
}
	$mysqli -> close();
?>
