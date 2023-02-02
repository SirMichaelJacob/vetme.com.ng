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
                        <h1 class="page-head-line">UPDATE USER INFO</h1>
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
    <input type="email" class="form-control" name="email" id="exampleInputEmail1" required placeholder="Enter email" 
    <?php if(isset($thisUser) and count($thisUser)>0)
    {
        echo "value=".$thisUser['email'];
        echo " disabled";        
    }   
    ?>

    />
  </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password" id="password" onkeyup='check();' placeholder="Password" />
  </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Re-Password</label>
    <input type="password" class="form-control" name="repassword"  id="repassword" onkeyup="check();" placeholder="Re-type Password" />
    <span id='message'></span>
  </div>
  
  <div class="checkbox">
    
  </div>
  
  <hr />
    <label for="exampleInputEmail1">First Name</label>
    <input type="text" class="form-control" name="firstname" placeholder="First Name" required

        <?php if(isset($thisUser) and count($thisUser)>0)
        {
            echo "value=".$thisUser['fname'];
        }   
        ?>


    />
    <label for="exampleInputEmail1">Surname</label>
    <input type="text" class="form-control" name="surname" placeholder="Surname" required
    <?php if(isset($thisUser) and count($thisUser)>0)
        {
            echo "value=".$thisUser['sname'];
        }   
    ?>

    />
    <label for="exampleInputEmail1">Phone</label>
    <input type="text" class="form-control" name="phone" placeholder="Phone" required
    <?php if(isset($thisUser) and count($thisUser)>0)
        {
            echo "value=".$thisUser['phone'];
        }   
        ?>

    />
    <label for="exampleInputEmail1">Gender</label>
                           <div class="radio">
                           <?php foreach($genderArray as $sex):?>
                            <div>                           
                               <label>
                                <input type="radio" name="gender" value="<?php htmlout($sex);?>" 
                                <?php 
                                    if($thisUser['gender']==$sex)
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
                                 <?php if(isset($thisUser) and count($thisUser)>0)
                                    {
                                       $dob=explode("-", $thisUser['dob']);                                        
                                        
                                    }   
                                    ?>
                                <select name="year" required>
                                  <option value="">Year</option>
                                  <?php for ($year = date('Y'); $year > date('Y')-50; $year--) { ?>
                                    <option value="<?php echo $year; ?>"
                                        <?php
                                        if($year==$dob[0])
                                        {
                                            echo " selected";
                                        }
                                        ?>
                                        ><?php echo $year; ?></option>
                                    <?php } ?>
                                </select>
                                <select name="month" required>
                                    <option value="">Month</option>
                                    <?php for ($month = 1; $month <= 12; $month++) { ?>
                                        <option value="<?php echo strlen($month)==1 ? '0'.$month : $month; ?>"

                                            <?php
                                                if($month==$dob[1])
                                                {
                                                    echo " selected";
                                                }
                                                ?>

                                            ><?php echo strlen($month)==1 ? '0'.$month : $month; ?></option>
                                    <?php } ?>
                                </select>
                                <select name="day" required>
                                  <option value="">Day</option>
                                    <?php for ($day = 1; $day <= 31; $day++) { ?>
                                    <option value="<?php echo strlen($day)==1 ? '0'.$day : $day; ?>"

                                            <?php
                                                if($day==$dob[2])
                                                {
                                                    echo " selected";
                                                }
                                                ?>

                                        ><?php echo strlen($day)==1 ? '0'.$day : $day; ?></option>
                                    <?php } ?>
                                </select>

                        </div>



                        <!-- ///////////////////////////////////////////////////////////////////// -->
                            <label for="exampleInputEmail1">Address</label>
                           <input type="text" class="form-control" name="address" value="<?php htmlout($thisUser['address']);?>" placeholder="Address" required />
                           <div class="form-group">
                                            <?php
                                                $thisSkills=array(); 
                                                foreach($userSkills as $userSkill)
                                                {
                                                    if($userSkill['userid']==$thisUser['id'])
                                                    {
                                                        array_push($thisSkills,$userSkill['skillid']);
                                                    }
                                                }
                                            ?>
                            <label>What is your Skill? (You can Select Multiple Skills)</label>
                            <select multiple="" name="skills[]" class="form-control">
                                <?php foreach($skills as $skill):?>
                                <option value="<?php echo $skill['id'];?>"

                                <?php foreach($thisSkills as $USkill)
                                      {
                                        if($skill['id']==$USkill)
                                        {
                                            echo ' selected';
                                            //echo ' disabled';
                                            echo " style= color:green";
                                        }
                                      }

                                ?>
                                ><?php echo $skill['skill'];?></option>
                                <?php endforeach;?>
                            </select>
                            </div>
                           <hr />
                           <label for="exampleInputEmail1">Description (Tell us about your Skill)</label>
                            <select name="desc" class="form-control" required>
                                <option value="">Select your skill level</option>
                                <option value="Expert"

                                    <?php if(isset($thisUser) and count($thisUser)>0)
                                            {
                                                if($thisUser['desc']=="Expert")
                                                {
                                                     echo " selected";
                                                }
                                               
                                            }   
                                    ?>  

                                >Expert</option>
                                <option value="Very Skilled"
                                     <?php if(isset($thisUser) and count($thisUser)>0)
                                            {
                                                if($thisUser['desc']=="Very Skilled")
                                                {
                                                     echo " selected";
                                                }
                                               
                                            }   
                                    ?>  


                                >Very Skilled</option>
                                <option value="Fairly Skilled"
                                    <?php if(isset($thisUser) and count($thisUser)>0)
                                            {
                                                if($thisUser['desc']=="Fairly Skilled")
                                                {
                                                    echo " selected";
                                                }
                                                
                                            }   
                                    ?>  
                                     

                                >Fairly Skilled</option>
                            </select>
                           <hr />
                           <div class="form-group">
                                            <label>State of Residence</label>
                                            <select class="form-control" name="state" onmousedown="if(this.options.length>5){this.size=5;}" onchange="this.blur()"  onblur="this.size=0;" required>
                                                <option value="">Where Do you Live?</option>                                                
                                                <option value="Abuja FCT"  <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Abuja") echo " selected";}?>>Abuja FCT</option>
                                                <option value="Abia"  <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Abia") echo " selected";}?>>Abia</option>
                                                <option value="Adamawa"  <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Adamawa") echo " selected";}?>>Adamawa</option>
                                                <option value="Akwa Ibom"  <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Akwa Ibom") echo " selected";}?>>Akwa Ibom</option>
                                                <option value="Anambra"  <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Anambra") echo " selected"; }?>>Anambra</option>
                                                <option value="Bauchi"  <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Bauchi") echo " selected";}?>>Bauchi</option>
                                                <option value="Bayelsa"  <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Bayelsa") echo " selected";}?>>Bayelsa</option>
                                                <option value="Benue" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Benue") echo " selected";}?>>Benue</option>
                                                <option value="Borno" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Borno") echo " selected";}?>>Borno</option>
                                                <option value="Cross River" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Cross River") echo " selected";}?>>Cross River</option>
                                                <option value="Delta" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Delta") echo " selected";}?>>Delta</option>
                                                <option value="Ebonyi" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Ebonyi") echo " selected";}?>>Ebonyi</option>
                                                <option value="Edo" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Edo") echo " selected";}?>>Edo</option>
                                                <option value="Ekiti" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Ekiti") echo " selected";}?>>Ekiti</option>
                                                <option value="Enugu" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Enugu") echo " selected";}?>>Enugu</option>
                                                <option value="Gombe" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Gombe") echo " selected";}?>>Gombe</option>
                                                <option value="Imo" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Imo") echo " selected";}?>>Imo</option>
                                                <option value="Jigawa" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Jigawa") echo " selected";}?>>Jigawa</option>
                                                <option value="Kaduna" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Kaduna") echo " selected";}?>>Kaduna</option>
                                                <option value="Kano" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Kano") echo " selected";}?>>Kano</option>
                                                <option value="Katsina" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Katsina") echo " selected";}?>>Katsina</option>
                                                <option value="Kebbi" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Kebbi") echo " selected";}?>>Kebbi</option>
                                                <option value="Kogi" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Kogi") echo " selected";}?>>Kogi</option>
                                                <option value="Kwara" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Kwara") echo " selected";}?>>Kwara</option>
                                                <option value="Lagos" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Lagos") echo " selected";}?>>Lagos</option>
                                                <option value="Nassarawa" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Nassarawa") echo " selected";}?>>Nassarawa</option>
                                                <option value="Niger" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Niger") echo " selected";}?>>Niger</option>
                                                <option value="Ogun" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Ogun") echo " selected";}?>>Ogun</option>
                                                <option value="Ondo" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Ondo") echo " selected";}?>>Ondo</option>
                                                <option value="Osun" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Osun") echo " selected";}?>>Osun</option>
                                                <option value="Oyo" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Oyo") echo " selected";}?>>Oyo</option>
                                                <option value="Plateau" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Plateau") echo " selected";}?>>Plateau</option>
                                                <option value="Rivers" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Rivers") echo " selected";}?>>Rivers</option>
                                                <option value="Sokoto" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Sokoto") echo " selected";}?>>Sokoto</option>
                                                <option value="Taraba" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Taraba") echo " selected";}?>>Taraba</option>
                                                <option value="Yobe" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Yobe") echo " selected";}?>>Yobe</option>
                                                <option value="Zamfara" <?php if(isset($thisUser) and count($thisUser)>0){if($thisUser['state']=="Zamfara") echo " selected";}?>>Zamfara</option>
                                    </select>
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

                                        if($thisUser['verified'] == $option)
                                        {
                                            echo ' checked';
                                        } 
                                    ?>
                                >
                               <?php htmlout($option);?>

                              </label>
                              </div>
                            <?php endforeach;?>
                            <hr />
                            <!-- For more customization for this template or its components please
                             visit official bootstrap website i.e <strong> getbootstrap.com </strong> or
                            <a href="http://getbootstrap.com/css/#forms" target="_blank">click here</a> -->
                            <label>
                                  *By signing up you have agreed to the Terms and Conditions of use
                            </label>
                              <hr>
                              <input type="hidden" name="myID" value="<?php htmlout($thisUser['id']);?>"/>
                              <button type="submit" name = "update" id="submit" value="Update" class="btn btn-success" 
                              <?php if(isset($specialUser))
                              {
                                echo ' disabled';
                              }
                              ?>

                              >Submit</button>
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
