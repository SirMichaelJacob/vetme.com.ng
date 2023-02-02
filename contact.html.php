<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - Contact Us</title>
    <!-- BOOTSTRAP STYLES-->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME ICONS STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM STYLES-->
    <link href="assets/css/style.css" rel="stylesheet" />
    <script src="confirmPword.js"></script>
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
                        <?php
                            if(isset($loggedIn)):
                        ?>
                        <li><a href="?profile"><i class="fa fa-user-plus"></i> My Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                        <?php endif;?>
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
           

        </nav>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <form action="." method="post">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">CONTACT US</h1>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            VetMe
                        </div>
                        <div class="panel-body"> 
                            <p><strong>Phone:</strong> 0805-684-9704, 0806-454-0395</p>
                            <p><strong>email:</strong> feedback@vetme.com.ng</p>
                            <p><strong>Address:</strong> 1st Floor Executive mansion, Bauchi Ring road Jos, Plateau state</p>
                        </div>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           We want to hear from you [Send a direct Message]
                        </div>
                        <div class="panel-body">
                            
                              <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" name="senderemail" id="exampleInputEmail1" required placeholder="Enter email" />
                              </div>
                              <div class="form-group">
                                <label for="exampleInputPassword1">Phone</label>
                                <input type="phone" class="form-control" name="phone" id="phone" required placeholder="Phone" />
                              </div>
                               <div class="form-group">
                                <label for="exampleInputPassword1">Name</label>
                                <input type="text" class="form-control" name="name"  id="name" required placeholder="Enter your name" />
                                <span id='message'></span>
                              </div>
  
  
                            </div>
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Message
                        </div>
                        <div class="panel-body"> 
                            <textarea name="msg" style="max-height:200px;max-width:300px;min-height:200px;min-width:190px" class="col-md-6" required></textarea>
                            <br/>                         
                           <hr>                           
                           
                             
                           
                        </div>
                            </div>
                    </div>
                </div>
                <div>
                             <button type="submit" name="sendmsg"  class="btn btn-success">Send</button>
                              <!-- <input type="submit" class="btn btn-default" value="Cancel"> -->
                              <a href="."><button type="button" class="btn btn-warning">Cancel</button></a>
                           </div>
            </div>
            </form>
            
            <div class="modal fade" id="msgmodal" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Message Sent</h4>
                            </div>
                        <div class="modal-body">
                            <p>Your Message has been Sent. We will respond within 1 work day</p>                     
                        </div>
                        <div class="modal-footer">
                            Message Prompt                     
                        </div>    
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
    <script src="confirmPword.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
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
    <?php
    if(isset($_POST['sendmsg']))
        { ?>
    <script type="text/javascript"> $('#msgmodal').modal('show'); </script>
    <?php } ?>

</body>
</html>
