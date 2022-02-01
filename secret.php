<?php
ob_start();
require_once('constants.php');


$inactive = 8; 
ini_set('session.gc_maxlifetime', $inactive);
session_start();



if (isset($_SESSION['updateTime']) && (time() - $_SESSION['updateTime'] > $inactive)) {
    // last request was more than 2 hours ago
    session_unset();     // unset $_SESSION variable for this page
    session_destroy();   // destroy session data

}

$_SESSION['updateTime'] = time(); // Update session


date_default_timezone_set('America/Vancouver');

if(isset($_SESSION['logintime'])) {
    $tm = (time() - $_SESSION['logintime']);

    $currentDate = gmdate('H:i:s', $tm);
    
    $sinceDate = date('g:i A M. jS');

    echo "<p align=right>Logged in for $currentDate Since $sinceDate</p>"."<br>";

} else {
    echo "Your not logged in, sorry!"."<br>";
}






if(!isset($_SESSION['username']))
{
    $_SESSION['pageattempted'] = 'secret.php';
    echo 'For security reasons, you have been logged out due to inactivity for 8 seconds, please re-login'."<br>";
    die(LOGIN_URL);
}
else
{
     //echo "thanks for logging " . $_SESSION['username'];
   

        echo "<p align=center> | <a href='secret.php'>secret</a> |</p>";
        echo "<p align=center> | <a href='private.php'>private</a> |</p>";
        echo "<p align=center> | <a href='logout.php'>logout</a> |</p>";
}


ob_end_flush();