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

			if(isset($_POST["orderStock"])) {
			
			
				$contractNo = $_POST['contractNo'];
                               $tradename = $_POST['tradename'];
                               $formula = $_POST['formula'];
                               $pharmaco = $_POST['pharmaco'];
                               $price = $_POST['price'];
                               $quantity = $_POST['quantity'];



                               $sql = $mysqli -> prepare("INSERT INTO orderStock VALUES(?, ?, ?, ?, ?, ?)");
                               $sql -> bind_param('ssssss',$contractNo,$tradename,$formula,$pharmaco,$price,$quantity);
                               $sql -> execute();
				if($sql -> errno)
					print("<p>Insert query failed</p>");
				else {
				
				print("<p>$quantity of $tradename from $pharmaco has been purchased for $price </p>");
				$sql = $mysqli -> prepare("INSERT INTO stock VALUES(?, ?, ?, ?, ?, ?)");
				$sql -> bind_param('ssssss',$contractNo,$tradename,$formula,$pharmaco,$price,$quantity);
                               $sql -> execute();
			}
			
		}
		else {
				include '../includes/OrderStock.html';
				include '../includes/footer.html';
		}
	}
}
	$mysqli -> close();
?>
