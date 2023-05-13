<?php
ob_start();
/*
manage Categories page
ADD | DELETE | EDIT  Categories from here
*/

session_start();

$pageTitle = "Categories";
if (isset($_SESSION['Username'])) {

    include('init.php');

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //start manage page
    if ($do == 'Manage') { //manage page  

        $sort = 'DESC';
        $sort_array = ['DESC','ASC'];
        //check if the admn the sorting asc or desc
        (isset($_GET['sort'])&& in_array(($_GET['sort']),$sort_array))? $sort=$_GET['sort']: $sort = 'ASC';
 
        $categories =getAllData('*','categories','WHERE Parent =0'  , '' , 'Cat_ID',$sort);
        
        ?>

        <div class="container categorie">
            <h1 class="text-center ">Welcome To Categorie Page</h1>;
            <div class="ordering  d-flex justify-content-around border rounded-pill me-auto ms-auto pt-2 w-75">
                <h2>Ordering</h2>
                <div class="upDown mt-1">
                <a class="<?php echo ($sort== 'ASC')?'active':""; ?>" href="?sort=ASC"><i class="fa-solid fa-arrow-up"></i></a>
                <a class="<?php echo ($sort== 'DESC')?'active':""; ?>" href="?sort=DESC"><i class="fa-solid fa-arrow-down"></i></a>
                </div>
            </div>
                <div class="row mt-2  ">
                    <?php foreach ($categories as $categorie) :
                        
                        ?>
                        
                            <div class="col-md-6 mb-3 d-flex align-items-stretch ">
                                <div class="card w-100">
                                    <div class="card-header text-center ">
                                        <h3 class=""><?= $categorie['Name']  ?></h3>
                                    </div>
                                    
                                    <div class="card-body ">
                                        <ul>
                                            <li><?php echo $categorie['Description']? 'Description : '. $categorie['Description']:'This categorie has no  description yet';  ?></li>
                                            <?php echo $categorie['Visibility']==1 ? '<li class=visibility>Hidden </li>':'';  ?>
                                            <?php echo $categorie['Allow_Comment']==1 ? '<li class=commenting> Comment Disable </li> ':'';  ?>
                                            <?php echo $categorie['Allow_Ads']==1 ? '<li class=ads> Ads Disable </li>':'';  ?>
                                            <?php $childCats =getAllData('*','categories','WHERE Parent ='.$categorie['Cat_ID']  , '' , 'Cat_ID','DESC');
                                            if(!empty($childCats)){echo '<li class="fw-bold">Category Branches</li>';}?>
                                            <ol class="list-group list-group-numbered">
                                            <?php foreach($childCats as $childCat): ?>
                
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold"><?php echo $childCat['Name']  ?></div>
                                                        <?php echo $childCat['Description']  ?>
                                                    </div>
                                                    <div class='category-link'>
                                                        <a href="?do=Edit&catID=<?= $childCat['Cat_ID'] ?>" 
                                                        class="badge bg-success rounded-pill">Edit
                                                        </a>  
                                                        <a href="?do=Delete&catID=<?= $childCat['Cat_ID'] ?>" 
                                                        class="badge bg-danger rounded-pill">Delete
                                                        </a>  
                                                    </div>
                                                </li>
                                                <br>
                                            <?php endforeach; ?>
                                                </ol>
                                            
                                        </ul>
                                    </div>
                                    <div class="card-footer">
                                        <div class="buttons d-flex justify-content-between">
                                            <a href="?do=Edit&catID=<?= $categorie['Cat_ID'] ?>" class="btn btn-success">Edit<i class="fa fa-edit ps-2"></i></a>
                                            <a href="?do=Delete&catID=<?= $categorie['Cat_ID'] ?>" class="btn btn-danger"><i class="fa fa-close  pe-2"></i>Delete</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    
                    <?php endforeach ?>
                 </div>

                <a class="text-center btn btn-primary ms-4" href="categories.php?do=Add">
                    <i class="fa fa-plus"></i> Add NEW Categorie
                </a>

        </div>

        <?php
        /*end $do =='Manage'*/
    } elseif ($do == 'Add') {  ?>
        <div class="container">
          <h1 class="text-center"> Add New Categories</h1>

            <form action="?do=Insert" method="post" class="updateForm" enctype="multipart/form-data">

                <!-- start name -->
                <div class=" mb-3 row">
                    <label for="staticName" class="col-sm-2 col-form-label">Name </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <input type="text" name="name" class="form-control" id="staticName" autocomplete="off" placeholder="Name Of Categorie">
                    </div>
                </div>
                <!-- end name  -->
                <!-- start description -->
                <div class=" mb-3 row">
                    <label for="description" class="col-sm-2 col-form-label">Description </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <input type="text" name="description" class="form-control" id="description" autocomplete="off" placeholder="description">
                    </div>
                </div>
                <!-- end description  -->
                <!-- start Image -->
                <div class=" mb-3 row">
                    <label for="Image" class="col-sm-2 col-form-label">Image </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <input type="file" name="img" class="form-control" id="Image" autocomplete="off" placeholder="Image">
                    </div>
                </div>
                <!-- end Image  -->
                <!-- start parent -->
                <div class=" mb-3 row">
                    <label for="parent" class="col-sm-2 col-form-label">Parent </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <select class="form-select" name="parent" aria-label="Default select example">
                            <option value="0">...</option>
                            <option value="0">parent</option>
                            <?php             
                                $cats = getAllData('*','categories','WHERE Parent = 0'  , '' , 'Cat_ID','DESC');
                                foreach($cats as $cat){
                                    echo '<option value="'.$cat['Cat_ID'].'">'.$cat['Name'].'</option>';
                                }
                            ?>

                        </select>
                    </div>
                </div>
                <!-- end parent  -->
                <!-- start ordering  -->
                <div class="mb-3 row">
                    <label for="ordering" class="col-sm-2 col-form-label">Ordering</label>
                    <div class="form-group col-sm-10 col-lg-6 ">
                        <input type="text" name="ordering" class="form-control" id="ordering" placeholder="Number to Arrange The categorie">

                    </div>
                </div>
                <!-- end ordering  -->
                <!-- start Visibility field  -->
                <div class="mb-3 row">
                    <label class=" col-sm-2 col-form-label">Visible</label>
                    <div class=" form-group col-sm-10 col-lg-6 radios ">
                        <div class='form-check form-check-inline'>
                            <input type="radio" name="visibility" class="form-check-input" id="vs-yes" value="0" checked>
                            <label for="vs-yes" class="form-check-label">Yes</label>
                        </div>
                        <div class='form-check form-check-inline '>
                            <input type="radio" name="visibility" class="form-check-input" value="1" id="vs-no">
                            <label for="vs-yes" class="form-check-label">No</label>
                        </div>
                    </div>
                </div>
                <!-- end Visibility field  -->
                <!-- start commenting field  -->
                <div class="mb-3 row">
                    <label class=" col-sm-2 col-form-label  "> Allow Comment</label>
                    <div class=" form-group col-sm-10 col-lg-6 radios-next-line ">
                        <div class='form-check form-check-inline'>
                            <input type="radio" name="commenting" class="form-check-input" id="cm-yes" value="0" checked>
                            <label for="cm-yes" class="form-check-label">Yes</label>
                        </div>
                        <div class='form-check form-check-inline '>
                            <input type="radio" name="commenting" class="form-check-input" value="1" id="cm-no">
                            <label for="cm-yes" class="form-check-label">No</label>
                        </div>
                    </div>
                </div>
                <!-- end commenting field  -->
                <!-- start ads field  -->
                <div class="mb-3 row">
                    <label class=" col-sm-2 col-form-label ">Alow Ads</label>
                    <div class=" form-group col-sm-10 col-lg-6 radios ">
                        <div class='form-check form-check-inline'>
                            <input type="radio" name="ads" class="form-check-input" id="ads-yes" value="0" checked>
                            <label for="ads-yes" class="form-check-label">Yes</label>
                        </div>
                        <div class='form-check form-check-inline '>
                            <input type="radio" name="ads" class="form-check-input"  value="1"id="ads-no">
                            <label for="ads-yes" class="form-check-label">No</label>
                        </div>
                    </div>
                </div>
                <!-- end ads field  -->

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
    } elseif ($do == 'Insert') {
        // insert page
        echo '<div class="container">';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center alert  alert-success">Welcome</h1>';
            echo '<h1 class="text-center"> Insert Categorie</h1>';

            //upload file
            
            $imgName = $_FILES['img']['name'];
            $imgSize = $_FILES['img']['size'];
            $imgTmp = $_FILES['img']['tmp_name'];

            //list of allowed file

            $img_exe = ['jpeg','jpg','png'];

            $extension = pathinfo($imgName, PATHINFO_EXTENSION);


            $name = $_POST['name'];
            $description = $_POST['description'];
            $ordering = $_POST['ordering'];
            $parent = $_POST['parent'];
            $visibility = $_POST['visibility'];
            $commenting = $_POST['commenting'];
            $ads = $_POST['ads'];
            
            $errors = [];
            if (! empty($imgName ) && ! in_array($extension , $img_exe)) {
                $errors[] = ' Extention is not Allowed ';
            }
            if (empty($imgName ) ) {
                $errors[] = ' Image is required ';
            }
            if ($imgSize > 4194304 ) {
                $errors[] = ' Avatar can\'t be larger than 4 mb';
            }
    
            if(!empty($name) && empty($errors)){
                
                //add location to the image 
                $image = rand(0,100000000). '_'.$imgName;

                move_uploaded_file($imgTmp,'../layout/images/catImg/'.$image);
                //check if categorie existe

                $check = checkItem('Name', 'categories', $name);

                    if ($check > 0) {

                        $msg = '<h1 class="text-center alert  alert-danger">Sorry this categorie is already existe</h1>';
                        redirectToHome($msg, 'back');
                    } else {
                    

                        $stmt = $conn->prepare("INSERT INTO `categories` 
                                            ( `Parent`,`Name`, `Description`, `Image`, `Ordering`, `Visibility`,
                                                `Allow_Comment`, `Allow_Ads`) 
                                                VALUES (:parent ,:name, :description, :image, :ordering,:visibility, :commenting,:ads)");
                        

                        $stmt->bindParam(':parent', $parent);
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':image', $image);
                        $stmt->bindParam(':ordering', $ordering);
                        $stmt->bindParam(':visibility', $visibility);
                        $stmt->bindParam(':commenting', $commenting);
                        $stmt->bindParam(':ads', $ads);

                        $stmt->execute();

                        $msg = '<h1 class="text-center alert  alert-success">' . $stmt->rowCount() . ' Recored added</h1>';
                        redirectToHome($msg, 'back');
                    }
                }else {
                
                    $msg =  '<div class="alert alert-danger "> Categorie Name Is Required</div>';

                    redirectToHome($msg, 'back');
                
            }
        } else {
            
            $msg = '<h1 class="alert alert-danger text-center">Sorry You Cant Browse To This Page Directly</h1>';
            redirectToHome($msg, 'back');
        }
        echo '</div>';
        //end $do =='Insert'
    } elseif ($do == 'Edit') { // edit page
        // get the id from url
        $catID = isset($_GET['catID']) && is_numeric($_GET['catID']) ? intval($_GET['catID']) : 0;
        // select all data depend of id

        
        
        $categorie = getAllData('*','categories','WHERE Cat_ID ='.$catID   , '', 'Cat_ID','DESC','one');
        

        // if error message
        if (!empty($categorie)) { ?>
            <h1 class="text-center"> Edit Categorie</h1>
            <div class="container">
                <form action="?do=Update" method="post" class="updateForm">
                    <input type="hidden" name="catID" value="<?= $catID ?>">
                <!-- start name -->
                <div class=" mb-3 row">
                    <label for="staticName" class="col-sm-2 col-form-label">Name </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <input type="text" name="name" value="<?= $categorie['Name'] ?>" class="form-control" id="staticName" autocomplete="off" placeholder="Name Of Categorie" required>
                    </div>
                </div>
                <!-- end name  -->
                <!-- start description -->
                <div class=" mb-3 row">
                    <label for="description" class="col-sm-2 col-form-label">Description </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <input type="text" name="description" value="<?= $categorie['Description'] ?>" class="form-control" id="description" autocomplete="off" placeholder="description">
                    </div>
                </div>
                <!-- end description  -->
                <!-- start parent -->
                <div class=" mb-3 row">
                    <label for="parent" class="col-sm-2 col-form-label">Parent </label>
                    <div class="form-group col-sm-10 col-lg-6  ">
                        <select class="form-select" name="parent" aria-label="Default select example">
                            <option value="0">...</option>
                            <option value="0">parent</option>
                            <?php             
                                $cats = getAllData('*','categories','WHERE Parent = 0'  , '' , 'Cat_ID','DESC','all');
                                foreach($cats as $cat){
                                    echo '<option value="'.$cat['Cat_ID'].'"';
                                        if($categorie['Parent'] == $cat['Cat_ID'] ){echo "selected";}
                                    echo '>'.$cat['Name'].'</option>';
                                }
                            ?>

                        </select>
                    </div>
                </div>
                <!-- end parent  -->
                <!-- start ordering  -->
                <div class="mb-3 row">
                    <label for="ordering" class="col-sm-2 col-form-label">Ordering</label>
                    <div class="form-group col-sm-10 col-lg-6 ">
                        <input type="text" name="ordering" value="<?= $categorie['Ordering'] ?>" class="form-control" id="ordering" placeholder="Number to Arrange The categorie">

                    </div>
                </div>
                <!-- end ordering  -->
                <!-- start Visibility field  -->
                <div class="mb-3 row">
                    <label class=" col-sm-2 col-form-label">Visible</label>
                    <div class=" form-group col-sm-10 col-lg-6 radios ">
                        <div class='form-check form-check-inline'>
                            <input type="radio" name="visibility" class="form-check-input" id="vs-yes" value="0" <?php echo ($categorie['Visibility']==0)? 'checked':''; ?>>
                            <label for="vs-yes" class="form-check-label">Yes</label>
                        </div>
                        <div class='form-check form-check-inline '>
                            <input type="radio" name="visibility" class="form-check-input" value="1" id="vs-no" <?php echo ($categorie['Visibility']==1)? 'checked':''; ?>>
                            <label for="vs-yes" class="form-check-label">No</label>
                        </div>
                    </div>
                </div>
                <!-- end Visibility field  -->
                <!-- start commenting field  -->
                <div class="mb-3 row">
                    <label class=" col-sm-2 col-form-label  "> Allow Comment</label>
                    <div class=" form-group col-sm-10 col-lg-6 radios-next-line ">
                        <div class='form-check form-check-inline'>
                            <input type="radio" name="commenting" class="form-check-input" id="cm-yes" value="0" <?php echo ($categorie['Allow_Comment']==0)? 'checked':''; ?>>
                            <label for="cm-yes" class="form-check-label">Yes</label>
                        </div>
                        <div class='form-check form-check-inline '>
                            <input type="radio" name="commenting" class="form-check-input" value="1" id="cm-no" <?php echo ($categorie['Allow_Comment']==1)? 'checked':''; ?>>
                            <label for="cm-yes" class="form-check-label">No</label>
                        </div>
                    </div>
                </div>
                <!-- end commenting field  -->
                <!-- start ads field  -->
                <div class="mb-3 row">
                    <label class=" col-sm-2 col-form-label ">Alow Ads</label>
                    <div class=" form-group col-sm-10 col-lg-6 radios ">
                        <div class='form-check form-check-inline'>
                            <input type="radio" name="ads" class="form-check-input" id="ads-yes" value="0" <?php echo ($categorie['Allow_Ads']==0)? 'checked':''; ?>>
                            <label for="ads-yes" class="form-check-label">Yes</label>
                        </div>
                        <div class='form-check form-check-inline '>
                            <input type="radio" name="ads" class="form-check-input"  value="1" id="ads-no" <?php echo ($categorie['Allow_Ads']==1)? 'checked':''; ?>>
                            <label for="ads-yes" class="form-check-label">No</label>
                        </div>
                    </div>
                </div>
                <!-- end ads field  -->

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
        /*end $do =='Edit'*/
    } elseif ($do == 'Update') {
                // insert page
        echo '<div class="container">';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center alert  alert-success">Welcome</h1>';
            echo '<h1 class="text-center"> Update Categorie</h1>';

            $catID = $_POST['catID'];
            $parent = $_POST['parent'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $ordering = $_POST['ordering'];
            $visibility = $_POST['visibility'];
            $commenting = $_POST['commenting'];
            $ads = $_POST['ads'];

            if(!empty($name)){
                //check if categorie existe

                $check = checkItem('Name', 'categories', $name);



                        $stmt = $conn->prepare("UPDATE categories SET 
                                                 Parent = :parent, 
                                                 Name = :name, 
                                                 Description = :description, 
                                                 Ordering = :ordering, 
                                                 Visibility = :visibility, 
                                                 Allow_Comment = :commenting, 
                                                 Allow_Ads = :ads
                                                  WHERE Cat_ID = :id");
                        
                        
                        $stmt->bindParam('id', $catID);
                        $stmt->bindParam('parent', $parent);
                        $stmt->bindParam('name', $name);
                        $stmt->bindParam('description', $description);
                        $stmt->bindParam('ordering', $ordering);
                        $stmt->bindParam('visibility', $visibility);
                        $stmt->bindParam('commenting', $commenting);
                        $stmt->bindParam('ads', $ads);
                        $stmt->execute();

                        $msg = '<h1 class="text-center alert  alert-success">' . $stmt->rowCount() . ' Recored added</h1>';
                        redirectToHome($msg, 'back');
                    
                }else {
                
                    $msg =  '<div class="alert alert-danger "> Categorie Name ss Required</div>';

                    redirectToHome($msg, 'back');
                
            }
        } else {
            
            $msg = '<h1 class="alert alert-danger text-center">Sorry You Cant Browse To This Page Directly</h1>';
            redirectToHome($msg, 'back');
        }
        echo '</div>';

        /*end $do =='Update'*/
    } elseif ($do == 'Delete') {

        
        echo '<div class="container">';
        echo '<h1 class="text-center alert alert-danger"> Delete</h1>';



                // get the id from url
        $catid = isset($_GET['catID']) && is_numeric($_GET['catID']) ? intval($_GET['catID']) : 0;
        // select all data depend of id

        $check= checkItem('Cat_ID','categories',$catid);

        // if error message
        if ($check > 0) {         
            
        $stmt = $conn->prepare("DELETE  FROM categories WHERE  Cat_ID =:catid ");

        $stmt->bindParam('catid', $catid);

        $stmt->execute();

        $msg='<h1 class="text-center alert alert-success"> the operation success</h1>';
        redirectToHome($msg,'back');

          }else{
            
            $errorMsg = 'This id is Not Existe';
            redirectToHome($errorMsg,3);
            
          }
        echo '</div>';


        /*end $do =='Delete'*/
    }
    include($temps . "/footer.php");
} else { // end isset($_SESSION['Username']

    header('location:index.php');
    exit();
}

ob_end_flush();
?>