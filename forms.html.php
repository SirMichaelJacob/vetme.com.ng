<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VetMe - Sign Up</title>
    <!-- BOOTSTRAP STYLES-->
    
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
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">SIGN UP</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Let us know about your Skill
                        </div>
                        <div class="panel-body">
<form action="." method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" name="email" id="exampleInputEmail1" required placeholder="Enter email" />
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password" id="password" onkeyup='check();' required placeholder="Password" />
  </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Re-Password</label>
    <input type="password" class="form-control" name="repassword"  id="repassword" onkeyup="check();" required placeholder="Re-type Password" />
    <span id='message'></span>
  </div>
  
  <div class="checkbox">
    
  </div>
  
  <hr />
    <label for="exampleInputEmail1">First Name</label>
    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" required/>
    <label for="exampleInputEmail1">Surname</label>
    <input type="text" class="form-control" name="surname" id="surname" placeholder="Surname" required/>
    <label for="exampleInputEmail1">Phone</label>
    <input type="text" class="form-control" name="phone" id="phone" placeholder="08012345678" required/>
    <label for="exampleInputEmail1">Gender</label>
    <div class="radio">                           
     <label>
     <input type="radio" name="gender" id="gender" value="Male" checked />
         Male
     </label>
     </div>
    <div class="radio">
     <label>
    <input type="radio" name="gender" id="gender" value="Female" />
    Female
    </label>
    </div>
                           
  <div class="checkbox">
  
  <hr>
  
</div>

                            </div>
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Continue
                        </div>
                        <div class="panel-body">                          
                           

                        <!-- DOB ///////////////////////////////////////////////////////////////// -->
                        <div>
                            <label>Date of Birth</label>
                                <select name="year" id="year" required>
                                  <option value="">Year</option>
                                  <?php for ($year = date('Y'); $year > date('Y')-50; $year--) { ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                    <?php } ?>
                                </select>
                                <select name="month" id="month" required>
                                    <option value="">Month</option>
                                    <?php for ($month = 1; $month <= 12; $month++) { ?>
                                        <option value="<?php echo strlen($month)==1 ? '0'.$month : $month; ?>"><?php echo strlen($month)==1 ? '0'.$month : $month; ?></option>
                                    <?php } ?>
                                </select>
                                <select name="day" id="day" required>
                                  <option value="">Day</option>
                                    <?php for ($day = 1; $day <= 31; $day++) { ?>
                                    <option value="<?php echo strlen($day)==1 ? '0'.$day : $day; ?>"><?php echo strlen($day)==1 ? '0'.$day : $day; ?></option>
                                    <?php } ?>
                                </select>

                        </div>



                        <!-- ///////////////////////////////////////////////////////////////////// -->
                            <label for="exampleInputEmail1">Address</label>
                           <input type="text" class="form-control" name="address" id="address" placeholder="Address" required />
                           <div class="form-group">
                                            <label>What is your Skill? (You can Select Multiple Skills)</label>
                                            <select multiple="" name="skills[]" id="skills[]" class="form-control" required>
                                                <?php foreach($skills as $skill):?>
                                                    <option value=<?php echo $skill['id'];?>><?php echo $skill['skill'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                           <hr />
                           <label for="exampleInputEmail1">Description (Tell us about your Skill)</label>
                            <select name="desc" id="desc" class="form-control" required>
                                <option value="">Select your skill level</option>
                                <option value="Expert">Expert</option>
                                <option value="Very Skilled">Very Skilled</option>
                                <option value="Fairly Skilled">Fairly Skilled</option>
                            </select>
                           <hr />
                           <div class="form-group">
                                            <label>State of Residence</label>
                                            <select class="form-control" name="state" onmousedown="if(this.options.length>5){this.size=5;}" onchange="this.blur()"  onblur="this.size=0;" id="state" required>
                                                <option value="">Where Do you Live?</option>                                                
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
                            <hr />
                            <!-- For more customization for this template or its components please
                             visit official bootstrap website i.e <strong> getbootstrap.com </strong> or
                            <a href="http://getbootstrap.com/css/#forms" target="_blank">click here</a> -->
                            <label>
                                  By signing up you have agreed to the Terms and Conditions of use
                            </label>
                              <hr>
                              <button type="submit" name="register" id="submit" class="btn btn-success">Submit</button>
                              <!-- <input type="submit" class="btn btn-default" value="Cancel"> -->
                              <a href="."><button type="button" class="btn btn-warning">Cancel</button></a>
                            </form>
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
    
    <script type="text/javascript">

        $("#phone").on('input', function() {  //this is use for every time input change.
        var inputValue = getInputValue(); //get value from input and make it usefull number
        var length = inputValue.length; //get lenth of input
        
        if (inputValue < 1000)
        {
            inputValue = '('+inputValue;
        }else if (inputValue < 1000000) 
        {
            inputValue = '('+ inputValue.substring(0, 3) + ')' + inputValue.substring(3, length);
        }else if (inputValue < 10000000000) 
        {
            inputValue = '('+ inputValue.substring(0, 3) + ')' + inputValue.substring(3, 6) + '-' + inputValue.substring(6, length);
        }else
        {
            inputValue = '('+ inputValue.substring(0, 3) + ')' + inputValue.substring(3, 6) + '-' + inputValue.substring(6, 10);
        }       
        $("#phone").val(inputValue); //correct value entered to your input.
        inputValue = getInputValue();//get value again, becuase it changed, this one using for changing color of input border
       if ((inputValue > 2000000000) && (inputValue < 9999999999))
      {
          $("#phone").css("border","green solid 1px");//if it is valid phone number than border will be black.
          document.getElementById("submit").disabled = false;
      }else
      {
          $("#phone").css("border","red solid 1px");//if it is invalid phone number than border will be red.
          document.getElementById("submit").disabled = true;

      }
  });

    function getInputValue() 
    {
         var inputValue = $("#phone").val().replace(/\D/g,'');  //remove all non numeric character
        if (inputValue.charAt(0) == 1) // if first character is 1 than remove it.
        {
            var inputValue = inputValue.substring(1, inputValue.length);
        }
        return inputValue;
    }

    </script>


</body>
</html>
