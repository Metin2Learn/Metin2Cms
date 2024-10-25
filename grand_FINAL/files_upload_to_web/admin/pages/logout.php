<?php

$_SESSION = array();
session_destroy();
Core::redirect("login.php", 0);

?>