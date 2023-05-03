<?php

ob_start();
session_start();

if (isset($_SESSION['Username'])) {
    $pageTitle = 'Dashboard';
    $limitMumber = 3; //to use in function getLatest()
    $limitItem = 3; //to use in function getLatest()
    $limitComment = 5; //to use in function getLatest()
    include('init.php');

    $theLatestMembers =  getLatest('*', 'users', 'UserID', $limitMumber);
    $theLatestItems =  getLatest('*', 'items', 'Item_ID', $limitItem);
    //$theLatestComment =  getLatest('*', 'comments', 'CMT_ID', $limitComment);
    $stmt = $conn->prepare('SELECT comments.* , users.Username as Uname FROM comments INNER JOIN users ON users.UserID = comments.Member_ID' );
    $stmt->execute();
    $theLatestComment = $stmt->fetchAll();

?>
    <div class="container home-stats text-center">
        <h1 class="text-center"> welcome <?= $_SESSION['Username'] ?> </h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-total">
                    <i class="fa fa-users"></i>
                    <div class="info">
                        Total
                        <span><a href="members.php"><?php echo countItems('UserID', 'users') ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                    <i class="fa fa-plus"></i>
                    <div class="info">
                        pending Total
                        <span>
                            <a href="members.php?do=Manage&page=pending">
                            <?php echo checkItem('RegStatus', 'users', 0)  ?>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                    <i class="fa fa-tag"></i>
                    <div class="info">
                        Total items
                        <span><a href="items.php"><?php echo countItems('Item_ID', 'items') ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">
                    <i class="fa fa-comment"></i>
                    <div class="info">
                        Total comments
                        <span><a href="comment.php"><?php echo countItems('CMT_ID', 'comments') ?></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="card  mt-3">
                    <h5 class="card-header text-center">
                        <i class="fa fa-users"></i> latest <?= $limitMumber ?> 
                        Registerd Users 
                    </h5> 
                    <div class="card-body">

                        <div class="card-text">
                            <ul class="list-group list-latest">
                                <?php
                                foreach ($theLatestMembers as $latest) {
                                    echo '<li class="list-group-item list-group-item-action  d-flex justify-content-between align-items-center">';
                                    echo $latest['Username'] ;
                                    echo '<span>';
                                    if ($latest['RegStatus']==0 ):
                                       echo '<a href="members.php?do=Activate&ID='. $latest['UserID']. '" class="btn btn-primary me-1 rounded-pill activate">';
                                       echo '<i class="fa-solid fa-check"></i> Activate</a>';  
                                    endif;
                                    echo '<a href="members.php?do=Edit&ID='.$latest['UserID'].'">';
                                    echo '<button class="btn  btn-success rounded-pill"> <i class="fa fa-edit pe-1"></i>Edit</button>';
                                    echo '</a> ';

                                    echo '</span>';
                                    echo '</li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                    <span> Total Members: <?php echo countItems('UserID', 'users') ?></span>
                    </div>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="card text-center mt-3">
                    <h5 class="card-header">
                        <i class="fa fa-tag"></i> latest Items
                    </h5>
                    <div class="card-body">
                        <div class="card-text">
                        <ul class="list-group list-latest">
                                <?php
                                foreach ($theLatestItems as $latest) {
                                    echo '<li class="list-group-item list-group-item-action  d-flex justify-content-between align-items-center">';
                                    echo $latest['Name'] ;
                                    echo '<span>';
                                    if ($latest['Approve']==0 ):
                                       echo '<a href="items.php?do=Approve&item_ID='. $latest['Item_ID']. '" class="btn btn-primary me-1 rounded-pill activate">';
                                       echo '<i class="fa-solid fa-check"></i> Activate</a>';  
                                    endif;
                                    echo '<a href="items.php?do=Edit&item_ID='.$latest['Item_ID'].'">';
                                    echo '<button class="btn  btn-success rounded-pill"> <i class="fa fa-edit pe-1"></i>Edit</button>';
                                    echo '</a> ';

                                    echo '</span>';
                                    echo '</li>';
                                }
                                ?>
                            </ul>                            
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                      <span> Total Items: <?php echo countItems('Item_ID', 'items') ?></span>
                    </div>

                </div>
            </div>
            <!-- end items -->
            <!-- statr comment -->
            <div class="col-sm-6">
                <div class="card text-center mt-3">
                    <h5 class="card-header">
                        <i class="fa fa-comment"></i> latest comments
                    </h5>
                    <div class="card-body">
                        <div class="card-text">
                        <ul class="list-group list-latest">
                                <?php
                                foreach ($theLatestComment as $latest) {
                                    echo '<li class="list-group-item list-group-item-action  d-flex justify-content-between align-items-center">';
                                    echo $latest['Uname'].' :     '.$latest['Comment'] ;
                                    
                                    echo '<span>';
                                    if ($latest['Status']==0 ):
                                        
                                       echo '<a href="items.php?do=Approve&item_ID='. $latest['CMT_ID']. '" class="btn btn-primary me-1 rounded-pill activate">';
                                       echo '<i class="fa-solid fa-check"></i> Activate</a>';  
                                    endif;
                                    echo '<a href="items.php?do=Edit&CMT_ID='.$latest['CMT_ID'].'">';
                                    echo '<button class="btn  btn-success rounded-pill"> <i class="fa fa-edit pe-1"></i>Edit</button>';
                                    echo '</a> ';

                                    echo '</span>';
                                    echo '</li>';
                                }
                                ?>
                            </ul>                            
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                      <span> Total comments: <?php echo countItems('CMT_ID', 'comments') ?></span>
                    </div>

                </div>
            </div>

        </div>
    </div>
<?php
} else {
    header('location:index.php');
    exit();
}
include($temps . "/footer.php");
ob_end_flush();
?>