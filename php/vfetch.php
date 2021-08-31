<?php
session_start(); 
require '../db.php';

	if(isset($_POST["video_id"]))
	{
		$output = array();
		$video_id = $_POST['video_id'];
		$statement = $conn->prepare("SELECT * FROM classvideo WHERE id = :id LIMIT 1");
		$statement->execute([':id'	=>	$video_id]);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output["id"] = $row["id"];
			$output["titles"] = $row["titles"];
			$output["subjects"] = $row["subjects"];
			$output["dates"] = $row["dates"];
			$output["links"] = $row["links"];
			$output["linkcode"] = $row["linkcode"];
		}
		echo json_encode($output);
	} else {
		$varivari= $_SESSION["classcode"];
		$statement = '';
		$output = array();
		$statement .= "SELECT * FROM classvideo WHERE linkcode ='$varivari' ";
		if(isset($_POST["search"]["value"]))
		{
			$statement .= 'AND titles LIKE "%'.$_POST["search"]["value"].'%" ';
		}
		$query = $conn->prepare($statement);
		$query->execute();
		$result = $query->fetchAll();
		$data = array();
		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = $row["id"];
			$sub_array[] = $row["titles"];
			$sub_array[] = $row["subjects"];
			$sub_array[] = $row["dates"];
			$sub_array[] = $row["links"];
			$sub_array[] = $row["linkcode"];
			$sub_array[] = '<button type="button"  name="update" id="'.$row["id"].'" class="btn btn-primaryy btn-sm update"><i class="fas fa-edit" aria-hidden="true"></i></button>';
			$sub_array[] = '<button type="button"  name="delete" id="'.$row["id"].'" class="btn btn-dangerr btn-sm delete"><i class="fas fa-trash" aria-hidden="true"></i></button>';
			$data[] = $sub_array;
		}
		$output = array(
			"data" => $data
		);
		echo json_encode($output);
		exit;
	}
?>