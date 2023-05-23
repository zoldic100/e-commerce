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
//get the user id from url
$uId = isset($_GET['uId']) && is_numeric($_GET['uId']) ? intval($_GET['uId']) : 0;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $cartid = $_POST['cartid'];
  
  $stmtX = $conn->prepare('Delete FROM shopping_cart WHERE CartID =:CartID ');

  $stmtX->bindParam(':CartID',$cartid);

  $stmtX->execute();
}


            // get the id from url

            $stmt = $conn->prepare('SELECT shopping_cart.* , items.Name AS Iname ,items.Tags, items.Description, items.Approve, items.Image, users.Username AS Uname
                            FROM shopping_cart  
                            INNER JOIN items ON items.Item_ID = shopping_cart.Item_ID
                            INNER JOIN users ON users.UserID = shopping_cart.UserID
                            WHERE shopping_cart.UserID ='.$uId.' ORDER BY CartID ASC' 
                          );

    $stmt->execute();
    $items = $stmt->fetchAll();
    if(!empty($items)):
?>
</div>
<div class="container ">
  <h1 class="text-center">Shopping card</h1>

  <div class="row">
    <div id="product-list"></div>
  </div>

  <div class="row row-cols-1 row-cols-md-3 g-4 show-cat">
    <?php


    foreach ($items as $item) { ?>


      <div class="col-md-3 col-12 col-md-6 col-lg-4 mb-3 d-flex justify-content-evenly">
      <div class="card home-card mb-3">
     
      <a href="./showItem.php?item=<?php echo $item["Iname"] ?>&item_ID=<?= $item["Item_ID"] ?>">
          <?php echo issetImage($item["Image"],'home-img','Product'); ?>
        </a>

             
      <div class="card-body">
        <div class="d-flex flex-row bd-highlight align-items-center">
          <div class="pe-1 bd-highlight">
            <a href="./showItem.php?item_ID=<?php echo $item["Item_ID"] ?>">
              <h5 class="card-title"><?php echo $item["Iname"] ?></h5>
            </a>
          </div>

          <div class="pe-1 bd-highlight desc">
            <p class="card-text"><?php echo $item["Description"] ?></p>
          </div>
        </div>
          <div class="d-flex justify-content-between align-items-center">
          <p class="price"> <?php echo $item["Price"] ?>.00$</p>
          
            <h6 class="card-text text-muted"> <?php echo $item["updated_at"] ?></h6>
          </div>

          <?php if($item["Approve"]==0){ echo '<p class="card-text">Not approve </p>';}else{ ?>

            <div class="d-flex justify-content-between">
              <div class="buy">
                <a href="#" class="btn rounded-pill ">Buy Now</a>
              <!--deletefromCart -->
              </div>
              <div class="deletefromCart">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>?uId=<?= $_SESSION['ID'] ?>"method="post">

                  <input type="hidden" name="cartid" value="<?php echo $item["CartID"] ?>">
                  <input type="submit" class="btn  rounded-pill confirm" name="delete_from_cart" value="Delete">

                </form>
              </div>
            </div>
            <div class="quantity">
            <h6 class="card-text fw-bold fs-4">Quantity: <?php echo $item["quantity"] ?></h6>

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
    <?php  } 
    //<!-- end foreach items -->

    $total = countPrice($_SESSION['ID']);
    

    ?>
  </div>
  <div class="confirm text-center">
      <h1 class="display-4 pt-5 text-center "> total price is : <span class="text-danger"><?= $total ?>DH</span></h1>
      <button class="btn btn-success">confirm</button>
  </div>
  
</div>
<?php

else:

  echo '<div class="container"><h1 class="display-4 pt-5 text-center ">The cart is empty</h1> </div>';

endif;

include($temps . "/footer.php");

