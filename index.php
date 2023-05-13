<?php
  session_start();
  $pageTitle ='B&S';

  include('init.php');   
  include($temps."/hero.php");   
      // select all items 
      $stmt = $conn->prepare('SELECT items.* , categories.Name AS Category_Name , users.Username AS Username FROM items INNER JOIN categories ON categories.Cat_ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID  WHERE items.Approve = 1  ORDER BY Item_ID DESC');

        
      $stmt->execute();

      // fetch data
      $items = $stmt->fetchAll(PDO::FETCH_ASSOC);


  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    addToCarte($_POST['add_to_cart'],$_POST['price'],$_POST['itemid'],$_SESSION['ID']);
  }

?>

<div class="container">
  <!-- start category area -->
  <div class="row category mb-5  ">
    <h1 class="text-center">
      Categories
    </h1>
    <?php 
    $categories = getAllData('*','categories','WHERE Parent = 0','','CAT_ID','ASC','all');
     foreach($categories as $cat):
    ?>
    <div class="col-6 col-md-2 ms-auto me-auto  mb-3 ">
      <a href="./categories.php?Cat_ID=<?= $cat['Cat_ID']?>&category=<?= $cat['Name']?>"> 
        <div class="text-center ">
              <div class="">
                <img src="./layout/images/catImg/<?= $cat['Image'] ?>" class="rounded-3" width="120px" hight="108px" alt=""> 
              </div>
              <div class="">
                <h5 class="card-title text-secondary pt-3"><?php echo $cat["Name"] ?></h5> 
              </div>

          </div>
        </a> 
    </div>
    <?php endforeach ?>
    <div class="show-more  text-end ">
    <a href="categories.php"  class="link-secondary ">show more ...</a>
    </div>
  </div>
  
  <!-- end category area -->
  
  <!-- start product area -->
  <div class="row products ">
    <h1 class="text-center">
      best Products
    </h1>
    <a href="./showItem.php?item_ID=<?= $item["Item_ID"] ?>">
      <?php    foreach($items as $item):?>
    </a>
    <div class=" col-12 col-md-4 col-lg-3 mb-3 d-flex justify-content-evenly">
      <div class="card home-card mb-5">
      <a href="./showItem.php?item_ID=<?= $item["Item_ID"] ?>">
        <?php echo issetImage($item["Image"],'home-img','Product'); ?>
      </a> 
        <div class="card-body mb-5">

          <div class="d-flex  align-items-start">
            <div class="pe-1 ">
              <h5 class="card-title text-center"><?php echo $item["Name"] ?></h5>
            </div>
            <div class=" desc">
              
            </div>
          </div>

          <div class="d-flex  align-items-center">

            <p class="price"> <?php echo $item["Price"] ?>.00 DH</p>
            

          </div>
          <div class="d-flex  align-items-center">

            <p class="rating">Rating <?php echo $item["Rating"] ?></p>
            

          </div>

          <?php if($item["Approve"]==0){ echo '<p class="card-text">Not approve </p>';
          }else{ 
            if(!empty($sessionUser)){
            ?>

            <div class="d-flex justify-content-between">
              <div class="buy">
                <a href="#" class="btn btn-light rounded-pill ">Buy Now</a>
              </div>

              <!-- add to carte -->
              <div class="addToCart">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?> "method="post">

                  <input type="hidden" name="price" value="<?php echo $item["Price"] ?>">
                  <input type="hidden" name="itemid" value="<?php echo $item["Item_ID"] ?>">
                  <input type="hidden" name="memberid" value="<?php echo $item["Member_ID"] ?>">
                  <input type="submit" class="btn btn-light  rounded-pill" name="add_to_cart" value="Add to cart">
                </form>
              </div>

            </div>
          <?php 
            }
          } 
          ?>

        </div> 
        <!-- end card body -->
      </div>
      <!-- end card -->
    </div>
    <!-- end col -->
    <?php  endforeach; ?>
    <!-- end foreach items -->
  </div>
  <!-- end row product -->
</div>
<!-- end container -->

<?php 
include($temps . "/footer.php");
