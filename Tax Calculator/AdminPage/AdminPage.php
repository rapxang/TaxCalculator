<?php require_once "newsController.php";
$results = mysqli_query($con, "SELECT * FROM info");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
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
                <form method="POST">
                    <input type="email" name="emailaddress" placeholder=" Admin Email" Required>
                    <button type="submit" name="addadmin">Add Admin</button>
                </form>
            </div>
            <?php
            if (isset($_POST['addadmin'])) {
                $email = $_POST['emailaddress'];
                $insert = mysqli_query($con, "INSERT INTO admins(email) VALUES ('$email')");
                if (!$insert) {
                    $errors['addadmin'] = "Failed to add new admin!";
                } else {
                    $info = "A new admin was successfull addes.<br> Now you can sign up with that email address!";
                }
            }
            ?>

            <div class="search-bar">
                <nav class="main-nav">
                    <ul>
                        <li><button type="button"><a href="../login-user.php">Logout</a></button></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="container">
        <?php if(isset($_SESSION['msg'])) { ?>
            <div class="alert success">
             
                <strong>Success! </strong> <?php echo $_SESSION['msg']; ?>
                <span class="closebtn">&times;</span>
            </div>

        <?php unset($_SESSION['msg']); } ?>

        <?php if(!empty($errors)){
            
            foreach($errors as $error) {
                echo $error;
            }
        }?>
        <section class="article-list group">
            <?php while ($row = mysqli_fetch_array($results)) { ?>
                <figure class="article-info">
                    <img src="<?php echo "../../public/storage/images/blog/" . $row['image']; ?>" class="myDIV" alt="">
                    <div class="overlay"><button class="button" onclick="document.location='adminView.php?edit=<?php echo $row['id']; ?>'">Edit</button> 
                    <button class="button" onclick="alert('are you sure you want to delete?');document.location='newsController.php?del=<?php echo $row['id']; ?>'">Delete</button></div>
                    <figcaption>
                        <?php echo $row['title']; ?>
                    </figcaption>
                </figure>
            <?php } ?>

        </section>

        <button class="open-button" onclick="openForm()">Add News</button>

        <div class="chat-popup" id="myForm">
            <form class="form-container" action="AdminPage.php" method="post" enctype="multipart/form-data">
                <h1>News</h1>
                <label for="title"><b>Title</b></label>
                <textarea placeholder="Title" name="title" required></textarea>
                <label for="description" ><b>Description</b></label>
                <textarea placeholder="Description" name="description" required></textarea>
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload" accept="image/png, image/jpeg">
                <button type="submit" name="post" class="btn">Post</button>
                <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
        <footer class="footer group">
            <div class="copyright">Copyright &copy; 2019. All rights reserved</div>
            <div class="footer-links">
                <ul>
                    <li><a href="taxcalculator.php">Tax Calculator</a></li>
                    <li><a href="newsfeed.php">User Feed</a></li>
                </ul>
            </div>
        </footer>
    </div>
    <script>
        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }
    </script>
    <script>
var close = document.getElementsByClassName("closebtn");
var i;

for (i = 0; i < close.length; i++) {
  close[i].onclick = function(){
    var div = this.parentElement;
    div.style.opacity = "0";
    setTimeout(function(){ div.style.display = "none"; }, 600);
  }
}
</script>
</body>

</html>