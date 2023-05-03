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
 <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="login" method="POST">
     <h4 class="text-center">Admin Login</h4>
     <input class="form-control " type="text" name="user" value="<?php echo isset($_POST['user'])?$_POST['user']:'';?>" id="" placeholder="username" autocomplete="off" autofocus>
     <input class="form-control" type="password" name="pass"  id="" placeholder="password" autocomplete="new-password">
     <div class="d-grid ">
        <?php if(isset($message)){?>
        <span class="text-center alert alert-danger">
        <?php echo $message; };?>
       </span>
         <input class="btn btn-primary " type="submit" value="Login ">
     </div>
 </form>

 <?php

    include($temps . "/footer.php");
