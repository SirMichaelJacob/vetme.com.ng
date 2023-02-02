<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - About Us</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
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
                 <?php if(!isLoggedIn()):?>
                 <li>
                   <aside class= "leftSidebuttonLinks"><a href="?signup" style="color:black;">SIGN UP</a></aside>
                </li> 
                <li>                     
                    <div class="btn-group">
                                              <button data-toggle="dropdown" class="btn btn-success dropdown-toggle">Welcome <span class="caret"></span></button>
                                              <ul class="dropdown-menu">
                                                <li><a href="?signup">Sign Up</a></li>
                                                <li class="divider"></li>
                                                <li><a href="?login">Log In</a></li>                                                                                             
                                              </ul>
                    </div>
                </li>
                <?php elseif (isLoggedIn()):?>

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
                    <div class="btn-group">
                                              <button data-toggle="dropdown" class="btn btn-success dropdown-toggle">Welcome <?php echo strtoupper($GLOBALS['sname'])." " .$GLOBALS['fname'];?> <span class="caret"></span></button>
                                              <ul class="dropdown-menu"> 
                                                <li><a href="?logout">Log Out</a></li>
                                              </ul>
               
            
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
                        <?php if(isset($GLOBALS['username'])):?>
                            <a  href=""> <strong> <?php echo $GLOBALS['username'];?> </strong></a>
                        <?php endif;?>
                    </li>                   
                </ul>
            </div>

        </nav>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">
                            <?php if(isset($GLOBALS['username'])):?>
                            <strong> <?php echo $GLOBALS['username'];?> </strong>
                            - USER PROFILE
                            <?php endif;?>
                        </h1>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 class="page-head-line">
                                VetMe - Nigeria's No.1 Skills Repository
                            </h1>                            
                        </div>
                        <div class="panel-body">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">What we do</a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse in" style="height: auto;">
                                        <div class="panel-body">
                                            Employers often search for competent manpower - people that can do the job. While those with skills cannot find their potential employers. VetMe is here to bridge this gap and seal this divide! VetMe.com.ng provides a platform where Tech Skilled Nigerians can register and the public can vouch-for or Vet them.
                                            VetMe provides an easy to use platform that connects Tech skilled Nigerians in the field of ICT to prospective employers.
                                            We bridge the gap between employers and job seekers.
                                            VetMe offers the following services:
                                            <ul>
                                                <li>Register Users who have ICT skills</li>
                                                <li>Provide exposure for our Users</li>
                                                <li>Allow persons who know these Users to vet them: This means that people can visit vetme.com.ng and vouch for these users</li>
                                                <li>Allow employers and organization to search for Users that possess relevant ICT skills based on their tech skill and location</li>
                                                <li>Connect Employers to our registered Users</li>
                                            </ul> 
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed">Do you have a Skill?</a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" style="height: auto;">
                                        <div class="panel-body">
                                            Are you skilled in any field of ICT? Do you want to connect with organizations and potential employers? If yes, then <a href="?signup">Sign Up</a> for FREE! This is the 1st step towards getting recognized and employed.
                                            After registration, a profile will be created for you. You will be given a unique link that directs visitors to vet your skills. Share this link on your social media page so as to get more of your friends to vet you. The more people you get to vet you, the more credible you become. Employers will need to know how many people have vouched for you!
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed">Are you looking for skilled employees?</a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            If you are an Employer or you own an organization, you can visit <a href="?home">VetMe.com.ng</a> and search for Users <i>(real people)</i> with relevant ICT skills based on their location within Nigeria.
                                            You will find the total number of people that have vouched for each user (<i>Total Vets</i>). The <i>Total Vets</i> of each user will help you to ascertain the user's credibility. You can Request for the contact details of each user you are interested in and we will send it directly to you as soon as possible!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
               

            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/footer.html.php';?>
        <!-- &copy; 2015 YourCompany | By : <a href="http://www.designbootstrap.com/" target="_blank">DesignBootstrap</a> -->
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
