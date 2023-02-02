<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - Orders</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <!-- FONTAWESOME ICONS STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM STYLES-->
    <link href="assets/css/style.css" rel="stylesheet" />
    <script src="vet.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
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
                 <?php if(!isset($_SESSION['loggedIn'])):?>
                 <li>
                   <aside class= "leftSidebuttonLinks"><a href="?signup" style="color:black;">SIGN UP</a></aside>
                </li>                     
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
                        <?php 
                            if(isLoggedIn())
                            {
                                foreach($users as $user)
                                {
                                    if($user['email']==$_SESSION['email'])
                                    {
                                        $GLOBALS['username'] = strtoupper($user['sname'])." " .$user['fname'];
                                        break;
                                    }
                                }   
                            }
                         ?>
                        <a  href="."> 
                            <?php if(isLoggedIn()):?>
                                    <strong> <?php htmlout($GLOBALS['username']);?> </strong>
                            <?php endif;?> 
                        </a>
                    </li>

                    <!-- <li>
                        <a   href="index.html"><i class="fa fa-dashboard "></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="ui.html"><i class="fa fa-venus "></i>UI Elements </a>
                        
                    </li>
                    
                    <li>
                        <a href="table.html"><i class="fa fa-bolt "></i>Data Tables </a>
                        
                    </li>
                   
                     
                     <li>
                        <a href="forms.html"><i class="fa fa-code "></i>Forms</a>
                    </li>
                   
                    <li>
                        <a href="#"><i class="fa fa-sitemap "></i>Multilevel Link <span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                            <li>
                                <a href="#"><i class="fa fa-cogs "></i>Second  Link</a>
                            </li>
                             <li>
                                <a href="#"><i class="fa fa-bullhorn "></i>Second Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third  Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Link</a>
                                    </li>

                                </ul>

                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="active-menu" href="blank.html"><i class="fa fa-dashcube "></i>Blank Page</a>
                    </li> -->
                   
                </ul>
            </div>

        </nav>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                         <h1 class="page-head-line" style="font face='Century Gothic',Serif;size:4;color:blue;">Vet<strong style="font face='Century Gothic',Serif;size:4;color:red;">Me</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php if(!isset($newRequest) or !$newRequest):?>

                        <?php if(isset($selectedUsers) and count($selectedUsers)>0):?>
                            <p>Order Total (N): <strong><?php htmlout($GLOBALS['OrderTotal']);?></strong></p>
                            <a href="?emptyCart" class="btn btn-danger btn-sm leftSidebuttonLinks">Empty Cart</a>
                        <?php endif;?>
                        <div class="alert alert-success"> 
                            <?php if(isset($selectedUsers)):?>
                                <?php if(count($selectedUsers)>0):?>
                                        <table  class="table table-striped table-bordered table-hover sortable">
                                            <tr>
                                                <th>USER</th>
                                                <th>SKILL(S)</th>
                                                <th></th>
                                                
                                            </tr>
                                                <?php foreach($selectedUsers as $person):?>
                                                    <tr>
                                                        <td><?php htmlout(($person['fname']) ." ". redactName($person['sname'])); $userSK= array();?></td>
                                                        <?php foreach($userSkills as $Userskill)                                                
                                                            {
                                                                if($Userskill['userid']==$person['id'])
                                                                {
                                                                    array_push($userSK, $Userskill['skillid']);
                                                                }

                                                            }                                               
                                                        ?>
                                                        <td><?php foreach($skills as $skill)
                                                            {
                                                                if(in_array($skill['id'], $userSK))
                                                                {
                                                                    htmlout($skill['skill'].", ");
                                                                }
                                                            }
                                                            ?>                                                            
                                                        </td>
                                                        <td>
                                                            <form action="" method="post">
                                                                <input type="hidden" name="remove" value="<?php htmlout($person['id']);?>"/>
                                                                <button type="submit" class="btn btn-info btn-xs">Remove from cart </cart>
                                                            </form>                                                            
                                                        </td>

                                                    </tr>
                                                <?php endforeach;?>                                     
                                        </table> 
                                        <div class="row">
                                         <div class="col-md-6">
                                            <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Enter your Email Address and Phone Number
                                            </div>
                                            <div class="panel-body">
                                                <form action="?order" method="post">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email address</label>
                                                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Phone No:</label>
                                                        <input type="phone" name="phone" class="form-control" placeholder="Phone" required/>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type='hidden' name='total' value="<?php htmlout($GLOBALS['OrderTotal']);?>">
                                                        <button type="submit" name="request" value="Send Order" class="btn-primary btn-lg">Send Order</button>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php else:?>
                                    <?php htmlout("Your cart is empty");?>

                                <?php endif;?>
                            <?php endif;?>                                      
                            <?php else:?>
                                <div class="alert alert-success"> 
                                    <p>Your Request has been Received.</p>
                                    <p>An email containing your Order-Number has been sent to the email address you provided(<?php htmlout($email);?>)</p>
                                    <p>We will send the Details of the Users that you requested for, to the email you provided (<?php htmlout($email);?>) as soon as your payment is confirmed.</p>
                                    <p>Pay <strong><?php htmlout($GLOBALS['OrderTotal']);?> Naira</strong> to any of the following bank Accounts and Text your email and <strong>Order-Number(<?php htmlout($orderID);?>)</strong> to <strong>0806-454-0395</strong> or <strong>0805-684-9704</strong></p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    GTBANK
                                                </div>
                                                <div class="panel-body">
                                                    Account Name:CRYPTIC CONCEPTS AND PERCEPTIONS NIGERIA LIMITED
                                                    <br/>
                                                    Account No.: 0251236675
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endif;?>
                        </div>
                            <!-- <strong><a href="http://www.designbootstrap.com/" target="_blank">DesignBootstrap.Com</a></strong>  -->
                        </div>
                            <!-- /////////////////////////////////////////////////////////////////////////////////////// -->

                            
                    </div>

                </div>
               <div class="row">
                    <div class="col-md-12">
                        
                    </div>
                </div>
                
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <footer >
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
    

</body>
<script src="vet.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</html>
