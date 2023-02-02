<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/session.inc.php';
require $_SERVER['DOCUMENT_ROOT'].'/controller.php';



if(adminIsLoggedIn() and isset($_SESSION['verified']) and $_SESSION['verified']==true)
{
	header('Location:./admin/');
	exit(); 
}

if(isset($_GET['register']))
{
	include 'forms.html.php';
	exit();
}


if(isset($_POST['register']) and $_POST['register']=="admin")
{
	$email=$_POST['email'];
	$password=md5($_POST['password']);
	$randNum = rand(100001,900001);

	$adminAccountExist=false;
	foreach($admins as $admin)
	{
		if($admin['email']==$email)
		{
			$adminAccountExist=true;
			break;
		}
	}

	if(!$adminAccountExist)
	{
		$GLOBALS['adminAccountExist']=true;
		try 
		{
			$sql="INSERT INTO admins SET email=:email,password=:password,firstname=:firstname,othername=:othername,surname=:surname,phone=:phone,gender=:gender,address=:address,code=:code";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':email',$email);
			$s->bindValue(':password',$password);
			$s->bindValue(':firstname',$_POST['firstname']);
			$s->bindValue(':othername',$_POST['othername']);
			$s->bindValue(':surname',$_POST['surname']);
			$s->bindValue(':phone',$_POST['phone']);
			$s->bindValue(':gender',$_POST['gender']);
			$s->bindValue(':address',$_POST['address']);
			$s->bindValue(':code',$randNum);
			$s->execute();
		} 
		catch (PDOException $e)
		{
			$output="Unable to Register new User ".$e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}
		try 
			{			
				$email=$_POST['email'];
				$msg="Thank you for creating an ADMIN account on vetMe (Nigeria's no.1 Skills repository) <br/> Please visit www.vetMe.com.ng and Enter ".$randNum." to Confirm your registration.";
				$subject = "New VetMe admin user Account";
				$headers = "From: admin@vetme.com.ng". "\r\n" .  'Reply-To:admin@vetme.com.ng' . "\r\n";
			    $to = $_POST['email'];
			    mail($to, $subject, $msg, $headers);
			} 
			catch (Exception $e) 
			{
				$output="Failed to send confirmation code to Email address.";
				include'output.html.php';
				exit();
			}
			$alertType="alert-danger1";
			$message="Your Registration was successful!<br/>A confirmation email containing a <strong>verification code</strong> has been sent to you.";


	}
	else
	{
		$GLOBALS['loginError']="This Account already exists";
		$alertType="alert-danger";
	}
	
}

if(isset($_POST['adminlogin']) and $_POST['adminlogin']=="Login")
{
	$email=$_POST['email'];
	$password =md5($_POST['password']);


	if(dbContainsAdmin($email,$password))
	{
		$GLOBALS['notVerified']=true;
		$_SESSION['verified']=false;

		foreach($admins as $admin)
		{
			if($admin['email']==$email and $admin['verified']=='YES')
			{
				$GLOBALS['notVerified']=false;
				$_SESSION['verified']=true;
				$adminVerified=true;
				break;				
			}
			else
			{
				$_SESSION['verified']=false;
			}
		}
		if($GLOBALS['notVerified']==true)
		{
			$message="Your Account is not verified.\r\n Enter verification code that was sent to your email";
			$_SESSION['email']=$email;
		}
		else
		{
			header('Location:/admin/');
			exit();
		}
		$GLOBALS['email']=$_POST['email'];

	}
	else
	{
		//$GLOBALS['loginError']="Wrong Log In credentials";
		foreach($admins as $admin)
		{
			if($admin['email']==$email and $admin['password']!=$password)
			{
				$GLOBALS['loginError']="Wrong password";;
				break;				
			}
		}
		//$message="Account does not exist";
		$alertType="alert-danger";
	}

}

if(isset($_POST['confirm']) and $_POST['confirm'] == 'Confirm')
{
	 // $x=$_REQUEST['email'];
	 // echo "<script> 
		// alert($x);
		// window.location.href='.';			
		// </script>";
	try 
		{
			$sql="UPDATE admins set verified='YES' where code=:code and email=:email";
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

		//////////////////////////////////////////Refresh the Array of ADMINS///////////////////////////////
		
		try 
		{
			$result1=$GLOBALS['pdo']->query("SELECT id,email,password,firstname,othername,surname,phone,gender,address,code,verified FROM admins");
		} 
		catch (PDOException $e)
		{
			$output="Unable to fetch admins";
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}

		foreach($result1 as $row)
		{
			$admins[]=array('id'=>$row['id'],'email'=>$row['email'],'password'=>$row['password'],'fname'=>$row['firstname'],'oname'=>$row['othername'],'sname'=>$row['surname'],'phone'=>$row['phone'],'gender'=>$row['gender'],'address'=>$row['address'],'code'=>$row['code'],'verified'=>$row['verified']);
		}

		///////////////////////////////////////////////////////////////////////////////////////////////////////

		foreach($admins as $admin)
		{
			if($admin['email']==$_SESSION['email'] and $admin['verified']=='YES')
			{
				$GLOBALS['notVerified']=false;
				$_SESSION['verified']=true;
				break;
			}
			else
			{
				$GLOBALS['notVerified']=true;
			}
		}

		if($GLOBALS['notVerified']==false)
		{
			$message="Your Account has been Verified!<br/> Please Login.";
			include 'login.html.php';
			exit();
		}
		else
		{
			$GLOBALS['notVerified']==true;
			$message="INCORRECT Verification code.";
			include 'login.html.php';
			exit();
		}
		
	
	
}








include 'login.html.php';
exit();


?>