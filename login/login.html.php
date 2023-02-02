<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - Admin Login</title>
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
            </ul>
            </div>
        </nav>
        
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Admin Log In</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="alert alert-warning">                            
                            <?php if(isset($GLOBALS['loginError'])):?>
                                <?php echo $GLOBALS['loginError'];?>
                            <?php endif;?>
                            <?php if(isset($GLOBALS['adminAccountExist']) and $GLOBALS['adminAccountExist']==false):?>
                                <div class="row">
                                        <div class="col-md-12">
                                            <?php if(isset($GLOBALS['message'])):?>
                                            <div class="alert <?php echo $GLOBALS['alertType'];?>">
                                                <?php echo"<br/>". $GLOBALS['message'];?>
                                            </div>
                                        <?php endif;?>
                                        </div>
                                        
                                </div>
                            <?php endif;?>
                            <?php if(isset($_SESSION['verified']) and $_SESSION['verified']==false and isset($message)):?>

                                <?php echo $message;?>
                                <br />
                                <form action="" method="post">
                                    <label for="exampleInputEmail1">Confirmation Code</label>
                                    <input type="text" class="form-control" name="code" id="exampleInputEmail1" required placeholder="Enter confirmation code" />
                                    <br/>
                                    <input type="submit" name="confirm" class="btn btn-default" value="Confirm">
                                    <a href="." class="btn btn-info btn-sm">Cancel</a>
                                    <!-- <button type="submit" value="Cancel "class="btn btn-default">Cancel</button> -->
                                </form>
                            <?php elseif(isset($_SESSION['verified']) and $_SESSION['verified']==true and (isset($message))):?>
                                <?php echo $message;?>
                            <?php  endif;?>

                            <!-- <strong><a href="http://www.designbootstrap.com/" target="_blank">DesignBootstrap.Com</a></strong>  -->
                        </div>
                        <form action="" method="post">
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" required placeholder="Enter email" />
                                 
                                  
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" name="password" id="exampleInputPassword1" required placeholder="Password" />
                                    <br/>
                                    <button type="submit" name="adminlogin" value="Login" class="btn btn-success">Login</button>
                                      <!-- <input type="submit" class="btn btn-default" value="Cancel"> -->
                                    <a href=".." class="btn btn-info">Cancel</a>
                                    <a href="?register" class= "leftSidebuttonLinks">Register</a>
                            </div>
                        </form>
                            <br />
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
</html>
