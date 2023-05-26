<?php
  $fixed_top="";
  if( isset( $_GET['name'] )){
   $pageTitle = $_GET['name'];
  }
  if( isset( $_GET['category'] )){
   $pageTitle = $_GET['category'];
  }
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

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    addToCarte($_POST['add_to_cart'],$_POST['price'],$_POST['itemid'],$_SESSION['ID']);
  }  
  }

  if(isset($_GET['name'])){
?>

<div class="container-fluid all-categories seperator">
  <h1 class="text-center">Item by <?php echo $_GET['name']; ?></h1>

  <div class="row mb-5 mt-5 d-flex justify-content-evenly align-items-start">

    <div class="col-3 phone-hide">
      <div class="card search">
          <div class="card-body">
              
          <input type="text" name="" id="search-item" placeholder="Search Products">
            <i class="fa fa-magnifying-glass"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
              <h4 class="filter"> Filter by Categories </h4>
              <ul class="list-group list-group-flush">
                <?php $cats = getAllData('*','categories','WHERE Parent =0','','Name','ASC','all') ;
                      foreach($cats as $cat){
                ?>
                
                <li class="list-group-item parent">
                  <a href="categories.php?Cat_ID=<?php echo $cat["Cat_ID"] ?>&category=<?php echo $cat["Name"]?>">
                  <?= $cat['Name'] ?>
                  </a>
                  <ul class="">
                    <?php $chilCats = getAllData('*','categories','WHERE Parent ='.$cat['Cat_ID'],'','Name','ASC','all') ;
                        foreach($chilCats as $chilCat){
                    ?>
                    
                      <li class=" child">
                        <a href="categories.php?Cat_ID=<?php echo $catChilde["Cat_ID"] ?>&category=<?php echo $catChilde["Name"]?>"">
                          <?= $chilCat['Name'] ?>
                        </a>
                      </li>
                      <?php }
                    ?>
                  </ul>
                </li>

                <?php }
                ?>

              </ul>
            </div>
          </div>
      </div>
    <?php

      // get the id from url
      $tag = isset($_GET['name'])  ?$_GET['name'] : 'discount';
      $items = getAllData('*','items','WHERE Tags like "%'.$tag.'%"' , '' , 'Item_ID' , 'ASC');
    ?>


    <div class="col-8">
    <div class="nav-search-pc">
            <!-- area will be hide on pc -->
            <div class="card search">
              <div class="card-body text-center">
                  
              <input type="text" name="" id="search-item-nav" placeholder="Search Products">
                <i class="fa fa-magnifying-glass"></i>
                </div>
            </div>
             <!-- area will be hide on pc -->
              <!-- all cat -->
              <div class="cat-nav card-body ">
                <ul class="d-flex list-inline justify-content-around flex-wrap ">
                      <?php $cats = getAllData('*','categories','WHERE Parent = 0','','Name','ASC','all') ;
                            foreach($cats as $cat){
                      ?>
                      
                      <li class="list-inline-item parent dropdown " >
                        <a class="nav-link dropdown-toggle " role="button" aria-expanded="false" data-bs-toggle="dropdown" id="navbarDropdown"  href="categories.php?Cat_ID=<?php echo $cat["Cat_ID"] ?>&category=<?php echo $cat["Name"]?>">
                        <?= $cat['Name'] ?>
                        </a>
                        <ul class="dropdown-menu">
                          <?php $chilCats = getAllData('*','categories','WHERE Parent ='.$cat['Cat_ID'],'','Name','ASC','all') ;
                              foreach($chilCats as $chilCat){
                          ?>
                            <li class="nav-item dropdown-item child">
                              <a href="categories.php?Cat_ID=<?php echo $catChilde["Cat_ID"] ?>&category=<?php echo $catChilde["Name"]?>"">
                                <?= $chilCat['Name'] ?>
                              </a>
                            </li>
                            <?php } ?>
                        </ul>
                      </li>
                      <?php }?>               
                </ul>
                </div>
                <!-- end all cat  -->
              </div>
        <div class="row all-product">
          <?php foreach ($items as $item) :?>
          <!-- start col cards -->

          <div class="col-12 col-md-6 searched  mb-3 ">

            <div class="card home-card mb-3">
              <a href="./showItem.php?item_ID=<?= $item["Item_ID"] ?>">
                <?php echo issetImage($item["Image"], 'home-img', 'Product'); ?>
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

                <?php if ($item["Approve"] == 0) {
                  echo '<p class="card-text">Not approve </p>';
                  } else { 
                ?>

                  <div class="d-flex justify-content-between btns">

                    <div class="buy">
                      <a href="#" class="btn rounded-pill ">Buy Now</a>

                    </div>
                    <!-- add to carte -->
                    <div class="addToCart">
                      <form action="<?php echo $_SERVER['PHP_SELF'] . '?name=' . $_GET['name']?>" method="post">

                        <input type="hidden" name="price" value="<?php echo $item["Price"] ?>">
                        <input type="hidden" name="itemid" value="<?php echo $item["Item_ID"] ?>">
                        <input type="hidden" name="memberid" value="<?php echo $item["Member_ID"] ?>">
                        <input type="submit" class="btn  rounded-pill" name="add_to_cart" value="Add to cart">
                      </form>
                    </div>

                  </div>

                    <!-- start tag -->
                <?php
                }
                //end if item approve
                if (!empty($item["Tags"])) { ?>
                
                  <div class=" card-text text-muted">
                    <?php
                    tags:
                    $arr = explode(',', $item["Tags"]);
                    foreach ($arr as $ar) {
                      $tag = str_replace(' ', '', $ar);
                      echo '<a href="tags.php?name=' . strtolower($tag), '">' . $tag . '</a> |';
                    }
                    ?>
                  </div>
                <?php } ?>
                <!-- end tag -->
              </div>
              <!--end card body  -->
            </div>
            <!-- end card -->
          </div>
          <!-- end col -->

            <?php endforeach; ?>
        </div>
        <!-- end row all-product -->
      </div>
      <!-- end-col-8 -->  
  </div>
    <!-- end row -->
</div>
<!-- end-container -->


<?php
}else{
  echo '<div class="alert alert-danger">You need choose specific tag</div>';

}

include($temps . "/footer.php");
