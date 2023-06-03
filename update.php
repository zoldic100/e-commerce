

<?php
  session_start();
  $pageTitle ='B&S';

  include('init.php');   
if(isset($_SESSION['ID'])){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
$imgName = $_FILES['img']['name'];
$imgSize = $_FILES['img']['size'];
$imgTmp = $_FILES['img']['tmp_name'];
//list of allowed file
$img_exe = ['jpeg','jpg','png'];
$extension = pathinfo($imgName, PATHINFO_EXTENSION);
//upload file
if(!empty($imgName)){


    if (! empty($imgName ) && ! in_array($extension , $img_exe)) {
        $errors[] = ' Extention is not Allowed ';
    }

    if ($imgSize > 4194304 ) {
        $errors[] = ' Avatar can\'t be larger than 4 mb';
    }
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
        if(!empty($imgName)){
        $image = rand(0,100000000). '_'.$imgName;

        move_uploaded_file($imgTmp,'layout/images/profile/'.$image);
        }else{
            $image = $_POST['inputImage'];
        }
        $pass = empty($_POST['newPass']) ? $_POST['oldPass'] : password_hash($input_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET Username = :username, Img = :img,  Password =:password, Email =:email, FullName =:full WHERE UserID = :userid ");

        $stmt->bindParam('username', $user);
        $stmt->bindParam('password', $pass);
        $stmt->bindParam(':img', $image);
        $stmt->bindParam('email', $email);
        $stmt->bindParam('full', $full);
        $stmt->bindParam('userid', $id);
        $stmt->execute();

        $success = 'The Update was successful';
        

   }
} else {
    foreach ($errors as $error) {
        echo  '<div class="alert alert-danger ">' . $error . '</div>';
    }
}
}

?>

<div class="container">
    <?php
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
                <form action="" method="post" class="updateForm" enctype="multipart/form-data">
                    <input type="hidden" name="userid" value="<?= $userid ?>">
                    <!-- start username -->
                    <div class=" mb-3 row">
                        <label for="staticUsername" class="col-sm-2 col-form-label">Username</label>
                        <div class="form-group col-sm-10 col-lg-6  ">
                            <input type="text" name="username" class="form-control" id="staticUsername" value="<?= $row['Username'] ?>" autocomplete="off" required>

                        </div>
                        
                    </div>
                    <!-- end username  -->
                    <!-- start img -->
                    <div class=" mb-3 row">
                        <label for="img" class="col-sm-2 col-form-label">Image</label>
                        <div class="form-group col-sm-10 col-lg-6  ">                            
                            <img class="rounded-circle" width="50" src="layout/images/profile/<?php echo $row['Img'] ?>" alt="<?php echo $row['Img'] ?>" />
                            <input type="text" name="inputImage" value="<?php echo $row['Img'] ?>">
                            <input type="file" name="img" class="form-control" id="img" value="<?php echo $row['Img'] ?>"  >
                        </div>
                    </div>
                    <!-- end img  -->
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
                <?php if (isset($success)) {?>
                    <p class="alert alert-success text-center"> <?= $success ?> </p>
                <?php }?>
            </div>
          <?php
            //else error message if there is no such id
        } 
        ?>     
</div>
<!-- end container -->

<?php 


include($temps . "/footer.php");


}else{?>
   <div class="alert alert-danger">You need to log in to create a product</div>  
<?php
}