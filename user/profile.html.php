<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - Dashboard</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME ICONS STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM STYLES-->
    <link href="assets/css/style.css" rel="stylesheet" />
      <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a  class="navbar-brand" href="?home">VetMe.com.ng 

                </a>
            </div>

            <div class="notifications-wrapper">
<ul class="nav">
               
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">                                
                                <li>
                                    <a href="?whatis">What is VetMe</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="?contactus">Contact Us</a>
                                </li>
                                <li class="divider"></li>                                
                    </ul>
                </li>
              
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user-plus"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="?profile"><i class="fa fa-user-plus"></i> My Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="?logout"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <aside class= "leftSidebuttonLinks"><a href="" style="font-size: 11px; color:black;">Your Cart(You have <?php if(isset($_SESSION['cart'])){ echo(count($_SESSION['cart']));} else{ echo'0';} ?> requests in your cart)</a></aside>
                </li>
                <li>
                    <aside class= "leftSidebuttonLinks"><a href="?checkout" style="font-size: 11px; color:black;">Checkout</a></aside>
                </li>
                 <?php if(!isset($_SESSION['email'])):?>
                <li>                     
                    <div class="btn-group leftSidebuttonLinks">
                                              <button data-toggle="dropdown" class="btn btn-success dropdown-toggle">Welcome <span class="caret"></span></button>
                                              <ul class="dropdown-menu">
                                                <li><a href="?signup">Sign Up</a></li>
                                                <li class="divider"></li>
                                                <li><a href="?login">Log In</a></li>                                                                                               
                                                
                                              </ul>
                    </div>
                </li>
                <?php elseif (isset($_SESSION['email']) and dbContainsUser($_SESSION['email'],$_SESSION['password'])):?>
                <li>
                    <?php foreach($users as $user)
                    {
                        if($user['email']==$_SESSION['email'])
                        {
                            $GLOBALS['sname'] = $user['sname'];
                            $GLOBALS['fname'] = $user['fname'];
                            break;
                        }
                    }                      
                    ?>
                    <div class="btn-group leftSidebuttonLinks">
                                              <button data-toggle="dropdown" class="btn btn-success dropdown-toggle">Welcome <?php echo strtoupper($GLOBALS['sname'])." " .$GLOBALS['fname'];?> <span class="caret"></span></button>
                                              <ul class="dropdown-menu"> 
                                                <li><a href="?logout">Log Out</a></li>
                                              </ul>
                    </div>                
                <?php elseif (!adminIsLoggedIn()): ?>

                   <?php 
                        echo "<script>
                            alert('User hasbeen logged out.');
                            window.location.href='?logout';
                            </script>";
                        exit();
               
                    ?>
            
            <?php endif;?>
            </ul>
            </div>
        </nav>
        <!-- /. NAV TOP  -->
        <nav  class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <div class="user-img-div">
                            <img src="assets/img/user.jpg" class="img-circle" />

                           
                        </div>

                    </li>
                     <li>
                        <?php if(isset($GLOBALS['username'])):?>
                            <a  href="#"> <strong> <?php echo $GLOBALS['username'];?> </strong></a>
                        <?php endif;?>
                    </li>                   
                </ul>
            </div>

        </nav>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">
                            <?php if(isset($GLOBALS['username'])):?>
                            <strong> <?php echo $GLOBALS['username'];?> </strong>
                            - USER PROFILE
                            <?php endif;?>
                        </h1>
                    </div>
                </div>
                
                

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            User Information
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#home-pills" data-toggle="tab">Home</a>
                                </li>
                                <li class=""><a href="#profile-pills" data-toggle="tab">Profile</a>
                                </li>
                                <li class=""><a href="#messages-pills" data-toggle="tab">Messages</a>
                                </li>                               
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="home-pills">
                                    <h4>Welcome <strong><?php htmlout($GLOBALS['username']);?></strong></h4>
                                    
                                    <p>User Link: <strong>https://vetme.com.ng/?view=<?php htmlout($_SESSION['userid']);?></strong>
                                    
                                    <p>Total Vets: <strong><?php htmlout($GLOBALS['myVets']);?></strong></p>
                                </div>
                                <div class="tab-pane fade" id="profile-pills">
                                    <h4>Profile Tab</h4> <a href="?userProfile" class="btn btn-info btn-xs">Edit Profile</a>
                                    <p>User ID : <strong><?php htmlout($_SESSION['userid']);?></strong></p>
                                    <p>Registration Date: <?php htmlout($GLOBALS['regDate']);?></p>
                                    <p>My Skills</p>
                                    <ul>
                                        <?php foreach($skills as $skill):?>
                                            <?php foreach($mySkills as $skillid):?>
                                                <?php if($skill['id']==$skillid):?>
                                                 <li><?php htmlout($skill['skill']);?></li>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        <?php endforeach;?>
                                        <form action="" method="post">
                                         <button name="vet" value="<?php htmlout($_SESSION['userid']);?>" type="submit" class="btn btn-primary">Vet</button>
                                        </form>                                        
                                    </ul>

                                </div>
                                <div class="tab-pane fade" id="messages-pills">
                                    <h4>Messages Tab <form action="" method="post"><a href="?clearMsg" class="btn btn-danger btn-xs" name="clearMsg">Clear All</a></form></h4>
                                        <?php if(isset($messages) and count($messages)>0):?>
                                            <ul>
                                                <?php foreach($messages as $message):?>
                                                    <?php if($message['userid']==$_SESSION['userid']):?>
                                                    <form action="" method="post">
                                                        <li><?php htmlout($message['content']." ".$message['date']);?> 
                                                            
                                                            <button name="msgid" value="<?php htmlout($message['id']);?>" class="btn btn-danger btn-xs">x</button>
                                                        </li>
                                                    </form>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            </ul>
                                        <?php endif;?>
                                </div>
                               
                            </div>
                            <div class="modal fade" id="successmodal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Vet Prompt</h4>
                                    </div>
                                        <div class="modal-body">
                                        <p><?php htmlout($msg);?></p>                     
                                        </div>    
                                    </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-4">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Information Panel
                        </div>
                        <div class="panel-body">
                            <p>Share your <strong><a href="https://vetme.com.ng/?view=<?php htmlout($_SESSION['userid']);?>">User Link</a></strong> on your social media pages to get your friends to vet you</p>
                        </div>
                        <div class="panel-footer">
                            <a href="?whatis">About VetMe</a>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row">
                
               
            </div>
            </div>     
        </div>
        </div>
    </div>
    <!-- /. WRAPPER  -->
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/footer.html.php';?>
    </footer>
    <!-- /. FOOTER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    <?php
    if(isset($_POST['vet']))
        { ?>
    <script type="text/javascript"> $('#successmodal').modal('show'); </script>
    <?php } ?>

</body>
</html>
