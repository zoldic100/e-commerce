<?php
ob_start();
/*
manage members page
ADD | DELETE | EDIT  MEMBERS from here
*/

session_start();

$pageTitle = "Items";
if (isset($_SESSION['Username'])) {

    include('init.php');

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //start manage page
    if ($do == 'Manage') { //manage page

        $stmt = $conn->prepare('SELECT items.* , categories.Name AS Category_Name , users.Username AS Username FROM items INNER JOIN categories ON categories.Cat_ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID ORDER BY Item_ID DESC' );

        $stmt->execute();
        $items = $stmt->fetchAll();
        if(!empty($items)):
        ?>

        <div class="container">
            <h1 class="text-center ">Welcome To Manage Page</h1>;

            <table class="main-table table table-dark table-bordered text-center">
                    <thead>
                        <tr class="">
                            <th scope="col">#ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">category</th>
                            <th scope="col">Owner</th>
                            <th scope="col"> Date</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr class="table-light">
                                <td><?= $item['Item_ID']  ?></td>
                                <td><?= $item['Name']  ?></td>
                                <td><?= $item['Description']  ?></td>
                                <td><?= $item['Price']  ?></td>
                                <td><?= $item['Category_Name']  ?></td>
                                <td><?= $item['Username']  ?></td>
                                <td><?= $item['Date']  ?></td>
                                <td>
                                    <a href="items.php?do=Delete&item_ID=<?= $item['Item_ID'] ?>" class="btn btn-danger confirm">
                                    <i class="fa fa-edit"></i> Delete</a>
                                    <a href="items.php?do=Edit&item_ID=<?= $item['Item_ID'] ?>" class="btn btn-success">
                                    <i class="fa fa-close"></i> Edit</a>
                                    <?php if($item['Approve']== 0): ?>
                                    <a href="items.php?do=Approve&item_ID=<?= $item['Item_ID'] ?>" 
                                    class="btn btn-primary activate">
                                    <i class="fa-solid fa-check"></i> Activate</a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                
            </table>

                <a class="text-center btn btn-primary " href="items.php?do=Add">
                    <i class="fa fa-plus"></i> Add NEW Item
                </a>
            </div>
            <?php 
      else: ?>
        <div class="container">
            <h1 class="alert alert-danger">Ther is no data to show </h1>
        </div>
          
        <?php endif;
    } elseif ($do == 'Add') {  ?>
        <div class="container">
          <h1 class="text-center"> Add New Item</h1>
        

            <form action="?do=Insert" method="post" class="updateForm" enctype="multipart/form-data">

                <!-- start name -->
                <div class=" mb-3 row">
                    <label for="staticName" class="col-sm-2 col-form-label">Name </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <input type="text" 
                            name="name" 
                            class="form-control" 
                            id="staticName"  
                            placeholder="Name Of Item"
                            required
                        >
                    </div>
                </div>
                <!-- end name  -->
                <!-- start image -->
                <div class=" mb-3 row">
                    <label for="staticimage" class="col-sm-2 col-form-label"> Item's Image </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <input type="file" 
                            name="img" 
                            class="form-control" 
                            id="staticimage"  
                            placeholder="image Of Item"
                            required
                        >
                    
                    </div>
                </div>
                <!-- end image  -->
                <!-- start description -->
                <div class=" mb-3 row">
                    <label for="description" class="col-sm-2 col-form-label">Description </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <input type="text"
                            name="description" 
                            class="form-control" 
                            id="description" 
                            placeholder="Description of the item"
                            required
                        >
                    </div>
                </div>
                <!-- end description  -->
                <!-- start price -->
                <div class=" mb-3 row">
                    <label for="price" class="col-sm-2 col-form-label">Price </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <input type="text"
                            name="price" 
                            class="form-control" 
                            id="price" 
                            autocomplete="off" 
                            placeholder="Enter Item Price "
                            required
                        >
                    </div>
                </div>
                <!-- end price  -->
                <!-- start country -->
                <div class=" mb-3 row">
                    <label for="country" class="col-sm-2 col-form-label">Country </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <input type="text"
                            name="country" 
                            class="form-control" 
                            id="country"  
                            placeholder="The country of origin "
                            required
                        >
                    </div>
                </div>
                <!-- end country  -->
                
                <!-- start status -->
                <div class=" mb-3 row">
                    <label for="status" class="col-sm-2 col-form-label">Status </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                    <select  id="status" name="status" class="form-select form-select"
                     aria-label=".form-select-sm example"
                     required>
                        <option selected value="0">...</option>
                        <option value="1">New</option>
                        <option value="2">Like New</option>
                        <option value="3">Used</option>
                        <option value="4">Old</option>
                    </select>                           
                    </div>
                </div>
                <!-- end status  -->
                <!-- start member -->
                <div class=" mb-3 row">
                    <label for="member" 
                        class="col-sm-2 col-form-label">Member 
                    </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                    <select  id="member" name="member" class="form-select form-select"
                     aria-label=".form-select-sm example"
                     required>
                        <option selected value="0">...</option>
                        <?php 

                        $users =getAllData('*', 'users', '' , '' , 'UserID' , 'ASC', 'all' );
                        foreach ($users as $user):
                        ?>
                        <option value="<?= $user['UserID']?>"><?= $user['Username']?></option>
                        <?php endforeach; ?>
                    </select>                           
                    </div>
                </div>
                <!-- end member  -->
                <!-- start category -->
                <div class=" mb-3 row">
                    <label for="category" 
                        class="col-sm-2 col-form-label">Category 
                    </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                    <select  id="category" name="category" class="form-select form-select"
                     aria-label=".form-select-sm example"
                     required>
                        <option selected value="0">...</option>
                        <?php 

                        $categories =getAllData('*', 'categories', 'WHERE Parent = 0' , '' ,'Cat_ID' , 'ASC', 'all' );

                        foreach ($categories as $category):
                        ?> 
                        <option class="fw-bold" value="<?= $category['Cat_ID']?>"><?= $category['Name']?></option>
                                <?php 
                                    $childCats =getAllData('*', 'categories', 'WHERE Parent ='.$category['Cat_ID'] , '' ,'Cat_ID' , 'ASC', 'all' );

                                    foreach ($childCats as $childCat):
                                ?>
                                 <option class="text-muted ms-2" value="<?= $childCat['Cat_ID']?>">
                                 <span class="text-muted ms-2">-</span>
                                    <?= $childCat['Name']?>
                                </option>
                     

                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </select>                         
                    </div>
                </div>
                <!-- end category  -->
                <!-- start tag  -->
                <div class=" mb-3 row">
                  <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                  <div class="form-group col-sm-10 col-lg-6">
                    <input type="text"
                      name="tags" 
                      class="form-control" 
                      id="tags"                        
                    >
                  </div>
                </div>
                
                <!-- end tag  -->

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
        
      /*end $do =='Add'*/
    }  elseif ($do == 'Insert') { // insert page
        echo '<div class="container">';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center alert  alert-success">Welcome</h1>';
            echo '<h1 class="text-center"> Insert Item</h1>';

            //upload file
            
            $imgName = $_FILES['img']['name'];
            $imgSize = $_FILES['img']['size'];
            $imgTmp = $_FILES['img']['tmp_name'];

            //list of allowed file

            $img_exe = ['jpeg','jpg','png'];

            $extension = pathinfo($imgName, PATHINFO_EXTENSION);

            
            

            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $member = $_POST['member'];
            $category = $_POST['category'];            
            $data = json_decode($_POST['tags'], true); // decode the JSON into an associative array
            
            $output = array(); // create an empty array to store the output
            
            foreach ($data as $item) {
                $output[] = $item['value']; // add each item's "value" to the output array
            }
            
            $tags = implode(',', $output); // join the output array with an empty string
            
            echo $tags ; // bal,bali,discount
            

            
            $errors = [];
            
            if (empty($name)) {
                $errors[] = ' Name Can\'t Be Empty ';
            }
            if (empty($description)) {
                $errors[] = ' Description Can\'t Be Empty ';
            }
            if (empty($price)) {
                $errors[] = ' Price Can\'t Be Empty ';
            }
            if (empty($country)) {
                $errors[] = ' country Can\'t Be Empty ';
            }
            if ($status == 0 ) {
                $errors[] = ' You must choose the status ';
            }
            if ($member == 0 ) {
                $errors[] = ' You must choose the member ';
            }
            if ($category == 0 ) {
                $errors[] = ' You must choose the category ';
            }
            if (! empty($imgName ) && ! in_array($extension , $img_exe)) {
                $errors[] = ' Extention is not Allowed ';
            }
            if (empty($imgName ) ) {
                $errors[] = ' Image is required ';
            }
            if ($imgSize > 4194304 ) {
                $errors[] = ' Avatar can\'t be larger than 4 mb';
            }

          

            if (empty($errors)) {

                //handel the uploded file 

                $image = rand(0,100000000). '_'.$imgName;

                move_uploaded_file($imgTmp,'../layout/images/'.$image);

                $stmt = $conn->prepare("INSERT INTO `items` (`Name`, `Description`,`Tags`, `Price`, `Date`, `Country_Origin`, `Image`, `Status`, `Rating`, `Member_ID`, `Cat_ID`)VALUES (:name,:description,:tags ,:price,now(),:country,:img,:status,'null',:member,:category)");

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':country', $country);
                $stmt->bindParam(':img', $image);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':member', $member);
                $stmt->bindParam(':category', $category);
                $stmt->bindParam(':tags', $tags);

                $stmt->execute();

                $msg = '<h1 class="text-center alert  alert-success">' . $stmt->rowCount() . ' Recored added</h1>';
                redirectToHome($msg,'back');  
                
            } else {
                foreach ($errors as $error) {
                    $err =  '<div class="alert alert-danger ">' . $error . '</div>';
                    
                    echo $err;
                    
                }
                redirectToHome('','back',100); 
            }
        } else {
            echo $_SERVER['HTTP_REFERER'];
            $msg ='<h1 class="alert alert-danger text-center">Sorry You Cant Browse To This Page Directly</h1>';
            redirectToHome($msg);        }
        echo '</div>';
    
      //end $do =='Insert'
    }  elseif ($do == 'Edit') { 
        // edit page 

        // get the id from url
        $itemId = isset($_GET['item_ID']) && is_numeric($_GET['item_ID']) ? intval($_GET['item_ID']) : 0;
        // select all data depend of id
        $stmt = $conn->prepare("SELECT * FROM items WHERE  Item_ID =:itemId");
        $stmt->bindParam('itemId', $itemId);
        $stmt->execute();

        // fetch data
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        // if error message
        if ($count > 0) { ?>
            <h1 class="text-center"> Edit Items</h1>
            <div class="container">
                <form action="?do=Update" method="post" class="updateForm">
                    <input type="hidden" name="itemId" value="<?= $itemId ?>">
                    <!-- start name -->
                    <div class=" mb-3 row">
                        <label for="staticName" class="col-sm-2 col-form-label">Name </label>
                        <div class="form-group col-sm-10 col-lg-6  ">
                            <input type="text" 
                                name="name" 
                                class="form-control" 
                                id="staticName"  
                                placeholder="Name Of Item"
                                value="<?= $item['Name'] ?>"
                                required
                            >
                        </div>
                    </div>
                    <!-- end name  -->
                    <!-- start description -->
                    <div class=" mb-3 row">
                        <label for="description" class="col-sm-2 col-form-label">Description </label>
                        <div class="form-group col-sm-10 col-lg-6  ">
                            <input type="text"
                                name="description" 
                                class="form-control" 
                                id="description" 
                                placeholder="Description of the item"
                                value="<?= $item['Description'] ?>"
                                required
                            >
                        </div>
                    </div>
                    <!-- end description  -->
                    <!-- start price -->
                    <div class=" mb-3 row">
                        <label for="price" class="col-sm-2 col-form-label">Price </label>
                        <div class="form-group col-sm-10 col-lg-6  ">
                            <input type="text"
                                name="price" 
                                class="form-control" 
                                id="price" 
                                autocomplete="off" 
                                placeholder="Enter Item Price "
                                value="<?= $item['Price'] ?>"
                                required
                            >
                        </div>
                    </div>
                    <!-- end price  -->
                    <!-- start country -->
                    <div class=" mb-3 row">
                        <label for="country" class="col-sm-2 col-form-label">Country </label>
                        <div class="form-group col-sm-10 col-lg-6  ">
                            <input type="text"
                                name="country" 
                                class="form-control" 
                                id="country"  
                                placeholder="The country of origin "
                                value="<?= $item['Country_Origin'] ?>"
                                required
                            >
                        </div>
                    </div>
                    <!-- end country  -->
                    <!-- start status -->
                    <div class=" mb-3 row">
                        <label for="status" class="col-sm-2 col-form-label">Status </label>
                        <div class="form-group col-sm-10 col-lg-6  ">
                        <select  id="status" name="status" class="form-select form-select"
                        aria-label=".form-select-sm example"
                        required>
                            <option <?php echo $item['Status']==1?'selected':'' ?> value="1">New</option>
                            <option <?php echo $item['Status']==2?'selected':'' ?> value="2">Like New</option>
                            <option <?php echo $item['Status']==3?'selected':'' ?> value="3">Used</option>
                            <option <?php echo $item['Status']==4?'selected':'' ?> value="4">Old</option>
                        </select>                           
                        </div>
                    </div>
                    <!-- end status  -->
                    <!-- start member -->
                    <div class=" mb-3 row">
                        <label for="member" 
                            class="col-sm-2 col-form-label">Member 
                        </label>
                        <div class="form-group col-sm-10 col-lg-6  ">
                        <select  id="member" name="member" class="form-select form-select"
                        aria-label=".form-select-sm example"
                        required>
                            <?php 
                            $stmt =$conn->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            foreach ($users as $user):
                            ?>
                            <option value="<?= $user['UserID']?>"<?php echo $item['Member_ID']==$user['UserID']?'selected':'' ?>><?= $user['Username']?></option>
                            <?php endforeach; ?>
                        </select>                           
                        </div>
                    </div>
                    <!-- end member  -->
                    <!-- start category -->
                    <div class=" mb-3 row">
                        <label for="category" 
                            class="col-sm-2 col-form-label">Category 
                        </label>
                        <div class="form-group col-sm-10 col-lg-6  ">
                        <select  id="category" name="category" class="form-select form-select"
                        aria-label=".form-select-sm example"
                        required>
                            <?php 
                            $stmt2 =$conn->prepare("SELECT * FROM categories");
                            $stmt2->execute();
                            $categories = $stmt2->fetchAll();
                            //transfer the $item['Tags'] from database item table
                            $str = $item['Tags'];
                            $arr = explode(",", $str); //convert strings to array
                            
                            foreach ($categories as $category):
                            ?>
                            <option value="<?= $category['Cat_ID']?>"
                            <?php echo $item['Cat_ID']== $category['Cat_ID']?'selected':'' ?>>
                            <?= $category['Name']?>
                            </option>
                            <?php endforeach; ?>
                        </select>                           
                        </div>
                    </div>
                    <!-- end category  -->
                                    <!-- start tag  -->
                <div class=" mb-3 row">
                  <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                  <div class="form-group col-sm-10 col-lg-6">
                    <input type="text"
                      name="tags" 
                      class="form-control" 
                      id="tags"  
                      value="<?php  
                      foreach($arr as $ar){
                        echo $ar.', ';
                      }
                       ?>"
                      
                    >
                  </div>
                </div>
                
                <!-- end tag  -->
                    <!-- submit  -->
                    <div class="mb-3 row">
                        <div class="offset-sm-6 offset-lg-4 col-sm-2">
                            <input type="submit" class="form-control btn btn-primary" value="Send">
                        </div>
                    </div>
                    <!-- end  -->
                </form>
                <?php
                $stmt = $conn->prepare('SELECT comments.* , users.Username as Uname FROM comments INNER JOIN users ON users.UserID = comments.Member_ID WHERE Item_ID =:itemId' );

                $stmt->bindParam('itemId', $itemId);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                if (!empty($rows)):
                ?>


                    <h1 class="text-center "> Manage <?= $item['Name'] ?>  Comment</h1>;

                    <table class="main-table table table-dark table-bordered text-center">
                        <thead>
                            <tr class="">
                                <th scope="col">Comment</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Added Date</th>
                                <th scope="col">Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row) : ?>
                                <tr class="table-light">
                                    <td><?= $row['Comment']  ?></td>
                                    <td><?= $row['Uname']  ?></td>
                                    <td><?= $row['CMT_date']  ?></td>
                                    <td>
                                        <a href="comment.php?do=Delete&comId=<?= $row['CMT_ID'] ?>" class="btn btn-danger confirm">
                                        <i class="fa fa-edit"></i> Delete</a>
                                        <a href="comment.php?do=Edit&comId=<?= $row['CMT_ID'] ?>" class="btn btn-success">
                                        <i class="fa fa-check"></i> Edit</a>

                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                        
                    </table>

                    <?php endif ?>



            </div>
          <?php
            //else error message if there is no such id
        } else {
             
            $msg = 'there is no sush id';
            redirectToHome($msg);
        }   
        //end  edit page

    } elseif ($do == 'Update') {
        echo '<div class="container">';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            echo '<h1 class="text-center alert  alert-success">Welcome</h1>';
            echo '<h1 class="text-center"> Update Item</h1>';


            $itemId = $_POST['itemId'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $member = $_POST['member'];
            $category = $_POST['category'];
            $data = json_decode($_POST['tags'], true); // decode the JSON into an associative array
            
            $output = array(); // create an empty array to store the output
            
            foreach ($data as $item) {
                $output[] = $item['value']; // add each item's "value" to the output array
            }
            
            $tags = implode(',', $output); // join the output array with an empty string
            
            echo $tags ; // bal,bali,discount

            
            $errors = [];
            
            if (empty($name)) {
                $errors[] = ' Name Can\'t Be Empty ';
            }
            if (empty($description)) {
                $errors[] = ' Description Can\'t Be Empty ';
            }
            if (empty($price)) {
                $errors[] = ' Price Can\'t Be Empty ';
            }
            if (empty($country)) {
                $errors[] = ' country Can\'t Be Empty ';
            }
            if ($status == 0 ) {
                $errors[] = ' You must choose the status ';
            }
            if ($member == 0 ) {
                $errors[] = ' You must choose the member ';
            }
            if ($category == 0 ) {
                $errors[] = ' You must choose the category ';
            }

            if (empty($errors)) {

                $stmt = $conn->prepare("UPDATE `items` SET `Item_ID` = :itemId, `Name` = :name, 
                `Tags` = :tags,
                `Description` = :description,
                 `Price` = :price, 
                  `Country_Origin` = :country, 
                  `Image` = 'Mbamppe', 
                  `Status` = :status, `Rating` = '4', 
                  `Member_ID` = :member, `Cat_ID` = :category
                   WHERE `items`.`Item_ID` = :itemId;");

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':country', $country);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':member', $member);
                $stmt->bindParam(':category', $category);
                $stmt->bindParam(':itemId', $itemId);
                $stmt->bindParam(':tags', $tags);

                $stmt->execute();

                $msg = '<h1 class="text-center alert  alert-success">' . $stmt->rowCount() . ' Recored Updated</h1>';
                redirectToHome($msg,'back');  
                
            } else {
                foreach ($errors as $error) {
                    $err =  '<div class="alert alert-danger ">' . $error . '</div>';
                    
                    echo $err;
                    
                }
                redirectToHome('','back',5); 
            }
        } else {
            echo $_SERVER['HTTP_REFERER'];
            $msg ='<h1 class="alert alert-danger text-center">Sorry You Cant Browse To This Page Directly</h1>';
            redirectToHome($msg);        }
        echo '</div>';

    } /*end $do =='Update'*/ elseif ($do == 'Delete') {

        echo '<div class="container">';
        echo '<h1 class="text-center alert alert-danger"> Delete</h1>';



                // get the id from url
        $itemId = isset($_GET['item_ID']) && is_numeric($_GET['item_ID']) ? intval($_GET['item_ID']) : 0;
        // select all data depend of id

        $check= checkItem('Item_ID','items',$itemId);

        // if error message
        if ($check > 0) {         
            
        $stmt = $conn->prepare("DELETE  FROM items WHERE  Item_ID =:itemId ");

        $stmt->bindParam('itemId', $itemId);

        $stmt->execute();

        $msg='<h1 class="text-center alert alert-success"> the operation success</h1>';
        redirectToHome($msg,'back');

          }else{
            
            $errorMsg = 'This id is Not Existe';
            redirectToHome($errorMsg,3);
            
          }
        echo '</div>';

    } /*end $do =='Update'*/ 
    elseif ($do == 'Approve') {

        echo '<div class="container">';
        echo '<h1 class="text-center alert alert-primary"> Approve</h1>';

            // get the id from url
        $itemId = isset($_GET['item_ID']) && is_numeric($_GET['item_ID']) ? intval($_GET['item_ID']) : 0;
        // select all data depend of id

        $check= checkItem('Item_ID','items',$itemId);

        // if error message
        if ($check > 0) {         
            
        $stmt = $conn->prepare("Update items SET Approve = 1 WHERE  Item_ID =:itemId ");

        $stmt->bindParam('itemId', $itemId);

        $stmt->execute();

        $msg='<h1 class="text-center alert alert-success"> the operation success</h1>';
        redirectToHome($msg,'back');

        }else{
            
            $errorMsg = 'This id is Not Existe';
            redirectToHome($errorMsg,3);
            
        }
        echo '</div>';
    }/*end $do =='Approve'*/ 
    else { // end isset($_SESSION['Username']

    header('location:index.php');
    exit();
}
include($temps . "/footer.php");

}
ob_end_flush();