<?php
// Very simple, just start the session, destroy it and redirect to index.php
session_start();
session_destroy();
header("Location: index.php");
exit;