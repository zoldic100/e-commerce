<?php
  session_start();
  $pageTitle ='B&S';

  include('init.php');   

if ($_SERVER['REQUEST_METHOD'] == 'POST') {



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

    move_uploaded_file($imgTmp,'layout/images/'.$image);

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


    
} else {
    foreach ($errors as $error) {
        $err =  '<div class="alert alert-danger ">' . $error . '</div>';
        
        echo $err;
        
    }
    
    }
}

?>

<div class="container">
          <h1 class="text-center"> Add New Item</h1>
        

            <form action="" method="post" class="updateForm" enctype="multipart/form-data">

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
<!-- end container -->

<?php 
include($temps . "/footer.php");
