<?php
ob_start();

$inactive = 8; 
ini_set('session.gc_maxlifetime', $inactive);
session_start();

date_default_timezone_set('America/Vancouver');

    $currentDate = gmdate('H:i:s', $tm);
    
    $sinceDate = date('g:i A M. jS');

    echo "<p align=right>Logged in for $currentDate Since $sinceDate</p>"."<br>";


 

if (isset($_SESSION['updateTime']) && (time() - $_SESSION['updateTime'] > $inactive)) {
    // last request was more than 2 hours ago
    session_unset();     // unset $_SESSION variable for this page
    session_destroy();   // destroy session data
}
$_SESSION['updateTime'] = time(); // Update session




// 1. no GET data, no SESSION data: show form
// 2. GET data,    no SESSION data: start a session, show menu
// 3. no GET data, SESSION data: logout? show menu
// 4. GET data,    SESSION data: start session with new get data, show menu


// 1. no GET data, no SESSION data: show form
if(!isset($_GET['username']) && !isset($_SESSION['username']))
{
    echo '
    <form action="" method="get" align="center">
    username:<input type="text" name="username"><br>
    password:<input type="text" name="password"><br>
    <input type="submit">
</form>
    ';
    die();
}
else if(isset($_GET['username']))
{
    $user_input = $_GET['username'];
    $password_input = ($_GET['password']);

    $file = fopen('users.txt', 'r');

    while(!feof($file)){
    $line = fgets($file);
    list($user, $password) = explode(',', $line);
    if(trim($user) == $user_input && trim($password) == $password_input){
        echo "<p align=center>logging you in as " . $_GET['username'] . "</p>"."<br>";
        //echo "logging you in as " . $_GET['username']."<br>";
        break;
        
    } else {
        die("<p align=center>sorry incorrect username match <a href='login.php'>Login</a></p>");
    }

}
fclose($file);
    echo "<p align=center>logged in</p>"."<br>"; 
    //echo "logged in"."<br>";
    $_SESSION['username'] = $_GET['username'];
    $_SESSION['logintime'] = time();
    // if($_SESSION['loginTime'] < time()+1*60){ logout(); }
    if(isset($_SESSION['pageattempted']))
    {
        echo "redirecting you to " . $_SESSION['pageattempted'];
        sleep(1);
        header('Location: ' . $_SESSION['pageattempted']);
        die();
    }else
    {
        echo "<p align=center> | <a href='secret.php'>secret</a> |</p>";
        echo "<p align=center> | <a href='private.php'>private</a> |</p>";
        echo "<p align=center> | <a href='logout.php'>logout</a> |</p>";
        
        //echo "<a href='secret.php'>secret</a> | ";
       // echo "<a href='private.php'>private</a> | ";
       // echo "<a href='logout.php'>logout</a>";
        die();
    }
}
else if(!isset($_GET['username']) && isset($_SESSION['username'])) //When the GET is NOT SET and SESSION IS SET
{
    
  
    die();
}

ob_end_flush();

