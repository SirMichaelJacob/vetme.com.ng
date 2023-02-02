<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/iknowdb.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/class.phpmailer.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/class.smtp.php';


$GLOBALS['myVetted']=array();
$GLOBALS['selectedUsers']=array();
$GLOBALS['xemail']="";
try 
{
	$result=$GLOBALS['pdo']->query("SELECT price FROM uirprice");
} 
catch (PDOException $e)
{
	$output="Unable to fetch UIRPRICE";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}
$row=$result->fetch();
$price=$row[0]; //Price per User Data

////////////////////////GET ORDERTOTAL ///////////////////////////////

try 
{
	$result=$GLOBALS['pdo']->query("SELECT orderid,total FROM ordertotal");
} 
catch (PDOException $e)
{
	$output="Unable to fetch UIRPRICE";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}
foreach($result as $row)
{
	$ordertotals[] = array('orderid'=>$row['orderid'],'total'=>$row['total']);
}
///////////////////////////////////////////////////////////////////////

///////////////////////Get USERS/////////////////////////////////////

try 
{
	$result=$GLOBALS['pdo']->query("SELECT id,email,password,firstname,surname,phone,gender,dob,address,state,description,code,verified,totalVets FROM user");
} 
catch (PDOException $e)
{
	$output="Unable to fetch Users";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}

foreach($result as $row)
{
	$users[]=array('id'=>$row['id'],'email'=>$row['email'],'password'=>$row['password'],'fname'=>$row['firstname'],'sname'=>$row['surname'],'phone'=>$row['phone'],'gender'=>$row['gender'],'dob'=>$row['dob'],'address'=>$row['address'],'state'=>$row['state'],'desc'=>$row['description'],'code'=>$row['code'],'verified'=>$row['verified'],'totVet'=>$row['totalVets']);
}
///////////////////////////////////////////////////////////////////
//////////////////////////Get Admin Roles///////////////////////////
try
{
	$result=$GLOBALS['pdo']->query("SELECT adminid,roleid FROM adminrole");
} 
catch (PDOException $e)
{
	$output="Unable to fetch Admin-roles";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}
foreach($result as $row)
{
	$adminroles[]=array('adminid'=>$row['adminid'],'roleid'=>$row['roleid']);
}

///////////////////////////////////////////////////////////////////

//////////////////Get Roles/////////////////////////////////////////

try 
{
	$result=$GLOBALS['pdo']->query("SELECT * from role");	
} 
catch (PDOException $e)
{
	$output="Unable to fetch roles";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}
foreach($result as $row)
{
	$roles[]=array('id'=>$row['id'],'desc'=>$row['description']);
}
////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////////////////////////////Get Admin Details///////////////////////////////
try 
{
	$result=$GLOBALS['pdo']->query("SELECT id,firstname,othername,surname,gender,address,phone,email,password,code,verified FROM admins");
} 
catch (PDOException $e) 
{
	$output="Unable to fetch Admin";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}
foreach($result as $row)
{
	$admins[]=array('id'=>$row['id'],'fname'=>$row['firstname'],'oname'=>$row['othername'],'sname'=>$row['surname'],'gender'=>$row['gender'],'address'=>$row['address'],'phone'=>$row['phone'],'email'=>$row['email'],'password'=>$row['password'],'code'=>$row['code'],'verified'=>$row['verified']);
}
////////////////////////////////////////////////////////////////////////////////

///////////////////Get userLog///////////////////////////////////////
try 
{
	$result=$GLOBALS['pdo']->query("SELECT * FROM userlog");

} 
catch (PDOException $e)
{
	$output="Unable to fetch Log";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}
foreach($result as $row)
{
	$Logs[]=array('userid'=>$row['userid'],'regDate'=>$row['regDate'],'lastLogin'=>$row['lastLogin']);
}
///////////////////////////////////////////////////////////////////

///////////////UNKNOWN USERS//////////////////////////////////////
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

/////////////////////Get UserSkills ////////////////////////////////
try 
{
	$result=$GLOBALS['pdo']->query("SELECT * FROM userskill");
} 
catch (PDOException $e)
{
	$output="Unable to fetch UserSkills";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}

foreach($result as $row)
{
	$userSkills[] = array('userid'=>$row['userid'],'skillid'=>$row['skillid']);
}

////////////////////////////////////////////////////////////////////////////////
///////////////////Get all ORDERS//////////////////////////////////////////
try 
{
	$result=$GLOBALS['pdo']->query("SELECT * FROM orders");
} 
catch (PDOException $e)
{
	$output="Unable to fetch orders ".$e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}

foreach($result as $row)
{
	$orders[]=array('id'=>$row['id'],'email'=>$row['email'],'phone'=>$row['phone'],'userid'=>$row['userid'],'orderdate'=>$row['orderdate'],'status'=>$row['status']);
}

////////////////////////////////////////////////////////////////////////////
/////////////////////////////////Get Notices////////////////////////////
try 
{
	$result=$GLOBALS['pdo']->query("SELECT id,text FROM notice");
} 
catch (PDOException $e) 
{
	$output="Unable to fetch Notices";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}

foreach($result as $row)
{
	$notices[] = array('id'=>$row['id'],'text'=>$row['text']);
}
////////////////////////////////////////////////////////////////////////////
///////////////////////Get all Vets/////////////////////////////////////////
try 
{
	$result=$GLOBALS['pdo']->query("SELECT * FROM vetlog");
} 
catch (PDOException $e) 
{
	$output="Unable to fetch Vet Log ".$e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}

foreach($result as $row)
{
	$vets[]=array('userid'=>$row['userid'],'vetter'=>$row['vetter'],'date'=>$row['date'],'skillid'=>$row['skillid']);
}
/////////////////////Get Skills///////////////////////////////////////////

try 
{
	$result=$GLOBALS['pdo']->query("SELECT id,skill FROM skill");
} 
catch (PDOException $e)
{
	$output="Unable to fetch Skills";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}

foreach($result as $row)
{
	$skills[] = array('id'=>$row['id'],'skill'=>$row['skill']);
}

/////////////////////////////////////////////////////////////////////////

//////////////////////////Get Messages ////////////////////////////////////

try 
{
	$result=$GLOBALS['pdo']->query("SELECT id,userid,content,date FROM message");	
} 
catch (PDOException $e)
{
	$output="Unable to fetch Messages";
	include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
}
foreach($result as $row)
{
	$messages[]=array('id'=>$row['id'],'userid'=>$row['userid'],'content'=>$row['content'],'date'=>$row['date']);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_GET['adminLogin']))
{
	header('Location:/login/');
	exit();
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//Start Cart Session//////////////////////////

if(!isset($_SESSION['cart']))
{
	$_SESSION['cart']=array();		
}
////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////
function html($text)
{
	return htmlspecialchars($text,ENT_QUOTES,'UTF-8');
}

function htmlout($text)
{
	echo html($text);
}

////////////////////Redact///////////////////////////////////////////
function redactEmail($text)
{
	$text2="";
	$myArray=str_split($text);
	for($i=0;$i<count($myArray);$i++)
	{
		if($i==0 or $i==1 or $i==count($myArray)-1 or $i==count($myArray)-2 or $i==count($myArray)-3 or $i==count($myArray)-4 or $i==count($myArray)-5 or $i==count($myArray)-6 or $i==count($myArray)-7 or $i==count($myArray)-8 or $i==count($myArray)-9 or $i==count($myArray)-10)
		{
			$text2=$text2.$myArray[$i];
		}
		else
		{
			$text2=$text2.'-';
		}
		
	}
	return $text2;
}

function redactName($text)
{
	$text2="";
	$myArray=str_split($text);

	for($i=0;$i<count($myArray);$i++)
	{
		if(count($myArray)<=10)
		{
			if($i==0)
			{
				$text2=$text2.$myArray[$i];
			}
			elseif($i>0 and $i!=count($myArray)-1)
			{
				$text2=$text2.'-';
			}
			
		}
		else
		{
			if($i==0 or $i==1)
			{
				$text2=$text2.$myArray[$i];
			}
			elseif($i==2 or $i==3 or $i==4 or $i==5 or $i==6 or $i==7 or $i==8 or $i==9 or $i==10 )
			{
				$text2=$text2.'-';
			}
			elseif($i==count($myArray)-1)
			{
				$text2=$text2.$myArray[$i];
			}
	 	}
		
		
		
	}
	return $text2;
}

function redactPhone($text)
{
	$text2="";
	$myArray=str_split($text);
	for($i=0;$i<count($myArray);$i++)
	{
		if($i==0 or $i==1 or $i==2 or $i==3 or $i==count($myArray)-1 or $i==count($myArray)-2 )
		{
			$text2=$text2.$myArray[$i];
		}
		else
		{
			$text2=$text2.'-';
		}
		
	}
	return $text2;
}
/////////////////////////////////////////////////////////////////////
	
	$verified=false;
	$GLOBALS['notVerified']='';
	//$adminVerified=false; ///used for Admin Login;
	$GLOBALS['email']="";

///////////////////////////////////////////////////////////////////////////////////
function dbContainsUser($email,$password)
{
	try 
	{
			$sql="SELECT COUNT(*) FROM user where email=:email and password=:password";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':email',$email);
			$s->bindValue(':password',$password);
			$s->execute();

	} 
	catch (PDOException $e)
	{
			$output="failed to fetch.".$e->getMessage();
	 		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	 		exit();
	}
	$row=$s->fetch();

	if($row[0]>0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
}

	function dbContainsAdmin($email,$password)
	{		
		try 
		{
			$sql="SELECT COUNT(*) FROM admins where email=:email and password=:password";
			$s=$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':email',$email);
			$s->bindValue(':password',$password);
			$s->execute();

		} 
		catch (PDOException $e)
		{
			$output="failed to fetch.".$e->getMessage();
	 		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	 		exit();
		}
		$row=$s->fetch();

		if($row[0]>0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function isLoggedIn()
	{
		if(isset($_POST['login']) and $_POST['login']=='Login')
		{
			if(!isset($_POST['email']) or $_POST['email']=="" or !isset($_POST['password']) or $_POST['password']=="")
			{
				$GLOBALS['logginError']="Please fill all fields.";
				return FALSE;
			}

			$password = md5($_POST['password']);
			if(dbContainsUser($_POST['email'],$password))
			{
				if(!isset($_SESSION))
				{
					session_start();
				}
				$_SESSION['email']=$_POST['email'];
				$_SESSION['password']=$password;
				$_SESSION['loggedIn']=TRUE;
				//$_SESSION['vetmsg']="";
				foreach($users as $user)
				{
					if($user['email']==$_POST['email'])
					{
						$GLOBALS['username'] = strtoupper($user['sname'])." " .$user['fname'];
						break;
					}
				}
				return TRUE;
			}
			else
			{
				session_start();
				unset($_SESSION['email']);
				unset($_SESSION['password']);
				unset($_SESSION['loggedIn']);
				$GLOBALS['loginError']="Wrong login Details.";
				return FALSE;
			}
		}

		if(!isset($_SESSION))
		{
			session_start();
		}
		
		if(isset($_SESSION['loggedIn']))
		{	
			
			return dbContainsUser($_SESSION['email'], $_SESSION['password']);
		}

	}


////////////////Admin isLoggedIn/////////////////////////////////////////////////////////////


function adminIsLoggedIn()
{
	/////////////////////////////Get Admin Details///////////////////////////////
	try 
	{
		$result=$GLOBALS['pdo']->query("SELECT id,firstname,othername,surname,gender,address,phone,email,password,code,verified FROM admins");
	} 
	catch (PDOException $e) 
	{
		$output="Unable to fetch Admin";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	}
	foreach($result as $row)
	{
		$admins[]=array('id'=>$row['id'],'fname'=>$row['firstname'],'oname'=>$row['othername'],'sname'=>$row['surname'],'address'=>$row['address'],'phone'=>$row['phone'],'email'=>$row['email'],'password'=>$row['password'],'code'=>$row['code'],'verified'=>$row['verified']);
	}
	////////////////////////////////////////////////////////////////////////////////

		if(isset($_POST['adminlogin']) and $_POST['adminlogin']=='Login')
		{
			if(!isset($_POST['email']) or $_POST['email']=="" or !isset($_POST['password']) or $_POST['password']=="")
			{
				$GLOBALS['logginError']="Please fill all fields.";
				return FALSE;
			}

			$password = md5($_POST['password']);

			if(dbContainsAdmin($_POST['email'],$password))
			{
				if(!isset($_SESSION))
				{
					session_start();
				}
				$_SESSION['email']=$_POST['email'];
				$_SESSION['password']=$password;
				$_SESSION['loggedIn']=TRUE;
				foreach($admins as $admin)
				{
					if($admin['email']==$_POST['email'])
					{
						$GLOBALS['username'] = strtoupper($admin['sname'])." " .$admin['fname'];
						break;
					}
				}
				return TRUE;
			}
			else
			{
				if(!isset($_SESSION))
				{
					session_start();
				}
				unset($_SESSION['email']);
				unset($_SESSION['password']);
				unset($_SESSION['loggedIn']);
				$GLOBALS['loginError']="Wrong login Details.";
				return FALSE;
			}
		}

		if(!isset($_SESSION))
		{
			session_start();
		}
		
		if(isset($_SESSION['loggedIn']))
		{	
			
			return dbContainsAdmin($_SESSION['email'], $_SESSION['password']);
		}

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////Admin Has Role/////////////////////////////////////////////////////////////////////

function adminHasRole($role)
{
	//$staffEmail=$_SESSION['email'];	
	$staffRoles=array();
	try 
	{
		$result=$GLOBALS['pdo']->query("SELECT id,email,password FROM admins");
	} 
	catch (PDOException $e) 
	{
		$output="Unable to fetch Admin";
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	}

	foreach($result as $admin)
	{
		if($admin['email']==$_SESSION['email'] and $admin['password']==$_SESSION['password'])
		{
			$adminID=$admin['id'];// The ID of the current Admin that is logged In
			break;
		}
	}

	try 
	{
		$sql="SELECT adminid,roleid FROM adminrole where adminid=:adminid";
		$s=$GLOBALS['pdo']->prepare($sql);
		$s->bindValue(':adminid',$adminID);
		$s->execute();
	} 
	catch (PDOException $e)
	{
		$output="Unable to fetch Admin roles ".$e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	}
	
	$result=$s->fetchAll();

	foreach($result as $staffRole)
	{
		if($staffRole['roleid']==$role)
		{
			array_push($staffRoles,$staffRole['roleid']);			
		}
	}
	if(in_array($role,$staffRoles))
	{
		return TRUE;
	}
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////


	if(isset($_SESSION['loggedin']))
	{
		foreach($users as $user)
		{
			if($user['id']==$_SESSION['userid'])
			{
				$GLOBALS['username'] = strtoupper($user['sname'])." " .$user['fname'];
				break;
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////Redirect to Homepage./////////////////////////////////
if(isset($_GET['home']))
{
	header('Location:..');
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////

/////////////////////////Redirect to Admin Homepage./////////////////////////////////
if(isset($_GET['adminhome']))
{
	header('Location:/admin/');
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////

/////////////////////////Redirect to staff page./////////////////////////////////
if(isset($_GET['staffman']))
{
	header('Location:/admin/staff/');
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////

/////////////////////////Redirect to sales page./////////////////////////////////
if(isset($_GET['salesman']))
{
	header('Location:/admin/sales/');
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////Redirect to User Management page./////////////////////////////////
if(isset($_GET['userman']))
{
	header('Location:/admin/user/');
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////Redirect to Contact Us page///////////////////////////////
if(isset($_GET['contactus']))
{
    header('Location:../?contact');
	//include 'contact.html.php';
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////

/////////////////////////Redirect to About Us page./////////////////////////////////
if(isset($_GET['whatis']))
{
	include'about.html.php';
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////

/////////////////////////Redirect to Profile page./////////////////////////////////
if(isset($_GET['profile']))
{
	header('Location:./user/');
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////

/////////////////////////Redirect to Forgot Password page./////////////////////////////////
if(isset($_GET['forgotpword']))
{
	include'resetpword.html.php';
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////




?>