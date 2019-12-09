<?php 

$mysqli = new mysqli("localhost", "root", "", "management");

$sql = "SELECT * FROM wo 
		WHERE psc_no LIKE '%".$_GET['q']."%'
		and position <= 10 LIMIT 10"; 
$result = $mysqli->query($sql);


$json = [];
while($row = $result->fetch_assoc()){
     $json[] = ['id'=>$row['id'], 'text'=>$row['psc_no']];
}


echo json_encode($json);
?>