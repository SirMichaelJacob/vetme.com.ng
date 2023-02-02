<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - Sales Management</title>
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
                        <!-- <li><a href="./user"><i class="fa fa-user-plus"></i> My Profile</a>
                        </li> -->
                        <!-- <li class="divider"></li> -->
                        <li><a href="?logout"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
                </li>
               <!--  <li>
                    <aside class= "leftSidebuttonLinks"><a href="?checkout">Your Cart(You have <?php if(isset($_SESSION['cart'])){ echo(count($_SESSION['cart']));} else{ echo'0';} ?> requests in your cart)</a></aside>
                </li>
                <li>
                    <aside class= "leftSidebuttonLinks"><a href="?checkout">Checkout</a></aside>
                </li> -->
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
                        <h1 style="font-size: 19px;" class="page-head-line">VetMe SALES Area</h1>                        
                    </div>
                </div>
                <div class="row">                  
                    <div class="col-md-3">                       
                    
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Filter Search
                            </div>
                            <div class="panel-body">
                                <form action="" method="get">
                                    <input type="text" name="orderid" id="exampleInputEmail1" required placeholder="Enter Order ID"/>
                                    <button type="submit" Value="GO" class="btn btn-success btn-sm">GO</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">                       
                    
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Set UIR Price
                            </div>
                            <div class="panel-body"  style="padding-left:20px;">
                                <p>Current UIR Price= <?php htmlout($price . ' Naira');?></p>
                                <form action="" method="post">
                                    <input type="text" name="price" id="exampleInputEmail1" required placeholder="Price"/>
                                    <button type="submit" name="setprice" Value="GO" class="btn btn-success btn-sm"  style="padding-right:10px; padding-left:10px;">SET PRICE</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <div class="alert alert-info">
                           All Orders
                           <?php if(isset($totalOrders) and count($totalOrders)>0):?>
                            
                                <table  class="table table-striped table-bordered table-hover sortable">
                                    <thead>
                                        <tr>
                                            <th>ORDERID</th>
                                            <th>EMAIL</th>                                        
                                            <th>PHONE</th>
                                            <th>DATE</th>
                                            <th>TOTAL REQUESTS</th>
                                            <th>AMOUNT</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    
                                    <?php if(!isset($filterClicked)):?>
                                    <tbody>
                                        <?php foreach($totalOrders as $single):?>
                                        <tr>
                                            <td><?php htmlout($single['id']);?></td>
                                            <td><?php htmlout($single['email']);?></td>
                                            <td><?php htmlout($single['phone']);?></td>
                                            <td><?php htmlout($single['orderdate']);?></td>
                                            <td>
                                                <?php $count=0;?>
                                                <?php foreach($ordertotals as $orderT)
                                                        if($orderT['orderid']==$single['id'])
                                                        {

                                                             $amount=$orderT['total'];
                                                             break;
                                                        }
                                                        foreach ($orders as $order)
                                                        {
                                                            if($order['id']==$single['id'])
                                                            {
                                                                $count++;
                                                            }
                                                        }
                                                ?>
                                                <?php 
                                                    htmlout($count);                                                    
                                                ?>
                                            </td>
                                            <td><?php htmlout($amount);?></td>
                                            <td>
                                                <form action="." method="get">
                                                    <button name="openOrder" value="<?php htmlout($single['id']);?>" class="btn btn-warning btn-sm">View Order</button>
                                                </form>

                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                    <?php elseif(isset($filterClicked) and isset($orderfound) and $orderfound==true):?>
                                        <tr>
                                            <td><?php htmlout($orderID);?></td>
                                            <td><?php htmlout($orderEmail);?></td>
                                            <td><?php htmlout($orderPhone);?></td>
                                            <td><?php htmlout($orderDate);?></td>
                                            <td><?php htmlout($numReq);?></td>
                                            <td><?php htmlout($orderAmount);?></td>
                                            <td>
                                            <form action="." method="get">
                                                <button name="openOrder" value="<?php htmlout($orderID);?>" class="btn btn-warning btn-sm">View Order</button>
                                            </form>

                                            </td>
                                        </tr>
                                    <?php elseif(isset($filterClicked) and isset($orderfound) and $orderfound==false):?>
                                        <strong><p>Order not found</p></strong>
                                    <?php endif;?>

                                    </tbody>
                                    
                                </table>
                                <?php if(!isset($filterClicked)):?>
                                <center>
                                     <?php if(isset($maxpage) and $maxpage>1):?> 
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
    <script src="sorttable.js"></script>

</body>
<script src="vet.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</html>
