<?php 
if (isset($_SESSION['user'])){

    $user = getUserbyId($_SESSION['ID']);
    

?>

<nav class="navbar navbar-expand-lg navbar-light mb-5" >
  <div class="container">
    <a class="navbar-brand" href="index.php"><?php echo lang('HOME')?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        
            <?php
            ?>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link"  href="profile.php">Profile</a>
                </li>
            </ul>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="categories.php"
          id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php echo lang('CATEGORIES')?>
          </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php  

            $categories = getAllData('*','categories','' , '' , 'Cat_ID' ,'ASC' );

            foreach($categories as $cat){ ?>
              
                <li><a class="dropdown-item" href="categories.php?Cat_ID=<?php echo $cat["Cat_ID"] ?>&category=<?php echo $cat["Name"]?>"><?php echo $cat["Name"]?></a></li>
               
            <?php  } ?>
            </ul>
          </li>
        <li class="nav-item">
          <a href="profile.php">
            
            <?php echo issetImage($user["Img"]," nav-img rounded-circle","Profile image"); ?>
        </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php if( isset($_SESSION['user'])and isset($_SESSION['Username'])){

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
        <li class="nav-item cart">
          <a href="shoppingCart.php">
          <i class="fa-solid fa-cart-shopping"></i>
            
        </a>
        </li>
       
      </ul>


     
    </div>
  </div>
</nav>

<?php 

}else{?> 
  
<nav class="navbar navbar-expand-lg  ">
  <div class="container">
    <a class="navbar-brand" href="index.php"><?php echo lang('HOME')?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link h5" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="signup.php">Sign up</a>
        </li>
      </ul>  
        

     
    </div>
  </div>
</nav>
<?php    } ?>