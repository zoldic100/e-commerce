<?php
session_start();
$noNavBar ='no';
$pageTitle ='Login';
if (isset($_SESSION['user'])) {
        header('location:profile.php');
    }

include('init.php'); 
    //check if user coming from http post reqest

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['contact-us'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $stmt =$conn->prepare("INSERT INTO `messages` ( `Username`, `Email`, `Message`) VALUES (:name, :email, :msg)");
        $stmt->bindParam(':name',$username);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':msg',$message);

        $stmt->execute();
        $message = 'Thank You';
    }else{
        echo 'failed to login';
    }
    
  
}  


?>
<div class="container-fluid contact">
<div class="container ">

    <div class="row d-flex align-items-center justify-content-center ">

        <div class="col-md-6 ">
        <h1 class="text-center" id="contact-us" >Contact Us</h1>
            <div class="contact-us ">
                
                
                    <form class="w-100" action="<?php echo $_SERVER['PHP_SELF'] ?>"  method="POST">
                        <!-- Username input -->
                        <div class="form-outline mb-4 ">
                            <label class="form-label " for="Username">Username</label>
                            <input type="text" name="username" id="Username" class="form-control" placeholder = "Enter your Username"/>

                        </div>

                        <!-- email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email"  class="form-control" placeholder = "Enter your email"  />

                        </div>

                        <!-- message -->
                        <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Message</label>
                        <textarea class="form-control"  name="message" placeholder="Enter Your Message" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>                        
                       
                        

                        <!-- Submit button -->
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary btn-block mb-4" name='contact-us' value="send">
                        </div>
                        
                    </form>
                
            </div>
        </div>
                
        <div class="col-md-6  " id="contact-img">
            
            
          
        </div>
        <div class=" mb-4  mt-5 text-center">
            <?php if(isset($message)){?>
            <span class="alert alert-success  d-block display-3 w-100">
            <?php echo $message; };?>
            </span>
        </div>
        </div>
</div>
</div>
<?php
include($temps . "/footer.php");
