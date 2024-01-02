<?php

include 'vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$dataType=$_GET["dataType"];


//$sql = "SELECT  * FROM rec_data where type = $dataType order by dt desc limit 10";

//$sql="select T1.room_id, T1.value, T1.dt, T1.type from rec_data T1, (select max(dt) as maxdate, room_id from rec_data where type='tempset-humidity' group by room_id) T2  where T1.room_id= T2.room_id and T1.dt = T2.maxdate and T1.type='tempset-humidity'";

$sql="select T1.room_id, T1.value, T1.dt, T1.type from rec_data T1, (select max(dt) as maxdate, room_id from rec_data where type= $dataType and dt >= NOW() - INTERVAL 30 MINUTE group by room_id) T2  where T1.room_id= T2.room_id and T1.dt = T2.maxdate and T1.type=$dataType";


$result = $conn->query($sql);

$data = array();

foreach ($result as $row) {
	$data[] = $row;
}
 

$conn->close();
  
echo json_encode($data);
     
?>
