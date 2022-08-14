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

		if(isset($_POST["stock"])) {
			$tradename = $_POST['tradename'];
			$formula = $_POST['formula'];
			
			
			$sql = $mysqli -> prepare("SELECT * FROM stock WHERE tradename=? and formula=?");

			
			$sql -> bind_param('ss', $tradename, $formula);
			$sql -> execute();
			$result = $sql -> get_result();

			if(!$result)
				print("<p>Select query failed</p>");
			else {
				if($result -> num_rows == 0)
					print("<p>No match found </p>");
        		else {
					print("<h1>Available Stocks</h1><table>");
	      			print("<tr><th>Contract Number</th><th>Trade Name</th><th>Formula</th><th>Company</th><th>Price</th><th>Quantity</th></tr>");
					while($row = $result -> fetch_object()) {
						echo '<tr>';
						echo '<td>'.$row -> contractNo.'</td>';
                                               echo '<td>'.$row -> tradename.'</td>';
                                               echo '<td>'.$row -> formula.'</td>';
                                               echo '<td>'.$row -> pharmaco.'</td>';
                                               echo '<td>'.$row -> price.'</td>';
                                               echo '<td>'.$row -> quantity.'</td>';
						
						echo '</tr>';
					}
					print("</table>");
				}
			}
		}
		else {
			include '../includes/Stock.html';
			include '../includes/footer.html';
		}
	}
}
	$mysqli -> close();
