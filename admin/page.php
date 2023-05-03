<?php

$do ='';

$do= isset($_GET['do'])? $_GET['do']: 'Manage';


    

if($do='Manage'){

    echo 'welcome';

}else{

    echo 'Error There\'s no page with this name';
}