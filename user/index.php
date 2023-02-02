<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/session.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/class.phpmailer.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/class.smtp.php';
include '../controller.php';

if(!isLoggedIn() or adminIsLoggedIn())
{	
	if(!adminIsLoggedIn())
	{
		header('Location:../?login');
		exit();
	}
	else
	{
		header('Location:../admin/');
		exit();
	}
	
}
////////////////////Get USERNAME//////////////////////////////////
foreach($users as $user)
{
	if($user['email']==$_SESSION['email'])
	{
		$GLOBALS['sname']=$user['sname'];
		$GLOBALS['fname']=$user['fname'];
		break;
	}
}
$GLOBALS['username'] = strtoupper($GLOBALS['sname'])." " .$GLOBALS['fname'];
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////Get Log Details ////////////////////////////////////
foreach($Logs as $userLog)
{
	if($userLog['userid']==$_SESSION['userid'])
	{
		$GLOBALS['regDate']=$userLog['regDate'];
		$GLOBALS['lastLogin'] = $userLog['lastLogin'];
		break;
	}
}
///////////////////////////////////////////////////////////////////////////////////
////////////////////////Get User Skills ////////////////////////////////////
$mySkills=array();
foreach($userSkills as $userSkill)
{
	if($userSkill['userid']==$_SESSION['userid'])
	{
		array_push($mySkills,$userSkill['skillid']);
		//$mySkills[]=array('skillid'=>$userSkill['skillid']);
	}
}
///////////////////////////////////////////////////////////////////////////////

/////////////////////Count number of vets /////////////////////////////////////
try 
{
	$sql="SELECT COUNT(*) FROM vetlog where userid=:userid";
	$s=$GLOBALS['pdo']->prepare($sql);
	$s->bindValue(':userid',$_SESSION['userid']);
	$s->execute();
} 
catch (PDOException $e)
{
	$output="Unable to fetch Vets";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}

$row=$s->fetch();
$GLOBALS['myVets']=$row[0];
try 
{
	$sql="UPDATE user SET totalVets=:totalVets where id=:id";
	$s=$GLOBALS['pdo']->prepare($sql);
	$s->bindValue(':totalVets',$GLOBALS['myVets']);
	$s->bindValue(':id',$_SESSION['userid']);
	$s->execute();
} 
	catch (PDOException $e) 
{
	$output="Failed to update user total vets ";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}



///////////////////////////////////////////////////////////////////

/////////////Vet SELF//////////////////////////////////////////////

if(isset($_POST['vet']) and $_POST['vet']==$_SESSION['userid'])
{
	$myskills=array();
	
	foreach($userSkills as $userSkill)
	{
		if($userSkill['userid']==$_SESSION['userid'])
		{
			array_push($myskills, $userSkill['skillid']);
		}
	}

	$continue=true;
	foreach($vets as $vet)
	{
		foreach ($myskills as $skid)
		{
			if($vet['userid']==$_SESSION['userid'] and $vet['vetter']==$_SESSION['userid'] and $vet['skillid']==$skid)
			{
				if (($key = array_search($skid, $myskills)) !== false) 
				{
    				unset($myskills[$key]);
				}
			}
		}
		
	}


	if(count($myskills)>0)
	{
		$continue=true;
	}
	else
	{
		$continue=false;
	}

	if($continue)
	{
		
		foreach ($myskills as $skid)
		{
			try 
			{
				$sql="INSERT INTO vetlog SET userid=:userid,vetter=:vetter,skillid=:skillid,date=CURDATE()";
				$s=$GLOBALS['pdo']->prepare($sql);
				$s->bindValue(':userid',$_SESSION['userid']);
				$s->bindValue(':vetter',$_SESSION['userid']);
				$s->bindValue(':skillid',$skid);
				$s->execute();
			} 
			catch (PDOException $e) 
			{
				$output="Failed to Vet";
				include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
			}
		}

		$success=true;
		$msg= "Vetting Successful!";
		
		// echo "<script> 
		// 	alert('Vetted');
		// 	window.location.href='.';			
		// 	</script>";
	}
	else
	{
		$success=true;
		$msg= "You cannot vet yourself more than once.";
		// echo "<script> 
		// 	alert('You cannot vet yourself more than once.');
		// 	window.location.href='.';			
		// 	</script>";
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////Delete Message/////////////////////////////////////////////////////////
if(isset($_POST['msgid']) and strlen($_POST['msgid'])>0)
{
	try 
	{
		$sql="DELETE FROM message where id=:id";
		$s=$GLOBALS['pdo']->prepare($sql);
		$s->bindValue(':id',$_POST['msgid']);
		$s->execute();
	} 
	catch (PDOException $e)
	{
		$output="Unable to delete message";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	}
	// try 
	// {
	// 	$result=$GLOBALS['pdo']->query("SELECT id,userid,content,date FROM message");	
	// } 
	// catch (PDOException $e)
	// {
	// 	$output="Unable to fetch Messages";
	// 	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	// }
	// foreach($result as $row)
	// {
	// 	$messages[]=array('id'=>$row['id'],'userid'=>$row['userid'],'content'=>$row['content'],'date'=>$row['date']);
	// }
	header('Location:.');
	exit();
}

/////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////Add to CART////////////////////////////////////////////////////
if(isset($_POST['request']) and $_POST['request']=='request')
{
	if(!in_array($_POST['vet1'], $_SESSION['cart']))
	{
		$_SESSION['cart'][]=$_POST['vet1'];
	}	
		
}
////////////////////////////////////////////////////////////////////////////////////////
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
//////////////////////////////////////////////////////////////////////////////////////////

///////////////////////CLEAR ALL MESSAGES/////////////////////////////////////////////////
if(isset($_GET['clearMsg']))
{
	try 
	{
		$delete=$GLOBALS['pdo']->query("DELETE FROM message where userid=".$_SESSION['userid']);
	} 
	catch (PDOException $e)
	{
		$output="Unable to delete user Messages";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	}
	header('Location:/user/');
	exit();
}
//////////////////////////////////////////////////////////////////////////////////////////

////EDIT USER PROFILE/////////////////////////////////////////////////////////
if(isset($_GET['userProfile']))
{
	$thisUser=array();
	$myID=$_SESSION['userid'];

	foreach($users as $user)
	{
		if($user['id']==$myID)
		{
			$thisUser=$user;
			break;
		}
	}

	include 'forms.html.php';
	exit();
}


///////////////////////////////////////////////////////////////////////////////



////////////UPDATE //////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update']))
{
	if(isset($_POST['password']) and $_POST['password']!='')
	{
		$mypassword= md5($_POST['password']);
		try 
		{
			$sql="UPDATE user SET email=:email,password=:password,firstname=:firstname,surname=:surname,phone=:phone,gender=:gender,dob=:dob,address=:address,description=:description,state=:state where id=:id";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':id',$_SESSION['userid']);
			$s->bindValue(':email',$_SESSION['email']);
			$s->bindValue(':password',$mypassword);
			$s->bindValue(':firstname',$_POST['firstname']);
			$s->bindValue(':surname',$_POST['surname']);
			$s->bindValue(':phone',$_POST['phone']);
			$s->bindValue(':gender',$_POST['gender']);
			$s->bindValue(':dob',$_POST['year']."-".$_POST['month']."-".$_POST['day']);
			$s->bindValue(':address',$_POST['address']);
			$s->bindValue(':state',$_POST['state']);
			$s->bindValue(':description',$_POST['desc']);
			$s->execute();
		} 
		catch (PDOException $e)
		{
			$output="Unable to Update User information ".$e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}		
	}
	else
	{
		try 
		{
			$sql="UPDATE user SET email=:email,firstname=:firstname,surname=:surname,phone=:phone,gender=:gender,dob=:dob,address=:address,description=:description,state=:state where id=:id";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':id',$_SESSION['userid']);
			$s->bindValue(':email',$_SESSION['email']);
			$s->bindValue(':firstname',$_POST['firstname']);
			$s->bindValue(':surname',$_POST['surname']);
			$s->bindValue(':phone',$_POST['phone']);
			$s->bindValue(':gender',$_POST['gender']);
			$s->bindValue(':dob',$_POST['year']."-".$_POST['month']."-".$_POST['day']);
			$s->bindValue(':address',$_POST['address']);
			$s->bindValue(':state',$_POST['state']);
			$s->bindValue(':description',$_POST['desc']);
			$s->execute();
		} 
		catch (PDOException $e) 
		{
			$output="Unable to Update User information ".$e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}
	}

	if(isset($_POST['skills']))
		{			

			$mySkills=array(); 

            foreach($userSkills as $userSkill)
            {
                if($userSkill['userid']==$_SESSION['userid'])
                {
                	array_push($mySkills,$userSkill['skillid']);
                
                }
            }

			foreach($_POST['skills'] as $skillid)
			{
				if(!in_array($skillid, $mySkills))
				{
					try 
					{
						$sql="INSERT INTO userskill SET userid=:userid,skillid=:skillid";
						$s=$GLOBALS['pdo']->prepare($sql);
						$s->bindValue(':userid',$_SESSION['userid']);
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
		}
	echo "<script> 
		alert('Your Profile has been Updated');
		window.location.href='.';			
		</script>";
}
///////////////////////////////////////////////////////////////////////////////////////
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
              $mail->Body = "Thank you for using VetMe.com.ng (Nigeria's no.1 Skills repository) \r\n Your requests have been received. \r\n This is your Request-ID: ".$orderID."\r\n Thank you for your patronage";
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

////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////Log Out////////////////////////////////////////////////////////////
if(isset($_GET['logout']))
	{
		session_start();
		unset($_SESSION['loggedIn']);
		unset($_SESSION['email']);
		unset($_SESSION['password']);
		header('Location:..');
		exit();
	}
/////////////////////////////////////////////////////////////////////////////




include 'profile.html.php';

?>
