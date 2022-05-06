<?php

session_start();
require "../connection.php";

error_reporting(E_ALL);
ini_set('display_errors', '1');

if($_SERVER["REQUEST_METHOD"] == "GET") {
  $results = mysqli_query($con,
				"SELECT info.id, info.title, info.description, info.image, COUNT(likes.info_id) as total_likes
				FROM info
				LEFT JOIN likes
				ON info.id=likes.info_id
				GROUP BY info.id");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $info_id = $_POST['info_id'];
    $query = "INSERT INTO `likes` (`info_id`) VALUES ('$info_id')";

    if (mysqli_query($con, $query)) {
        $result = mysqli_query($con, "SELECT COUNT(*) FROM `likes` where info_id='$info_id'");

	    $count = mysqli_fetch_array($result);
        echo $count['0'];

      } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
      }
}

mysqli_close($con);
