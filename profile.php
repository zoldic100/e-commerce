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
    <form method="post">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                    <?php if (isset($user['Img'])): ?>
                    <img src="./layout/images/<?php echo $user['Img'] ?>" alt="" />
                    <?php else: ?>
                        <img src="./layout/images/random.jpg" alt="" />

                    <?php endif; ?>
                    <div class="file btn btn-lg btn-primary">
                        Change Photo
                        <input type="file" name="file" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-head">
                    <h5>
                    <?= $user['Username']?>
                    
                    </h5>
                    <h6>
                        Web Developer and Designer
                    </h6>
                    <p class="proile-rating">RANKINGS : <span>8/10</span></p>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <a href="#"class="profile-edit-btn btn btn-light rounded-pill">Edit Profile</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="profile-work">
                    <p>WORK LINK</p>
                    <a href="">ID: <?php echo $_SESSION['ID'] ?></a><br />
                    <a href="">Bootsnipp Profile</a><br />
                    <a href="">Bootply Profile</a>
                    <p>SKILLS</p>
                    <a href="">Web Designer</a><br />
                    <a href="">Web Developer</a><br />
                    <a href="">WordPress</a><br />
                    <a href="">WooCommerce</a><br />
                    <a href="">PHP, .Net</a><br />
                </div>
            </div>
            <div class="col-md-8">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>User Id</label>
                            </div>
                            <div class="col-md-6">
                                <p>Kshiti123</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Name</label>
                            </div>
                            <div class="col-md-6">
                                <p>Kshiti Ghelani</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6">
                                <p>kshitighelani@gmail.com</p>
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
                                <label>Profession</label>
                            </div>
                            <div class="col-md-6">
                                <p>Web Developer and Designer</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Experience</label>
                            </div>
                            <div class="col-md-6">
                                <p>Expert</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Hourly Rate</label>
                            </div>
                            <div class="col-md-6">
                                <p>10$/hr</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Total Projects</label>
                            </div>
                            <div class="col-md-6">
                                <p>230</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>English Level</label>
                            </div>
                            <div class="col-md-6">
                                <p>Expert</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Availability</label>
                            </div>
                            <div class="col-md-6">
                                <p>6 months</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Your Bio</label><br />
                                <p>Your detail description</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="container emp-profile">
    <div class="row">
        <h1 class="text-center">My Ads</h1>
        
        <?php  
            $check = checkIfAlreadyUsed('items', 'Member_ID', $user['UserID']);
            if($check > 0){
            $Items = getAllData('*','items','where Member_ID ='.$user['UserID']  , '' , $user['UserID']);

            if(isset($Items)){
            foreach($Items as $itm){ 
                
        ?>
        <div class="col-md-4">
            <?php echo issetImage($itm['Image'],'ads-img'); ?>
        </div>
        <div class="col-md-6">
            <div class="profile-head">
                        
                <h5 class="card-title"><?php echo $itm["Name"]?></h5>
                <p class="card-text">This is a longer card with supporting
                    text below as a natural lead-in to additional content. This content is a little bit longer.
                </p>
                <p class="card-text">This is a short card.</p>
                <p class="proile-rating">RANKINGS : <span>8/10</span></p>

            </div>
        </div>
        <div class="col-md-2">
            <br>
            <a href="#" class="btn btn-success"><?php echo $itm["Price"]?></a>
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
<div class="container emp-profile comments">
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
