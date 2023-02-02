<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - Sales View</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME ICONS STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM STYLES-->
    <link href="assets/css/style.css" rel="stylesheet" />
    <script src="vet.js"></script>
    <script src="process.js"></script>
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
                         <h1 class="page-head-line" style="font face='Century Gothic',Serif;color:blue;">Vet<strong style="font face='Century Gothic',Serif;size:4;color:red;">Me</strong></h1>                      
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">

                        <div class="alert alert-success col-md-12"> 
                            <div class="panel panel-default col-md-6">
                                    <div class="panel-heading">
                                        <strong>ORDER ID:</strong> <?php htmlout($orderID);?>
                                    </div>
                                    <div class="panel-body">
                                        <table  class="table table-striped table-bordered table-hover sortable">
                                            <tr>
                                                <th>REQUESTED USER</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        
                                            <?php foreach($getOrders as $ord):?>  
                                                <tr>                                              
                                                 <?php foreach($users as $user):?>
                                                    <?php if($ord['userid']==$user['id']):?>                                                    
                                                    <td>
                                                        <?php htmlout($user['fname']. " ". $user['sname']);?>
                                                        <a href="http://localhost/vetme/?view=<?php htmlout($user['id']);?>" class="btn btn-info btn-xs">View</a>

                                                    </td>
                                                    <td><?php htmlout($ord['status']);?></td>                                                   
                                                   
                                                    <?php break;?>
                                                    <?php endif;?>
                                                 <?php endforeach;?>                                                 
                                                    <td>
                                                        <form action="." method="post">
                                                            <input type="hidden" name="OID" id="OID" value="<?php htmlout($orderID);?>"/>                                                            
                                                            <button type="submit" class="btn btn-primary btn-sm">Open</button>
                                                            <input type="hidden" name="UID" id="UID" value="<?php htmlout($ord['userid']);?>" required>
                                                        </form>
                                                    </td> 
                                                </tr>                                              
                                            <?php endforeach;?>
                                        </table>
                                    </div>
                            </div>
                             <?php if(isset($thisOID) and isset($thisUID)):?>
                             <div class="panel panel-default col-md-6">
                                    <div class="panel-heading">
                                        <strong>USER NAME:</strong> <?php htmlout($Usname. " ".$Ufname);?>
                                    </div>
                                    <div class="panel-body">
                                        <p>EMAIL: <?php htmlout($Uemail);?></p>
                                        <p>PHONE: <?php htmlout($Uphone);?></p>
                                        <p>ADDRESS: <?php htmlout($Uaddress);?></p>
                                        <div>
                                            <form action="sendReq.php" method="post">
                                                <input type="hidden" name="orID" id="orID" value="<?php htmlout($thisOID);?>"/>                                                            
                                                <button type="button" onclick="ProcessReq();" class="btn btn-primary btn-sm">Send </button>
                                                <input type="hidden" name="urID" id="urID" value="<?php htmlout($thisUID);?>" required>
                                            </form>                                            
                                        </div>
                                    </div>
                            </div>
                        <?php endif;?>
                           
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
<script src="process.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
</html>
