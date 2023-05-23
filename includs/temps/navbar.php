<?php 
if (isset($_SESSION['user'])){

    $user = getUserbyId($_SESSION['ID']);
    

?>

<div class="header">

  <nav class="navbar navbar-expand-lg sticky <?php  if(isset($fixed_top)){ echo 'fixed-top'; } ?> r-nav" >
    <div class="container ">
      <!-- logo -->
      <a class="navbar-brand" href="index.php">
       <i>B&s</i> 
      </a>
      <!-- end logo --> 
      <!-- btn toggler --> 
      <button class="navbar-toggler" id="collapsedBtn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- end btn toggler -->
      <!-- collapse nav -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- main ul -->
        <ul class="navbar-nav d-flex justify-content-between  w-100 mb-2 mb-lg-0">
          
          <!-- midlle-nav -->

          <div class=" align-items-center  md  " >
              <!-- home link -->
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <!--end homelink -->
            <!--start About US link -->
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="aboutUs.php">About US</a>
            </li>
            <!--end About US link -->
            <!--start Services link -->
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php?#services">Services</a>
            </li>
            <!--end Services link -->
            <!--start profile link -->
              
            <li class="nav-item">
              <a class="nav-link"  href="profile.php">Profile</a>
            </li>

            <!-- end profile link -->
            <!--  categories link -->
            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="categories.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo lang('CATEGORIES')?>
              </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php  

                    $categories = getAllData('*','categories','WHERE Parent = 0' , '' , 'Cat_ID' ,'ASC' );

                    foreach($categories as $cat){ ?>
                  
                    <li>
                      <a class="dropdown-item" href="categories.php?Cat_ID=<?php echo $cat["Cat_ID"] ?>&category=<?php echo $cat["Name"]?>">
                        <?php echo $cat["Name"]?>
                      </a>
                      <ul>

                        <?php  
                          $catChildes = getAllData('*','categories','WHERE Parent ='.$cat["Cat_ID"] , '' , 'Cat_ID' ,'ASC' );
                          foreach($catChildes as $catChilde){ ?>
                          <li class="fs-6">               
                            <a class="dropdown-item" href="categories.php?Cat_ID=<?php echo $catChilde["Cat_ID"] ?>&category=<?php echo $catChilde["Name"]?>">
                            <?php echo $catChilde["Name"]?>
                            </a> 
                          </li>
                          <?php  } ?>
                      </ul>
                    </li>
                  
                  <?php  } ?>
                </ul>
            </li>
            <!--end  categories link -->
          </div>

          <div class="ed    justify-content-between align-items-center" id="colappsedEd">
          <!--user img link -->

          <li class="nav-item  margin-img ">
            <a href="profile.php">
              
              <?php echo issetImage($user["Img"]," nav-img rounded-circle","Profile image"); ?>
            </a>
          </li>

          <!--  end user image link -->
          <!--   user link update logout  -->

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php 
                if( isset($_SESSION['user'])and isset($_SESSION['Username'])){

                    echo $_SESSION['user'];

                  } elseif(isset($_SESSION['user'])){

                    echo $_SESSION['user'];
                  } elseif(isset($_SESSION['Username'])){

                    echo $_SESSION['Username'];
                  }else{
                    echo 'root';
                }
              ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="members.php?do=Edit&ID=<?php echo $_SESSION['ID'] ?>">Edit profile</a></li>
              <li><a class="dropdown-item" href="#">Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </li>
          <!--  end user link update logout  -->
          <!--  cart link   -->

          <li class="nav-item cart ">
            
            <a class="position-relative" href="shoppingCart.php?uId=<?= $_SESSION['ID'] ?>" class="nav-link">
              <i class="fa-solid fa-cart-shopping"></i> 
              <?php 
                $total = countQuantity($_SESSION['ID']);
                if( $total != 0 ){
              ?>
              <span class="count position-absolute  start-50 translate-middle badge border border-light rounded-circle bg-danger p-1">
                <strong>
                  <?php  echo $total; ?>
                </strong>
              </span>
              <?php } ?>

            </a>
          </li>
          <!--  cart link   -->
          </div>

        </ul>
        <!--end main ul -->

      
      </div>
      <!-- end collapse nav -->

    </div>
  </nav>

  <?php 

  }else{?> 
    <!-- not login user -->
    <nav class="navbar navbar-expand-lg sticky <?php  if(isset($fixed_top)){ echo 'fixed-top'; } ?> r-nav" >
      <div class="container">
        <a class="navbar-brand" href="index.php">B&S</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          
          <i class="fa-solid fa-bars-staggered"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav middle-bar d-flex justify-content-between  w-100 mb-2 mb-lg-0">
          <div class="md  align-items-center  ">
            <!-- home link -->
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <!--end homelink -->
          <!--start About US link -->
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="aboutUs.php">About US</a>
          </li>
          <!--end About US link -->
          <!--start Services link -->
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Services</a>
          </li>
          <!--end Services link -->

          <!--  categories link -->
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="categories.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             <?php echo lang('CATEGORIES')?>
            </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php  

                  $categories = getAllData('*','categories','WHERE Parent = 0' , '' , 'Cat_ID' ,'ASC' );

                  foreach($categories as $cat){ ?>
                
                  <li>
                    <a class="dropdown-item" href="categories.php?Cat_ID=<?php echo $cat["Cat_ID"] ?>&category=<?php echo $cat["Name"]?>">
                      <?php echo $cat["Name"]?>
                    </a>
                    <ul>

                      <?php  
                        $catChildes = getAllData('*','categories','WHERE Parent ='.$cat["Cat_ID"] , '' , 'Cat_ID' ,'ASC' );
                        foreach($catChildes as $catChilde){ ?>
                        <li class="fs-6">               
                          <a class="dropdown-item" href="categories.php?Cat_ID=<?php echo $catChilde["Cat_ID"] ?>&category=<?php echo $catChilde["Name"]?>">
                          <?php echo $catChilde["Name"]?>
                          </a> 
                        </li>
                        <?php  } ?>
                    </ul>
                  </li>
                
                <?php  } ?>
              </ul>
          </li>
          <!--end  categories link -->
          </div>
          <div class="ed lg-sp   justify-content-between align-items-center">
            <li class="nav-item">
              <a class="nav-link  " href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link border ps-3 " href="sign_up.php">Sign up</a>
            </li>
          </div>
          </ul>  
        </div>
      </div>
    </nav>
  <?php    } ?>