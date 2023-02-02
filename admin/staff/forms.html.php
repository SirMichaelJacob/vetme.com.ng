<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - Staff Management</title>
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
                <form action="" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">UPDATE STAFF INFORMATION</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           All fields are required
                        </div>
                        <div class="panel-body">
                       
                          <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" name="email" value="<?php htmlout($email);?>" id="exampleInputEmail1" required placeholder="Enter email" 
                                <?php if(isset($specialemail) and $email==$specialemail)
                                {
                                    echo 'disabled';
                                }
                                ?>

                            />
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" id="password" onkeyup="check();" class="form-control" placeholder="Password" 
                                <?php if( isset($specialpassword) and $password==$specialpassword)
                                {
                                    echo 'disabled';
                                }
                                ?>


                            />                            
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Re-Password</label>
                            <input type="password" class="form-control" name="repassword"  id="repassword" onkeyup="check();" placeholder="Re-type Password" />
                            <span id='message'></span>
                          </div> 
                          <label for="exampleInputPassword1">VERIFIED</label>
                          <div class="radio">
                            <?php foreach ($verify as $option):?>
                            <div>
                              <label>
                                <input type="radio" name="verified"  value="<?php htmlout($option);?>"
                                    <?php
                                        if(isset($specialUser) and $specialUser==true)
                                        {
                                            echo ' disabled ';
                                        }                                         

                                        if(isset($verified) and $verified== $option)
                                        {
                                            echo ' checked';
                                        } 
                                    ?>
                                >
                               <?php htmlout($option);?>

                              </label>
                            </div>
                            <?php endforeach;?>
                         </div>
                         <label for="exampleInputPassword1">User Roles:</label>
                         <div class="checkbox">                            
                             <?php foreach($roles as $role):?>
                                <div>
                                 <label>
                                    <input type='checkbox' name ="staffRoles[]" value="<?php htmlout($role['id']);?>"

                                        <?php 

                                        if(isset($specialUser) and $specialUser==true)
                                        {
                                             echo ' disabled';
                                        }
                                        if(isset($myRoles))
                                        {
                                            foreach($myRoles as $item)
                                            {
                                                if($item['id']==$role['id'])
                                                {
                                                    echo ' checked';
                                                }
                                            }
                                        }

                                        ?>


                                    >
                                    <?php htmlout($role['id']);?>
                                 </label>
                                </div>
                             <?php endforeach;?>
                        </div>
                        <!-- </form> -->
                    </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Continue
                        </div>
                        <div class="panel-body">
                            
                              <label for="exampleInputEmail1">First Name</label>
                                    <input type="text" class="form-control" name="firstname" value="<?php htmlout($fname);?>" placeholder="First Name" required/>
                            <label for="exampleInputEmail1">Othername</label>
                                    <input type="text" class="form-control" name="othername" value="<?php htmlout($oname);?>" placeholder="Othername"/>
                              <label for="exampleInputEmail1">Surname</label>
                                <input type="text" class="form-control" name="surname"  value="<?php htmlout($sname);?>"placeholder="Surname" required/>
                                <label for="exampleInputEmail1">Phone</label>
                              <input type="text" class="form-control" name="phone" value="<?php htmlout($phone);?>" placeholder="Phone" required/>
                                        <div class="checkbox">
    
                                        </div>
                           
                           <label for="exampleInputEmail1">Gender</label>
                           <div class="radio">
                           <?php foreach($genderArray as $sex):?>
                            <div>                           
                               <label>
                                <input type="radio" name="gender" value="<?php htmlout($sex);?>" 
                                <?php 
                                    if(isset($gender) and ($gender==$sex))
                                    {
                                        echo ' checked ';
                                    }

                                ?>

                                >
                                <?php htmlout($sex);?>
                                </label>
                            </div>
                            <?php endforeach;?>
                        </div>
                        
                        
                        <label for="exampleInputEmail1">Address</label>
                           <input type="text" class="form-control" name="address" placeholder="Address"  value="<?php htmlout($address);?>" required />
                                                   
                        <hr />
                              <input type="hidden" name="Id" value="<?php htmlout($staffid);?>">
                              <button type="submit" name="update" id="submit" value="<?php htmlout($action);?>" class="btn btn-success"

                                <?php 

                                        if(isset($specialUser) and $specialUser==true)
                                        {
                                             echo ' disabled';
                                        }
                                ?>

                              ><?php htmlout($action);?></button>
                              
                              <!-- <input type="submit" class="btn btn-default" value="Cancel"> -->
                              <a href="."><button type="button" class="btn btn-warning">Cancel</button></a>
                       
                    </div>
                    </div>
                        </div>
                </div>
            </form>

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
    <script>
        var check = function(){
      if (document.getElementById('password').value ==
        document.getElementById('repassword').value) {
        document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = 'password match';
        document.getElementById("submit").disabled = false;
      } else {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = 'password does not match';
        document.getElementById("submit").disabled = true;
      }
    }
    </script>

</body>
</html>
