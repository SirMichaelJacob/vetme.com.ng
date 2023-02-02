<?php

include $_SERVER['DOCUMENT_ROOT'].'/includes/iknowdb.inc.php';
require $_SERVER['DOCUMENT_ROOT'].'/controller.php';
session_start();


if(!adminIsLoggedIn())
{
	header('Location:/login/');
	exit();
}

if(!adminHasRole('user manager'))
{	
		
	echo "<script> 
		alert('Access Denied. You do not have USER Mangement privillege');
		window.location.href='../';			
		</script>";

	exit();
}

if(isset($_GET['skillman']))
{	
	
	if(adminIsLoggedIn() and adminHasRole('user manager') and adminHasRole('HR manager') and adminHasRole('sales manager'))
	{

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

  	$rperpage=4;



	try 
	{
		$sql = " SELECT * FROM skill LIMIT ". $start.", ". $rperpage;
		$result = $GLOBALS['pdo']->query($sql);
		//echo $sql1;
	} 
	catch (PDOException $e)
	{
		$output = 'Error fetching users. '.$e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		exit();
	}

	foreach ($result as $row)
	{
		
		$Allskills[] = array('id'=>$row['id'],'skill'=>$row['skill']);
	}


	try
	{
		$sql = "SELECT COUNT(*) FROM skill";
			
		$s =$GLOBALS['pdo']->query($sql);
		
			
	}
	catch (PDOException $e)
	{
		$output = 'Error fetching skill. ';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		exit();
	}
	$row=$s->fetch();		

	$totSkills=$row[0];;

	$maxpage=ceil($totSkills/$rperpage);

	$action="Add Skill";
	$name="";
	$skiid="";
//......................................................../////////////
		include 'skill.html.php';
		exit();
	}
	else
	{
		echo "<script> 
		alert('Access Denied. You cannot Manage Skills on VetMe');
		window.location.href='../';			
		</script>";
	}

	
}


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

  $rowsperpage=4;



try 
	{
		$sql = " SELECT * FROM user LIMIT ". $start.", ". $rowsperpage;
		$result = $GLOBALS['pdo']->query($sql);
		//echo $sql1;
	} 
	catch (PDOException $e)
	{
		$output = 'Error fetching users. '.$e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		exit();
	}

	foreach ($result as $row)
	{
		$Allusers[] = array('id'=>$row['id'],'email'=>$row['email'],'password'=>$row['password'],'fname'=>$row['firstname'],'sname'=>$row['surname'],'phone'=>$row['phone'],'gender'=>$row['gender'],'dob'=>$row['dob'],'address'=>$row['address'],'state'=>$row['state'],'desc'=>$row['description'],'code'=>$row['code'],'verified'=>$row['verified'],'totVet'=>$row['totalVets']);
	}


try
	{
		$sql = "SELECT COUNT(*) FROM user";
			
		$s =$GLOBALS['pdo']->query($sql);
		
			
	}
	catch (PDOException $e)
	{
		$output = 'Error fetching users. '.$e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		exit();
	}
		$row=$s->fetch();		

$totUsers=$row[0];;

$maxpage=ceil($totUsers/$rowsperpage);


//......................................................../////////////
/////////////////////////EDIT USER///////////////////////////////////
if(isset($_POST['edit']) and isset($_POST['userId']))
{
	$thisUser=array();
	$myID=$_POST['userId'];

	foreach($users as $user)
	{
		if($user['id']==$myID)
		{
			$thisUser=$user;
			break;
		}
	}

	$verify=array('YES','NO');
	$genderArray=array('Male','Female');

	if($thisUser['email']=='michaeljacob01@gmail.com')
	{
		$specialUser=true;
	}

	include 'forms.html.php';
	exit();
}

///////////////////////////////////////////////////////////////////////////////////////
////////////UPDATE //////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update']))
{
	$myID=$_POST['myID'];

	foreach($users as $user)
	{
		if($user['id']==$myID)
		{
			$email=$user['email'];
			break;
		}
	}

	if(isset($_POST['password']) and $_POST['password']!='')
	{
		$mypassword= md5($_POST['password']);

		try 
		{
			$sql="UPDATE user SET email=:email,password=:password,firstname=:firstname,surname=:surname,phone=:phone,gender=:gender,dob=:dob,address=:address,description=:description,state=:state,verified=:verified where id=:id";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':id',$myID);
			$s->bindValue(':email',$email);
			$s->bindValue(':password',$mypassword);
			$s->bindValue(':firstname',$_POST['firstname']);
			$s->bindValue(':surname',$_POST['surname']);
			$s->bindValue(':phone',$_POST['phone']);
			$s->bindValue(':gender',$_POST['gender']);
			$s->bindValue(':dob',$_POST['year']."-".$_POST['month']."-".$_POST['day']);
			$s->bindValue(':address',$_POST['address']);
			$s->bindValue(':state',$_POST['state']);
			$s->bindValue(':description',$_POST['desc']);
			$s->bindValue(':verified',$_POST['verified']);
			$s->execute();
		} 
		catch (PDOException $e)
		{
			$output="Unable to Update User information ";
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}		
	}
	else
	{
		try 
		{
			$sql="UPDATE user SET email=:email,firstname=:firstname,surname=:surname,phone=:phone,gender=:gender,dob=:dob,address=:address,description=:description,state=:state,verified=:verified where id=:id";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':id',$myID);
			$s->bindValue(':email',$email);
			$s->bindValue(':firstname',$_POST['firstname']);
			$s->bindValue(':surname',$_POST['surname']);
			$s->bindValue(':phone',$_POST['phone']);
			$s->bindValue(':gender',$_POST['gender']);
			$s->bindValue(':dob',$_POST['year']."-".$_POST['month']."-".$_POST['day']);
			$s->bindValue(':address',$_POST['address']);
			$s->bindValue(':state',$_POST['state']);
			$s->bindValue(':description',$_POST['desc']);
			$s->bindValue(':verified',$_POST['verified']);
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
                if($userSkill['userid']==$myID)
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
						$s->bindValue(':userid',$myID);
						$s->bindValue(':skillid',$skillid);
						$s->execute();
					} 
					catch (PDOException $e) 
					{
						$output="Unable to INSERT new User Skills ".$e->getMessage();
						include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
					}
				}				

			}
		}
	echo "<script> 
		alert('User Profile has been Updated');
		window.location.href='.';			
		</script>";
}
///////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////UPDATE SKILL/////////////////////////

if(isset($_POST['skillname']) and $_POST['action']=='Update')
{

	try 
	{
		$sql="UPDATE skill SET skill=:skill where id=:id";
		$s=$GLOBALS['pdo']->prepare($sql);
		$s->bindValue(':id',$_POST['skiid']);
		$s->bindValue(':skill',$_POST['skillname']);
		$s->execute();		
					
	} 
	catch(PDOException $e) 
	{
		$output="Unable to Update Skill ";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';		
	}
	$name="";		
	$skiid="";
	$action="Add Skill";

	header('Location:/admin/user/?skillman');
	exit();
}

////////////////////////////////////////////////////////////////////////

/////////////////////////////////EDIT SKILL/////////////////////////

if(isset($_POST['skillId']) and isset($_POST['edit']))
{
	foreach($skills as $skill)
	{
		if($_POST['skillId']==$skill['id'])
		{
			$name=$skill['skill'];
			$skiid=$skill['id'];
			$action='Update';
			break;
		}
	}
	include 'skill.html.php';
	exit();
}

////////////////////////////////////////////////////////////////////////

/////////////////////////////////SKILL SKILL/////////////////////////

if(isset($_POST['skillId']) and isset($_POST['delete']))
{
	try 
	{
		$sql="DELETE FROM userskill where skillid=:skillid";
		$s=$GLOBALS['pdo']->prepare($sql);
		$s->bindValue(':skillid',$_POST['skillId']);
		$s->execute();

	} 
	catch (PDOException $e) 
	{
		$output="Unable to Delete Skill from User Skill";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	}

	try 
	{
		$sql="DELETE FROM vetlog where skillid=:skillid";
		$s=$GLOBALS['pdo']->prepare($sql);
		$s->bindValue(':skillid',$_POST['skillId']);
		$s->execute();

	} 
	catch (PDOException $e) 
	{
		$output="Unable to Delete Skill from User Skill";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	}

	try 
	{
		$sql="DELETE FROM skill where id=:id";
		$s=$GLOBALS['pdo']->prepare($sql);
		$s->bindValue(':id',$_POST['skillId']);
		$s->execute();

	} 
	catch (PDOException $e) 
	{
		$output="Unable to Delete Skill from User Skill";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	}

}

////////////////////////////////////////////////////////////////////////


//////////////////SEARCH FOR USER////////////////////////////////////////////////////////////////////
if(isset($_POST['getUser']))
{
	$thisperson=array();
	$foundUser=false;
	foreach($users as $user)
	{
		if($user['id']==$_POST['usid'])
		{
			$thisperson[] = $user;
			$foundUser=true;
			break;
		}
	}	
	
}
///////////////////////////////////////////////////////////////////////////////////////////

//////////////////SEARCH FOR SKILL////////////////////////////////////////////////////////////////////
if(isset($_POST['getSkill']))
{
	$action="Add Skill";
	$name="";
	$thisSkill=array();
	$foundSkill=false;
	foreach($skills as $skill)
	{

		if($skill['id']==$_POST['skill'] or strtolower($skill['skill'])==strtolower($_POST['skill']))
		{
			array_push($thisSkill, $skill);
			$foundSkill=true;
			break;
		}
	}

	$filterClicked=true;
	// header('Location:/vetme/admin/user/?skillman');
	// exit();
	include 'skill.html.php';
	exit();
}
///////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////View USERS with particular Skill //////////////////
if(isset($_POST['viewusers']))
{
	$thisperson=array();
	$ids=array();
	foreach($userSkills as $us)
	{
		if($us['skillid']==$_POST['dSkill'])
		{
			$ids[]=$us['userid'];
		}
	}

	foreach($ids as $id)
	{
		foreach($users as $user)
		{
			if($id==$user['id'] and $user['totVet']>=$_POST['limit'])
			{
				$thisperson[]= $user;		
			}
		}
	}
	$foundUser=true;
	$action="Add Skill";
}

/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////ADD NEW SKILL //////////////////////////////////////////////////////

if(isset($_POST['skillname']) and $_POST['action']=='Add Skill')
{
	$action="Add Skill";
	if(strlen($_POST['skillname'])>1 and $_POST['skillname']!='')
	{
		try 
		{
			$sql="INSERT into skill set skill=:skill";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':skill',$_POST['skillname']);
			$s->execute();
		} 
		catch (PDOException $e)
		{
			$output = 'Failed to add new skill. '.$e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
			exit();
		}
		
		header('Location:/admin/user/?skillman');
		exit();		
	}
	else
	{
		header('Location:/admin/user/?skillman');
		exit();
	}
}


//////////////////////////////////////////////////////////////////////////////////////////

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





include 'user.html.php';
?>