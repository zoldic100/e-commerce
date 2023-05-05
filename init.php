<?php
// error reporting

ini_set('display_errors','On');
error_reporting(E_ALL);

include('admin/connect.php');  // to call it to all my pages


$sessionUser ='';
if(isset($_SESSION['user'])){

    $sessionUser = $_SESSION['user'];
}


//routes
$temps= 'includs/temps'; //template darictory (if you change the folder name it will change it in all file)
$lang= 'includs/languages'; 
$function = 'includs/functions';
$css= 'layout/css'; 
$js= 'layout/js'; 


//include the important file 


include($function . "/functions.php");
include($lang . "/eng.php");
include($temps . "/header.php");

//include navbar in all pages expext pages that have noNavBar variable
if(!isset($noNavBar)){
include($temps."/navbar.php");
 }

include($temps."/hero.php");
 