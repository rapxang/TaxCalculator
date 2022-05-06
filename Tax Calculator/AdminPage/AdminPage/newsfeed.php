<?php  require_once "commentController.php";

// die($uk);

$id = $_GET['id']; 
$result = mysqli_query($con, "SELECT * FROM info WHERE id=$id");
$blog = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>News Feed</title>
</head>

<body style="background-color:#181A1B;">
    <header class="main-header">
        <div class="container row">
            <div class="page-title">
                <h1>Blogs</h1>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="taxcalculator.php">Tax Calculator</a></li>
                    <li><a href="homepage.php">User Feed</a></li>
                </ul>
            </nav>

            <div class="search-bar">
                <nav class="main-nav">
                    <ul>
                        <li><button type="button"><a href="login.php">Logout</a></button></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="blog-box">
    
        <div class="blog-title">
            <p><?php echo $blog['title']; ?></p>
        </div>
        <div class="blog-image">
            <img src="<?php echo "../../public/storage/images/blog/" . $blog['image']; ?>" class="myDIV" alt="">
        </div>
        <div class="blog-description">
            <p>
            <?php echo $blog['description']; ?>
            </p>
        </div>
    
    </div>

    <div class="comment-container">
    <div class="inner-content">
    <p style="font-family: sans-serif; font-size:28px; color:white"> Leave a comment </p>
    <form action = "commentController.php" method="post" class="">
    <textarea placeholder="write a comment.." class="comment-box" cols="45" rows="8" aria-required="true"></textarea>
    <button class="comment-btn" type="button" >Post comment</button> 
    </form>
    <div class="comment">
    <p>
    good post.
    </p>
    </div>
    </div>
    </div>
</body>

</html>