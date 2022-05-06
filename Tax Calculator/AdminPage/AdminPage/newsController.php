<?php

session_start();
require "../connection.php";
$title = "";
$description = "";
$image = "";
// die($id);
$id = "0";
$update = true;

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

if (isset($_POST['post'])) {
	$title = $_POST['title'];
	$description = $_POST['description'];
	

	if ($_FILES["fileToUpload"]["name"]) {
		$uploads_dir = '../../public/storage/images/blog';
		$target_file = basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if ($check !== false) {
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "$uploads_dir/$target_file")) {
				// echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
		$image = $target_file;
	}

	$query = "INSERT INTO info (title, description, image) values ('$title', '$description', '$image')";
	mysqli_query($con, $query);
	$_SESSION['msg'] = "News saved";
}

// delete records
if (isset($_GET['del'])) {
	$id = $_GET['del'];
	$result = mysqli_query($con, "SELECT image FROM info WHERE id=$id");
	$blog = mysqli_fetch_array($result);
	mysqli_query($con, "DELETE FROM info WHERE id=$id");
	$uploads_dir = '../../public/storage/images/blog';
	unlink($uploads_dir . '/' . $blog['image']);
	$_SESSION['msg'] = "News deleted";
	header('location: AdminPage.php');
}

if (isset($_GET['edit'])) {
	$id = $_GET['edit'];
	$result = mysqli_query($con, "SELECT * FROM info WHERE id=$id");
	$blog = mysqli_fetch_array($result);
}
// update record

if (isset($_POST['update'])) {
	$id = $_POST['id'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$image = $_POST['hiddenImageFile'];

	// echo $description; die;

	if ($_FILES["fileToUpload"]["name"]) {
		$uploads_dir = '../../public/storage/images/blog';
		$target_file = basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if ($check !== false) {
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "$uploads_dir/$target_file")) {
				// echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";

			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
		$image = $target_file;
	}
	// echo $description; die;
	// $sql = "UPDATE info SET title='$title', description='$description', image='$image' WHERE id=$id";
	// echo $sql;die;
	mysqli_query($con, "UPDATE info SET title='$title', description='$description', image='$image' WHERE id=$id");
	$_SESSION['msg'] = "news updated!";
	$result = mysqli_query($con, "SELECT * FROM info WHERE id=$id");
	$blog = mysqli_fetch_array($result);
	header('location: AdminPage.php');
}

