<?php


function getAllData($fild, $table, $where = '', $and = '', $orderfield = '', $ordering = 'DESC', $fetch  = 'all')
{
    global $conn;

    $getall = $conn->prepare("SELECT $fild FROM $table  $where $and ORDER BY $orderfield $ordering ");


    $getall->execute();

    if ($fetch == 'all') {
        $rows = $getall->fetchAll();
    } else {
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
function checkIfAlreadyUsed($from, $where, $value, $and = '')
{

    global $conn;

    $stmtCheck = $conn->prepare("SELECT * FROM $from WHERE $where=:value $and");

    $stmtCheck->bindParam(':value', $value);

    $stmtCheck->execute();

    $rowCount = $stmtCheck->rowCount();
    return $rowCount;
}

function addToCarte($submit, $itemprice, $itemid, $userid)
{
    global $conn;


    if (isset($submit)) {

        $price = $itemprice;
        $product = $itemid;
        $user = $userid;

        // check if item is in the database
        $quantity = 1;  //function checkIfAlreadyUsed($from, $where, $value, $and = '')

        $productQantity = getAllData('*', 'shopping_cart', 'where Item_ID =' . $product, '', 'Item_ID', 'ASC', 'one');

        $checkUser = checkIfAlreadyUsed('shopping_cart', 'UserID', $user, 'AND Item_ID = '.$product);
        
        if ($checkUser > 0 ) {
                echo 'Update the quantity of the existing item  :';
                echo '<br> u'.$checkUser;
                $quantity = $productQantity['quantity'] + 1;

                $stmt = $conn->prepare(' UPDATE `shopping_cart` SET `quantity` = :quantity WHERE Item_ID = :pID ');

                $stmt->bindParam(":pID", $product);
                $stmt->bindParam(":quantity", $quantity);

            } else {
                echo 'insert';  
                echo '<br> u'.$checkUser;
                $stmt = $conn->prepare('INSERT INTO shopping_cart (UserID, Item_ID, quantity, Price) VALUES (:uID, :pID, :quantity, :price)');
                $stmt->bindParam(":uID", $user);
                $stmt->bindParam(":pID", $product);
                $stmt->bindParam(":quantity", $quantity);
                $stmt->bindParam(":price", $price);
            }
        $stmt->execute();
    }
}
function buyNow($submit, $itemprice, $itemid, $userid)
{
    global $conn;


    if (isset($submit)) {

        $price = $itemprice;
        $product = $itemid;
        $user = $userid;

        
        $productQantity = getAllData('*', 'shopping_cart', 'where Item_ID =' . $product, '', 'Item_ID', 'ASC', 'one');

        $checkUser = checkIfAlreadyUsed('shopping_cart', 'UserID', $user, 'AND Item_ID = '.$product);
        
        if ($checkUser > 0 ) {
                echo 'Update the quantity of the existing item  :';
                echo '<br> u'.$checkUser;
                $quantity = $productQantity['quantity'] + 1;

                $stmt = $conn->prepare(' UPDATE `shopping_cart` SET `quantity` = :quantity WHERE Item_ID = :pID ');

                $stmt->bindParam(":pID", $product);
                $stmt->bindParam(":quantity", $quantity);

            } 
        $stmt->execute();
    }
}
function countPrice($userid){

    global $conn;

    $stmtCount = $conn->prepare("SELECT SUM(Price * quantity) as Total  FROM shopping_cart WHERE UserID = :uid");
    
    $stmtCount->bindParam(':uid',$userid);

    $stmtCount->execute();

    $total = $stmtCount->fetch();

    return $total['Total'];
}
function countQuantity($userid){

    global $conn;

    $CountQ =  $conn->prepare('SELECT SUM(quantity) as Total FROM shopping_cart WHERE UserID = :userid');
    
    $CountQ->bindParam(':userid',$userid);

    $CountQ->execute();

    $total = $CountQ->fetch();

    return $total['Total'];
}
function countUserThing( $col, $table ,$where,$userid){

    global $conn;

    $CountQ =  $conn->prepare(' SELECT count('.$col.') as Total from '.$table.' WHERE '.$where.' = :userid');
    
    $CountQ->bindParam(':userid',$userid);

    $CountQ->execute();

    $total = $CountQ->fetch();

    return $total['Total'];
}

function issetImage($path, $class = '', $alt = 'image')
{
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
