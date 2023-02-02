<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - Find Skills</title>
    <!-- BOOTSTRAP STYLES-->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
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
                 <?php if(!isset($_SESSION['loggedIn'])):?>
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
                <?php elseif (isset($_SESSION['loggedIn'])):?>

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
            <div class=" col-md-3 col-sm-3">
                <div class="user-img-div1">
                    <img src="assets/img/webdev.jpg"/>
                </div>
                <!-- <div class="style-box-one Style-one-clr-one">
                            <a href="#">

                                <span class="glyphicon glyphicon-headphones"></span>
                                 <h5>GRAPHIC DESIGNERS</h5>
                            </a>
                </div> -->
            </div>
              <div class=" col-md-3 col-sm-3">
                <div class="user-img-div1">
                    <img src="assets/img/security.jpg"/>
                </div>
                <!-- <div class="style-box-one Style-one-clr-two">
                            <a href="#">
                                <span class="glyphicon glyphicon-repeat"></span>
                                 <h5>WEB DESIGNERS</h5>
                            </a>
                        </div> -->
              </div>
            <div class=" col-md-3 col-sm-3">
                <div class="user-img-div1">
                    <img src="assets/img/mobdev.jpg"/>                    
                </div>
                <!-- <div class="style-box-one Style-one-clr-three">
                            <a href="#">
                                <span class="glyphicon glyphicon-camera"></span>
                                 <h5>PROGRAMMERS</h5>
                            </a>
                </div> -->
            </div>
            <div class=" col-md-3 col-sm-3">
                <div class="user-img-div1">
                    <img src="assets/img/code.jpg"/>
                </div>
                <!-- <div class="style-box-one Style-one-clr-four">
                            <a href="#">
                                <span class="glyphicon glyphicon-cog"></span>
                                <h5>Some Sample Text</h5>
                            </a>
                </div> -->
            </div>      
            </div>
            <div class="row">
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
                        <div class="alert alert-info">
                            <h3>SEARCH</h3>
                            <form action="?" method="GET">
                            <label>What Skill are you looking for?</label>
                                <select name="skill" class="form-control" required>
                                    <?php foreach($skills as $skill):?>
                                        <option value=<?php echo $skill['id'];?>><?php echo $skill['skill'];?></option>
                                    <?php endforeach;?>
                                 </select>
                                 <div class="form-group">
                                    <label>Location</label>
                                    <select class="form-control" name="state" onmousedown="if(this.options.length>5){this.size=5;}" onchange="this.blur()"  onblur="this.size=0;">
                                        <option value="">Any Location</option>
                                        <option value="Abuja FCT">Abuja FCT</option>
                                        <option value="Abia">Abia</option>
                                        <option value="Adamawa">Adamawa</option>
                                        <option value="Akwa Ibom">Akwa Ibom</option>
                                        <option value="Anambra">Anambra</option>
                                        <option value="Bauchi">Bauchi</option>
                                        <option value="Bayelsa">Bayelsa</option>
                                        <option value="Benue">Benue</option>
                                        <option value="Borno">Borno</option>
                                        <option value="Cross River">Cross River</option>
                                        <option value="Delta">Delta</option>
                                        <option value="Ebonyi">Ebonyi</option>
                                        <option value="Edo">Edo</option>
                                        <option value="Ekiti">Ekiti</option>
                                        <option value="Enugu">Enugu</option>
                                        <option value="Gombe">Gombe</option>
                                        <option value="Imo">Imo</option>
                                        <option value="Jigawa">Jigawa</option>
                                        <option value="Kaduna">Kaduna</option>
                                        <option value="Kano">Kano</option>
                                        <option value="Katsina">Katsina</option>
                                        <option value="Kebbi">Kebbi</option>
                                        <option value="Kogi">Kogi</option>
                                        <option value="Kwara">Kwara</option>
                                        <option value="Lagos">Lagos</option>
                                        <option value="Nassarawa">Nassarawa</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Ogun">Ogun</option>
                                        <option value="Ondo">Ondo</option>
                                        <option value="Osun">Osun</option>
                                        <option value="Oyo">Oyo</option>
                                        <option value="Plateau">Plateau</option>
                                        <option value="Rivers">Rivers</option>
                                        <option value="Sokoto">Sokoto</option>
                                        <option value="Taraba">Taraba</option>
                                        <option value="Yobe">Yobe</option>
                                        <option value="Zamfara">Zamfara</option>
                                    </select>
                                </div>                               
                                    <!-- <input type="hidden" name="page" value="1"> -->
                                    <button type="submit" class="btn-primary btn-lg" name="action" value="search"> SEARCH </button>
                                </form>
                        </div>                        
                    </div>
                     <h2> VetMe - NIGERIA'S No.1 TECH SKILLS REPOSITORY</h2>
                    <br />

                    <div class="media">
                      <a class="media-left" href="#">
                          <img src="assets/img/1.jpg" alt="" class="img-rounded" />
                      </a>
                          <div class="media-body">
                            <h4 class="media-heading"><strong>What we do</strong> </h4>
                              Employers often search for competent manpower-people that can do the job. While those with skills cannot find their potential employers. <strong>VetMe</strong> is here to bridge this gap and seal this divide! <strong>VetMe.com.ng</strong> provides a platform where Skilled Nigerians can register and the public can vouch-for or Vet them.
                        </div>

                    </div>                    
            </div>
                 
            <div class="row">
            <div class=" col-md-6 col-sm-6">
                <div class="table-responsive">
                     <form action="?view" method="get">
                            <table class="table table-striped table-bordered table-hover"><strong>TOP VETTED</strong>
                                <thead>
                                    <tr>
                                        <th>Position</th>
                                        <th>First Name</th>
                                        <th>Location</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php 
                                            $count=1;
                                            foreach($vetmeusers as $user):
                                        ?>
                                        <tr>
                                            <td><?php echo $count;?></td>
                                            <td><span class="label label-success"><?php echo $user['fname'];?></span></td>
                                            <td><?php htmlout($user['state']);?></td>                                            
                                            <td>                                               
                                                <button type="submit" name="view" value="<?php htmlout($user['id']);?>" class="btn btn-primary btn-sm">View</button>                                                
                                            </td>
                                            <?php $count++;?>
                                        </tr>         
                                        <?php if($count==6):?>
                                        <?php break;?>                              
                                    <?php endif;?>
                                    <?php endforeach;?>
                                    
                                </tbody>
                            </table>
                            <form>
                    </div>
                     
                 
                  <br />            
                
                    
            </div>  

            <div class="alert  alert-info col-md-6 col-sm-6">
                    <div class="current-notices">

                            <h3>Current Notices :</h3>
                    <hr />
                    <ul>
                        <?php foreach($notices as $notice):?>
                            <li>
                                <?php echo $notice['text'];?>
                            </li>
                        <?php endforeach;?>
                    </ul>
                    </div>
                </div>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
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
