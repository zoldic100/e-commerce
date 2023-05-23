 <?php
session_start();
 $noNavBar ='';
 $pageTitle ='Login';
    if (isset($_SESSION['Username'])) {
        header('location:dashboard.php');
    }

    include('init.php');
  
   

    //check if user coming from http post reqest

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $username = $_POST['user'];
        $pass = $_POST['pass'];
        $options = [
            'cost' => 12, // the number of iterations to use for the hashing algorithm (higher is more secure)
        ];
       
        $stmt = $conn->prepare("SELECT UserID, Username,Password FROM users WHERE Username = :Username AND  GroupID = 1 LIMIT 1");

        $stmt->bindParam('Username', $username);

        
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        
        
        

        // if count > 0 mean these user is admin

        
          if ($row && password_verify($pass, $row['Password'])) {
         //user is an admin   
            
            $_SESSION['Username'] = $username;
            $_SESSION['ID'] = $row['UserID'];
            
            header('location:dashboard.php');
            exit();
            
          } else {
            $message= "Invalid username or password.";
        }
            
          
    }
    ?>
    <style>
        :root {
  --bg-color:#Ffff;
  --mean-color:#7b6dda;
  --heading-color-blue:blue;
  --nav-color:#d8e0ff;
}
        /*start login*/
.log-sign{
  background-color: var(--nav-color) !important;
  padding: 45px 0 200px ;
    }
    #login-img{
      background-image: url('admin-login.png');
      
      height: 90vh;
      
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center; 
    }
    @media (max-width: 767px) {
      #login-img {
        display: none;
      }
    }
  
   .login{
      width: 90%;
      height: 90%;
      margin: 0 auto;
      background-color:  #f6f6f6;;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0px 2px 10px 2px rgba(0,0,0,0.2);
      color:var(--mean-color);
    }
    #login{
      color: var(--mean-color) !important;
    }
  
   .login input {
      margin-bottom: 40px;
      height: 6vh;
   }
   .login input:focus {
    box-shadow: 0 0 15px 1px var(--mean-color );
   }
  
   .login .form-control{
      background-color:#EAEAEA;
      color: var(--mean-color);
   }
   .login label{
    padding-bottom: 7px;
    padding-left: 15px;
    font-size: 1.5rem;
    font-weight: bold;
   }
   .login .btn{
   background-color: var(--mean-color);
   color: #FFF;
   width: 100%;
   border: var(--nav-color);
   }
   .login .btn:hover{
    background-color: #2EE59D;
    box-shadow: 0px 15px 20px rgba(46, 229, 157, 0.4);
    color: #fff !important;
    transform: translateY(-7px);
    transition: all 0.5s;
    border: none;
   }
  /*end login*/
    </style>
 <div class="container-fluid log-sign">
     <div class="container ">
         <div class="row d-flex align-items-center justify-content-center ">

             <div class="col-md-6  " id="login-img">
                 <div></div>
                 <!-- <img src="layout/site-img/login_img.png" alt="login"> -->

             </div>
             <div class="col-md-6  ">
                 <h1 class="text-center " id="login">Admin Login</h1>
                 <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="login" method="POST">
                     
                     <input class="form-control  mt-4" type="text" name="user"
                         value="<?php echo isset($_POST['user'])?$_POST['user']:'';?>" id="" placeholder="username"
                         autocomplete="off" autofocus>
                     <input class="form-control" type="password" name="pass" id="" placeholder="password"
                         autocomplete="new-password">
                     <div class="d-grid ">
                         <?php if(isset($message)){?>
                         <span class="text-center alert alert-danger">
                             <?php echo $message; };?>
                         </span>
                         <input class="btn btn-primary " type="submit" value="Login ">
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <?php

    include($temps . "/footer.php");