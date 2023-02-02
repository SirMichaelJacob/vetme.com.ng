<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - View User</title>
    <!-- BOOTSTRAP STYLES-->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
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

                                      
                </ul>
            </div>

        </nav>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <div id="page-inner">

                    <div class="col-md-12">
                         <h1 class="page-head-line" style="font face='Century Gothic',Serif;color:blue;">Vet<strong style="font face='Century Gothic',Serif;size:4;color:red;">Me</strong></h1>                      
                    </div>
                
                <div class="row">
                    <div class="alert alert-success col-md-12">                       
                            <div class="panel panel-default col-md-6">
                                    <div class="panel-heading">
                                        <p style="font face='Century Gothic',Serif;font-size: 19px;color:black;">NAME: <strong><?php htmlout($firstname ." ". $surname);?></p></strong>                               
                                    </div>
                                <div class="panel-body">

                                <?php if(isset($nullUser) and $nullUser==false):?>
                                
                                    <strong style="font face='Century Gothic',Serif;font-size: 19px;color:red;">Total Vets:
                                            <?php htmlout($countVet);?>
                                    </strong>
                                    <p style="font face='Century Gothic',Serif;font-size: 19px;color:black;">Gender: <?php htmlout($gender);?></p>
                                    <p style="font face='Century Gothic',Serif;font-size: 19px;color:black;">Phone: <?php htmlout(redactPhone($phone));?></p>
                                    <p style="font face='Century Gothic',Serif;font-size: 19px;color:black;">Email: <?php htmlout(redactEmail($email));?></p>
                                    <p style="font face='Century Gothic',Serif;font-size: 19px;color:black;">State: <?php htmlout($state);?></p>
                                    <p style="font face='Century Gothic',Serif;font-size: 19px;color:black;">Address: <?php htmlout(redactName($address));?></p>
                                    <p style="font face='Century Gothic',Serif;font-size: 19px;color:black;"> Select the Skill(s) you want to Vet:</p>
                                        <?php if(isset($uskills)):?>  
                                        <?php if(isLoggedIn()):?>
                                        <form action="." method="post" id='form1'>
                                            <select name="sid" id="sid">
                                                        <?php foreach($uskills as $id):?>
                                                             <?php foreach($skills as $skill):?>                                        
                                                                <?php if($skill['id']==$id):?>
                                                                    <option value="<?php htmlout($skill['id']);?>"><?php htmlout($skill['skill']);?></option>
                                                                    <?php break;?>                                                    
                                                                <?php endif;?> 
                                                            <?php endforeach;?>
                                                        <?php endforeach;?>
                                            </select>
                                            <input type="hidden" name="vet" id="vet" value="<?php echo $userid ;?>" form = "form1"/>            
                                            <input type = "submit" name="btnvet" id="btnvet" class="btn btn-primary btn-lg" value="VET" form = 'form1'/>                                           
                                        </form> 
                                        <?php else:?>  
                                        <form action='vetter.php' method='post' id='form1'>
                                                <select name="sid" id="sid">
                                                            <?php foreach($uskills as $id):?>
                                                                 <?php foreach($skills as $skill):?>                                        
                                                                    <?php if($skill['id']==$id):?>
                                                                        <option value="<?php htmlout($skill['id']);?>"><?php htmlout($skill['skill']);?></option>
                                                                        <?php break;?>                                                    
                                                                    <?php endif;?> 
                                                                <?php endforeach;?>
                                                            <?php endforeach;?>
                                                </select>
                                                <input type="hidden" name="vet" id="vet" value="<?php htmlout($userid);?>"> 
                                                <input type="button" name="btnvet" id="btnvet" onclick='SubmitForm();' class="btn btn-primary btn-lg" value="VET" data-toggle='modal' data-target='#myModal'  form="form1">
                                        </form>
                                        <?php endif;?> 

                                            
                                        <?php endif;?>
                                    
                                    <center>
                                        <div class="alert alert-warning">
                                        <?php if(!in_array($userid, $GLOBALS['myVetted'])):?>
                                            <!-- <form action="vetter.php" method="post">
                                                <input type="hidden" name="vet" id="vet" value="<?php htmlout($userid);?>">
                                                <button type="button" onclick="SubmitForm();" class="btn btn-primary btn-lg">VET</button>                                        
                                            </form> -->
                                        
                                        <?php endif;?>
                                            <br/>
                                            <form action="" method="post">
                                                <input type="hidden" name="vet1" id="vet1" value="<?php htmlout($userid);?>">                                       
                                                <button type="submit" name="request" value="request" class="btn btn-success btn-lg">Add to Cart</button> 
                                                                                              
                                            </form>                                            

                                        <?php else:?>
                                            <p>User Profile not found!</p>
                                        <?php endif;?>
                                          </div>
                                                                
                                        </center>
                                    </div>
                                </div> 

                                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title" id="myModalLabel">You are not Logged In</h4>
                                                            </div>
                                                            <form action="vetter.php" method="post">
                                                                <div class="modal-body">
                                                                    Please<a href="?login"> Log In</a>.
                                                                    <p>Or</p>
                                                                    Use your email to Vet:</p>
                                                                        <label for="exampleInputEmail1">Email address</label>
                                                                            <input type="email" class="form-control" style="width:300px;" name="email" id="exampleInputEmail1" required placeholder="Enter email" form="form1"/>
                                                                            <br/>                                                                             
                                                                            <button class="btn btn-warning" form="form1">Vet</button>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
                                                                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
<!-- ...................................................................................................................................... -->

                                        <?php if(isset($_SESSION['vetmsg'])):?>
                                        <div class="modal fade" id="successmodal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="myModalLabel">Vet Prompt</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><?php htmlout($_SESSION['vetmsg']);?></p>                     
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="." method="post">
                                                                <input type="hidden" name="close"/>
                                                                <button type="submit" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </form>
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif;?>

<!-- .............................................................................................................................................. -->

                            <div class="modal fade" id="addtocartmodal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="myModalLabel">1 new Item has been added to your cart</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>You have <?php htmlout(count($_SESSION['cart']));?> Items in your cart</p>
                                                            <p>If you are done, click <a href="?checkout">Checkout</a></p>                      
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div> 
<!-- ................................................................................................................................................ -->
                            <?php if(isset($nullUser) and $nullUser==false):?>
                                <div class="panel panel-default col-md-6">
                                    <div class="panel-heading">
                                        <p style="font face='Century Gothic',Serif;font-size: 19px;color:black;">NAME: <strong><?php htmlout($firstname ." ". $surname);?></p></strong>                               
                                    </div>
                                        <div class="panel-body">
                                            <table  class="table table-striped table-bordered table-hover sortable">
                                                <tr>
                                                    <th>Skill </th>
                                                    <th>No. of VETS </th>  
                                                </tr>
                                                <?php foreach($uskills as $id):?>
                                                <tr>
                                                         <?php foreach($skills as $skill):?>                                        
                                                            <?php if($skill['id']==$id):?>
                                                                <td><?php htmlout($skill['skill']);?></td>
                                                                <?php break;?>
                                                            <?php endif;?>
                                                        <?php endforeach;?>
                                                        <?php $counting=0;?>
                                                        <?php foreach ($vets as $vet)
                                                        {                                                            
                                                            if($vet['userid']==$userid and $id==$vet['skillid'])
                                                            {
                                                                $counting++; //Counts the number of vets for the particular skill
                                                            }

                                                        }
                                                        ?>                                                             
                                                        <td><?php htmlout($counting);?></td>
                                                </tr>

                                                <?php endforeach;?>                                                
                                                
                                            </table>          
                                        </div>
                                <?php else:?>
                                
                                </div>
                                
                                <?php endif;?>
                        </div>

                    </div>            <!-- <strong><a href="http://www.designbootstrap.com/" target="_blank">DesignBootstrap.Com</a></strong>  -->
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
    <?php
    if(isset($_POST['request']) and $_POST['request']=='request')
        { ?>
    <script type="text/javascript"> $('#addtocartmodal').modal('show'); </script>
    <?php } ?>

    <?php
    if(isset($_SESSION['vetmsg']))
        { ?>
    <script type="text/javascript"> $('#successmodal').modal('show'); </script>
    <?php } ?>
<script src="vet.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>

</body>

</html>
