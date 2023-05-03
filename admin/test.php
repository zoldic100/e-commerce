<?php 
echo '<div class="container">';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    echo '<h1 class="text-center alert  alert-success">Welcome</h1>';
    echo '<h1 class="text-center"> Insert Item</h1>';


    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $country = $_POST['country'];
    $status = $_POST['status'];

    
    $errors = [];
    
    if (empty($name)) {
        $errors[] = ' Name Can\'t Be Empty ';
    }
    if (empty($description)) {
        $errors[] = ' Description Can\'t Be Empty ';
    }
    if (empty($price)) {
        $errors[] = ' Price Can\'t Be Empty ';
    }
    if (empty($country)) {
        $errors[] = ' country Can\'t Be Empty ';
    }
    if ($status == 0 ) {
        $errors[] = ' You must choose the status ';
    }

    if (empty($errors)) {

        $stmt = $conn->prepare("INSERT INTO `items` (`Name`, `Description`, `Price`, `Date`, `Country_Origin`, `Image`, `Status`, `Rating`, `Member_ID`, `Cat_D`)
                                 VALUES (:name,:description ,:price,now(),:country,null,:status,null,null,null)");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':status', $status);

        $stmt->execute();

        $msg = '<h1 class="text-center alert  alert-success">' . $stmt->rowCount() . ' Recored added</h1>';
        redirectToHome($msg,'back');  
        
    } 
}
?>