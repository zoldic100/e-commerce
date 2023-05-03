<?php

/*
manage members page
ADD | DELETE | EDIT  MEMBERS from here
*/

session_start();

$pageTitle = "Members";
if (isset($_SESSION['Username'])) {

    include('init.php');

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //start manage page
    if ($do == 'Manage') { //manage page

        $stmt = $conn->prepare('SELECT * FROM users  WHERE GroupID !=1 ORDER BY UserID DESC' );


        if ((isset($_GET['page'])) && ($_GET['page']=='pending') ){

            $stmt = $conn->prepare('SELECT * FROM users WHERE GroupID !=1 And RegStatus = 0 ORDER BY UserID DESC' );

        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        
        if(!empty($rows)):
        ?>

        <div class="container">
            <h1 class="text-center ">Welcome To Manage Page</h1>;

            <table class="main-table table table-dark table-bordered text-center">
                <thead>
                    <tr class="">
                        <th scope="col">#ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Registered Date</th>

                        <th scope="col">Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr class="table-light">
                            <td><?= $row['UserID']  ?></td>
                            <td><?= $row['Username']  ?></td>
                            <td><?= $row['Email']  ?></td>
                            <td><?= $row['FullName']  ?></td>
                            <td><?= $row['Date']  ?></td>
                            <td>
                                <a href="members.php?do=Delete&ID=<?= $row['UserID'] ?>" class="btn btn-danger confirm">
                                <i class="fa fa-edit"></i> Delete</a>
                                <a href="members.php?do=Edit&ID=<?= $row['UserID'] ?>" class="btn btn-success">
                                <i class="fa fa-close"></i> Edit</a>

                                <?php if ($row['RegStatus']==0 && (isset($_GET['page'])) && ($_GET['page']=='pending')): ?>
                                <a href="members.php?do=Activate&ID=<?= $row['UserID'] ?>" class="btn btn-primary activate">
                                <i class="fa-solid fa-check"></i> Activate</a>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                
            </table>

            <a class="text-center btn btn-primary ms-4" href="members.php?do=Add">
                <i class="fa fa-plus"></i> Add NEW Member
            </a>

        </div>

      <?php 
      else: ?>
        <div class="container">
            <h1 class="alert alert-danger">Ther is no data to show </h1>
        </div>
          
        <?php endif;
    } elseif ($do == 'Add') {    ?>

        <h1 class="text-center"> Add Member</h1>
        <div class="container">
        
            <form action="?do=Insert" method="post" class="updateForm">

                <!-- start username -->
                <div class=" mb-3 row">
                    <label for="staticUsername" class="col-sm-2 col-form-label">Username</label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <input type="text" name="username" class="form-control" id="staticUsername" autocomplete="off" required placeholder="Username">
                    </div>
                </div>
                <!-- end username  -->
                <!-- start password  -->
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="form-group col-sm-10 col-lg-6 ">
                        <input type="password" name="password" class="password form-control" id="inputPassword" autocomplete="new-password" required placeholder="Password">
                        <i class="show-pass fa fa-eye fa-sm"></i>
                    </div>
                </div>
                <!-- end password  -->
                <!-- start Email  -->
                <div class="mb-3 row">
                    <label for="inputEmail" class=" col-sm-2 col-form-label">Email</label>
                    <div class=" form-group col-sm-10 col-lg-6 ">
                        <input type="Email" name="email" class="form-control" id="inputEmail" required placeholder="Email">
                    </div>
                </div>
                <!-- end Email  -->
                <!-- start Full Name -->
                <div class="mb-3 row">
                    <label for="Full_Name" class="col-sm-2 col-form-label">Full Name</label>
                    <div class=" form-group col-sm-10 col-lg-6 ">
                        <input type="text" name="full" class="form-control" id="Full_Name" required placeholder="Full-Name">
                    </div>
                </div>
                <!-- end Full  -->
                <!-- submit  -->
                <div class="mb-3 row">
                    <div class="offset-sm-6 offset-lg-4 col-sm-2">
                        <input type="submit" class="form-control btn btn-primary" value="Add">
                    </div>
                </div>
                <!-- end  -->
            </form>
        </div>
        <?php
    } /*end $do =='Add'*/ elseif ($do == 'Insert') { // insert page
        echo '<div class="container">';



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center alert  alert-success">Welcome</h1>';
            echo '<h1 class="text-center"> Insert Member</h1>';


            $user = $_POST['username'];
            $email = $_POST['email'];
            $full = $_POST['full'];
            $password = $_POST['password'];

            
            $errors = [];
            if (strlen($password) < 8) {
                $errors[] = 'Password cant Be less Than 8 Characters ';
            }
            if (strlen($password) > 16) {
                $errors[] = ' Password cant Be  more Than 15 Characters ';
            }
            if (strlen($user) < 4) {
                $errors[] = '  Password cant Be less Than 4 Characters ';
            }
            if (strlen($user) > 20) {
                $errors[] = ' Username cant Be  more Than 20 Characters ';
            }
            if (empty($user)) {
                $errors[] = ' Username is required ';
            }
            if (empty($full)) {
                $errors[] = ' Name is required ';
            }
            if (empty($email)) {
                $errors[] = ' Email is required ';
            }

            if (empty($errors)) {
                //check if user existe

                $check = checkItem('Username','users',$user);

                if($check>0){

                    $msg= '<h1 class="text-center alert  alert-danger">Sorry this user is existe</h1>';
                    redirectToHome($msg,'back');

                }else{

                //hash the password

                $pass = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT  INTO users( Username, Password, Email, RegStatus, FullName ,
                 Date) VALUES (:username, :password, :email,1, :full,now())");

                $stmt->bindParam(':username', $user);
                $stmt->bindParam(':password', $pass);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':full', $full);

                $stmt->execute();

                $msg = '<h1 class="text-center alert  alert-success">' . $stmt->rowCount() . ' Recored added</h1>';
                redirectToHome($msg,'back');  
                }
            } else {
                foreach ($errors as $error) {
                    $msg =  '<div class="alert alert-danger ">' . $error . '</div>';
                    
                    redirectToHome($msg,'back'); 
                }
            }
        } else {
               echo $_SERVER['HTTP_REFERER'];
            $msg ='<h1 class="alert alert-danger text-center">Sorry You Cant Browse To This Page Directly</h1>';
            redirectToHome($msg);        }
        echo '</div>';
    //end $do =='Insert'
     
    

    }elseif ($do == 'Edit') { // edit page

        // get the id from url
        $userid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        // select all data depend of id
        $stmt = $conn->prepare("SELECT * FROM users WHERE  UserID =:userid  LIMIT 1");
        $stmt->bindParam('userid', $userid);
        $stmt->execute();

        // fetch data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        // if error message
        if ($count > 0) { ?>
            <h1 class="text-center"> Edit Member</h1>
            <div class="container">
                <form action="?do=Update" method="post" class="updateForm">
                    <input type="hidden" name="userid" value="<?= $userid ?>">
                    <!-- start username -->
                    <div class=" mb-3 row">
                        <label for="staticUsername" class="col-sm-2 col-form-label">Username</label>
                        <div class="form-group col-sm-10 col-lg-6  ">
                            <input type="text" name="username" class="form-control" id="staticUsername" value="<?= $row['Username'] ?>" autocomplete="off" required>
                        </div>
                    </div>
                    <!-- end username  -->
                    <!-- start password  -->
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                        <div class="form-group col-sm-10 col-lg-6 ">
                            <input type="password" name="newPass" class="form-control"  autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change">

                            <input type="hidden" name="oldPass" value="<?php echo $row['Password'] ?>" class="form-control" id="inputPassword" autocomplete="new-password">
                        </div>
                    </div>
                    <!-- end password  -->
                    <!-- start Email  -->
                    <div class="mb-3 row">
                        <label for="inputEmail" class=" col-sm-2 col-form-label">Email</label>
                        <div class=" form-group col-sm-10 col-lg-6 ">
                            <input type="Email" name="email" class="form-control" value="<?= $row['Email'] ?>" id="inputEmail" required>
                        </div>
                    </div>
                    <!-- end Email  -->
                    <!-- start Full Name -->
                    <div class="mb-3 row">
                        <label for="Full_Name" class="col-sm-2 col-form-label">Full Name</label>
                        <div class=" form-group col-sm-10 col-lg-6 ">
                            <input type="text" name="full" class="form-control" value="<?= $row['FullName'] ?>" id="Full_Name" required>
                        </div>
                    </div>
                    <!-- end Full  -->
                    <!-- submit  -->
                    <div class="mb-3 row">
                        <div class="offset-sm-6 offset-lg-4 col-sm-2">
                            <input type="submit" class="form-control btn btn-primary" value="Update">
                        </div>
                    </div>
                    <!-- end  -->
                </form>
            </div>
          <?php
            //else error message if there is no such id
        } else {
             
            $msg = 'there is no sush id';
            redirectToHome($msg);
        }
    } elseif ($do == 'Update') {
        echo '<div class="container">';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center alert  alert-success">Welcome</h1>';
            echo '<h1 class="text-center"> Update Member</h1>';

            $id = $_POST['userid'];
            $user = $_POST['username'];
            $email = $_POST['email'];
            $full = $_POST['full'];
            $input_password = $_POST['newPass'];

            $pass = empty($_POST['newPass']) ? $_POST['oldPass'] : password_hash($input_password, PASSWORD_DEFAULT);

            $errors = [];
            if (!empty($input_password)){
              if (strlen($input_password) < 8) {
                $errors[] = 'Password cant Be less Than 8 Characters ';
              }
        
              if (strlen($input_password) > 16) {
                $errors[] = ' Password cant Be  more Than 15 Characters ';
              }
            }
            if (strlen($user) < 4) {
                $errors[] = '  Password cant Be less Than 4 Characters ';
            }
            if (strlen($user) > 20) {
                $errors[] = ' Username cant Be  more Than 20 Characters ';
            }
            if (empty($user)) {
                $errors[] = ' Username is required ';
            }
            if (empty($full)) {
                $errors[] = ' Name is required ';
            }
            if (empty($email)) {
                $errors[] = ' Email is required ';
            }

            if (empty($errors)) {

                

                $checkStmt = $conn->prepare("SELECT * FROM users  WHERE Username = :username AND UserID !=:id");
                $checkStmt->bindParam('username', $user);
                $checkStmt->bindParam('id', $id);
                $checkStmt->execute();

                $count = $checkStmt->rowCount();

                if ($count ==1){
                    $errorMsg ='<div class="alert alert-danger ">Sorry this username is already used</div>';

                    redirectToHome($errorMsg,3);
                }else{

                    $pass = empty($_POST['newPass']) ? $_POST['oldPass'] : password_hash($input_password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE users SET Username = :username, Password =:password, Email =:email, FullName =:full WHERE UserID = :userid ");

                    $stmt->bindParam('username', $user);
                    $stmt->bindParam('password', $pass);
                    $stmt->bindParam('email', $email);
                    $stmt->bindParam('full', $full);
                    $stmt->bindParam('userid', $id);
                    $stmt->execute();
                    
                    $msg= '<h1 class="text-center alert  alert-success">' . $stmt->rowCount() . ' Recored updated</h1>';
                    redirectToHome($msg,'back');
               }
            } else {
                foreach ($errors as $error) {
                    echo  '<div class="alert alert-danger ">' . $error . '</div>';
                }
            }
        } else {
                // redirect function
            $msg =  '<h1 class="text-center alert alert-warning">Sorry You Cant Browse To This Page Directly</h1>';
            redirectToHome($msg);
        }
        echo '</div>';
    } /*end $do =='Update'*/ elseif ($do == 'Delete') {

        echo '<div class="container">';
        echo '<h1 class="text-center alert alert-danger"> Delete</h1>';



                // get the id from url
        $userid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        // select all data depend of id

        $check= checkItem('UserID','users',$userid);

        // if error message
        if ($check > 0) {         
            
        $stmt = $conn->prepare("DELETE  FROM users WHERE  UserID =:userid ");

        $stmt->bindParam('userid', $userid);

        $stmt->execute();

        $msg='<h1 class="text-center alert alert-success"> the operation success</h1>';
        redirectToHome($msg,'back');

          }else{
            
            $errorMsg = 'This id is Not Existe';
            redirectToHome($errorMsg,3);
            
          }
        echo '</div>';
    }/*end $do =='Delete'*/
     elseif ($do == 'Activate') {

        echo '<div class="container">';
        echo '<h1 class="text-center alert alert-primary"> Activate</h1>';

                // get the id from url
        $userid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        // select all data depend of id

        $check= checkItem('UserID','users',$userid);

        // if error message
        if ($check > 0) {         
            
        $stmt = $conn->prepare("Update users SET RegStatus =1 WHERE  UserID =:userid ");

        $stmt->bindParam('userid', $userid);

        $stmt->execute();

        $msg='<h1 class="text-center alert alert-success"> the operation success</h1>';
        redirectToHome($msg,'back');

          }else{
            
            $errorMsg = 'This id is Not Existe';
            redirectToHome($errorMsg,3);
            
          }
        echo '</div>';
    }/*end $do =='Activate'*/
include($temps . "/footer.php");

} else { // end isset($_SESSION['Username']

    header('location:index.php');
    exit();
}

