<?php
    require_once "likeController.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>home</title>
</head>

<body style="background-color:#181A1B;">
    <header class="main-header">
        <div class="container row">
            <div class="page-title">
                <h1>Tax news</h1>
            </div>



            <nav class="main-nav">
                <ul>
                    <li><a href="taxcalculator.php">Tax Calculator</a></li>

                </ul>
            </nav>

        </div>
    </header>

    <div class="blog-box">
        <?php while ($row = mysqli_fetch_array($results)) { ?>
            <div class="blog-image">
                <img src="<?php echo "../../public/storage/images/blog/" . $row['image']; ?>" class="myDIV" alt="">
            </div>
            <button class="like" data-id="<?php echo $row['id']; ?>">
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
            </button>
            <span class="total-like <?php echo $row['id']; ?>"><?php echo $row['total_likes']?></span> Likes
            <div class="blog-title">
                <?php echo $row['title']; ?>
            </div>
            <div class="blog-description">
                <p style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <?php echo $row['description']; ?>
                </p>
            </div>
            <button type="button" class="comment-btn" onclick="document.location='newsfeed.php?id=<?php echo $row['id']; ?> '">Read Full</button>
        <?php } ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                //if clicked on like
                $('.like').on('click', function(event) {
                    event.preventDefault();
                    $(this).prop('disabled', true);

                    var postid = $(this).data('id');

                    $.ajax({
                        url: 'likeController.php',
                        type: 'POST',
                        data: {
                            'info_id': postid
                        },
                        success: function(response) {
                            $(".total-like."+postid).text(response); 
                        },
                        error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            alert(err.Message);
                        }
                    });
                });
            });
        </script>

</body>

</html>