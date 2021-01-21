<?php
require_once __DIR__."/../pdo.php";
require_once "utils.php";

session_start();

if (!logged_in()) {
    die('ACCESS DENIED');
}

$imageFileType = false;

$target_dir = __DIR__."/../images/";
$uploadOk = false;

if (isset($_POST['submit'])) {

    // if (!isset($_POST['img-file'])) {
    //     $_SESSION['error'] = 'You have not uploaded any file.';
    //     header("Location: upload.php");
    //     exit();
    // }

    $target_file = $target_dir.basename($_FILES['img-file']['name']);

    if (file_exists($target_file)) {
        $_SESSION['error'] = 'File already exists';
        header("LOcation: upload.php");
        exit();
    }

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // $imageFileSize = $_FILES['img-file']['size'];


    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        $_SESSION['error'] = "File must be an image with extension .jpg or .jpeg or .png";
        header("Location: upload.php");
        exit();
    }

    $imageFileName = basename($_FILES['img-file']['name']);
    $imageTmpName = $_FILES['img-file']['tmp_name'];

    if (move_uploaded_file($imageTmpName, $target_file)) {
        $_SESSION['success'] = 'The file '.htmlspecialchars($imageFileName).' has been uploaded successfully';
        $stmt = $pdo->prepare("INSERT INTO images (`user_id`, `file_name`, category) VALUES (:u_id, :fn, :cat)");
        $stmt->execute(array(
            ':u_id' => $_SESSION['user_id'],
            'fn' => $imageFileName,
            ':cat' => (int)$_POST['category']
        ));
        header("Location: index.php");
        exit();
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <h1>Upload Image</h1>
    <?php
    if (logged_in()) {
        // User is logged in
        echo '<h4>User: '.$_SESSION['name']."</h4>\n";
        echo '<p><a href="logout.php">Logout</a></p>'."\n";

        echo '<p><a href="index.php">Back</a></p>';
    }
    flash_messages();
    ?>

    <div><form action="upload.php" method="post" enctype="multipart/form-data">
        <p><label for="img-file">Select image to upload: </label></p>
        <p><input type="file" name="img-file" id="img-file"></p>
        <p>Select Category: </p>
        <p>
            <p><input type="radio" name="category" value="1" id="pg" checked><label for="pg">Photography</label></p>
            <p><input type="radio" name="category" value="2" id="gd"><label for="gd">Graphic Design</label></p>
        </p>
        <p><input type="submit" value="Upload Image" name="submit"></p>
    </form></div>
</body>
</html>