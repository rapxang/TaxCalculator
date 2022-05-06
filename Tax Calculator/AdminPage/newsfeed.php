<?php  require_once "commentController.php";
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
    <form action = "newsfeed.php" method="post" class="">
    <textarea placeholder="write a comment.." name="comment" class="comment-box" cols="45" rows="8" aria-required="true" required></textarea>
    <input type="text" name="id" value="<?php echo $id?>" hidden>
    <button class="comment-btn" type="submit">Post comment</button> 
    </form>
    <?php while ($comment = mysqli_fetch_array($comments)) { ?>
    <div class="comment">
    
    <p>
    <?php echo $comment['comment']; ?>
    </p>
    </div>
    <?php } ?>
    </div>
    </div>
</body>

</html>