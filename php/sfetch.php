<?php
require '../db.php';
session_start(); 

$varivari= $_SESSION["classcode"];
$output = array();

$statement = $conn->prepare("SELECT * FROM classsubject WHERE subjectcode ='$varivari'");
$statement->execute();
$result = $statement->fetchAll();
$data = array();
foreach($result as $row)
{
	$sub_array = array();
	$sub_array[] = $row["id"];
	$sub_array[] = $row["subjects"];
	$sub_array[] = $row["subjectcode"];
	$sub_array[] = '<button type="button" name="updatee" id="'.$row["id"].'" class="btn btn-primaryy btn-sm update"></button>';
	$sub_array[] = '<button type="button" name="deletee" id="'.$row["id"].'" class="btn btn-dangerr btn-sm deletee"><i class="fas fa-trash" aria-hidden="true"></i></button>';
	$data[] = $sub_array;
}
$output = array(
	"data" =>  $data
);
echo json_encode($output);
?>