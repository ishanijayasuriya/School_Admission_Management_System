<?php
session_start();
session_unset(); // clear session variables
session_destroy(); // destroy session
header("Location: ../Front-end/home.html"); // or admin/login.html based on your preference
exit();
?>
