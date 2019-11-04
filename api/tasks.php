<?php
$dbconnecterror = FALSE;
$dbh = NULL;

require_once 'credentials.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
	try{
	
	$conn_string = "mysql:host=".$dbserver.";dbname=".$db;
	
	$dbh= new PDO($conn_string, $dbusername, $dbpassword);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
	http_response_code(500);
	exit();
}

if (!$dbconnecterror) {
	
	try {
		$sql = "SELECT listID, listItem AS taskName, finishDate AS taskDate, complete AS completed FROM doList";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// listID -> listID
		// listItem -> taskName
		// finishDate -> taskDate
		// complete -> completed

		http_response_code(200);
		echo json_encode($result);
		exit();

	} catch (PDOException $e) {
		http_response_code(500);
		exit();
	}

}
} else {
	http_response_code(500);
	echo 'invalid request method';
	exit();
}
