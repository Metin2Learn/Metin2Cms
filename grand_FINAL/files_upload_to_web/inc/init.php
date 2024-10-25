<?php
mb_internal_encoding("UTF-8");
date_default_timezone_set("Europe/Prague");


// DATABASE INFO
$host = "localhost";	// IP GAME SERVER
$username = "root";  // GAME SERVER DATABASE USERNAME
$password = "";		

$dbname = "mt2grand"; // Do not change !
// DATABASE INFO

define('__ROOT__', dirname(dirname(__FILE__)));

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log', __ROOT__.'inc/errors.log');


// Autoload classes
spl_autoload_register(
    function ($class)
    {
        $path = __ROOT__."/inc/classes/".$class.".class.php";
        if(file_exists($path) AND filesize($path) > 0)
        {
            require_once($path);
        } else {
            trigger_error("Class was not found : ".$path, E_USER_ERROR);
        }
    }
);
// Autoload classes

// Connect to the database
try {
    Database::connect($host, $username, $password, $dbname);
} catch(PDOException $e)
{
    Core::redirect("offline.php");
    die();
}
// Connect to the database


?>