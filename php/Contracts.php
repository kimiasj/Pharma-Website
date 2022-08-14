<?php
	session_start();
	include 'conn.php';

	if(empty($_SESSION['username']) || empty($_SESSION['password']))
		print("Access to database denied");
	else {
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
		$type = $_SESSION['type'];

		if($type != "pharmacist") {
			include '../includes/phheader.html';
			print("<p>Insufficient privileges</p>");      
		}
		else {
			include '../includes/phheader.html';

			if(isset($_POST["contracts"])) {
			
			        $sql = $mysqli -> prepare("SELECT * FROM pharmacist WHERE phsin=?");
			        $sql -> bind_param('s',$username);
			        $result = $sql -> execute();
			        $result = $sql -> get_result();
			        $row = $result -> fetch_object();
			        $suppervisor = $row -> phname;
			        $pharmacy = $row -> pharmacy;
			        
				$contractNo = $_POST['contractNo'];
                               $tradename = $_POST['tradename'];
                               $formula = $_POST['formula'];
                               $startdate = $_POST['startdate'];
                               $enddate = $_POST['enddate'];
                               $pharmaco = $_POST['pharmaco'];
                               



                               $sql = $mysqli -> prepare("INSERT INTO contracts VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
                               $sql -> bind_param('ssssssss',$contractNo,$tradename,$formula,$startdate,$enddate,$suppervisor,$pharmaco,$pharmacy);
                               $sql -> execute();
				if($sql -> errno)
					print("<p>Insert query failed</p>");
				else {
				$sql = $mysqli -> prepare("SELECT * FROM contracts");
               $sql -> execute();
               $result = $sql -> get_result();

               if(!$result)
               print("<p>Select query failed</p>");
               else {
                     if($result -> num_rows == 0)
                     print("<p>No match found</p>");
                       else {
                             print("<h1>Contracts</h1><table>");
                             print("<tr><th>Contract Number</th><th>Trade Name</th><th>Formula</th><th>Start Date</th><th>End Date</th><th>Contract Supervisor</th><th>Pharmacy</th></tr>");
                            while($row = $result -> fetch_object()) {
                                    echo '<tr>';
                                    echo '<td>'.$row -> contractNo.'</td>';
                                    echo '<td>'.$row -> tradename.'</td>';
                                    echo '<td>'.$row -> formula.'</td>';
                                    echo '<td>'.$row -> startdate.'</td>';
                                    echo '<td>'.$row -> enddate.'</td>';
                                    echo '<td>'.$row -> suppervisor.'</td>';
                                    
                                    echo '<td>'.$row -> pharmacy.'</td>';
                                    echo '</tr>';
                                    }
                                       print("</table>");
                                     

                                   }
                              }
                              
                              
			}
			
		}
		else {
				include '../includes/Contracts.html';
				include '../includes/footer.html';
		}
	}
}
	$mysqli -> close();
?>
