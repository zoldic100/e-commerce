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

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $pass = $_POST['password'];


        $stmt = $conn->prepare("SELECT * FROM users WHERE Username = :username limit 1");

        $stmt->bindParam('username', $username);
        


        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);


    


        // if count > 0 mean these user is admin


        if ($row && password_verify($pass, $row['Password'])) {
        //user is an admin   
            
            $_SESSION['user'] = $username;
            $_SESSION['ID'] = $row['UserID'];
            
            header('location:index.php');
            exit();
            
        } else {
            $message= "Invalid username or password.";
        }
    }else{
        echo 'failed to login';
    }
    
  
}  


?>
<div class="container">
    <div class="row">
        
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="row">
                <div class="col-md-6 w-100 ">
                    <h2 class="display-1 fw-bold text-lg-start text-md-center" >Welcome</h2>
                    <p class="display-6">Bye And Sell</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="login">
                
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>"  method="POST">
                        <!-- Username input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="Username">Username</label>
                            <input type="text" name="username" id="Username" class="form-control" />

                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" name="password" id="password" autocomplete="new-password" class="form-control" />

                        </div>
                        
                        <div class="form-outline mb-4">
                            <?php if(isset($message)){?>
                            <span class="text-center alert alert-danger">
                                <?php echo $message; };?>
                            </span>
                        </div>
                        

                        <!-- Submit button -->
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary btn-block mb-4" name='login' value="login">
                        </div>
                        <!-- Register buttons -->
                        <div class="text-center">
                            <p>Not a member? <a href="./sign_up.php">Register</a></p>
                        </div>
                    </form>
                
            </div>
        </div>
    </div>
</div>
<?php
include($temps . "/footer.php");
