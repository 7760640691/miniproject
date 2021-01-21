<?php

function logged_in() {
    // Function to check if user is logged in or not
    
    if (isset($_SESSION['name']) && isset($_SESSION['email']) && isset($_SESSION['user_id'])) {
        return true;
    }
    return false;
}

function flash_messages() {
    // Function to render flash messages

    if (isset($_SESSION['success'])) {
        echo '<p style="color: green;">'.$_SESSION['success']."</p>\n"; // Display the message
        unset($_SESSION['success']); // Hide on browser reload
    }

    if (isset($_SESSION['error'])) {
        echo '<p style="color: red;">'.$_SESSION['error']."</p>\n"; // Display the message
        unset($_SESSION['error']); // Hide on browser reload
    }
}