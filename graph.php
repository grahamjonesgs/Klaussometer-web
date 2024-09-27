<?php

include 'vars.php'; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$dataType=$_GET["dataType"];
$days=$_GET["days"];

$sql = "SELECT * FROM (SELECT  * FROM rec_data where type = $dataType and dt >= NOW() - INTERVAL $days DAY order by rand() limit 5000) alias order by room_id, dt";
//select * from (select * from rec_data order by RAND() limit 10) alias order by dt;

$result = $conn->query($sql);

$data = array();

foreach ($result as $row) {
	$data[] = $row;
}


$conn->close();

echo json_encode($data);

?>
