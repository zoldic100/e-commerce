<?php


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


function checkUserStatus($user)
{

    global $conn;

    $St = $conn->prepare("SELECT Username,RegStatus FROM users WHERE Username = :username And RegStatus = 0");

    $St->bindParam(':username', $user);
    $St->execute();

    $row = $St->rowCount();

    return $row;
}
function checkIfAlreadyUsed($from, $where, $value ,$and='')
{

    global $conn;

    $stmtCheck = $conn->prepare("SELECT * FROM $from WHERE $where=:value $and");

    $stmtCheck->bindParam(':value', $value);

    $stmtCheck->execute();

    $rowCount = $stmtCheck->rowCount();
    return $rowCount;
}



function issetImage($path, $class = '', $alt = 'image') {
    // Set up the class and alt attributes
    $myclass = $class != '' ? 'class="' . $class . '"' : '';
    $myalt = 'alt="' . $alt . '"';
    
    if ($path) {
        // Build the HTML output with the correct attributes
        $output = '<img src="./layout/images/' . $path . '" ' . $myclass . ' ' . $myalt . '>';
    } else {
        // Use a default image if no path is provided
        $output = '<img src="./layout/images/random.jpg" ' . $myclass . ' ' . $myalt . '>';
    }
    
    return $output;
}


function getUserbyId($id)
{

    global $conn;

    $getUser = $conn->prepare("SELECT * FROM users WHERE UserID=:id");

    $getUser->bindParam(':id', $id);

    $getUser->execute();

    $user = $getUser->fetch();
    
    return $user;
}













/*to echo the page title*/
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
