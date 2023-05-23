<?php
ob_start();
session_start();

$pageTitle = 'Sign Up';

$noNavBar="";
include('init.php');
$falseEmailOrPass = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['signup'])){
        
        $errors = [];

        if(isset($_POST['username'])){
            $filterUser = strip_tags($_POST['username']);
            
            if (strlen(($filterUser))<4){
                $errors[]=  'username must be larger than 4 character';
            }
            
            $checkUser =  checkIfAlreadyUsed('users','Username',$filterUser);

            if($checkUser!=0){
                $errors[]= 'the Username is already used';
            }
        }


        if(isset($_POST['email'])){

            $filterEmail = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

                if(filter_var($_POST['email'],FILTER_SANITIZE_EMAIL)!=true){
                    $errors[] = 'this email is note valid';

                    $checkEmail =  checkIfAlreadyUsed('users','Email',$filterEmail);

                    if($checkEmail!=0){
                        $errors[]= 'the email is already used';
                    }
                }

            }
            if(isset($_POST['password'])){

                if (strlen(($_POST['password']))< 7){
                    $errors[]=  'password must be larger than 8 character';
                }    
                if (empty(($_POST['password']))){
                    $errors[]=  'password can\'t be empty ';
                }    
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                
                
            }


            if (empty($_FILES['profile']['name'])) {
            $errors[] = 'photo is requared';
            }

            if (empty($errors)){
                

                $file_name = $_FILES['profile']['name'];
                $file_tmp_name = $_FILES['profile']['tmp_name'];
                $file_size = $_FILES['profile']['size'];
                $file_error = $_FILES['profile']['error'];
                $file = explode('.', $file_name); //bach tfr9
                $file_accepte = strtolower(end($file)); // == 'png', 'jpg', 'svg', 'jpge'...
                $allowed = array('png', 'jpg', 'svg', 'jpge');
                if (in_array($file_accepte, $allowed)) {
                    if ($file_error === 0) {
                        if ($file_size < 4000000) {
                            $image_new_name = uniqid("", true) . "-" . $file_name;
                            $target = './layout/images/' . $image_new_name;

                        // echo $file_tmp_name. $image_new_name;

                    if (!empty($file_name)) {
                            

                            $stmtSign =$conn->prepare('INSERT INTO users (Username,Email,Password,Img,Date) VALUES(:name,:email,:password,:image,now())');

                            $stmtSign->bindParam(':name',$filterUser);
                            $stmtSign->bindParam(':email',$filterEmail);
                            $stmtSign->bindParam(':password',$hash);
                            $stmtSign->bindParam(':image',$image_new_name);

                            $stmtSign->execute();

                            if (move_uploaded_file($file_tmp_name, $target)); // to save file in target location
                            header('location:./login.php');
                            exit();
                        }
                    }           
                    else {
                        $errors[]= ' image size is too big';
                    }

                }
            }
        }   

    }
              
}

?>
<div class="container-fluid  log-sign">
<div class="container ">
    <div class="row d-flex justify-content-center align-items-center">

        <div class="col-md-6 " id="signUp-img">

        </div>
        <div class="col-md-6">
        <h1 class="text-center" id="login" >Sign Up</h1>
            <div class="signUp">
                <div class="container ">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">

                            <!-- uname input -->
                            <div class="form-outline">
                                <label class="form-label" for="uname">Username</label>
                                <input placeholder="Enter your Username" type="text" name="username" id="uname" class="form-control" autocomplete="off" required/>

                            </div>
                    
                            <!-- Email input -->
                            <div class="form-outline mb-4">

                                <label class="form-label" for="email">Email address</label>
                                <input placeholder="Enter your Email" type="email" name="email" id="email" class="form-control" />
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="password">Password</label>
                                <input placeholder="Enter your Password" type="password" minlength="8" maxlength="16" name="password" id="password" class="form-control" autocomplete="new-password" />
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="profile">Profile Pictue</label>
                                <input type="file" name="profile" class="form-control" id="profile">

                            </div>

                            <!-- Submit button -->
                            <div class="text-center">
                                <input type="submit" class="btn btn-primary btn-block mb-4" name="signup" value="Sign Up">

                            </div>
                            <!-- Register buttons -->
                            <div class="text-center">
                                <p>You Have An Account? <a href="./login.php">Sign in</a></p>
                            </div>
                    </form>

                        <?php if(!empty($errors)){
                            echo  '<div class="alert alert-danger">';
                                echo  '<ul>';
                                    foreach($errors as $er) :
                                    
                                        echo '<li>'. $er .'</li>';
                                        endforeach;
                                echo'</ul>';
                            echo '</div>';
                        }

                        ?>


            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php

ob_end_flush();
?>