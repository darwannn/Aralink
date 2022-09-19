<?php
require dirname(__FILE__, 2).'/php/controller.php';
session_start();
session_unset();
session_destroy();


header("location: ../");
?>