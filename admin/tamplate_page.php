<?php

/*
manage members page
ADD | DELETE | EDIT  MEMBERS from here
*/

session_start();

$pageTitle = "";
if (isset($_SESSION['Username'])) {

    include('init.php');

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //start manage page
    if ($do == 'Manage') { //manage page


    } elseif ($do == 'Add') {  

      /*end $do =='Add'*/
    }  elseif ($do == 'Insert') { // insert page
      //end $do =='Insert'
    }  elseif ($do == 'Edit') { // edit page

    } elseif ($do == 'Update') {

    } /*end $do =='Update'*/ elseif ($do == 'Delete') {


    }/*end $do =='Delete'*/


} else { // end isset($_SESSION['Username']

    header('location:index.php');
    exit();
}
include($temps . "/footer.php");
