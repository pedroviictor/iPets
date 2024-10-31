<?php

session_start();

if (isset($_SESSION['store_data'])) {
    unset($_SESSION['store_data']);
}

session_destroy();

header("Location: loginselect.php");
exit();

?>