<?php
require_once __DIR__."/../pdo.php";
require_once "utils.php";

session_start();

if (isset($_POST['cancel'])) {
    header("Location: index.php");
    exit;
}


if (isset($_POST['email']) && isset($_POST['pwd'])) { // Check if email and password are set
    
    unset($_SESSION['user_id']);
    unset($_SESSION['email']);
    unset($_SESSION['name']);

    // Fetch user with email == (the one entered by user)
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email"); // :email is a placeholder

    /* Execute the above SQL statement by adding the value of 
    $_POST['email'] to the defined placeholder :email */
    $stmt->execute(array(':email' => $_POST['email']));

    // Fetch the row from SELECT statement
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row == false) { // SELECT statement returned an empty set (zero rows)
        $_SESSION['error'] = "User doesn't exist";
        header("Location: login.php");
        exit;
    }
    else {
        $verify = password_verify($_POST['pwd'], $row['password']); // compare with password hash stored in the database
        // $check = hash('md5', $salt.$_POST['pwd']); // compute hash value of user entered password
        if ($verify) {

            //Login successful
            error_log("Login success: ".$_POST['email']);
            $_SESSION['success'] = "Logged in successfully!!";

            // Store current user in session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];

            header("Location: upload.php");
            exit;
        }
        else {
            // Login failed
            error_log("Login fail ".$_POST['email']." $check");
            $_SESSION['error'] = "Incorrect password";
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
</head>
<body>
    <h1>Please Log In</h1>
    <?php
    flash_messages();
    ?>
    
    <!-- Display login form -->
    <form method="post">
        <p><label for="email">Email</label> 
        <input type="text" id="email" name="email" size="40"></p>
        <p><label for="pwd">Password</label>
        <input type="password" id="pwd" name="pwd" size="40"></p>
        <p><input type="submit" onclick="return doValidate();" value="Log In">
        <input type="submit" name="cancel" value="Cancel"></p>
    </form>
    <script>
        // Function to validate email and password fields in form
        function doValidate() {
            console.log('Validating...');
            try {
                email = document.getElementById('email').value;
                pwd = document.getElementById('pwd').value;
                console.log("Validating email = " + email + "password = " + pwd);
                if (email == null || email == "" || pwd == null || pwd == "") {
                    alert("Both fields must be filled out");
                    return false;
                }
                if (email.indexOf('@') == -1) {
                    alert("Invalid email address");
                    return false;
                }
                return true;
            }
            catch(exception) {
                return false;
            }
            return false;
        }
    </script>
</body>
</html>