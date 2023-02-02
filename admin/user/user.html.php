<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - User Management</title>
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
                        <h1 style="font-size: 19px;" class="page-head-line">VetMe User Management Area</h1>                        
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
                        <div class="col-md-3">                       
                    
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Filter Search
                            </div>
                            <div class="panel-body">
                                <form action="." method="post">
                                    <input type="text" name="usid" id="exampleInputEmail1" required placeholder="Enter User ID"/>
                                    <button type="submit" name="getUser" class="btn btn-success btn-sm">Search</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">                       
                    
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               Skill Management
                            </div>
                            <div class="panel-body">
                                <a href="?skillman" class="btn btn-info">Skills Management</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 alert alert-warning">
                        <?php if(!isset($thisperson)):?>
                        <div class="alert alert-info">                            
                           All Users
                           <?php if(isset($Allusers) and count($Allusers)>0):?>
                            
                                <table  class="table table-striped table-bordered table-hover sortable">
                                    <tr>
                                        <th>USER-ID</th>
                                        <th>EMAIL</th>                                        
                                        <th>PHONE</th>
                                        <th>FIRST NAME</th>
                                        <th>SURNAME</th>
                                        <th>STATE</th>
                                        <th>TOTAL VETS</th>
                                        <th></th>                                        
                                    </tr>
                                    <?php foreach($Allusers as $person):?>
                                    <tr>
                                        <td><?php htmlout($person['id']);?></td>
                                        <td><?php htmlout($person['email']);?></td>
                                        <td><?php htmlout($person['phone']);?></td>
                                        <td><?php htmlout($person['fname']);?></td>
                                        <td><?php htmlout($person['sname']);?></td>
                                        <td><?php htmlout($person['state']);?></td>
                                        <td><?php htmlout($person['totVet']);?></td>
                                        <td>
                                            <input type="hidden" name="userId" value="<?php htmlout($person['id']);?>">
                                                <div class="btn-group">
                                                  <button class="btn btn-primary">Action</button>
                                                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                                  <ul class="dropdown-menu">
                                                    <li>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="userId" value="<?php htmlout($person['id']);?>">                                                            
                                                            <button type="submit" name="edit" class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button>
                                                            <?php if($person['email']!='michaeljacob01@gmail.com'):?>
                                                                <button type="submit" name="delete" class="btn btn-danger"><i class="fa fa-pencil"></i> Delete</button>
                                                            <?php endif;?>
                                                        </form>
                                                    </li>                                                   
                                                    <li class="divider"></li>                                                   

                                                  </ul>
                                                </div>
                                        </td>
                                    </tr>
                                    <?php endforeach;?> 
                                </table>                                
                        </div>
                        <?php if(!isset($filterClicked)):?>
                                <center>
                                     <?php if(isset($maxpage) and $maxpage>0):?> 
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
                                <?php elseif(isset($filterClicked)):?>
                                        <center>
                                            <a href="."><button type="submit" Value="GO" class="btn btn-success btn-lg">Back</button></a>
                                        </center>                                        
                                <?php endif;?>  
                            <?php endif;?>
                    <?php elseif(isset($thisperson) and isset($foundUser) and $foundUser==true):?>
                        <table  class="table table-striped table-bordered table-hover sortable">
                                    <thead>
                                        <tr>
                                            <th>USER-ID</th>
                                            <th>EMAIL</th>                                        
                                            <th>PHONE</th>
                                            <th>FIRST NAME</th>
                                            <th>SURNAME</th>
                                            <th>STATE</th>
                                            <th>TOTAL VETS</th>
                                            <th></th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($thisperson as $p):?>
                                            <tr>
                                                <td><?php htmlout($p['id']);?></td>
                                                <td><?php htmlout($p['email']);?></td>
                                                <td><?php htmlout($p['phone']);?></td>
                                                <td><?php htmlout($p['fname']);?></td>
                                                <td><?php htmlout($p['sname']);?></td>
                                                <td><?php htmlout($p['state']);?></td>
                                                <td><?php htmlout($p['totVet']);?></td>
                                                <td>
                                                    <input type="hidden" name="userId" value="<?php htmlout($p['id']);?>">
                                                        <div class="btn-group">
                                                          <button class="btn btn-primary">Action</button>
                                                          <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                                          <ul class="dropdown-menu">
                                                            <li>
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="userId" value="<?php htmlout($p['id']);?>">                                                            
                                                                    <button type="submit" name="edit"  class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button>
                                                                    <?php if($p['email']!='michaeljacob01@gmail.com'):?>
                                                                        <button type="submit" name="delete" class="btn btn-danger"><i class="fa fa-pencil"></i> Delete</button>
                                                                    <?php endif;?>
                                                                </form>
                                                            </li>                                                   
                                                            <li class="divider"></li>                                                   

                                                          </ul>
                                                        </div>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>

                                    </tbody>
                                    
                        </table>
                        <?php elseif(isset($foundUser) and $foundUser==false):?>
                        <p>User not found</p>
                    <?php endif;?>
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
    <script src="sorttable.js"></script>

</body>
<script src="vet.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</html>
