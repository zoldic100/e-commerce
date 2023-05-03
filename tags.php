<?php

$pageTitle = 'Categories';
session_start();

include('init.php');

if(isset($_SESSION['user'])){
$userStatus = checkUserStatus($_SESSION['user']);
if($userStatus == 1 ){
  echo "you need to be activated by admin";
}
}
//add to cart 
if($_SERVER['REQUEST_METHOD'] == 'POST') {

if(isset($_POST['add_to_cart'])){
    
  $price =$_POST['price'];
  $product =$_POST['itemid'];
  $user = $_SESSION['ID'];

  // check if item is in the database
  $quantity =1;
  
  $productQantity = getAllData('quantity','shopping_cart','where Item_ID ='.$product,'','Item_ID','ASC','one');
  $check = checkIfAlreadyUsed('shopping_cart', 'Item_ID', $product);
  
  

  if ($check > 0){

    $quantity =$productQantity['quantity'] + 1;

  $stmt = $conn->prepare(' UPDATE `shopping_cart` SET `quantity` = :quantity WHERE Item_ID = :pID ');

  $stmt->bindParam(":pID", $product);
   $stmt->bindParam(":quantity", $quantity);


  }else{
      // the mean statement insert to db
  $stmt = $conn->prepare(' INSERT INTO shopping_cart (UserID , Item_ID , quantity , Price) VALUES (:uID , :pID , :quantity , :price )');

  $stmt->bindParam(":uID", $user);
   $stmt->bindParam(":pID", $product);
   $stmt->bindParam(":quantity", $quantity);
   $stmt->bindParam(":price", $price);
  }

  //end of check
   $stmt->execute();
  

}   
}
if(isset($_GET['name'])){
?>

<div class="container">
  <h1 class="text-center">Item by <?php echo $_GET['name']; ?></h1>



  <div class="row">
    <div id="product-list"></div>
  </div>

  <div class="row">
    <?php

            // get the id from url
    $tag = isset($_GET['name'])  ?$_GET['name'] : 'discount';
    $items = getAllData('*','items','WHERE Tags like "%'.$tag.'%"' , '' , 'Item_ID' , 'ASC');

    foreach ($items as $item): ?>

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
                <form action="<?php echo $_SERVER['PHP_SELF'].'?name='.$_GET['name'] ?>"  method="post">

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
}else{
  echo '<div class="alert alert-danger">You need choose specific category</div>';

}

include($temps . "/footer.php");
