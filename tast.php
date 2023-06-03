<div class="col-md-6 col-12">
      
      <div class="row   show-cat">
        <?php


        foreach ($items as $item) { ?>


          <div class=" col-12  mb-3 d-flex justify-content-evenly">
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

       
        

        ?>
      </div>
    </div>