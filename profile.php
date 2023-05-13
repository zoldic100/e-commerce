<?php
session_start();
$pageTitle = 'profile';

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
<div class="container emp-profile">
    
        <!-- PROFILE AREA -->
        <div class="row">
            <!-- PROFILE IMAGE -->
            <div class="col-md-4">
                <div class="profile-img">
                    <?php if (isset($user['Img'])): ?>
                    <img class="rounded-5" src="./layout/images/<?php echo $user['Img'] ?>" alt="" />
                    <?php else: ?>
                        <img class="rounded-4" src="./layout/images/random.jpg" alt="" />
                    <?php endif; ?>

                    <!--upload image <div class="file btn btn-lg btn-primary">
                        Change Photo
                        <input type="file" name="file" />
                    </div> -->
                </div>
            </div>
            <!-- END PROFILE IMAGE -->
            <!-- START BAR -->
            <div class="col-md-6">
                <!-- nav links -->
                <div class="profile-head">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Ads</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="false">Comments</a>
                        </li>
                    </ul>
                </div>
                <!-- end nav links -->

                <!-- start user info -->
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <div class="row">
                            <div class="col-md-6">
                                <label>User Id</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $_SESSION['ID'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Name</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $_SESSION['user'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $user['Email'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Phone</label>
                            </div>
                            <div class="col-md-6">
                                <p>123 456 7890</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Current Ads</label>
                            </div>
                            <div class="col-md-6">
                                <p>2</p>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end user info -->
            </div>
            <!-- end bar -->
            <div class="col-md-2">
                <a href="#"class="profile-edit-btn btn btn-light rounded-pill">Edit Profile</a>
            </div>
        </div>
        <!-- END PROFILE AREA -->
        
    
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
