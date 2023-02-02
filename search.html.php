<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - Search Result</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
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
                            <img src="assets/img/user.jpg" class="img-square" />

                           
                        </div>

                    </li>
                     <li>
                        <?php 
                            if(isLoggedin())
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
                             if(isLoggedin()):
                         ?>  
                            
                            <a  href="."> <strong> <?php htmlout($GLOBALS['username']);?> </strong></a>
                        <?php endif;?>
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
                    </li>
                    -->
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
                        <div class="alert alert-warning"> 
                             Search Result.
                            <?php if(isset($searchResults) and count($searchResults)>0):?>
                                <p>*This table is sortable. Click on a column to sort.</p>
                            <?php endif;?>
                            <!-- <strong><a href="http://www.designbootstrap.com/" target="_blank">DesignBootstrap.Com</a></strong>  -->
                        </div>
                        <?php if(isset($searchResults) and count($searchResults)>0):?>
                                
                                <table  class="table table-striped table-bordered table-hover sortable">
                                    <tr>
                                        <th>USER</th>
                                        <th>EMAIL</th>                                        
                                        <th>PHONE</th>
                                        <th>LOCATION</th>
                                        <th>TOTAL VETS</th>
                                        <th></th>
                                    </tr>
                                    <?php 
                                        foreach($searchResults as $person):
                                        // if($counter<=1):
                                    ?>
                                        <tr>
                                            <td><?php htmlout(($person['fname']) ." ". redactName($person['sname'])); ?></td>
                                            <td><?php htmlout(redactEmail($person['email']));?></td> 
                                            <td><?php htmlout(redactPhone($person['phone']));?></td>
                                            <td><?php htmlout($person['state']);?></td>
                                            <td>
                                                <?php
                                                    $counter=0;
                                                    foreach($vets as $vet)
                                                    {
                                                       if($vet['userid']==$person['id'])
                                                       {
                                                            $counter++;
                                                       }

                                                    }
                                                    htmlout($counter);
                                                ?>


                                            </td>
                                            <td>                                  
                                               
                                                <form action="?view" method="get">
                                                    <!-- <input type="hidden" name="searchUrl" value="<?php htmlout($searchUrl);?>">      -->
                                                    <input type="hidden" name="view" id="view" value="<?php htmlout($person['id']);?>">                                      
                                                    <button type="submit" class="btn btn-primary">View</button>
                                                             
                                                </form>   
                                            </td>
                                        </tr>
                                                                                                                      
                                    <?php endforeach;?>
                                
                                </table>
                        <?php else:?>
                            <?php htmlout("Search returned Empty");?>                            
                        <?php endif?>                             
                    </div>
                    
                        

                </div>
                <center>
                     <?php if(isset($maxpage) and intval($maxpage)>1):?> 
                        <form action="" method="post">

                            <label>Page: <select name="start" class="form-control">
                                <?php for($i=0;$i<$maxpage;$i++):?>
                                                               
                                    <option value="<?php echo ($i*$rowsperpage).'|'.$i;?>"
                                    <?php
                                        
                                        if(isset($option) and $option==$i)
                                        {
                                            echo ' selected';
                                        }

                                    ?>

                                    >
                                    <?php $num=$i+1; htmlout("\r\n".$num."\r\n");?>
                                     
                                    </option>
                                 
                                <?php endfor;?>
                            </select>
                            </label>

                            <a href="<?php $self;?>"><button type="submit" Value="GO" class="btn btn-success btn-sm">GO</button></a>                     
                        </form>
                    <?php endif;?>  
                </center> 
                
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
    <script src="sorttable.js"></script>
</body>
<script src="vet.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</html>
