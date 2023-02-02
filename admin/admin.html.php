<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - Admin Area</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
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
                <a  class="navbar-brand" href="?home">VetMe.com.ng</a>
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
                        <li><a href="?logout"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
                </li>
               
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
                            if(adminIsLoggedIn())
                            {
                                foreach($admins as $admin)
                                {
                                    if($admin['email']==$_SESSION['email'])
                                    {
                                        $GLOBALS['username'] = strtoupper($admin['sname'])." " .$admin['fname'];
                                        break;
                                    }
                                }   
                            }
                         ?>
                        <a  href="."> 
                            <?php if(adminIsLoggedIn()):?>
                                    <strong> <?php htmlout($GLOBALS['username']);?> </strong>
                            <?php endif;?> 
                        </a>
                    </li>

                    <li>
                        <a   href="?adminhome"><i class="fa fa-dashboard "></i>Admin Hompage</a>
                    </li>
                    <li>
                        <a href="?userman"><i class="fa fa-venus "></i>User Management </a>
                        
                    </li>
                    
                    <li>
                        <a href="?staffman"><i class="fa fa-bolt "></i>Staff Management</a>
                        
                    </li>
                   
                     
                     <li>
                        <a href="?salesman"><i class="fa fa-code "></i>Sales Management</a>
                    </li>
                   
                </ul>
            </div>

        </nav>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <div id="page-inner">
                
                
                <div class="row">
                    <div class="col-md-12">
                        <h1 style="font-size: 19px;" class="page-head-line">VetMe Admin Area</h1>                        
                    </div>
                    <div class="col-md-12">
                        <?php if(isset($GLOBALS['message'])):?>
                        <div class="alert <?php echo $GLOBALS['alertType'];?>">
                            <?php echo $GLOBALS['message'];?>
                        </div>
                    <?php endif;?>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-6">

                        <div class="alert alert-danger">
                                                       
                                    <div>
                                        <div class= "leftSidebuttonLinks">Manages VetMe <strong>Staff</strong> Information System<br/> Edit / Update / Delete VetMe Staff data <br/> Creates New Roles and Assigns Staff Roles <br/></div> 
                                        <a href="../admin/staff/"><aside style="font-size: 50px;" class="glyphicon glyphicon-user"></aside></a>
                                        <br />
                                        <strong style="font-size: 15px;">Staff Management</strong>
                                    </div>                                    
                                    
                                
                        </div>
                    </div>

                     <div class="col-md-6">

                        <div class="alert alert-warning">
                                                       
                                    <div>
                                        <div class= "leftSidebuttonLinks">Manages VetMe <strong>Users</strong> Information System<br/> Edit / Update / Delete VetMe Users <br/> Views VetMe Users statistics <br/></div> 
                                        <a href="../admin/user/"><aside style="font-size: 50px;" class="glyphicon glyphicon-user"></aside></a>
                                        <br />
                                         <strong style="font-size: 15px;">User Management</strong>
                                    </div>                                    
                                    
                                
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="alert alert-success">
                                    <div>
                                        <div class= "leftSidebuttonLinks">Manages All VetMe <strong>Sales Operations</strong><br/>Sets Price of UIR (User Information Request) <br/>Confirms Customer Payments and Process Customer Requests </div> 
                                        <a href="../admin/sales/"><span style="font-size: 50px;" class="glyphicon glyphicon-user"></span></a>
                                        <br />
                                        <strong style="font-size: 15px;">Sales Management</strong>
                                    </div>
                            
                               
                           
                        </div>
                                                                          
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
