<?php
session_start();
$pageTitle ='By&Sell';

include('init.php');   
    
    // select all data depend of id
    $stmt = $conn->prepare('SELECT items.* , categories.Name AS Category_Name , users.Username AS Username FROM items INNER JOIN categories ON categories.Cat_ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID  WHERE items.Approve = 1  ORDER BY Item_ID DESC');

    
    $stmt->execute();

    // fetch data
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

   
  if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['add_to_cart'])){
        
      $price =$_POST['price'];
      $product =$_POST['itemid'];
      $user = $_SESSION['ID'];

      // check if item is in the database
      $quantity =1;
      
      $productQantity = getAllData('*','shopping_cart','where Item_ID ='.$product,'','Item_ID','ASC','one');
      $checkQuantity = checkIfAlreadyUsed('shopping_cart', 'Item_ID', $product);
      $checkUser = checkIfAlreadyUsed('shopping_cart', 'UserID', $user);
      //if items is there and new user
      $checkUserQantity = checkIfAlreadyUsed('shopping_cart', 'Item_ID ', $product,'AND UserID  <>'.$user);
      
      if ($checkUserQantity >0) {
        // Insert the new item for the existing user
        echo 'insert new user';
        $stmt = $conn->prepare('INSERT INTO shopping_cart (UserID, Item_ID, quantity, Price) VALUES (:uID, :pID, :quantity, :price)');
        $stmt->bindParam(":uID", $user);
        $stmt->bindParam(":pID", $product);
        $stmt->bindParam(":quantity", $quantity);
        $stmt->bindParam(":price", $price);

      
        }else{

          if($checkUser > 0 && $checkQuantity > 0 ){
          // Update the quantity of the existing item
          echo 'update quantity';
          $quantity =$productQantity['quantity'] + 1;

          $stmt = $conn->prepare(' UPDATE `shopping_cart` SET `quantity` = :quantity WHERE Item_ID = :pID ');

          $stmt->bindParam(":pID", $product);
          $stmt->bindParam(":quantity", $quantity);
        

          
          }elseif ($checkUser == 1 && $checkQuantity == 0) {
            // Insert the new item for the existing user
            echo 'insert new user';
            $stmt = $conn->prepare('INSERT INTO shopping_cart (UserID, Item_ID, quantity, Price) VALUES (:uID, :pID, :quantity, :price)');
            $stmt->bindParam(":uID", $user);
            $stmt->bindParam(":pID", $product);
            $stmt->bindParam(":quantity", $quantity);
            $stmt->bindParam(":price", $price);
          }else{
            // Insert the new user and item
            echo 'insert else';
                // the mean statement insert to db
            $stmt = $conn->prepare(' INSERT INTO shopping_cart (UserID , Item_ID , quantity , Price) VALUES (:uID , :pID , :quantity , :price )');

            $stmt->bindParam(":uID", $user);
            $stmt->bindParam(":pID", $product);
            $stmt->bindParam(":quantity", $quantity);
            $stmt->bindParam(":price", $price);
        }
        echo "Item added to cart successfully!";

      }
      //end of check
      $stmt->execute();
      

    }   
  }

?>

<div class="container">

  <div class="row">
    <?php    foreach($items as $item):?>
    <div class="col-md-3 col-12 col-md-6 col-lg-4 mb-3 d-flex justify-content-evenly">
      <div class="card home-card mb-3">

        <?php echo issetImage($item["Image"],'home-img','Product'); ?>
        
        <div class="card-body">
        <div class="d-flex flex-row bd-highlight align-items-center">
          <div class="pe-1 bd-highlight">
            <h5 class="card-title"><?php echo $item["Name"] ?></h5>
          </div>
          <div class="pe-1 bd-highlight desc">
            <p class="card-text"><?php echo $item["Description"] ?></p>
          </div>
        </div>
          <div class="d-flex justify-content-between align-items-center">
          <p class="price"> <?php echo $item["Price"] ?>.00$</p>
          
            <h6 class="card-text text-muted"> <?php echo $item["Date"] ?></h6>
          </div>

          <?php if($item["Approve"]==0){ echo '<p class="card-text">Not approve </p>';}else{ ?>

            <div class="d-flex justify-content-between">
              <div class="buy">
                <a href="#" class="btn rounded-pill ">Buy Now</a>
              <!-- add to carte -->
              </div>
              <div class="addToCart">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?> "method="post">

                  <input type="hidden" name="price" value="<?php echo $item["Price"] ?>">
                  <input type="hidden" name="itemid" value="<?php echo $item["Item_ID"] ?>">
                  <input type="hidden" name="memberid" value="<?php echo $item["Member_ID"] ?>">
                  <input type="submit" class="btn  rounded-pill" name="add_to_cart" value="Add to cart">
                </form>
              </div>
            </div>
          <?php }?>
          <?php if (!empty($item["Tags"])){ ?>
            <div class=" card-text text-muted">
              <?php
                  tags:
                  $arr= explode(',', $item["Tags"]);
                  foreach($arr as $ar){
                    $tag = str_replace(' ','',$ar);
                    echo '<a href="tags.php?name='.strtolower($tag),'">'.$tag.'</a> |';
                  }
                ?>
              </div>
          <?php } ?>
        </div> 

      </div>
    </div>
    
    <?php  endforeach; ?>

  </div>
</div>

<?php 
      
    





include($temps . "/footer.php");
