<?php
/*to echo the page title*/

function getAllData($fild, $table, $where = '' , $and = '' , $orderfield='' , $ordering = 'DESC', $fetch  = 'all' )
{
    global $conn;
    
    $getall = $conn->prepare("SELECT $fild FROM $table  $where $and ORDER BY $orderfield $ordering ");


    $getall->execute();

    if($fetch == 'all'){
       $rows = $getall->fetchAll(); 
    }else{
        $rows = $getall->fetch(); 
 
    }

    

    return $rows;
}
function getTitle()
{

    global $pageTitle;

    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo 'Default';
    }
}


function redirectToHome($msg, $url = null, $seconds = 3)
{

    if ($url === null) {

        $url = 'dashboard.php';

        $link = 'HomePage';
    } else {

        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

            $url = $_SERVER['HTTP_REFERER'];

            $link = 'Previous Page';
        } else {

            $url = 'dashboard.php';

            $link = 'HomePage';
        }
    }
    echo $msg;

    echo '<h1 class="alert alert-info text-center">You Will Be redirect to' . $link . ' After ' . $seconds . ' s</h1>';

    header('refresh:' . $seconds . ';url=' . $url);

    exit();
}

function checkItem($select, $from, $value)
{
    global $conn;

    $statement = $conn->prepare("SELECT $select FROM $from WHERE $select=:select");
    $statement->bindParam(':select', $value);

    $statement->execute();

    $count = $statement->rowCount();

    return $count;
}

function countItems($item, $table)
{

    global $conn;

    $stmt2 = $conn->prepare("SELECT COUNT($item) FROM $table");

    $stmt2->execute();

    return $stmt2->fetchColumn();
}


function getLatest($select, $table, $order, $limit)
{

    global $conn;

    $getSt = $conn->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");


    $getSt->execute();

    $row = $getSt->fetchAll();

    return $row;
}
