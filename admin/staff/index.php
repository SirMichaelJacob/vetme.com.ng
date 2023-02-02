<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/session.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/controller.php';

if(!adminIsLoggedIn())
{
	header('Location:/login/');
	exit();
}

if(!adminHasRole('HR manager'))
{	
	// $GLOBALS['message']="Access Denied \r\n You do not have HR Mangement privillege";
	// $GLOBALS['alertType']="alert-danger";	
	// header('Location:/vetme/admin/');
	
	echo "<script> 
		alert('Access Denied. You do not have HR Mangement privillege');
		window.location.href='../';			
		</script>";

	exit();
}

if(isset($_POST['edit']))
{
	$staffid=$_POST['staffId'];

	foreach($admins as $staff)
	{
		if($staff['id']==$staffid and $staff['email']=='michaeljacob01@gmail.com')
		{
			$specialUser=true;
			$specialemail=$staff['email'];
			$specialpassword= $staff['password'];
			break;
		}
	}

	$action="Update";
	foreach($admins as $staff)
	{
		if($staff['id']==$staffid)
		{
			$email=$staff['email'];
			$password=$staff['password'];
			$phone=$staff['phone'];
			$fname=$staff['fname'];
			$oname=$staff['oname'];
			$sname= $staff['sname'];
			$gender=$staff['gender'];
			$verified =$staff['verified'];			
			$address= $staff['address'];
			break;	

		}
	}
	try 
	{
		$sql="SELECT roleid FROM adminrole where adminid=:adminid";
		$s=$GLOBALS['pdo']->prepare($sql);
		$s->bindValue(':adminid',$staffid);
		$s->execute();
	} 
	catch (PDOException $e)
	{
		$output="failed to fetch Admin roles";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	}
	$result=$s->fetchAll();
	//$myRoles=array();

	foreach($result as $id)
	{		
		$myRoles[]=array('id'=>$id['roleid']);
	}


	$verify=array('YES','NO');
	$genderArray=array('Male','Female');

	include 'forms.html.php';
	exit();
}


if(isset($_POST['update']) and isset($_POST['Id']))
{
	if(isset($_POST['password']) and $_POST['password']!="")
	{
		//echo "Hoooo";
		$password=md5($_POST['password']);

		try 
		{
			
			$sql="UPDATE admins SET firstname=:firstname,othername=:othername,surname=:surname,gender=:gender,address=:address,phone=:phone,email=:email,password=:password,verified=:verified where id=:id";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':id',$_POST['Id']);
			$s->bindValue(':firstname',$_POST['firstname']);
			$s->bindValue(':othername',$_POST['othername']);
			$s->bindValue(':surname',$_POST['surname']);
			$s->bindValue(':gender',$_POST['gender']);
			$s->bindValue(':address',$_POST['address']);
			$s->bindValue(':phone',$_POST['phone']);
			$s->bindValue(':email',$_POST['email']);
			$s->bindValue(':password',$password);			
			$s->bindValue(':verified',$_POST['verified']);
			$s->execute();
		} 
		catch (PDOException $e)
		{
			$output="Unable to update Admin";
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}

		
	}
	else
	{
		//echo "Hoooo";
		try 
		{
			$sql="UPDATE admins SET firstname=:firstname,othername=:othername,surname=:surname,gender=:gender,address=:address,phone=:phone,email=:email,verified=:verified where id=:id";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':id',$_POST['Id']);
			$s->bindValue(':firstname',$_POST['firstname']);
			$s->bindValue(':othername',$_POST['othername']);
			$s->bindValue(':surname',$_POST['surname']);
			$s->bindValue(':gender',$_POST['gender']);
			$s->bindValue(':address',$_POST['address']);
			$s->bindValue(':phone',$_POST['phone']);
			$s->bindValue(':email',$_POST['email']);
			//$s->bindValue(':password',$_POST['password']);			
			$s->bindValue(':verified',$_POST['verified']);
			$s->execute();
		}
		catch (PDOException $e)
		{
			$output="Unable to update Admin";
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}
	}
	if(isset($_POST['staffRoles']))
	{
		try 
		{
			$sql='DELETE FROM adminrole where adminid=:adminid';
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue('adminid',$_POST['Id']);
			$s->execute();
		} 
		catch (PDOException $e)
		{
			$output="Unable to delete previous Admin roles";
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}

		foreach($_POST['staffRoles'] as $roleid)
		{
			try 
			{
				$sql="INSERT INTO adminrole SET adminid=:adminid,roleid=:roleid";
				$s=$GLOBALS['pdo']->prepare($sql);
				$s->bindValue(':adminid',$_POST['Id']);
				$s->bindValue(':roleid',$roleid);
				$s->execute();
			} 
			catch (PDOException $e) 
			{
				$output="Unable to delete Insert new Admin roles";
				include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
			}
		}
	}
	



header('Location:.');
exit();
}


if(isset($_GET['logout']))
{
	session_start();
	unset($_SESSION['loggedIn']);
	unset($_SESSION['email']);
	unset($_SESSION['password']);
	unset($_SESSION['verified']);
	header('Location:/login/');
	exit();
}











include 'staff.html.php';
exit();
?>