<?php
require_once "utils.php";

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Images</title>
    <?php require_once __DIR__."/../base.php";?>
    <style>
        .photos {
            width: 25%;
            height: 25%;
        }
    </style>
</head>
<body>
    <h1>Images</h1>
    <?php
    flash_messages();
    if (!logged_in()) {
        echo '<p><a href="login.php">Login to upload image</a></p>';
    }
    else {
        echo '<h4>User: '.$_SESSION['name'].'</h4>';
        echo '<p><a href="upload.php">Upload image</a></p>';
        echo '<p><a href="logout.php">Logout</a></p>';
    }
    ?>
    <div id="myImages"></div>

    <script type="text/javascript">
        $.getJSON("getimages.php", function(data) {

            $('#myImages').empty();
            
            if (data.length < 1) {
                $('#myImages').append('<p>No images</p>');
            }

            for (var i = 0; i < data.length; i++) {
                imageFileName = data[i]['file_name'];
                $('#myImages').append(`<img src="../images/${imageFileName}" alt="" class="photos">&emsp;`);
            }
        });
    </script>
</body>
</html>