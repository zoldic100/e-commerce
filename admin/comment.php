<?php

/*
manage members page
ADD | DELETE | EDIT  Comment from here
*/

session_start();

$pageTitle = "Comment";
if (isset($_SESSION['Username'])) {

    include('init.php');

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //start manage page
    if ($do == 'Manage') { //manage page

        $stmt = $conn->prepare('SELECT comments.* , items.Name as Iname, users.Username as Uname FROM comments INNER JOIN items ON items.Item_ID = comments.Item_ID INNER JOIN users ON users.UserID = comments.Member_ID ORDER BY CMT_ID DESC' );


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
                        <th scope="col">Comment</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Added Date</th>
                        <th scope="col">Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr class="table-light">
                            <td><?= $row['CMT_ID']  ?></td>
                            <td><?= $row['Comment']  ?></td>
                            <td><?= $row['Iname']  ?></td>
                            <td><?= $row['Uname']  ?></td>
                            <td><?= $row['CMT_date']  ?></td>
                            <td>
                                <a href="comment.php?do=Delete&comId=<?= $row['CMT_ID'] ?>" class="btn btn-danger confirm">
                                <i class="fa fa-edit"></i> Delete</a>
                                <a href="comment.php?do=Edit&comId=<?= $row['CMT_ID'] ?>" class="btn btn-success">
                                <i class="fa fa-close"></i> Edit</a>

                                <?php if($row['CMT_ID']!= 1): ?>
                                <a href="comment.php?do=Approve&comId=<?= $row['CMT_ID'] ?>" class="btn btn-primary activate">
                                <i class="fa-solid fa-check"></i> Approve</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                
            </table>


        </div>

        <?php 
      else: ?>
        <div class="container">
            <h1 class="alert alert-danger">Ther is no data to show </h1>
        </div>
          
        <?php endif;
    }elseif ($do == 'Edit') { // edit page

        // get the id from url
        $comId = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;
        // select all data depend of id
        $stmt = $conn->prepare("SELECT * FROM comments WHERE  CMT_ID =:comId  LIMIT 1");
        $stmt->bindParam(':comId', $comId);
        $stmt->execute();

        // fetch data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        // if error message
        if ($count > 0) { ?>
            <h1 class="text-center"> Edit Comment</h1>
            <div class="container">
                <form action="?do=Update" method="post" class="updateForm">
                    <input type="hidden" name="comId" value="<?= $comId ?>">
                    <!-- start username -->
                    <div class=" mb-3 row">
                        <label for="staticcomment" class="col-sm-2 col-form-label">Comment</label>
                        <div class="form-group col-sm-10 col-lg-6  ">
                            <input type="text" name="comment" class="form-control" id="staticcomment" value="<?= $row['Comment'] ?>" autocomplete="off" required>
                        </div>
                    </div>
                    <!-- end username  -->

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
            echo '<h1 class="text-center"> Update Comment</h1>';

            $id = $_POST['comId'];
            $comment = $_POST['comment'];
            
                

                $stmt = $conn->prepare("UPDATE comments SET Comment = :comment WHERE CMT_ID = :comId ");

                $stmt->bindParam(':comment', $comment);
                $stmt->bindParam('comId', $id);
                $stmt->execute();
                
                $msg= '<h1 class="text-center alert  alert-success">' . $stmt->rowCount() . ' Recored updated</h1>';
                redirectToHome($msg,'back');

            
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
        $comId = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;
        // select all data depend of id

        $check= checkItem('CMT_ID','comments',$comId);

        // if error message
        if ($check > 0) {         
            
        $stmt = $conn->prepare("DELETE  FROM comments WHERE  CMT_ID =:comId ");

        $stmt->bindParam('comId', $comId);

        $stmt->execute();

        $msg='<h1 class="text-center alert alert-success"> the operation success</h1>';
        redirectToHome($msg,'back');

          }else{
            
            $errorMsg = 'This id is Not Existe';
            redirectToHome($errorMsg,3);
            
          }
        echo '</div>';
    /*end $do =='Delete'*/
    }    elseif ($do == 'Approve') {

        echo '<div class="container">';
        echo '<h1 class="text-center alert alert-primary"> Approve</h1>';

            // get the id from url
            $comId = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;
        // select all data depend of id

        $check= checkItem('CMT_ID','comments',$comId);

        // if error message
        if ($check > 0) {         
            
        $stmt = $conn->prepare("Update comments SET Status = 1 WHERE  CMT_ID =:comId ");

        $stmt->bindParam('comId', $comId);

        $stmt->execute();

        $msg='<h1 class="text-center alert alert-success"> the operation success</h1>';
        redirectToHome($msg,'back');

        }else{
            
            $errorMsg = 'This id is Not Existe';
            redirectToHome($errorMsg,3);
    
        }
        echo '</div>';
    }/*end $do =='Approve'*/ 
include($temps . "/footer.php");

} else { // end isset($_SESSION['Username']

    header('location:index.php');
    exit();
}

