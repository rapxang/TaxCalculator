<?php require_once "newsController.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Artiicle</title>
</head>

<body>
    <header class="main-header">
        <div class="container row">
            <div class="page-title">
                <h1>Admin Page</h1>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="taxcalculator.php">Tax Calculator</a></li>
                    <li><a href="homepage.php">User Feed</a></li>
                </ul>
            </nav>

            <div class="search-bar">
                <input type="text" name="email" id="" required>
                <button type="submit">Add Admin</button>
            </div>

            <div class="search-bar">
                <nav class="main-nav">
                    <ul>
                        <li><button type="button"><a href="../login-user.php">Logout</a></button></li>
                    </ul>
                </nav>
            </div>
        </div>  
    </header>

    <form class="article-container" action="newsController.php" method="post" enctype="multipart/form-data">
        <label for="fname">Title</label><br>
        <input type="text" id="title" name="title" value="<?php echo $blog['title']; ?>" required><br>
        <input type="text" id="id" name="id" value="<?php echo $blog['id']; ?>" hidden><br>
        <label for="lname">Description:</label><br>
        <textarea class="description-box" rows="4" cols="50" name="description" required>
       
        <?php echo $blog['description']; ?></textarea>
        <img src="<?php echo "../../public/storage/images/blog/".$blog['image']; ?>" alt="<?php echo $blog['title']; ?>" srcset="" width="500" height="300" requried>
        Select image to replace above image:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="text" id="hiddenImageFile" name="hiddenImageFile" value="<?php echo $blog['image']; ?>" hidden><br>
        <div class="input-group">
            <?php if ($update == true): ?>
                <button type="submit" class="save-btn" name="update">Update</button>
            <?php else : ?>
                <button type="submit" class="save-btn" name="save">Save</button>
            <?php endif ?>
        </div>
    </form>

    <footer class="footer group">
        <div class="copyright">Copyright &copy; 2019. All rights reserved</div>
        <div class="footer-links">
            <ul>
                <li><a href="taxcalculator.php">Tax Calculator</a></li>
                <li><a href="userfeed.php">User Feed</a></li>
            </ul>
        </div>
    </footer>
</body>

</html>