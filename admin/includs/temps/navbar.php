<nav class="navbar navbar-expand-lg  ">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME')?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="dashboard.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories.php"><?php echo lang('CATEGORIES')?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="items.php"><?php echo lang('ITEMS')?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php"><?php echo lang('MEMBERS')?></a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="comment.php"><?php echo lang('COMMENTS')?></a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php echo isset($_SESSION['Username'])?$_SESSION['Username']:"root"?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../index.php">visit shop</a></li>
            <li><a class="dropdown-item" href="members.php?do=Edit&ID=<?php echo $_SESSION['ID'] ?>">Edit profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>
       
      </ul>
      
    </div>
  </div>
</nav>