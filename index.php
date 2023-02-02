<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/iknowdb.inc.php';
require $_SERVER['DOCUMENT_ROOT'].'/controller.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/class.phpmailer.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/class.smtp.php';

session_start();



$GLOBALS['searchUrl']="";
try 
{
	$result=$GLOBALS['pdo']->query("SELECT * FROM user ORDER BY totalVets DESC");
	//$GLOBALS['pdo']=null;
} 
catch (PDOException $e)
{
	$output="Unable to get Users";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}
foreach($result as $row)
{

	$vetmeusers[]=array('id'=>$row['id'],'email'=>$row['email'],'password'=>$row['password'],'fname'=>$row['firstname'],'sname'=>$row['surname'],'phone'=>$row['phone'],'gender'=>$row['gender'],'dob'=>$row['dob'],'address'=>$row['address'],'state'=>$row['state'],'desc'=>$row['description'],'code'=>$row['code'],'verified'=>$row['verified'],'totVet'=>$row['totalVets']);

}

$match=false;
///////////////////////////Register////////////////////////////////////////
if(isset($_POST['register']))
{
	$foundEmail=false;
	$randNum=rand(100001,900001);

	foreach($users as $user)
	{
		if($user['email'] == $_POST['email'])
		{
			$foundEmail=true;
			break;
		}
	}

	if($foundEmail==false)
	{
		try
		{
			$pwd = md5($_POST['password']);
			$sql="INSERT INTO user SET email=:email,password=:password,firstname=:firstname,surname=:surname,phone=:phone,gender=:gender,dob=:dob,address=:address,description=:description,state=:state,code=:code";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':email',$_POST['email']);
			$s->bindValue(':password',$pwd);
			$s->bindValue(':firstname',$_POST['firstname']);
			$s->bindValue(':surname',$_POST['surname']);
			$s->bindValue(':phone',$_POST['phone']);
			$s->bindValue(':gender',$_POST['gender']);
			$s->bindValue(':dob',$_POST['year']."-".$_POST['month']."-".$_POST['day']);
			$s->bindValue(':address',$_POST['address']);
			$s->bindValue(':state',$_POST['state']);
			$s->bindValue(':description',$_POST['desc']);
			$s->bindValue(':code',$randNum);
			$s->execute();
		} 
		catch (PDOException $e)
		{
			$output="Unable to Register new User ";
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}
		$userid=$pdo->lastInsertId();

		if(isset($_POST['skills']))
		{
			foreach($_POST['skills'] as $skillid)
			{
				try 
				{

					$sql="INSERT INTO userskill SET userid=:userid,skillid=:skillid";
					$s=$GLOBALS['pdo']->prepare($sql);
					$s->bindValue(':userid',$userid);
					$s->bindValue(':skillid',$skillid);
					$s->execute();
				} 
				catch (PDOException $e) 
				{
					$output="Unable to INSERT new User Skills";
					include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
				}

			}
		}
		try 
		{
			$sql="INSERT into userlog SET userid=:userid,regDate=CURDATE(),lastLogin=CURDATE()";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':userid',$userid);
			$s->execute();
		} catch (PDOException $e)
		{
			
		}

	
		$mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch

        $mail->IsSMTP(); // telling the class to use SMTP
////////////////////////Send Confirmation email to New USER/////////////////
        try {
        $mail->Host= "mail.vetme.com.ng"; // SMTP server
              $mail->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth= true;                  // enable SMTP authentication
              $mail->SMTPSecure = "ssl";// secure transfer enabled REQUIRED for Gmail
              $mail->Mailer  = "smtp";
              $mail->Host="mail.vetme.com.ng"; // sets the SMTP server
              $mail->Port= 465;                 // set the SMTP port for the GMAIL server
              $mail->Username= "feedback@vetme.com.ng"; // SMTP account username
              $mail->Password   = "lixlyn101#";        // SMTP account password
              $mail->AddReplyTo('support@vetme.com.ng');
              $recipient=$_POST['email'];
              $mail->AddAddress("$recipient",$_POST['email']);
              $mail->SetFrom('feedback@vetme.com.ng','VetMe');
              $mail->AddReplyTo('feedback@vetme.com.ng');
              $mail->Subject = "New VetMe Account Confirmation";
            //   $mail->AltBody = "Your password on VetMe.com.ng (Nigeria's no.1 Skills repository) has been reset.\r\n Please visit www.vetMe.com.ng and Enter ".$code." to Confirm reset."; // optional - MsgHTML will create an alternate automatically
              $mail->Body = "Welcome to VetMe.com.ng (Nigeria's no.1 Tech Skills repository) \r\n Please Login to www.vetMe.com.ng/?login and Enter ".$randNum." to Confirm your registration.";
              //$mail->MsgHTML(file_get_contents('contents.html'));
              //$mail->AddAttachment('images/phpmailer.gif');      // attachment
              //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
              $mail->Send();
             
            } catch (phpmailerException $e) {
              //echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
              //echo $e->getMessage(); //Boring error messages from anything else!
            }
		
		$alertType="alert-danger1";
		$message="Your Registration was successful!<br/>A confirmation email containing a <strong>verification code</strong> has been sent to you. [Also Check your Junk or Spam folder]";
		
	/////Notify ADMIN//////////////////////////////////////////////////////
	
	$mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch

    $mail->IsSMTP(); // telling the class to use SMTP
	
	try {
        $mail->Host= "mail.vetme.com.ng"; // SMTP server
              $mail->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth= true;                  // enable SMTP authentication
              $mail->SMTPSecure = "ssl";// secure transfer enabled REQUIRED for Gmail
              $mail->Mailer  = "smtp";
              $mail->Host="mail.vetme.com.ng"; // sets the SMTP server
              $mail->Port= 465;                 // set the SMTP port for the GMAIL server
              $mail->Username= "feedback@vetme.com.ng"; // SMTP account username
              $mail->Password   = "lixlyn101#";        // SMTP account password
              $mail->AddReplyTo('support@vetme.com.ng');
              //$recipient='admin@vetme.com.ng';
              $mail->AddAddress("admin@vetme.com.ng",'Admin');
              $mail->SetFrom('feedback@vetme.com.ng','VetMe');
              $mail->AddReplyTo('feedback@vetme.com.ng');
              $mail->Subject = "New VetMe USER registration";
            //   $mail->AltBody = "Your password on VetMe.com.ng (Nigeria's no.1 Skills repository) has been reset.\r\n Please visit www.vetMe.com.ng and Enter ".$code." to Confirm reset."; // optional - MsgHTML will create an alternate automatically
              $mail->Body = "A New User has just registered on VetMe.com.ng \r\n User Email: ".$_POST['email'];
              //$mail->MsgHTML(file_get_contents('contents.html'));
              //$mail->AddAttachment('images/phpmailer.gif');      // attachment
              //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
              $mail->Send();
             
            } catch (phpmailerException $e) {
              //echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
              //echo $e->getMessage(); //Boring error messages from anything else!
            }
	
	
	}
	else
	{
		$alertType="alert-danger";
		$message="Your Registration was NOT successful!<br/>The email address you entered already exist";
		
	}
		

}

/////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////
if(isset($_GET['signup']))
{
	if(!isLoggedIn())
	{
		include 'forms.html.php';
		exit();
	}
	else
	{
		header('Location:/vetme/user');
		exit();
	}
	
}
////////////////////////////////////////////LOGIN/////////////////////////////////////////////////////////////
if(isset($_GET['login']))
{
	include 'login.html.php';
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['login']) and $_POST['login'] == 'Login')
{
	if($_POST['email']=='' or $_POST['password']=='' )
	{
		$GLOBALS['logginError']='Please Fill all fields';		
		include'login.html.php';
		exit();
	}

	$password= md5($_POST['password']);
	if(!dbContainsUser($_POST['email'],$password))
	{	
		$GLOBALS['logginError']="\t Wrong Login credentials";
		include'login.html.php';
		exit();
	}
	else
	{
		$_SESSION['email']=$_POST['email'];
	}

	
	$email=$_SESSION['email'];

	foreach($users as $user)
	{
		if($user['email']== $email and $user['verified']=='YES')
		{
			$GLOBALS['userid']=$user['id'];
			$GLOBALS['sname']=$user['sname'];
			$GLOBALS['fname'] = $user['fname'];
			$GLOBALS['userid']=$user['id'];
			$GLOBALS['verified']=true;
			break;
		}
	}


	if($GLOBALS['verified']==false)
	{
		$_SESSION['email']=$_POST['email'];
		$message ="Your Account is Not yet Confirmed. Please enter the <strong><i>confirmation code</i></strong> sent to your email.[Check your Junk or Spam folder for the email]";
		include 'login.html.php';
		exit();
	}
	else if($GLOBALS['verified']==true)
	{
		session_start();
		$_SESSION['email']=$_POST['email'];
		$_SESSION['password']=$password;
		$_SESSION['loggedIn']=TRUE;
		$_SESSION['userid']=$userid;
		try 
		{
			$sql="UPDATE userlog SET lastLogin=CURDATE() where userid=:userid";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':userid',$userid);
			$s->execute();
		} 
		catch (PDOException $e)
		{
			$output="Failed to Update userLog.";
			include'includes/output.html.php';
			exit();
		}
		header('Location:./user/');
		exit();
		
	}
	
}
/////////////////////////////////////////VETTING////////////////////////////////////////////
if(isset($_POST['btnvet']))
{
	$continue=true;	

	if(!isset($_SESSION))
	{
		session_start();
						
	}
	unset($_SESSION['vetmsg']);

	$UserExists=false;
	foreach($users as $user)
	{

		if($user['id']==$_POST['vet'])
		{
			$UserExists=true;
			break;
		}
	}
	if(!$UserExists)
	{
		echo "User does not exist!";
	}
	else
	{
		if(isLoggedIn())
		{
			
			foreach($vets as $vet)
			{
				if($vet['userid']==$_POST['vet'] and $vet['vetter']==$_SESSION['userid'] and $vet['skillid']==$_POST['sid'])
				{
					$continue=false;
					break;
				}
			}

			if($continue)
			{
				try 
				{
					$sql="INSERT INTO vetlog SET userid=:userid,vetter=:vetter,skillid=:skillid,date=CURDATE()";
					$s=$GLOBALS['pdo']->prepare($sql);
					$s->bindValue(':userid',$_POST['vet']);
					$s->bindValue(':vetter',$_SESSION['userid']);
					$s->bindValue(':skillid',$_POST['sid']);
					$s->execute();
				} 
				catch (PDOException $e) 
				{
					$output="Failed to Vet ".$e->getMessage();
					include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
				}
				//////////////////////////////Get USERNAME////////////////////////////////////////////
				foreach($users as $user)
	            {
	                if($user['id']==$_SESSION['userid'])
	                {
	                    $GLOBALS['username'] = strtoupper($user['sname'])." " .$user['fname'];
	                    break;
	                }
	            }   

	            $thisSkill="";
	            foreach($skills as $skill)
	            {
	                if($_POST['sid']==$skill['id'])
	                {
	                    $thisSkill = $skill['skill'];
	                    break;
	                }
	            }  

				//////////////////////////////////////////////////////////////////////////////////////

				try 
				{
					$sql="INSERT INTO message SET userid=:userid,content=:content,date=CURDATE()";
					$s=$GLOBALS['pdo']->prepare($sql);
					$s->bindValue(':userid',$_POST['vet']);
					$s->bindValue(':content',"USER-ID: ".$_SESSION['userid']." "."has just vetted you for $thisSkill.\r\n");
					$s->execute();
				} 
				catch (PDOException $e) 
				{
					$output="Failed to send notification ";
					include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
				}
                $umail="";
                $ufname="";
                foreach($users as $user)
                {
                    if($user['id']==$_POST['vet'])
                    {
                        $umail=$user['email'];
                        $ufname=$user['fname'];
                        break;
                    }
                }
                //////////////SEND email to User//////////////////////////
                $mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch

        $mail->IsSMTP(); // telling the class to use SMTP
////////////////////////Send Confirmation email to New USER/////////////////
        try {
        $mail->Host= "mail.vetme.com.ng"; // SMTP server
              $mail->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth= true;                  // enable SMTP authentication
              $mail->SMTPSecure = "ssl";// secure transfer enabled REQUIRED for Gmail
              $mail->Mailer  = "smtp";
              $mail->Host="mail.vetme.com.ng"; // sets the SMTP server
              $mail->Port= 465;                 // set the SMTP port for the GMAIL server
              $mail->Username= "feedback@vetme.com.ng"; // SMTP account username
              $mail->Password   = "lixlyn101#";        // SMTP account password
              $mail->AddReplyTo('support@vetme.com.ng');
              $recipient=$umail;
              $mail->AddAddress("$recipient",$ufname);
              $mail->SetFrom('feedback@vetme.com.ng','VetMe');
              $mail->AddReplyTo('feedback@vetme.com.ng');
              $mail->Subject = "You have just been Vetted";
            //   $mail->AltBody = "Your password on VetMe.com.ng (Nigeria's no.1 Skills repository) has been reset.\r\n Please visit www.vetMe.com.ng and Enter ".$code." to Confirm reset."; // optional - MsgHTML will create an alternate automatically
              $mail->Body = "Congratulations!! \r\nUSER-ID=".$_SESSION['userid']. " just vetted you for $thisSkill! \r\n VetMe.com.ng (Nigeria's no.1 Tech Skills repository)";
              //$mail->MsgHTML(file_get_contents('contents.html'));
              //$mail->AddAttachment('images/phpmailer.gif');      // attachment
              //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
              $mail->Send();
             
            } catch (phpmailerException $e) {
              //echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
              //echo $e->getMessage(); //Boring error messages from anything else!
            }
            ///////////////////////////////////////////////////////////////////

				if(!isset($_SESSION))
				{
					session_start();
					
				}
				unset($_SESSION['vetmsg']);
				$_SESSION['vetmsg']="Vetting Successful";
				$_SESSION['vetclicked']=true;
				
				$countVet=0;
        		foreach($vets as $vet)
        	    {
        	       if($vet['userid']==$_POST['vet'])
        	       {
        	       		$countVet++;
        	       }
        
        	    }

////////////////////////////Comment Out after Development................/////////////////
	    		try 
				{
					$sql="UPDATE user SET totalVets=:totalVets where id=:id";
					$s=$GLOBALS['pdo']->prepare($sql);
					$s->bindValue(':totalVets',$countVet);
					$s->bindValue(':id',$_POST['vet']);
					$s->execute();
				} 
					catch (PDOException $e) 
				{
					$output="Failed to update user total vets ";
					include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
				}

/////////////////////////////////////////////////////////////////////////////////////////////////
			}
			else
			{

				if(!isset($_SESSION))
				{
					session_start();
					
				}
				unset($_SESSION['vetmsg']);
				$_SESSION['vetmsg']="You have already vetted this user.";
				
			}

		}
		// else
		// {
		// 	echo 'Please Login to Vet';
		// }

	}


}




/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////CONFIRM//////////////////////////////////////////////////////////
if(isset($_POST['confirm']) and $_POST['confirm'] == 'Confirm')
{

		try 
		{
			$sql="UPDATE user set verified='YES' where code=:code and email=:email";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':email',$_SESSION['email']);
			$s->bindValue(':code',$_POST['code']);
			$s->execute();
			
		} 
		catch (PDOException $e)
		{
			$message ="Error ".$e->getMessage();
			include 'login.html.php';
			exit();
		}

		//////////////////////////////////////////Refresh the Array of USERS///////////////////////////////
		
		try 
		{
			$result=$GLOBALS['pdo']->query("SELECT id,email,password,firstname,surname,phone,gender,address,state,description,code,verified FROM user");
		} 
		catch (PDOException $e)
		{
			$output="Unable to fetch Users";
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}

		foreach($result as $row)
		{
			$users[]=array('id'=>$row['id'],'email'=>$row['email'],'password'=>$row['password'],'fname'=>$row['firstname'],'sname'=>$row['surname'],'phone'=>$row['phone'],'gender'=>$row['gender'],'address'=>$row['address'],'state'=>$row['state'],'desc'=>$row['description'],'code'=>$row['code'],'verified'=>$row['verified']);
		}

		///////////////////////////////////////////////////////////////////////////////////////////////////////

		foreach($users as $user)
		{
			if($user['email']==$_SESSION['email'] and $user['verified']=='YES')
			{
				$GLOBALS['verified']=true;
				break;
			}
		}
		if($GLOBALS['verified']==true)
		{
			$message="Your Account has been Verified!<br/> Please Login.";
			include 'login.html.php';
			exit();
		}
		else
		{
			$GLOBALS['verified']==false;
			$message="INCORRECT Verification code.";
			include 'login.html.php';
			exit();
		}
		
	
	
}
/////////////////////////////Search///////////////////////////////////////////////////////

if(isset($_GET['action']) or isset($_POST['start']))
{	

	$placeholders=array();
	


	$select ="SELECT userid,skillid ";
	// $select="SELECT id,email,firstname, surname, state ";
	$from="FROM userskill ";
	$where=" where TRUE";

	if($_GET['skill']!='')
	{
		$where.= " AND skillid=:skillid ";	
		$placeholders[':skillid']=$_GET['skill'];
	}
	

	if($_GET['state']!='')
	{
		$from .='INNER JOIN user ON id=userid ';
		$where.=" AND state=:state ";
		$placeholders[':state']=$_GET['state'];
	}

	// if($_GET['text'] != '')
	// {
	// 	$where.=" AND userid like :userid";
	// 	$placeholders[':userid']='%'.$_GET['text'].'%';
	// }

	if(!(isset($_POST['start'])))
	{
		$start=0;
	}
	else
	{
		$value = explode("|", $_POST['start']); //


		$start=$value[0];

		

		$option = $value[1]; //PAGE NUMBER SELECTED
	}

	
	
	$rowsperpage=8;

	//$page=1;
	//$start= $page*$rowsperpage;
	////////////For calculating the MAXPAGE///........................../////
	try 
	{
		$sql = $select . $from . $where;
		$s =$GLOBALS['pdo']->prepare($sql);
		$s->execute($placeholders);
	} 
	catch (PDOException $e)
	{
		$output = 'Error fetching users. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		exit();
	}

	foreach ($s as $row)
	{
		$All_1[] = array('userid' => $row['userid'], 'skillid' =>$row['skillid']);
	}

	if(isset($All_1))

	{	
		$TotalResults= array();
		foreach($users as $user)
		{			
			foreach($All_1 as $person)
			{
				if($user['id']==$person['userid'] and $user['verified']=='YES')
				{
					if(!in_array($user, $TotalResults))
					{
						array_push($TotalResults,$user);
					}
					
				}
			}
		}
	}
//////////////////////..........................................//////////
	try
	{
		$sql = "$select $from  $where LIMIT $start , $rowsperpage";
		// $sql = $select . $from . $where;
		$s =$GLOBALS['pdo']->prepare($sql);
		$s->execute($placeholders);
	}
	catch (PDOException $e)
	{
		$output = 'Error fetching users. '.$e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		exit();
	}
	
	foreach ($s as $row)
	{
		$All[] = array('userid' => $row['userid'], 'skillid' =>$row['skillid']);
	}

	
	$self=$_SERVER['REQUEST_URI'];

	if(isset($All))
	{	
		$searchResults= array();
		foreach($users as $user)
		{			
			foreach($All as $person)
			{
				if($user['id']==$person['userid'] and $user['verified']=='YES')
				{
					if(!in_array($user, $searchResults))
					{
						$searchResults[]=$user;
						// array_push($searchResults,$user);
					}
					
				}
			}
		}
	}
	//$self=$_SERVER['QUERY_STRING'];

	$GLOBALS['searchUrl'] = $_SERVER['QUERY_STRING'];
	if(isset($TotalResults) and count($TotalResults)>=0)
	{
		$numrec= count($TotalResults);///Count total search
		$val=$numrec/$rowsperpage;
		$maxpage=ceil($val);
	}
	
	
	

 	$GLOBALS['myVetted']=array();
 	if(isLoggedIn())
 	{
 		foreach($vets as $vet)
		{
			if($vet['vetter'] == $_SESSION['userid'])
			{
				array_push($GLOBALS['myVetted'],$vet['userid']);
			}
		}
 	}
 	
	if(!isset($_SESSION))
	{
		session_start();
						
	}
	unset($_SESSION['vetmsg']);
	$_SESSION['vet']=false;
	
	
	//header('Location:./search/');
	include 'search.html.php';
	//$GLOBALS['searchUrl'] = $_SERVER['REQUEST_URI'];
	exit();

}

//////////////////////////////Add to CART////////////////////////////////////////////////////
if(isset($_POST['request']) and $_POST['request']=='request')
{
	if(!isset($_SESSION))
	{
		session_start();		
	}
	if(!isset($_SESSION['cart']))
	{
		$_SESSION['cart']=array();						
	}

	if(!in_array($_POST['vet1'], $_SESSION['cart']))
	{
		$_SESSION['cart'][]=$_POST['vet1'];
	}	

}
////////////////////////////////////////////////////////////////////////////////////////

////////////////REMOVE ITEM FROM CART/////////////////////////////////////////////////
if(isset($_POST['remove']))
{

		foreach ($_SESSION['cart'] as $id)
		{
			if($id==$_POST['remove'])
			{
				if (($key = array_search($id, $_SESSION['cart'])) !== false) 
				{
    				unset($_SESSION['cart'][$key]);
				}
			}
		}
	header('Location:?checkout');
	exit();
}

/////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////EMPTY CART////////////////////////////////////////////
if(isset($_GET['emptyCart']))
{
	unset($_SESSION['cart']);
	header('Location:?checkout');
	exit();
}

///////////////////////////////////////////////////////////////////////////////////////

////////////////////////CHECKOUT/////////////////////////////////////////////////////////////////
if(isset($_GET['checkout']))
{	
	$selectedUsers=array();
	if(isset($_SESSION['cart']))
	{
		foreach($_SESSION['cart'] as $person)
		{
			foreach($users as $user)
			{
				if($person==$user['id'])
				{
					array_push($selectedUsers, $user);
				}
			}
		}
	}
	$GLOBALS['selectedUsers']=$selectedUsers;
	$GLOBALS['OrderTotal']=$price * count($selectedUsers);
	include 'request.html.php';
	exit();
}

///////////////////////////////////////////////////////////////////////////////////////////


////////////////Unregistered VETTER//////////////////////////////////////////////////////
if(isset($_GET['unregEmail']))
{
		try 
		{
			$result=$GLOBALS['pdo']->query("SELECT * FROM unknownusers");

		} 
		catch (PDOException $e)
		{
			$output="Unable to fetch Unknown Users ";
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}
		foreach($result as $row)
		{
			$xUsers[]=array('email'=>$row['email'],'code'=>$row['code'],'verified'=>$row['verified']);
		}
    $emailExists=false;
	$foundX=false;
	$vStatus='NO';
	
	foreach($xUsers as $xUser)
	{
		if($xUser['email'] == $_SESSION['xemail'])
		{
			$foundX=true;
			$vStatus=$xUser['verified'];
			break;
		}
	}
	
	foreach($users as $user)
	{
		if($user['email'] == $_SESSION['xemail'])
		{
			$emailExists=true;
			break;
		}
	}
	
	if(!$emailExists)
	{

    	if(!$foundX and $vStatus=='NO')
    	{
    		$randNum=rand(1000001,9000001);
    
    		try 
    		{
    			$sql="INSERT INTO unknownusers SET email=:email,code=:code";
    			$s=$GLOBALS['pdo']->prepare($sql);
    			$s->bindValue(':email',$_SESSION['xemail']);
    			$s->bindValue(':code',$randNum);
    			$s->execute();
    		} 
    		catch (PDOException $e)
    		{
    			$output="Unable to register new annoynymous user ";
    			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
    		}
    ////////////////////////////Send Verification code to email////////////
    
    // 			
    			
    		$mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch
    
            $mail->IsSMTP(); // telling the class to use SMTP
    
            try {
            $mail->Host= "mail.vetme.com.ng"; // SMTP server
                  $mail->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
                  $mail->SMTPAuth= true;                  // enable SMTP authentication
                  $mail->SMTPSecure = "ssl";// secure transfer enabled REQUIRED for Gmail
                  $mail->Mailer  = "smtp";
                  $mail->Host="mail.vetme.com.ng"; // sets the SMTP server
                  $mail->Port= 465;                 // set the SMTP port for the GMAIL server
                  $mail->Username= "feedback@vetme.com.ng"; // SMTP account username
                  $mail->Password   = "lixlyn101#";        // SMTP account password
                  $mail->AddReplyTo('support@vetme.com.ng');
                  $recipient=$_SESSION['xemail'];
                  $mail->AddAddress("$recipient",$_SESSION['xemail']);
                  $mail->SetFrom('feedback@vetme.com.ng','VetMe');
                  $mail->AddReplyTo('feedback@vetme.com.ng');
                  $mail->Subject = "Confirmation code for New VetMe email";
                //   $mail->AltBody = "Your password on VetMe.com.ng (Nigeria's no.1 Skills repository) has been reset.\r\n Please visit www.vetMe.com.ng and Enter ".$code." to Confirm reset."; // optional - MsgHTML will create an alternate automatically
                  $mail->Body = "Thank you for using VetMe.com.ng (Nigeria's no.1 Tech Skills repository).\r\n Please visit www.VetMe.com.ng and Enter ".$randNum." to Confirm your email. This will enable you Vet users.";
                  //$mail->MsgHTML(file_get_contents('contents.html'));
                  //$mail->AddAttachment('images/phpmailer.gif');      // attachment
                  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
                  $mail->Send();
                 
                } catch (phpmailerException $e) {
                  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
                } catch (Exception $e) {
                  //echo $e->getMessage(); //Boring error messages from anything else!
                }
    		
    /////////////// refresh UNKNOWN USERS//////////////////////////////////////
    		try 
    		{
    			$result=$GLOBALS['pdo']->query("SELECT * FROM unknownusers");
    
    		} 
    		catch (PDOException $e)
    		{
    			$output="Unable to fetch Unknown Users ";
    			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
    		}
    		foreach($result as $row)
    		{
    			$xUsers[]=array('email'=>$row['email'],'code'=>$row['code'],'verified'=>$row['verified']);
    		}
    
    ///////////////////////////////////////////////////////////////////
    
    		$GLOBALS['verified']==false;
    		$message="A one time verification code was sent to <strong>".$_SESSION['xemail'] ."</strong>. Please enter it below so as to enable you use <strong>".$_SESSION['xemail'] ."</strong> to vet users. [Check your Junk or Spam folder for the email]";
    		include 'unreglogin.html.php';
    		exit();
    	}
    	elseif($foundX and $vStatus=='NO')
    	{
    		$GLOBALS['verified']==false;
    		$message="Your email is yet not verified.<br/>A one time verification code was sent to <strong>".$_SESSION['xemail'] ."</strong>. Please enter it below so as to enable you use <strong>".$_SESSION['xemail'] ."</strong> to vet users.[Check your Junk or Spam folder for the email]";
    		include 'unreglogin.html.php';
    		exit();
    
    	}
    }
	else
	{
		$GLOBALS['verified']==true;
		$message="<strong>".$_SESSION['xemail'] ."</strong> is already registered as a User Email.";
		include 'unreglogin.html.php';
		exit();
	}

}

/////////////////////////////////////////////////////////////////////////////////////


/////////////////////CONFIRM UNREG EMAIL/////////////////////////////////////////////
if(isset($_POST['confirmUnreg']) and isset($_POST['code']))
{
	foreach($xUsers as $xUser)
	{
		if($xUser['email']==$_SESSION['xemail'] and $xUser['code']==$_POST['code'])
		{
			try
			{
				$sql="UPDATE unknownusers set verified='YES' where code=:code and email=:email";
				$s=$GLOBALS['pdo']->prepare($sql);
				$s->bindValue(':email',$_SESSION['xemail']);
				$s->bindValue(':code',$_POST['code']);
				$s->execute();
			} 
			catch (PDOException $e)
			{
				$output="Unable to update unknownusers";
				include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
			}
			break;
		}
	}

	/////////////// refresh UNKNOWN USERS//////////////////////////////////////
		try 
		{
			$result=$GLOBALS['pdo']->query("SELECT * FROM unknownusers");

		} 
		catch (PDOException $e)
		{
			$output="Unable to fetch Unknown Users ";
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}
		foreach($result as $row)
		{
			$xUsers[]=array('email'=>$row['email'],'code'=>$row['code'],'verified'=>$row['verified']);
		}

	///////////////////////////////////////////////////////////////////
	$xVerify=false;
	foreach($xUsers as $xUser)
	{
		if($xUser['email']==$_SESSION['xemail'] and $xUser['verified']=="YES")
		{
			$xVerify=true;
			break;
		}
	}
	if($xVerify)
	{
		$GLOBALS['verified']=true;
		$message="Your email has been Verified!<br/> You can now use <strong>".$_SESSION['xemail']."</strong> to vet Users";
		include 'unreglogin.html.php';
		exit();
	}
	else
	{
		$GLOBALS['verified']==false;
		$message="INCORRECT Verification code.";
		include 'unreglogin.html.php';
		exit();
	}
	

}



/////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////VIEW ////////////////////////////////////////////////////////////////////////
if(isset($_GET['view']))
{


	$nullUser=true;
	$userid=$_GET['view'];
	foreach($users as $user)
	{
		if($user['id']==$userid and $user['verified']=='YES')
		{
			$nullUser=false;
			break;
		}
	}

	if($nullUser==false)
	{	
		
		
		$uskills=array();
		foreach($users as $user)
		{
			if($userid==$user['id'])
			{
				$surname = redactName($user['sname']);
				$firstname = $user['fname'];
				//$name= strtoupper($user['sname'])." ".$user['fname'];
				$state=$user['state'];
				$email=$user['email'];
				$phone=$user['phone'];
				$gender=$user['gender'];
				$address=$user['address'];
				$dob=$user['dob'];
				$des=$user['desc'];			
				break;
			}		
		}
		$countVet=0;
		foreach($vets as $vet)
	    {
	       if($vet['userid']==$_GET['view'])
	       {
	       		$countVet++;
	       }

	    }

////////////////////////////Comment Out after Development................/////////////////
	    			try 
				{
					$sql="UPDATE user SET totalVets=:totalVets where id=:id";
					$s=$GLOBALS['pdo']->prepare($sql);
					$s->bindValue(':totalVets',$countVet);
					$s->bindValue(':id',$_GET['view']);
					$s->execute();
				} 
					catch (PDOException $e) 
				{
					$output="Failed to update user total vets ";
					include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
				}

/////////////////////////////////////////////////////////////////////////////////////////////////
		foreach($userSkills as $userSkill)
		{
			if($userSkill['userid']==$_GET['view'])
			{
				array_push($uskills, $userSkill['skillid']);
			}
		}
	}
	if(!isset($_SESSION))
	{
		session_start();
	}	
	$_SESSION['lastLocation']=$_SERVER['REQUEST_URI'];

	if(isLoggedIn())
	{
		include'view1.html.php';
		exit();
	}
	else
	{
		include'view.html.php';
		exit();
	}
	
}
//////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////Send ORDER////////////////////////////////////////////////
if(isset($_GET['order']) and isset($_POST['request']) and $_POST['request']=="Send Order")
{
	// $x=count($GLOBALS['selectedUsers']);

	// echo "<script> 
	// 	alert('$x');
	// 	window.location.href='.';			
	// 	</script>";


	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$orderID=rand(109300001,1109900001);
	foreach($orders as $order)
	{
		if($order['id']==$orderID)
		{
			$orderID=rand(109300001,1109900001);
		}
	}

	$orderExists=false;

if(!$orderExists)
{
	foreach($_SESSION['cart'] as $userid)
	{
		try 
		{		
			$sql="INSERT into orders SET id=:id, email=:email, phone=:phone, userid=:userid, orderdate=CURDATE(),status='NEW'";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':email',$email);
			$s->bindValue(':phone',$phone);
			$s->bindValue(':userid',$userid);
			$s->bindValue(':id',$orderID);
			$s->execute();		
		} 
		catch (PDOException $e)
		{
			$output = 'Error sending request. '.$e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
			exit();
		}
	}
	////..................Register Order in Ordertotal table........./////
		$total= count($_SESSION['cart']) * $price;
		try 
		{
			$sql="INSERT INTO ordertotal SET orderid=:orderid,total=:total";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':orderid',$orderID);
			$s->bindValue(':total',$total);
			$s->execute();
		} 
		catch (PDOException $e)
		{
			$output = 'Failed to Insert order-total ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
			exit();	
		}
////-------------///SEND email to customer //............./////////
// 	try 
// 		{			
// 			$email=$_POST['email'];
// 			$headers = "From: sales@vetme.com.ng". "\r\n" .  'Reply-To:requests@vetme.com.ng' . "\r\n";
// 			$msg="Thank you for using vetMe (Nigeria's no.1 Skills repository)<br/> Your requests have been received. <br/> This is your Request-ID: ".$orderID."<br/> Thank you for your patronage";
// 			$subject = "vetMe User Information Request";
// 			$to = $_POST['email'];
// 			//Mail it
// 			mail($to, $subject, $msg, $headers);
// 		} 
// 		catch (Exception $e) 
// 		{
// 			$output="Failed to send confirmation code to Email address.";
// 			include'output.html.php';
// 			exit();
// 		}

        $mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch

        $mail->IsSMTP(); // telling the class to use SMTP

        try {
        $mail->Host= "mail.vetme.com.ng"; // SMTP server
              $mail->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth= true;                  // enable SMTP authentication
              $mail->SMTPSecure = "ssl";// secure transfer enabled REQUIRED for Gmail
              $mail->Mailer  = "smtp";
              $mail->Host="mail.vetme.com.ng"; // sets the SMTP server
              $mail->Port= 465;                 // set the SMTP port for the GMAIL server
              $mail->Username= "feedback@vetme.com.ng"; // SMTP account username
              $mail->Password   = "lixlyn101#";        // SMTP account password
              $mail->AddReplyTo('support@vetme.com.ng');
              $recipient=$_POST['email'];
              $mail->AddAddress("$recipient",$_POST['email']);
              $mail->SetFrom('feedback@vetme.com.ng','VetMe');
              $mail->AddReplyTo('feedback@vetme.com.ng');
              $mail->Subject = "New VetMe User Information Request";
            //   $mail->AltBody = "Your password on VetMe.com.ng (Nigeria's no.1 Skills repository) has been reset.\r\n Please visit www.vetMe.com.ng and Enter ".$code." to Confirm reset."; // optional - MsgHTML will create an alternate automatically
              $mail->Body = "Thank you for using VetMe.com.ng (Nigeria's no.1 Tech Skills repository) \r\n Your requests have been received. \r\n This is your Request-ID: ".$orderID."\r\n Thank you for your patronage.\r\n We will send the complete profile of All requested Users as soon as payment is confirmed.";
              //$mail->MsgHTML(file_get_contents('contents.html'));
              //$mail->AddAttachment('images/phpmailer.gif');      // attachment
              //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
              $mail->Send();
             
            } catch (phpmailerException $e) {
              //echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
              //echo $e->getMessage(); //Boring error messages from anything else!
            }


//////////.............................................................//
///.................../////////Send Email to Admin ///..............................////////////

    
    $mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch

        $mail->IsSMTP(); // telling the class to use SMTP

        try {
        $mail->Host= "mail.vetme.com.ng"; // SMTP server
              $mail->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth= true;                  // enable SMTP authentication
              $mail->SMTPSecure = "ssl";// secure transfer enabled REQUIRED for Gmail
              $mail->Mailer  = "smtp";
              $mail->Host="mail.vetme.com.ng"; // sets the SMTP server
              $mail->Port= 465;                 // set the SMTP port for the GMAIL server
              $mail->Username= "feedback@vetme.com.ng"; // SMTP account username
              $mail->Password   = "lixlyn101#";        // SMTP account password
              $mail->AddReplyTo('support@vetme.com.ng');
              //$recipient=$_POST['reemail'];
              $mail->AddAddress("admin@vetme.com.ng",'Admin');
              $mail->SetFrom('feedback@vetme.com.ng','VetMe');
              $mail->AddReplyTo('feedback@vetme.com.ng');
              $mail->Subject = "New UIR (User Information Request)";
            //   $mail->AltBody = "Your password on VetMe.com.ng (Nigeria's no.1 Skills repository) has been reset.\r\n Please visit www.vetMe.com.ng and Enter ".$code." to Confirm reset."; // optional - MsgHTML will create an alternate automatically
              $mail->Body = "A New UIR (User Information Request) has been received from \r\n Email: ".$email ."\r\n Phone: ".$phone;
              //$mail->MsgHTML(file_get_contents('contents.html'));
              //$mail->AddAttachment('images/phpmailer.gif');      // attachment
              //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
              $mail->Send();
             
            } catch (phpmailerException $e) {
              //echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
              //echo $e->getMessage(); //Boring error messages from anything else!
            }

    
	$newRequest= true;
	$GLOBALS['OrderTotal']=$_POST['total'];
	unset($_SESSION['cart']);
}
else
{
	echo "<script> 
	alert('This Order has already been submitted');
	window.location.href='?checkout';			
	</script>";
}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	include'request.html.php';
	exit();
}

/////////////////////////////RESET PASSWORD///////////////////////////////////////////////////////////
if(isset($_POST['reset']) and $_POST['reset']=="reset")
{
	$foundit=false;
	foreach($users as $user)
	{
		if($user['email']==$_POST['reemail'])
		{
			$foundit=true;
			break;
		}
	}
	if(!$foundit)
	{
		$alertType="alert-danger";
		$GLOBALS['verified']=TRUE;
		$message="The email address you entered does not exist on VetMe.";
	}
	else
	{
		$code="";

		foreach($users as $user)
		{
			if($user['email']==$_POST['reemail'])
			{
				$code=$user['code'];
				break;				
			}
		}


		try 
		{
			$sql="UPDATE user set verified='NO',password=:password where email=:email";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':email',$_POST['reemail']);
			$s->bindValue(':password',md5($_POST['password1']));
			$s->execute();
			
		} 
		catch (PDOException $e)
		{
			$message ="Error ".$e->getMessage();
			include 'login.html.php';
			exit();
		}

// 		try 
// 		{	
// 		    $name="Vetme";
// 			$email=$_POST['reemail'];
// 			$msg="Your password on vetMe (Nigeria's no.1 Skills repository) has been reset.\r\n Please visit www.vetMe.com.ng and Enter ".$code." to Confirm reset.";
// 			$subject = "VetMe Account Password reset";
// 			$headers= "feedback@vetme.com.ng";
// 		    $to = $_POST['reemail'];
// 		    mail($to, $subject, $msg, $name, $headers);
// 		} 
// 		catch (Exception $e) 
// 		{
// 			$output="Failed to send confirmation code to Email address.";
// 			include'output.html.php';
// 			exit();
// 		}
		
		$mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch

        $mail->IsSMTP(); // telling the class to use SMTP

        try {
        $mail->Host= "mail.vetme.com.ng"; // SMTP server
              $mail->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth= true;                  // enable SMTP authentication
              $mail->SMTPSecure = "ssl";// secure transfer enabled REQUIRED for Gmail
              $mail->Mailer  = "smtp";
              $mail->Host="mail.vetme.com.ng"; // sets the SMTP server
              $mail->Port= 465;                 // set the SMTP port for the GMAIL server
              $mail->Username= "feedback@vetme.com.ng"; // SMTP account username
              $mail->Password   = "lixlyn101#";        // SMTP account password
              $mail->AddReplyTo('support@vetme.com.ng');
              $recipient=$_POST['reemail'];
              $mail->AddAddress("$recipient",'Password Reset');
              $mail->SetFrom('feedback@vetme.com.ng','VetMe');
              $mail->AddReplyTo('feedback@vetme.com.ng');
              $mail->Subject = "VetMe Account Password reset";
              $mail->AltBody = "Your password on VetMe.com.ng (Nigeria's no.1 Skills repository) has been reset.\r\n Please visit www.vetMe.com.ng and Enter ".$code." to Confirm reset."; // optional - MsgHTML will create an alternate automatically
              $mail->Body = "Your password on VetMe.com.ng (Nigeria's no.1 Skills repository) has been reset.\r\n Please visit www.vetMe.com.ng and Enter ".$code." to Confirm reset.";
              //$mail->MsgHTML(file_get_contents('contents.html'));
              //$mail->AddAttachment('images/phpmailer.gif');      // attachment
              //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
              $mail->Send();
             
            } catch (phpmailerException $e) {
              //echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
              //echo $e->getMessage(); //Boring error messages from anything else!
            }

		
		
		$GLOBALS['verified']=false;
		$alertType="alert-danger1";
		$message="Your password has been reset and a confirmation email containing a <strong>verification code</strong> \r\n has been sent to your email address(".$_POST['reemail']."). [Check your Junk or Spam folder for the email]";

		if(!isset($_SESSION))
		{
			session_start();
		}
		$_SESSION['email']=$_POST['reemail'];
	}


	include'resetpword.html.php';
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////


//////////////////////Logout/////////////////////////////////////////////////////////////
if(isset($_GET['logout']))
{
	if(!isset($_SESSION))
	{
		session_start();
	}	
	unset($_SESSION['loggedIn']);
    unset($_SESSION['email']);
	unset($_SESSION['password']);
	unset($_SESSION['cart']);
}


/////////////////////Send Contact Us Message /////////////////////////////////////////

if(isset($_POST['sendmsg']))
{
		$name=$_POST['name'];
		$senderemail =$_POST['senderemail'];
		$phone=$_POST['phone'];
		$msg=$_POST['msg'];

		$mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch

        $mail->IsSMTP(); // telling the class to use SMTP
////////////////////////Send Customer Email to Admin/////////////////
        try {
        	  $mail->Host= "mail.vetme.com.ng"; // SMTP server
              $mail->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth= true;                  // enable SMTP authentication
              $mail->SMTPSecure = "ssl";// secure transfer enabled REQUIRED for Gmail
              $mail->Mailer  = "smtp";
              $mail->Host="mail.vetme.com.ng"; // sets the SMTP server
              $mail->Port= 465;                 // set the SMTP port for the GMAIL server
              $mail->Username= "feedback@vetme.com.ng"; // SMTP account username
              $mail->Password   = "lixlyn101#";        // SMTP account password
              $mail->AddReplyTo('support@vetme.com.ng');
              $recipient='admin@vetme.com.ng';
              $mail->AddAddress("$recipient",'VetMe Admin');
              $mail->SetFrom('feedback@vetme.com.ng','VetMe');
              $mail->AddReplyTo('feedback@vetme.com.ng');
              $mail->Subject = "VetMe Public Feedback";
            //   $mail->AltBody = "Your password on VetMe.com.ng (Nigeria's no.1 Skills repository) has been reset.\r\n Please visit www.vetMe.com.ng and Enter ".$code." to Confirm reset."; // optional - MsgHTML will create an alternate automatically
              $mail->Body = "SENDER Name: ".$name."\r\n SENDER EMAIL: ".$senderemail."\r\n SENDER PHONE: ".$phone."\r\n MESSAGE: ".$msg;
              //$mail->MsgHTML(file_get_contents('contents.html'));
              //$mail->AddAttachment('images/phpmailer.gif');      // attachment
              //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
              $mail->Send();
             
            } catch (phpmailerException $e) {
              //echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
              //echo $e->getMessage(); //Boring error messages from anything else!
            }
//////...................................................................................///////////////////////////////////

 ///////////////////////Send Email to Customer/////////////////
        try {
        	  $mail->Host= "mail.vetme.com.ng"; // SMTP server
              $mail->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth= true;                  // enable SMTP authentication
              $mail->SMTPSecure = "ssl";// secure transfer enabled REQUIRED for Gmail
              $mail->Mailer  = "smtp";
              $mail->Host="mail.vetme.com.ng"; // sets the SMTP server
              $mail->Port= 465;                 // set the SMTP port for the GMAIL server
              $mail->Username= "feedback@vetme.com.ng"; // SMTP account username
              $mail->Password   = "lixlyn101#";        // SMTP account password
              $mail->AddReplyTo('support@vetme.com.ng');
              $recipient=$senderemail;
              $mail->AddAddress("$recipient",$name);
              $mail->SetFrom('feedback@vetme.com.ng','VetMe');
              $mail->AddReplyTo('feedback@vetme.com.ng');
              $mail->Subject = "VetMe Feedback";
            //   $mail->AltBody = "Your password on VetMe.com.ng (Nigeria's no.1 Skills repository) has been reset.\r\n Please visit www.vetMe.com.ng and Enter ".$code." to Confirm reset."; // optional - MsgHTML will create an alternate automatically
              $mail->Body = "Thank you for contacting Us. Your Message has been Received.\r\n We will respond within 1 work day.";
              //$mail->MsgHTML(file_get_contents('contents.html'));
              //$mail->AddAttachment('images/phpmailer.gif');      // attachment
              //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
              $mail->Send();
             
            } catch (phpmailerException $e) {
              //echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
              //echo $e->getMessage(); //Boring error messages from anything else!
            }
//////...................................................................................///////////////////////////////////

include 'contact.html.php';
exit();
}

if(isset($_GET['contact']))
{
	include 'contact.html.php';
	exit();
}

include 'home.html.php';

?>	
