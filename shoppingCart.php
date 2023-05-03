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

?>

<div class="container">
  <h1 class="text-center">Shopping card</h1>



  <div class="row">
    <div id="product-list"></div>
  </div>

  <div class="row row-cols-1 row-cols-md-3 g-4 show-cat">
    <?php

            // get the id from url

    $stmt = $conn->prepare('SELECT shopping_cart.* , items.Name AS Iname ,items.Tags, items.Description, items.Approve, items.Image, users.Username AS Uname FROM shopping_cart INNER JOIN items ON items.Item_ID = shopping_cart.Item_ID INNER JOIN users ON users.UserID = shopping_cart.UserID WHERE shopping_cart.UserID ='.$_SESSION['ID'].' ORDER BY CartID ASC' );

    $stmt->execute();
    $items = $stmt->fetchAll();
    if(!empty($items)):

    foreach ($items as $item) { ?>


      <div class="col-md-3 col-12 col-md-6 col-lg-4 mb-3 d-flex justify-content-evenly">
      <div class="card home-card mb-3">

            
      <?php echo issetImage($item["Image"],'home-img','Product'); ?>

             
      <div class="card-body">
        <div class="d-flex flex-row bd-highlight align-items-center">
          <div class="pe-1 bd-highlight">
            <a href="./showItem.php?item_ID=<?php echo $item["Item_ID"] ?>">
              <h5 class="card-title"><?php echo $item["Uname"] ?></h5>
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
              <!-- add to carte -->
              </div>
              <div class="addToCart">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>"method="post">

                  <input type="hidden" name="price" value="<?php echo $item["Price"] ?>">
                  <input type="hidden" name="itemid" value="<?php echo $item["Item_ID"] ?>">
                  <input type="hidden" name="memberid" value="<?php echo $item["UserID"] ?>">
                  <input type="submit" class="btn  rounded-pill" name="add_to_cart" value="Add to cart">
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
    <?php  } ?>

    
  </div>
</div>
<?php
endif;

include($temps . "/footer.php");
