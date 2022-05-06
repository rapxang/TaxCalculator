<?php

session_start();
require "../connection.php";

if (isset($_POST['post'])) {
	$comment = $_POST['comment'];
    $query = "INSERT INTO comments (comment) values ('$comment')";
	mysqli_query($con, $query);
}