<?php

ob_start();
require_once('constants.php');
session_start();

if (!isset($_SESSION['username'])) {
    echo "you can't log out! you haven't logged in!";
    $_SESSION['pageattempted'] = 'logout.php';
    die(LOGIN_URL);
}
// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

//A PHP array containing the data that we want to log.
$dataToLog = array(
    date("Y-m-d H:i:s"), //Date and time
    $_SERVER['REMOTE_ADDR'], //IP address
    $_SERVER['REQUEST_TIME'], //The timestamp of the start of the request.
    $_SERVER['REMOTE_USER'], //The authenticated user.
    $_SERVER['REMOTE_PORT'] //The port being used on the user's machine to communicate with the web server.
);

//Turn array into a delimited string using
//the implode function
$data = implode(" - ", $dataToLog);

//Add a newline onto the end.
$data .= PHP_EOL;

//The name of your log file.
//Modify this and add a full path if you want to log it in 
//a specific directory.
$pathToFile = 'log.txt';

//Log the data to your file using file_put_contents.
file_put_contents($pathToFile, $data, FILE_APPEND);

// Finally, destroy the session.
session_destroy();
echo "Bye!"."<br>";
echo LOGIN_URL;


ob_end_flush();