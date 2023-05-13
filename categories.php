<?php

  $pageTitle = 'Categories';
  session_start();

  include('init.php');


  if(isset($_SESSION['user'])):

  $userStatus = checkUserStatus($_SESSION['user']);
  if($userStatus == 1 ){
    echo "you need to be activated by admin";
  }
  endif;

  //add to cart
  if($_SERVER['REQUEST_METHOD'] == 'POST') {

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    addToCarte($_POST['add_to_cart'],$_POST['price'],$_POST['itemid'],$_SESSION['ID']);
    
  }   
  }

  if(isset($_GET['category'])&& isset($_GET['Cat_ID'])){
?>

<div class="container">

  <h1 class="text-center"><?php echo $_GET['category']; ?></h1>
  <div class="row">
    <div id="product-list"></div>
  </div>

  <div class="row row-cols-1 row-cols-md-3 g-4 show-cat">
    <?php 
      $catid = isset($_GET['Cat_ID']) && is_numeric($_GET['Cat_ID']) ? intval($_GET['Cat_ID']) : 0;

      $categories =getAllData('*','categories','WHERE Parent =0'  , 'AND Cat_ID ='.$catid , 'Cat_ID','DESC');
      foreach ($categories as $categorie) :
        $childCats =getAllData('*','categories','WHERE Parent ='.$categorie['Cat_ID']  , '' , 'Cat_ID','DESC');
          if(!empty($childCats)){ ?>
              <?php foreach($childCats as $childCat): ?>

                  <div class="ms-2 d-inline">
                      <a href="./categories.php?Cat_ID=<?= $childCat['Cat_ID']?>&category=<?= $childCat['Name']?>">
                        <div class="fw-bold text-primary"><?php echo $childCat['Name']?></div>
                      </a> 
                  </div>
              <?php 
                  endforeach ;
          } 
 
      endforeach;  
    

      // get the id from url
      $catid = isset($_GET['Cat_ID']) && is_numeric($_GET['Cat_ID']) ? intval($_GET['Cat_ID']) : 0;
      $Items = getAllData('*','items','WHERE Cat_ID ='. $catid , '' , 'Item_ID' , 'ASC');
     
     
      foreach ($Items as $item) : 
    ?>
         <!-- start col cards --> 

      <div class="col-md-3 col-12 col-md-6 col-lg-4 mb-3 d-flex justify-content-evenly">
        <div class="card home-card mb-3">
          <a href="./showItem.php?item_ID=<?= $item["Item_ID"] ?>">
            <?php echo issetImage($item["Image"],'home-img','Product'); ?>
          </a>
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
                
                </div>
                <!-- add to carte -->
                <div class="addToCart">
                  <form action="<?php echo $_SERVER['PHP_SELF'].'?Cat_ID='.$_GET['Cat_ID'].'&category='.$_GET['category'] ?>"method="post">

                    <input type="hidden" name="price" value="<?php echo $item["Price"] ?>">
                    <input type="hidden" name="itemid" value="<?php echo $item["Item_ID"] ?>">
                    <input type="hidden" name="memberid" value="<?php echo $item["Member_ID"] ?>">
                    <input type="submit" class="btn  rounded-pill" name="add_to_cart" value="Add to cart">
                  </form>
                </div>

              </div>

             
            <?php 
              }
              //end if item approve
              if (!empty($item["Tags"])){ 
            ?>
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
          <!--end card body  -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
    
    <?php  endforeach; ?>
  </div>
  <!-- end row -->
</div>
<!-- end-container -->
<?php
}else{
  echo '<div class="alert alert-danger">You need choose specific category</div>';

}

include($temps . "/footer.php");
