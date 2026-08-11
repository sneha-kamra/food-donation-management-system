<?php
session_start();
session_destroy();
header("Location: volunteer_login.php");
?>