<?php

session_start();

$pwd = false;
$pwd_hash = false;

if (isset($_POST['pwd'])) {

    if (strlen($_POST['pwd']) < 6) {
        $_SESSION['error'] = 'Password must be minimum 6 characters';
        header("Location: generate.php");
        exit();
    }
    $pwd = $_POST['pwd'];
    $pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Hash Generator</title>
</head>
<body>
    <h4>Enter a password:</h4>
    <div><form action="" method="post">
        <label for="id">Password</label>
        <input type="text" name="pwd" id="pwd">
        <input type="submit" value="Generate">
    </form></div>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red">'.$_SESSION['error']."</p>";
        unset($_SESSION['error']);
    }
    ?>
    <p>Password: <?= $pwd?></p>
    <p>Password Hash:<?= $pwd_hash?></p>

</body>
</html>