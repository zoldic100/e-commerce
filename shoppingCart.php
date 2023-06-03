<?php

$pageTitle = 'Categories';
session_start();

include('init.php');

if(isset($_SESSION['user'])){
$userStatus = checkUserStatus($_SESSION['user']);
if($userStatus == 1 ){
 // echo "you need to be activated by admin";
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
  $total = countPrice($_SESSION['ID']);

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
  <div class="col-12 col-md-9">
  <table class="table table-dark table-hover">
  <thead>
    <th> N° </th>
    <th> Image </th>
    <th> Name </th>
    <th> Qantity</th>
    <th> Price</th>
    <th> Delete</th>

  </thead>
  <tbody>
    <?php $i=1; foreach ($items as $item) { ; ?>
      <tr>
        <th><?= $i ?></th>
        <td>         
           <a href="./showItem.php?item=<?php echo $item["Iname"] ?>&item_ID=<?= $item["Item_ID"] ?>">
              <?php echo issetImage($item["Image"],'shoping-img','Product'); ?>
            </a>
        </td>
        <td>
          <a href="./showItem.php?item_ID=<?php echo $item["Item_ID"] ?>">
            <h5 class="card-title"><?php echo $item["Iname"] ?></h5>
          </a>
        </td>
        <td>  <?php echo $item["quantity"] ?> </td>
        <td><?php echo $item["Price"] ?>.00$</td>
        <td>
        <div class="deletefromCart">
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>?uId=<?= $_SESSION['ID'] ?>"method="post">

            <input type="hidden" name="cartid" value="<?php echo $item["CartID"] ?>">
            <input type="submit" class="btn btn-danger rounded-pill confirm" name="delete_from_cart" value="Delete">

          </form>
        </div>
        </td>
      </tr>
      <?php  $i++; } //<!-- end foreach items --> ?>
  </tbody>
  <tfoot>
    <th class="text-center fs-4">
      Total :
    </th>
   
    <td colspan="5 " class="text-center">
      
      <span class="text-danger fs-4 fw-bold"><?= $total ?>DH</span>
    
  </td>

  </tfoot>
  </table>
  </div>
    <div class="col-12 col-md-3">
      <div class="confirm text-center">
        <h2> Pay by : </h2>

          <div id="paypal-button-container" class="text-center"></div>
          
      </div>
    </div>
  </div>
  
</div>
<?php

else:

  echo '<div class="container"><h1 class="display-4 pt-5 text-center ">The cart is empty</h1> </div>';

endif;

include($temps . "/footer.php"); 
?>




<script> 
  var total = <?= $total ?>;
  paypal.Buttons({

    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: <?= $total ?> // Replace with actual purchase amount
          }
        }]
      });
    },
   onApprove: function(data, actions) { 
      return actions.order.capture().then(function(details) {
        // Handle the payment completion and show success message
        alert('Payment completed successfully!');
        
        // Check if payment status is 'COMPLETED'
      if (details.status === 'COMPLETED') {
        // Execute the PHP code to delete data from the shopping cart
        <?php
        $uid = $_GET['uId'];
        $stmtX = $conn->prepare('DELETE FROM shopping_cart WHERE UserID = :uid');
        $stmtX->bindParam(':uid', $uid);
       // $stmtX->execute();
        ?>
        
        // Reload the page
        window.location.reload();
      }

      });


    }
  }).render('#paypal-button-container');
</script>

    <?php // header('Location: index.php');
        //exit;
      ?>