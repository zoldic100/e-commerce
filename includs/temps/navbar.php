<?php 
if (isset($_SESSION['user'])){

    $user = getUserbyId($_SESSION['ID']);
    

?>

<div class="header">
  <nav class="navbar navbar-expand-lg " >
    <div class="container ">
      <!-- logo -->
      <a class="navbar-brand" href="index.php">
        <svg width="64" height="26" viewBox="0 0 64 26" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M10.6543 14.5576H4.44531L4.41211 10.9385H9.54199C10.4495 10.9385 11.1855 10.8278 11.75 10.6064C12.3255 10.3851 12.7461 10.0641 13.0117 9.64355C13.2773 9.21191 13.4102 8.68066 13.4102 8.0498C13.4102 7.3304 13.2773 6.74935 13.0117 6.30664C12.7461 5.86393 12.3255 5.54297 11.75 5.34375C11.1855 5.13346 10.4551 5.02832 9.55859 5.02832H6.4043V25H0.992188V0.828125H9.55859C11.0085 0.828125 12.3034 0.960938 13.4434 1.22656C14.5833 1.49219 15.5518 1.90169 16.3486 2.45508C17.1566 3.00846 17.7708 3.7002 18.1914 4.53027C18.612 5.36035 18.8223 6.33984 18.8223 7.46875C18.8223 8.45378 18.6009 9.3724 18.1582 10.2246C17.7266 11.0768 17.0293 11.7686 16.0664 12.2998C15.1035 12.8311 13.8141 13.1188 12.1982 13.1631L10.6543 14.5576ZM10.4385 25H3.06738L5.02637 20.8164H10.4385C11.2686 20.8164 11.9437 20.6836 12.4639 20.418C12.984 20.1523 13.3659 19.7926 13.6094 19.3389C13.8529 18.8851 13.9746 18.376 13.9746 17.8115C13.9746 17.1475 13.8584 16.5719 13.626 16.085C13.4046 15.598 13.0505 15.2217 12.5635 14.9561C12.0876 14.6904 11.4512 14.5576 10.6543 14.5576H5.80664L5.83984 10.9385H11.7666L13.0283 12.3662C14.5667 12.333 15.7952 12.582 16.7139 13.1133C17.6436 13.6335 18.3132 14.3197 18.7227 15.1719C19.1322 16.0241 19.3369 16.9261 19.3369 17.8779C19.3369 19.4495 18.9993 20.7666 18.3242 21.8291C17.6491 22.8805 16.6475 23.6719 15.3193 24.2031C14.0023 24.7344 12.3753 25 10.4385 25ZM26.2266 12.1836L31.124 9.0791C31.8102 8.63639 32.2474 8.21029 32.4355 7.80078C32.6348 7.39128 32.7344 6.95964 32.7344 6.50586C32.7344 6.01888 32.5573 5.5651 32.2031 5.14453C31.849 4.72396 31.3509 4.51367 30.709 4.51367C30.2441 4.51367 29.8512 4.61882 29.5303 4.8291C29.2204 5.03939 28.9824 5.32161 28.8164 5.67578C28.6615 6.01888 28.584 6.40072 28.584 6.82129C28.584 7.31934 28.7168 7.82845 28.9824 8.34863C29.2591 8.85775 29.6243 9.39453 30.0781 9.95898C30.5319 10.5234 31.041 11.1432 31.6055 11.8184L42.9775 25H37.1504L27.8701 14.3584C27.0954 13.3844 26.4202 12.488 25.8447 11.6689C25.2692 10.8499 24.821 10.0586 24.5 9.29492C24.179 8.52018 24.0186 7.72331 24.0186 6.9043C24.0186 5.63151 24.2952 4.51367 24.8486 3.55078C25.402 2.58789 26.1768 1.83529 27.1729 1.29297C28.18 0.750651 29.3643 0.479492 30.7256 0.479492C31.9984 0.479492 33.0996 0.739583 34.0293 1.25977C34.959 1.77995 35.6784 2.47168 36.1875 3.33496C36.6966 4.19824 36.9512 5.14453 36.9512 6.17383C36.9512 6.91536 36.8128 7.61263 36.5361 8.26562C36.2594 8.90755 35.8776 9.49967 35.3906 10.042C34.9147 10.5732 34.3669 11.0602 33.7471 11.5029L28.3184 15.3379C27.9974 15.6589 27.7484 15.9798 27.5713 16.3008C27.4053 16.6217 27.2891 16.9372 27.2227 17.2471C27.1562 17.557 27.123 17.8724 27.123 18.1934C27.123 18.8021 27.2503 19.3444 27.5049 19.8203C27.7594 20.2852 28.1136 20.6504 28.5674 20.916C29.0212 21.1816 29.5358 21.3145 30.1113 21.3145C31.0078 21.3145 31.8766 21.1152 32.7178 20.7168C33.57 20.3184 34.3281 19.7539 34.9922 19.0234C35.6562 18.293 36.182 17.4242 36.5693 16.417C36.9678 15.3988 37.167 14.2809 37.167 13.0635H41.5498C41.5498 14.3363 41.4225 15.5482 41.168 16.6992C40.9134 17.8392 40.5039 18.8962 39.9395 19.8701C39.375 20.833 38.6169 21.6852 37.665 22.4268C37.6097 22.471 37.5101 22.543 37.3662 22.6426C37.2334 22.7422 37.1338 22.8141 37.0674 22.8584C35.9606 23.6995 34.8317 24.3249 33.6807 24.7344C32.5407 25.1439 31.2402 25.3486 29.7793 25.3486C28.1634 25.3486 26.7633 25.0553 25.5791 24.4688C24.4059 23.8822 23.4984 23.0742 22.8564 22.0449C22.2145 21.0156 21.8936 19.8369 21.8936 18.5088C21.8936 17.557 22.0762 16.7269 22.4414 16.0186C22.8177 15.2992 23.3324 14.6351 23.9854 14.0264C24.6383 13.4066 25.3854 12.7923 26.2266 12.1836ZM58.0186 18.625C58.0186 18.2155 57.9577 17.8503 57.8359 17.5293C57.7142 17.1973 57.4928 16.8929 57.1719 16.6162C56.8509 16.3395 56.3971 16.0628 55.8105 15.7861C55.224 15.4984 54.4548 15.2051 53.5029 14.9062C52.4183 14.5521 51.3835 14.1536 50.3984 13.7109C49.4245 13.2572 48.5557 12.7314 47.792 12.1338C47.0283 11.5361 46.4251 10.8389 45.9824 10.042C45.5508 9.24512 45.335 8.31543 45.335 7.25293C45.335 6.22363 45.5618 5.29395 46.0156 4.46387C46.4694 3.63379 47.1058 2.92546 47.9248 2.33887C48.7438 1.74121 49.7067 1.28743 50.8135 0.977539C51.9202 0.656576 53.1377 0.496094 54.4658 0.496094C56.2367 0.496094 57.7917 0.811523 59.1309 1.44238C60.4811 2.06217 61.5326 2.93652 62.2852 4.06543C63.0378 5.18327 63.4141 6.48372 63.4141 7.9668H58.0352C58.0352 7.3138 57.8968 6.73828 57.6201 6.24023C57.3545 5.73112 56.945 5.33268 56.3916 5.04492C55.8493 4.75716 55.1686 4.61328 54.3496 4.61328C53.5527 4.61328 52.8831 4.73503 52.3408 4.97852C51.8096 5.21094 51.4056 5.5319 51.1289 5.94141C50.8633 6.35091 50.7305 6.79915 50.7305 7.28613C50.7305 7.6735 50.8301 8.02767 51.0293 8.34863C51.2396 8.65853 51.5384 8.95182 51.9258 9.22852C52.3242 9.49414 52.8112 9.7487 53.3867 9.99219C53.9622 10.2357 54.6208 10.4681 55.3623 10.6895C56.6572 11.099 57.8027 11.5527 58.7988 12.0508C59.806 12.5488 60.6527 13.1133 61.3389 13.7441C62.0251 14.375 62.5397 15.0889 62.8828 15.8857C63.237 16.6826 63.4141 17.5846 63.4141 18.5918C63.4141 19.6654 63.2038 20.6172 62.7832 21.4473C62.3737 22.2773 61.776 22.9857 60.9902 23.5723C60.2155 24.1478 59.2858 24.585 58.2012 24.8838C57.1165 25.1826 55.9046 25.332 54.5654 25.332C53.348 25.332 52.1471 25.1771 50.9629 24.8672C49.7786 24.5462 48.7051 24.0592 47.7422 23.4062C46.7904 22.7533 46.0267 21.9232 45.4512 20.916C44.8867 19.8978 44.6045 18.6914 44.6045 17.2969H50.0166C50.0166 18.0273 50.1217 18.6471 50.332 19.1562C50.5423 19.6543 50.8411 20.0583 51.2285 20.3682C51.627 20.6781 52.1084 20.8994 52.6729 21.0322C53.2373 21.165 53.8682 21.2314 54.5654 21.2314C55.3734 21.2314 56.0264 21.1208 56.5244 20.8994C57.0335 20.667 57.4098 20.3516 57.6533 19.9531C57.8968 19.5547 58.0186 19.112 58.0186 18.625Z" fill="#3D1010"/>
        </svg>
      </a>
      <!-- end logo --> 
      <!-- btn toggler --> 
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- end btn toggler -->
      <!-- collapse nav -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- main ul -->
        <ul class="navbar-nav d-flex justify-content-between  w-100 mb-2 mb-lg-0">
          <!-- home link -->
          <div class="md d-flex  ">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <!--end home link -->
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

                  $categories = getAllData('*','categories','' , '' , 'Cat_ID' ,'ASC' );

                  foreach($categories as $cat){ ?>
                
                  <li>
                    <a class="dropdown-item" href="categories.php?Cat_ID=<?php echo $cat["Cat_ID"] ?>&category=<?php echo $cat["Name"]?>">
                      <?php echo $cat["Name"]?>
                    </a>
                  </li>
                
                <?php  } ?>
              </ul>
          </li>
          <!--end  categories link -->
          </div>
          <div class="ed d-flex   justify-content-between align-content-between">
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

          <li class="nav-item cart">
            <a href="shoppingCart.php" class="nav-link">
              <i class="fa-solid fa-cart-shopping"></i> 
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
    <nav class="navbar navbar-expand-lg  ">
      <div class="container">
        <a class="navbar-brand" href="index.php"><?php echo lang('HOME')?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link " href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="signup.php">Sign up</a>
            </li>
          </ul>  
        </div>
      </div>
    </nav>
  <?php    } ?>