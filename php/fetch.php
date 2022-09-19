<?php
session_start(); 
require 'db.php';

	/* Fetch Data From the Database  */
	if(isset($_POST["video_id"]))
	{
		$output = array();
		$video_id = $_POST['video_id'];
		$query = $conn->prepare("SELECT * FROM classvideo WHERE id = :id LIMIT 1");
		$query->execute([':id'	=>	$video_id]);
		$result = $query->fetchAll();
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
	} else if (isset($_POST["fetch_subject"])){
		$class_code= $_SESSION["classcode"];
		$output = array();
		$query = $conn->prepare("SELECT * FROM classsubject WHERE subjectcode =:subjectcode");
		$query->execute([':subjectcode' => $class_code]);
		$result = $query->fetchAll();
		$data = array();
		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = $row["id"];
			$sub_array[] = $row["subjects"];
			$sub_array[] = $row["subjectcode"];
			$sub_array[] = '<button type="button" name="subject-update" id="'.$row["id"].'" class="btn btn-primaryy btn-sm subject-update"></button>';
			$sub_array[] = '<button type="button" name="subject-delete" id="'.$row["id"].'" class="btn btn-dangerr btn-sm subject-delete"><i class="fas fa-trash" aria-hidden="true"></i></button>';
			$data[] = $sub_array;
		}
		$output = array(
			"data" =>  $data
		);
		echo json_encode($output);
	} else{
		$class_code= $_SESSION["classcode"];
		$query = '';
		$output = array();
		$query .= "SELECT * FROM classvideo WHERE linkcode ='$class_code' ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND titles LIKE "%'.$_POST["search"]["value"].'%" ';
		}
		$query = $conn->prepare($query);
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
			$sub_array[] = '<button type="button"  name="video-update" id="'.$row["id"].'" class="btn btn-primaryy btn-sm video-update"><i class="fas fa-edit" aria-hidden="true"></i></button>';
			$sub_array[] = '<button type="button"  name="video-delete" id="'.$row["id"].'" class="btn btn-dangerr btn-sm video-delete"><i class="fas fa-trash" aria-hidden="true"></i></button>';
			$data[] = $sub_array;
		}
		$output = array(
			"data" => $data
		);
		echo json_encode($output);
		exit;
	}
?>