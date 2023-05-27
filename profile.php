<?php
session_start();
$pageTitle = 'profile';

$fixed_top="";
include('init.php');

if (isset($_SESSION['user'])) {

    $getUser = $conn->prepare("SELECT * FROM users WHERE Username =:user ");

    $getUser->bindParam(':user',$_SESSION['user']);

    $getUser->execute();

    $user = $getUser->fetch();// use the user array in the whole page
    

    $userStatus = checkUserStatus($_SESSION['user']);
if($userStatus == 1 ){
  echo "you need to be activated by admin";
}



?>

<div class="profile text-center">
   

        <h1 class="text-center" id="myText">hello <?php echo $_SESSION['user'] ?></h1> 

        <div class="detail_profile row">
            <div class="img_user col-4 ">
                <p class="mt-4"><?php echo $user['Username'] ?></p>
               <p> <?php echo $user['Email'] ?></p>
            </div>
            <div class="img_user col-4 ">
                <?php if (isset($user['Img'])): ?>
                    <img class="rounded-circle" src="./layout/images/<?php echo $user['Img'] ?>" alt="" />
                <?php else: ?>
                    <img class="rounded-circle" src="./layout/images/avatar.png" alt="" />
                <?php endif; ?>
                <br>
                <?php echo $user['FullName'] ?>

            </div>
            <div class="img_user col-4  ">
                <p class="mt-4"> Total Ads : 5</p>
                <p class=""> Card Status : 5 item</p>
                <p class=""> total comment: 15  </p>
                
            </div>
        </div>

</div>
    



   


<div class="container emp-profile"id="profile">
    <div class="row">
        <h1 class="text-center">My Ads</h1>
        
        <?php  
            $check = checkIfAlreadyUsed('items', 'Member_ID', $user['UserID']);
            if($check > 0){
            $Items = getAllData('*','items','where Member_ID ='.$user['UserID']  , '' , 'Item_ID');

            if(isset($Items)){
            foreach($Items as $itm){ 
                
        ?>
        <!-- item image -->
        <div class="col-md-4 ">
            <?php echo issetImage($itm['Image'],'ads-img'); ?>
        </div>
        <!-- end item image -->
        <!-- start item info -->
        <div class="col-md-6 ">
            <div class="profile-head pt-5">
                        
                <h5 class="card-title"><?php echo $itm["Name"]?></h5>
                <p class="card-text">This is a longer card with supporting
                    text below as a natural lead-in to additional content. This content is a little bit longer.
                </p>
                <p class="card-text">This is a short card.</p>
                <p class="proile-rating">RANKINGS : <span>8/10</span></p>
                <p class="card-text">Purchas total : 0 </p>
                
            </div>
        </div>
        <!-- end item info -->
        <div class="col-md-2">
            <br>
            <a href="#" class="btn btn-success mt-5"><?php echo $itm["Price"]?> DH</a>
        </div>  
        <p> </p>
        <hr>          
        <?php  
            } //endforeach
            }else{
             echo ' <div class="alert alert-info">there is no data to show</div>';
            }/*endif*/
           }else{
             echo ' <div class="alert alert-info">there is no data to show</div>';
            }/*endif*/
        ?>

    </div>
</div>
<div class="container emp-profile comments " id="comments">
    <div class="row">
        <h1 class="text-center">My Comments</h1>
        <?php
        $commentSt = getAllData('*','comments','where Member_ID ='.$user['UserID']  , '' , 'CMT_ID','DESC');
        foreach($commentSt as $cmt){
        if ( !empty($cmt)){

        ?>
        <div class="col-md-4">
            <h5>
                  <?=  $cmt['Comment'] ?>
            </h5>
        </div>
        <div class="col-md-6">
            <div class="profile-head">
                <p class="text-muted">
                  <?=  $cmt['CMT_date'] ?>
                </p>

            </div>
        </div>
        <div class="col-md-2">
            x
        </div>
        <?php    
        }else{
                ?> 
                <div class="col-md-4">
                    <p class="alert alert-light" > There is no comment </p>
                </div>
                <?php
        }
    }
         ?>
    </div>
</div>


<?php


}else{
   header('location:login.php'); 

   exit();
}
include($temps . "/footer.php");
