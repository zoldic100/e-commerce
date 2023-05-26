<?php
    session_start();
    $pageTitle = 'B&s';

    include('init.php');
    
    // get the id from url
    $itemId = isset($_GET['item_ID']) && is_numeric($_GET['item_ID']) ? intval($_GET['item_ID']) : 0;
    // select all data depend of id
    $stmt = $conn->prepare('SELECT items.* , categories.Name AS Category_Name , users.Username AS Username FROM items INNER JOIN categories ON categories.Cat_ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID  WHERE  Item_ID =:itemId AND Approve = 1 ORDER BY Item_ID DESC');

    $stmt->bindParam('itemId', $itemId);
    $stmt->execute();

    // fetch data
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    $count = $stmt->rowCount();
    if ($count > 0) {
    
        // add to cart
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['add_to_cart'])){
                addToCarte($_POST['add_to_cart'],$_POST['price'],$_POST['itemid'],$_SESSION['ID']);
            }
        }


?>

<div class="container">
    <!-- show item details -->
    <div class="row align-items-start showItem mt-5 mb-5">
        
        <div class="col-12 col-lg-6 text-center">
        <?php echo issetImage($item["Image"],'item-image',$item["Name"]); ?>
        <!-- add to cart -->

        </div>

        <div class="col-12 col-lg-6 info">

            <div class=" d-flex justify-content-evenly items-btns">
            <?php if (isset($_SESSION['user'])) { ?>
            <button  class="btn btn-light rounded-pill  Buy-now w-75">Buy Now</button>  
             
              <form action="<?php echo $_SERVER['PHP_SELF'].'?item='.$_GET["item"].'&item_ID='.$_GET['item_ID'] ?> "method="post">

                <input type="hidden" name="price" value="<?php echo $item["Price"] ?>">
                <input type="hidden" name="itemid" value="<?php echo $item["Item_ID"] ?>">
                <input type="hidden" name="memberid" value="<?php echo $item["Member_ID"] ?>">
                <button type="submit" id="submit" class="btn btn-light  rounded-pill  " name="add_to_cart">
                <i class="fa-solid fa-cart-shopping fa-bounce"></i>
                </button>
              </form>
           

            <?php }else{ ?>

                <button  class="btn btn-light rounded-pill  Buy-now w-75">Buy Now</button>            
                  <button class="btn btn-light  rounded-pill add-to-cart ">
                  <i class="fa-solid fa-cart-shopping fa-bounce"></i>
                </button> 
            <?php } ?>
            </div>
            <div id="login-condition" >
                <p >Please login to add items to your cart.</p>
                <div class="btns">
                <button class="CloLog" id="close-button">Close</button>
                <button class="CloLog"><a href="login.php">login</a></button>
                </div>
          </div>
            <div class=" mt-3  pb-3">
                <span class=" heading "><?php echo $item["Name"] ?></span>
                
            </div>        
            <div class=" ">
                <p class=""><?php echo $item["Description"] ?>
                 Lorem ipsum dolor sit amet consectetur adipisicing 
                elit. Nam reiciendis nobis dolor praesentium pariatur inventore consectetur cumque.
                 Blanditiis illo nostrum asperiores voluptatem iusto,
                 a, molestias, repudiandae harum maiores quo soluta.</p> 
                <span class=" price-hp heading"><?php echo $item["Price"] ?>&dollar;</span>
            </div>
            <div class="pb-3 cat  float-end me-5 ">
                <span class=" "><a href="categories.php?Cat_ID=<?php echo $item["Cat_ID"] ?>&category=<?php echo $item["Category_Name"] ?>"><?php echo $item["Category_Name"] ?></a></span>
            </div>
            

        </div>

    </div>
    <!-- end show item details -->

    <div class="row mt-3">
        <?php if (isset($_SESSION['user'])) :?>

            <form action="<?php echo $_SERVER['PHP_SELF'].'?item='.$_GET["item"].'&item_ID='.$_GET['item_ID'] ?> "method="post">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="comment" class="mr-2 h5">Write a comment:</label>
                        <textarea class="form-control mr-2" name="comment" id="comment" placeholder="Enter your comment"></textarea>
                    </div>
                    <input type="submit" value="Submit" name="submit" class="btn btn-primary mt-2">
                </div>
            </form>
        <?php else :  ?>

        <div class="col-12 ">
            <span class="float-end">
                <a href="./login.php">Login</a>
                OR 
                <a href="./sign_up.php">Sing Up</a>
                to Write a comment
            </span>

        </div>
        <?php 
            endif;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['submit'])) {

                $com = strip_tags($_POST['comment']);
                $Item_id = $item['Item_ID'];
                $uID = $_SESSION['ID'];

                $stmt = $conn->prepare("INSERT INTO comments (Comment, CMT_date, Status, Item_ID, Member_ID) VALUES (:comment , now(), 0, :itemid, :memberid) ");

                $stmt->bindParam(':comment', $com);
                $stmt->bindParam(':itemid', $Item_id);
                $stmt->bindParam(':memberid', $uID);
                $stmt->execute();


                $count = $stmt->rowCount();

                if ($count > 0) {
                    echo '<div id="success-alert" class="alert alert-success">Comment added</div>';
                }
            }
        }
        ?>
    </div>
                 
    <div class="container mt-4">
        <h2>Comments</h2>
            <?php
                $stmt = $conn->prepare("SELECT comments.* , items.Name as Iname, users.Username as Uname, users.Img  FROM comments INNER JOIN items ON items.Item_ID = comments.Item_ID INNER JOIN users ON users.UserID = comments.Member_ID WHERE comments.Item_ID = :itemid ORDER BY CMT_ID DESC");
                
                $stmt->bindParam(':itemid',$itemId);
                $stmt->execute();

                $rows = $stmt->fetchAll(pdo::FETCH_ASSOC);

                if (!empty($rows)) :
                    foreach ($rows as $row): 
            ?>
                    
            <ul class="list-unstyled">
                <li class="media my-4">
                    <div class="row">
                        <div class="col-md-1 comment-img text-center">
                            
                                <?php echo issetImage($row["Img"]); ?>
                                <div class="lead">
                                <h6 class="mt-0"><?php echo $row["Uname"] ?></h6>
                                </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="media-body">
                                <p class="mt-2"><?php echo $row["Comment"] ?></p>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
                <?php 
                    endforeach;
                    endif;
                ?>
    </div>
</div>
<!-- end container -->


<?php
    } else {
        $msg = 'there is no sush id';
        redirectToHome($msg);
    }




include($temps . "/footer.php");
