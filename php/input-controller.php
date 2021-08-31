<?php
require '../db.php';

	if(isset($_POST["video_operation"])) {
		if($_POST["video_operation"] == "Add") {
			$titles=$_POST['titles'];
			$subjects=$_POST['subjects'];
			$dates=$_POST['dates'];
			$links=$_POST['links'];
			$linkcode=$_POST['linkcode'];
			$statement = $conn->prepare("INSERT INTO classvideo (titles, subjects, dates, links, linkcode) VALUES (:titles, :subjects, :dates, :links, :linkcode)");
			$result = $statement->execute(
				array(
					':titles'	=>	$titles,
					':subjects'	=>	$subjects,
					':dates'	=>	$dates,
					':links'	=>	$links,
					':linkcode'	=>	$linkcode
				)
			);
		}
		if($_POST["video_operation"] == "Edit") {
			$titles=$_POST['titles'];
			$subjects=$_POST['subjects'];
			$dates=$_POST['dates'];
			$links=$_POST['links'];
			$linkcode=$_POST['linkcode'];
			$video_id = $_POST['video_id'];
			$statement = $conn->prepare("UPDATE classvideo SET titles = :titles, subjects = :subjects, dates = :dates, links = :links, linkcode = :linkcode WHERE id = :id");
			$result = $statement->execute(
				array(
					':titles'	=>	$titles,
					':subjects'	=>	$subjects,
					':dates'	=>	$dates,
					':links'	=>	$links,
					':linkcode'	=>	$linkcode,
					':id'		=>	$video_id
				)
			);
		}
	} else {
		if(isset($_POST["video_id"])) {
			$video_id = $_POST['video_id'];
			$statement = $conn->prepare("DELETE FROM classvideo WHERE id = :id"
			);
			$result = $statement->execute(
				array(':id'	=>	$video_id)
			);
		}
	}
	if(isset($_POST["subject_operation"])) {
		if($_POST["subject_operation"] == "Add") {
			$subjects=$_POST['subjects'];
			$subjectcode=$_POST['subjectcode'];
			$statement = $conn->prepare("INSERT INTO classsubject (subjects, subjectcode) VALUES (:subjects, :subjectcode)");
			$result = $statement->execute(
				array(
					':subjects'	=>	$subjects,
					':subjectcode'	=>	$subjectcode
				)
			);
		}
	} else {
		if(isset($_POST["subject_id"])) {
			$subject_id = $_POST['subject_id'];
			$statement = $conn->prepare("DELETE FROM classsubject WHERE id = :id");
			$result = $statement->execute(
				array(':id'	=>	$subject_id)
			);
		}
	}
?>