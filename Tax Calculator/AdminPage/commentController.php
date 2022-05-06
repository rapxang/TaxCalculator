<?php

session_start();
require "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$comment = $_POST['comment'];
	$post_id = $_POST['id'];
    $query = "INSERT INTO `comments` (`comment`, `info_id`) VALUES ('$comment', '$post_id')";
	if (mysqli_query($con, $query)) {
        echo "success";
      } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
      }
}

if(isset($_GET['id'])) {
	$id = $_GET['id']; 
} else {  
	$id = $_POST['id']; 
}

$result = mysqli_query($con, "SELECT * FROM info WHERE id=$id");
$blog = mysqli_fetch_array($result);

$comments = mysqli_query($con, "SELECT * FROM comments WHERE info_id=$id");