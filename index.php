<?php
session_start();
$pageTitle = 'B&S';
$fixed_top="";
//$noNavBar ='';
include('init.php');
include($temps . "/hero.php");
// select all items 
$stmt = $conn->prepare('SELECT items.* , categories.Name AS Category_Name , users.Username AS Username FROM items INNER JOIN categories ON categories.Cat_ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID  WHERE items.Approve = 1 AND items.Rating = 5  ORDER BY Item_ID DESC');


$stmt->execute();

// fetch data
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  addToCarte($_POST['add_to_cart'], $_POST['price'], $_POST['itemid'], $_SESSION['ID']);
}

?>

<div class="container " id="aboutUs">
<section class="About r-p " id="About">
  <div class="container mt-5 mt-lg-0">
    <div class="row">
      <h1 class="text-center ">About us </h1>
      <div class="col-lg-6 col-12 d-flex align-items-center">
        <img src="layout/site-img/aboutUS.png" class="img-fluidimg-thumbnail rounded-4 w-100" width="400" alt="profil picture">
      </div>
      <div class="col-lg-6 col-12">
        
        <h4>Welcome to  <span class="word fw-bold"> store </span> ! </h4>
        <div class="aboutUs-text">
          
          
          <p> We offer high-quality products that enhance your everyday life,
            making online shopping convenient, enjoyable, and reliable. With a wide range of carefully curated 
            items from trusted brands, we prioritize
            customer satisfaction and provide personalized support for a seamless shopping experience.
          </p>
          <p>At B&S , we believe in fostering lasting relationships with our customers.
            Our user-friendly website makes it easy to browse, select, and purchase products with just a few clicks. With secure payment options and efficient shipping, you can have peace of mind knowing your order will arrive promptly and in perfect condition. Whether you're looking for the latest tech gadgets, trendy fashion accessories,
            home essentials, or unique gifts, we've got you covered.
          </p>
          <p>Thank you for choosing B&S. We appreciate your trust
            in us and look forward to serving you with excellence. Happy shopping!"
          </p> 
          <div class="icon text-center">
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="https://www.facebook.com/profile.php?id=100055673912503" target="_blank"><i class="fa-brands
                  fa-facebook"></i></a>
                <a href="https://www.instagram.com/1sword0/" target="_blank"><i class="fa-brands
                  fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-twitter" target="_blank"></i></a>
                <a href="#"><i class="fa-brands fa-twitch" target="_blank"></i></a>
              </li>
            </ul>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>
</div>
<div class="service" id='services'>
  <div class="container-fluid service home-page " >
  <div class="container">
  <div class="row text-center">
    <div class="col-6 col-md-3 ps-3">
      <div class="row">
        <div class="col-12">
        <i class="fa-solid fa-truck-fast"></i>
        </div>
        <div class="info ps-2">
          <h5>Fast Shipping</h5>
          <p>Get your items delivered quickly with our fast shipping service.</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3 ps-3">
      <div class="row">
        <div class="col-12">
        <i class="fa-solid fa-arrows-rotate"></i>
        </div>
        <div class="info ps-2">
          <h5>Easy Returns</h5>
          <p>Enjoy hassle-free returns with our easy return policy.</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3 ps-3">
      <div class="row">
        <div class="col-12">
        <i class="fa-solid fa-headset"></i>
        </div>
        <div class="info ps-2">
          <h5>24/7 Customer Support</h5>
          <p>Our dedicated team is available 24/7 to assist you with any queries or concerns.</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3 ps-3">
      <div class="row">
        <div class="col-12">
         <i class="fa-solid fa-bag-shopping"></i>
        </div>
        <div class="info ps-2">
          <h5>Secure Shopping</h5>
          <p>Shop with confidence knowing that your personal information is safe and secure.</p>
        </div>
      </div>
    </div>
  </div>
  </div>

  </div>
</div>
  <!-- start category area -->
  <div class="container-fluid home-page">
  <div class="row category mb-5  ">
    <h1 class="text-center">
      Categories
    </h1>
    <?php
    $categories = getAllData('*', 'categories', 'WHERE Parent = 0', '', 'CAT_ID', 'ASC', 'all');
    foreach ($categories as $cat) :
    ?>
      <div class="col-6 col-md-2 ms-auto me-auto  mb-3 ">
        <a href="./categories.php?Cat_ID=<?= $cat['Cat_ID'] ?>&category=<?= $cat['Name'] ?>">
          <div class="text-center cat-container">
            <div class="">
              <img src="./layout/images/catImg/<?= $cat['Image'] ?>" class="rounded-3" width="120px" hight="108px" alt="">
            </div>
            <div class="">
              <h5 class="card-title text-secondary pt-3"><?php echo $cat["Name"] ?></h5>
            </div>

          </div>
        </a>
      </div>
    <?php endforeach ?>
    <div class="show-more  text-end ">
      <a href="categories.php" class="btn btn-light mt-2 rounded-pill  ">show more ...</a>
    </div>
  </div>
  </div>


  <!-- end category area -->

  <!-- start product area -->
  <div class="container">
  <div class="row products home-page  " >
    <h1 class="text-center"id="best-products">
      best Products
    </h1>
    <a href="./showItem.php?item_ID=<?= $item["Item_ID"] ?>">
      <?php foreach ($items as $item) : ?>
    </a>
    <div class=" col-12 col-md-4 col-lg-3 mb-3 d-flex justify-content-evenly">
      <div class="card home-card mb-5">
        <a href="./showItem.php?item=<?php echo $item["Name"] ?>&item_ID=<?= $item["Item_ID"] ?>">
          <?php echo issetImage($item["Image"], 'home-img', 'Product'); ?>
        </a>
        <div class="card-body mb-5 " >

          <div class="d-flex  align-items-start">
            <div class="pe-1 ">
              <h5 class="card-title text-center"><?php echo $item["Name"] ?></h5>
            </div>
            <div class=" desc">

            </div>
          </div>

          <div class="d-flex  align-items-center">

            <p class="price"> <?php echo $item["Price"] ?>.00 DH</p>


          </div>
          <div class="d-flex  align-items-center">

            <p class="rating">Rating <?php echo $item["Rating"] ?></p>


          </div>

          <?php if ($item["Approve"] == 0) {
            echo '<p class="card-text">Not approve </p>';
          } else {
            if (!empty($sessionUser)) { ?>
         

              <div class="d-flex justify-content-between btns">
                <div class="buy">
                  <form action="buyNow.php" method="post">

                      <input type="hidden" name="price" value="<?php echo $item["Price"] ?>">
                      <input type="hidden" name="name" value="<?php echo $item["Name"] ?>">
                      <input type="hidden" name="itemid" value="<?php echo $item["Item_ID"] ?>">
                      <input type="hidden" name="memberid" value="<?php echo $item["Member_ID"] ?>">
                      <input type="hidden" name="img" value="<?php echo $item["Image"] ?>">
                      <input type="submit" class="btn btn-light  rounded-pill" name="buy" value="Buy Now">
                    </form>
                  
                </div>

                <!-- add to carte -->
                <div class="addToCart">
                  <form action="<?php echo $_SERVER['PHP_SELF'] ?> " method="post">

                    <input type="hidden" name="price" value="<?php echo $item["Price"] ?>">
                    <input type="hidden" name="itemid" value="<?php echo $item["Item_ID"] ?>">
                    <input type="hidden" name="memberid" value="<?php echo $item["Member_ID"] ?>">
                    <input type="submit" class="btn btn-light  rounded-pill" name="add_to_cart" value="Add to cart">
                  </form>
                </div>

              </div>
          <?php
            }else{?>
              <div class="d-flex justify-content-between btns">
                
                  <button  class="btn btn-light rounded-pill  Buy-now">Buy Now</button>            
                  <button class="btn btn-light  rounded-pill add-to-cart"> Add To cart</button>  
                </div>  
                
              
          <?php  
            }
          }
          ?>
 
          <div id="login-condition" >
            <p >Please login to add items to your cart.</p>
            <div class="btns">
              <button class="CloLog" id="close-button">Close</button>
              <button class="CloLog"><a href="login.php">login</a></button>
            </div>
          </div>
        </div>
        <!-- end card body -->
      </div>
      <!-- end card -->
    </div>

    <!-- end col -->
  <?php endforeach; ?>
  <!-- end foreach items -->
  </div>
  <!-- end row product -->

</div>

<!-- end container -->
<div class="container-fluid text-center feedback home-page mb-5">
  <h6>Feedback</h6>
  <h1>What Our Clients Say</h1>
  <div class="row d-flex justify-content-evenly">

    <div class="col-12 col-md-4 f1">
      <div class="text">
        <i class="fa-solid fa-quote-right"></i>
          <p>"The service provided by this company is outstanding. They were prompt, professional,
            and exceeded my expectations. I highly recommend them!"</p>
        </div>
         <div class="image-container">
          <img src="./client-img/Assouli.png" width="70" height="70" alt="Profile Image" class="rounded-circle">
          <figcaption class="text-dark pt-3 fw-bold">
            M.Assouli
          </figcaption>
        </div>
    </div>
    <div class="col-12 col-md-4 f2">
      <div class="text">
      <i class="fa-solid fa-quote-right"></i>
      <p>"I am extremely satisfied with the product I purchased from this company.
         It's of high quality and exactly what I was looking for. Great job!"</p>
        </div>
         <div class="image-container">
          <img src="./client-img/Moutachawik.png" width="70" height="70" alt="Profile Image" class="rounded-circle">
          <figcaption class="text-dark pt-3 fw-bold">
            R.Moutachawik
          </figcaption>
        </div>
        
    </div>
    <div class="col-12 col-md-4 f3">
      <div class="text">
    <i class="fa-solid fa-quote-right"></i>
      <p>"The customer support team went above and beyond to assist me with my inquiries.
         They were knowledgeable, friendly, and resolved my issue quickly. Thank you!"</p>
        </div>
         <div class="image-container">
          <img src="./client-img/Rmili.png" width="70" height="70" alt="Profile Image" class="rounded-circle">
          <figcaption class="text-dark pt-3 fw-bold">
            N.Rmili
          </figcaption>
        </div>
    </div>
    
  </div>
</div>


<?php
include($temps . "/footer.php");
