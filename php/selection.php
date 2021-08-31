<?php
 session_start();
if (isset($_POST['subject'])) {
	$subject=$_POST['subject'];
	$selected = $subject;
	$_SESSION['selected'] = $selected;	
	}
?>