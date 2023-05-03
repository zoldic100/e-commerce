<?php
session_start();
$pageTitle = 'Login';

include('init.php');
if (isset($_SESSION['user'])) {

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

?>

<div class="container">
            <div class="row align-items-center showItem">
                <div class="col-md-6 ">
                    <img src="./layout/images/<?php echo $item["Image"] ?>" height="300px" class="card-img-top " alt="<?php echo $item["Name"] ?>">
                </div>

                <div class="col-md-6">
                    <div class="clearfix mt-3 mb-3 w-50">
                        <span class="float-start badge rounded-pill bg-primary"><?php echo $item["Name"] ?></span>
                        <span class="float-end price-hp"><?php echo $item["Price"] ?>&dollar;</span>
                    </div>
                    <div class="clearfix mb-3 w-50">
                        <span class="float-start h3">created by :</span>
                        <span class="float-end "><?php echo $item["Username"] ?></span>
                    </div>
                    <div class="clearfix mb-3 w-50">
                        <span class="float-start h3">Category :</span>
                        <span class="float-end "><a href="categories.php?Cat_ID=<?php echo $item["Cat_ID"] ?>&category=<?php echo $item["Category_Name"] ?>"><?php echo $item["Category_Name"] ?></a></span>
                    </div>
                    <h5 class="card-title">Description<?php echo $item["Description"] ?></h5>

                </div>

            </div>
            <div class="row mt-3">
                <?php if (isset($_SESSION['user'])) :
                ?>

                    <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF'] . '?item_ID=' . $item["Item_ID"] ?>" method="POST">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="comment" class="mr-2 h5">Write a comment:</label>
                                <textarea class="form-control mr-2" name="comment" id="comment" placeholder="Enter your comment"></textarea>
                            </div>
                            <input type="submit" value="Submit" name="submit" class="btn btn-primary mt-2">
                        </div>
                    </form>
                <?php else :  ?>
                    <div class="col-md-6">
                        <span><a href="./login.php">Login</a>OR <a href="./sign_up.php">Sing Up</a>Write a comment</span>
                    </div>
                <?php endif;
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








<?php
    } else {
        $msg = 'there is no sush id';
        redirectToHome($msg);
    }
} else {
    header('location:login.php');
    exit();
}



include($temps . "/footer.php");
