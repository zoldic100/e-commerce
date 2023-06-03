<?php

if( isset( $_GET['name'] )){
   $pageTitle = $_GET['name'];
  }else if( isset( $_GET['category'] )){
   $pageTitle = $_GET['category'];
  }else{
    $pageTitle = 'Categories';
  }
$fixed_top="";
session_start();

include('init.php');


if (isset($_SESSION['user'])) :

  $userStatus = checkUserStatus($_SESSION['user']);
  if ($userStatus == 1) {
    echo "you need to be activated by admin";
  }
endif;

//add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    addToCarte($_POST['add_to_cart'], $_POST['price'], $_POST['itemid'], $_SESSION['ID']);
  }
}

$stmt = $conn->prepare('SELECT items.* , categories.Name AS Category_Name , users.Username AS Username FROM items INNER JOIN categories ON categories.Cat_ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID  WHERE items.Approve = 1  ORDER BY Item_ID ASC');


$stmt->execute();
// fetch data for all category
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// fetch data
if (isset($_GET['category']) && isset($_GET['Cat_ID'])) {
?>

  <div class="container-fluid all-categories seperator">

    <h1 class="text-center"><?php echo $_GET['category']; ?></h1>

    <div class="row mb-5 mt-5 d-flex justify-content-evenly align-items-start show-cat">
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
          <?php
          $catid = isset($_GET['Cat_ID']) && is_numeric($_GET['Cat_ID']) ? intval($_GET['Cat_ID']) : 0;

          $categories = getAllData('*', 'categories', 'WHERE Parent =0', 'AND Cat_ID =' . $catid, 'Cat_ID', 'DESC');
          foreach ($categories as $categorie) :
            $childCats = getAllData('*', 'categories', 'WHERE Parent =' . $categorie['Cat_ID'], '', 'Cat_ID', 'DESC');
            if (!empty($childCats)) { ?>
              <?php foreach ($childCats as $childCat) : ?>

                <div class="ms-2 d-inline">
                  <a href="./categories.php?Cat_ID=<?= $childCat['Cat_ID'] ?>&category=<?= $childCat['Name'] ?>">
                    <div class="fw-bold text-primary"><?php echo $childCat['Name'] ?></div>
                  </a>
                </div>
            <?php
              endforeach;
            }

          endforeach;


      // get the id from url
      $catid = isset($_GET['Cat_ID']) && is_numeric($_GET['Cat_ID']) ? intval($_GET['Cat_ID']) : 0;
      $Items = getAllData('*', 'items', 'WHERE Cat_ID =' . $catid, '', 'Item_ID', 'ASC');


      foreach ($Items as $item) :
        ?>
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
              } else { if (!empty($sessionUser)) { ?>

                <div class="d-flex justify-content-between btns">

                  <div class="buy">
                    <form action="buyNow.php" method="post">

                      <input type="hidden" name="price" value="<?php echo $item["Price"] ?>">
                      <input type="hidden" name="name" value="<?php echo $item["Name"] ?>">
                      <input type="hidden" name="itemid" value="<?php echo $item["Item_ID"] ?>">
                      <input type="hidden" name="memberid" value="<?php echo $item["Member_ID"] ?>">
                      <input type="hidden" name="img" value="<?php echo $item["Image"] ?>">
                      <input type="submit" class="btn btn-light  rounded-pill" name="buy" value="Buy Now">
                    </form>

                  </div>
                  <!-- add to carte -->
                  <div class="addToCart">
                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?Cat_ID=' . $_GET['Cat_ID'] . '&category=' . $_GET['category'] ?>" method="post">

                      <input type="hidden" name="price" value="<?php echo $item["Price"] ?>">
                      <input type="hidden" name="itemid" value="<?php echo $item["Item_ID"] ?>">
                      <input type="hidden" name="memberid" value="<?php echo $item["Member_ID"] ?>">
                      <input type="submit" class="btn  rounded-pill" name="add_to_cart" value="Add to cart">
                    </form>
                  </div>

                </div>

                  <!-- start tag -->
              <?php
              }else{?>
              <div class="d-flex justify-content-between btns">
                
                  <button  class="btn btn-light rounded-pill  Buy-now">Buy Now</button>            
                  <button class="btn btn-light  rounded-pill add-to-cart"> Add To cart</button>  
                </div>  
                
              
          <?php  
            }
          }
          ?>
 
          <div id="login-condition" >
            <p >Please login to add items to your cart.</p>
            <div class="btns">
              <button class="CloLog" id="close-button">Close</button>
              <button class="CloLog"><a href="login.php">login</a></button>
            </div>
          </div>
              <?php
              //end if item approve
              if (!empty($item["Tags"])) {
              ?>
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
  <!-- end-row-show-cat -->
  </div>
  <!-- end-container-fluid -->
<?php
} else { ?>


<div class="seperator ">
  <div class="container-fluid all-categories">
    <h1 class="text-center pb-5">Categories</h1>

    <div class="row mb-5 mt-5 d-flex justify-content-evenly align-items-start">
      <!-- area will be hide on the phones -->
      <div class="col-3 phone-hide">
        <!-- input search -->
        <div class="card search">
          <div class="card-body">  
             <input type="text" name="" id="search-item" placeholder="Search Products">
            <i class="fa fa-magnifying-glass"></i>
           </div>
        </div>
        <!--end input search -->
        <!--all categories -->
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
        <!-- end all categories -->
      </div>
        <!-- end area will be hide on the phones -->

      <div class="col-lg-8 col-11">
        
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
              
                <?php foreach ($items as $item) : ?>
              
              <div class="col-12 col-md-6   mb-3 searched ">
                <div class="card home-card mb-5">
                  <a href="./showItem.php?item=<?php echo $item["Name"] ?>&item_ID=<?= $item["Item_ID"] ?>">
                    <?php echo issetImage($item["Image"], 'home-img', 'Product'); ?>
                  </a>
                  <div class="card-body mb-5 " >

                    <div class="d-flex  align-items-start ">
                      <div class="pe-1 ">
                        <h5 class="card-title text-center"><?php echo $item["Name"] ?></h5>
                      </div>
                      <div class="desc">

                      </div>
                    </div>

                    <div class="d-flex  align-items-center">

                      <p class="price"> <?php echo $item["Price"] ?>.00 DH</p>


                    </div>
                    <div class="d-flex  align-items-center">

                      <p class="rating">Rating <?php echo $item["Rating"] ?></p>


                    </div>

                    <?php if ($item["Approve"] == 0) {
                echo '<p class="card-text">Not approve </p>';
              } else { if (!empty($sessionUser)) { ?>

                <div class="d-flex justify-content-between btns">

                  <div class="buy">
                    <form action="buyNow.php" method="post">

                      <input type="hidden" name="price" value="<?php echo $item["Price"] ?>">
                      <input type="hidden" name="name" value="<?php echo $item["Name"] ?>">
                      <input type="hidden" name="itemid" value="<?php echo $item["Item_ID"] ?>">
                      <input type="hidden" name="memberid" value="<?php echo $item["Member_ID"] ?>">
                      <input type="hidden" name="img" value="<?php echo $item["Image"] ?>">
                      <input type="submit" class="btn btn-light  rounded-pill" name="buy" value="Buy Now">
                    </form>

                  </div>
                  <!-- add to carte -->
                  <div class="addToCart">
                    <?php if(isset($_GET['Cat_ID'])) { ?>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?Cat_ID=' . $_GET['Cat_ID'] . '&category=' . $_GET['category'] ?>" method="post">
                    <?php }else{ ?>
                      <form action="<?php echo $_SERVER['PHP_SELF']  ?>" method="post">

                      <?php } ?>
                      <input type="hidden" name="price" value="<?php echo $item["Price"] ?>">
                      <input type="hidden" name="itemid" value="<?php echo $item["Item_ID"] ?>">
                      <input type="hidden" name="memberid" value="<?php echo $item["Member_ID"] ?>">
                      <input type="submit" class="btn  rounded-pill" name="add_to_cart" value="Add to cart">
                    </form>
                  </div>

                </div>

                  <!-- start tag -->
              <?php
              }else{?>
              <div class="d-flex justify-content-between btns">
                
                  <button  class="btn btn-light rounded-pill  Buy-now">Buy Now</button>            
                  <button class="btn btn-light  rounded-pill add-to-cart"> Add To cart</button>  
                </div>  
                
              
          <?php  
            }
          }
          ?>
 
          <div id="login-condition" >
            <p >Please login to add items to your cart.</p>
            <div class="btns">
              <button class="CloLog" id="close-button">Close</button>
              <button class="CloLog"><a href="login.php">login</a></button>
            </div>
          </div>
              <?php
              //end if item approve
              if (!empty($item["Tags"])) {
              ?>
                <div class=" card-text text-muted">
                  <?php
                  
                  $arr = explode(',', $item["Tags"]);
                  foreach ($arr as $ar) {
                    $tag = str_replace(' ', '', $ar);
                    echo '<a href="tags.php?name=' . strtolower($tag), '">' . $tag . '</a> |';
                  }
                  ?>
                </div>
              <?php } ?>
              <!-- end tag -->
              <!-- end tag -->
                  </div>
                  <!-- end card body -->
                </div>
                <!-- end card -->
              </div>
              <!-- end col -->
            <?php endforeach; ?>
            <!-- end foreach items -->
  
  

        </div>
      </div>
    </div>
 </div>
</div>
<?php
}

include($temps . "/footer.php");
