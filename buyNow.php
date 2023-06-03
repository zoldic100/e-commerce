<?php
  

$name = $_POST['name'];
$itemid = $_POST['itemid'];
$memberid = $_POST['memberid'];
$img = $_POST['img'];

$pageTitle = $name;
session_start();

include('init.php');

if(isset($_SESSION['user'])){
$userStatus = checkUserStatus($_SESSION['user']);
if($userStatus == 1 ){
 // echo "you need to be activated by admin";
}
}

$total = $_POST['price'];
?>
</div>
<div class="container ">
  <h1 class="text-center"><?= $name ?>  </h1>

  <div class="row">
  <div class="col-12 col-md-9">
  <table class="table table-dark table-hover">
  <thead>
    <th> N° </th>
    <th> Image </th>
    <th> Name </th>
    <th> Qantity</th>
    <th> Price</th>
    

  </thead>
  <tbody>
          <tr>
        <th>1</th>
        <td>         
           <a href="./showItem.php?item=<?php echo $name ?>&item_ID=<?= $itemid ?>">
              <?php echo issetImage($img,'shoping-img','Product'); ?>
            </a>
        </td>
        <td>
          <a href="./showItem.php?item_ID=<?php echo $itemid ?>">
            <h5 class="card-title"><?php echo $name ?></h5>
          </a>
        </td>
        <td>  1 </td>
        <td><?php echo $total ?>.00$</td>

      </tr>
    
  </tbody>
  <tfoot>
    <th class="text-center fs-4">
      Total :
    </th>
   
    <td colspan="4 " class="text-center">
      
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
      if (details.status !== 'COMPLETED') {
        alert('Payment not  completed ');

      }

      });


    }
  }).render('#paypal-button-container');
</script>

    <?php // header('Location: index.php');
        //exit;
      ?>