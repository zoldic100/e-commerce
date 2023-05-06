<?php
session_start();
$pageTitle ='By&Sell';

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
  <div class="row category ">
    <h1 class="text-center">
      Categories
    </h1>
    <?php 
    $categories = getAllData('*','categories','','','CAT_ID','ASC','all');
     foreach($categories as $cat):
    ?>
    <div class="col-md-3 col-12 col-md-6 col-lg-4 mb-3 d-flex justify-content-evenly">  
    <div class="d-flex flex-row ">
          <div class="pe-1">
            <h5 class="card-title"><?php echo $cat["Name"] ?></h5> 
          </div>
          <div class="pe-1 desc">
            <p class="card-text"><?php echo $cat["Description"] ?></p>
          </div>
        </div>
    </div>

    <?php endforeach ?>
  </div>

  <div class="row products">
  <h1 class="text-center">
      best Products
    </h1>
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
