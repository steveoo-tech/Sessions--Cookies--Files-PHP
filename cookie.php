 <?php 
ob_start();
//require_once('constants.php');
session_start();

if(!isset($_SESSION['Username'])) {
    die();
}


ob_end_flush();




session_start();

ob_start();

if(!(isset($_COOKIE['firstname']))) 
{
    
    
    setcookie('firstname', 'steven', time() + 100 * 60);
    echo 'Welcome Newcomer';
   


} else 
{
    
    echo "welcome back " . $_COOKIE['firstname'];
    
}

echo "PHP Sessions PATH: ".((session_save_path()) ? session_save_path():sys_get_temp_dir() ).PHP_EOL;


 ob_end_flush()

?>  