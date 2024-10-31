<?php

session_start();

if (isset($_SESSION['user_data'])) {
    unset($_SESSION['user_data']);
}

session_destroy();

header("Location: loginselect.php");
exit();

?>