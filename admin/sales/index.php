<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/session.inc.php';
require $_SERVER['DOCUMENT_ROOT'].'/controller.php';

if(!adminIsLoggedIn())
{
	header('Location:/login/');
	exit();
}

if(!adminHasRole('sales manager'))
{	
	// $GLOBALS['message']="Access Denied \r\n You do not have HR Mangement privillege";
	// $GLOBALS['alertType']="alert-danger";	
	// header('Location:/vetme/admin/');
	
	echo "<script> 
		alert('Access Denied. You do not have SALES Mangement privillege');
		window.location.href='..';			
		</script>";

	exit();
}

if(isset($_GET['orderid']) and $_GET['orderid']!='')
{
	$filterClicked=true;
	$orderfound=false;

	foreach($orders as $order)
	{
		if($order['id']==$_GET['orderid'])
		{
			$orderfound=true;			
			break;
		}
	}
	if($orderfound)
	{
		foreach($orders as $order)
		{
			if($order['id']==$_GET['orderid'])
			{
				$orderID=$order['id'];
				$orderEmail=$order['email'];
				$orderPhone=$order['phone'];
				$orderDate=$order['orderdate'];
				break;
			}
		}

		$numReq=0;

		try
		{
			$sql = "SELECT COUNT(*) FROM orders where id=:id";
			
			$s =$GLOBALS['pdo']->prepare($sql);
			$s->bindValue(':id',$_GET['orderid']);
			$s->execute();
			
		}
		catch (PDOException $e)
		{
			$output = 'Error fetching users. '.$e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
			exit();
		}
		$row=$s->fetch();
		$numReq= $row[0];
		$orderAmount=0;
		foreach($ordertotals as $orderT)
		{
			if($orderT['orderid'] == $orderID)
			{
				$orderAmount=$orderT['total'];
				break;
			}
		}
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

  $rowsperpage=10;



	try
	{
		$sql = "SELECT * FROM orders";
		
		$s = $GLOBALS['pdo']->query($sql);
		
	}
	catch (PDOException $e)
	{
		$output = 'Error fetching users. '.$e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		exit();
	}
	
	foreach ($s as $row)
	{
		$All[] = array('id' => $row['id']);
	}


	$Orderids=array();

	foreach($All as $a)
	{
		if(!in_array($a['id'], $Orderids))
		{
			array_push($Orderids, $a['id']);
		}
		
	}
	

	try 
	{
		$sql = " SELECT id,email,phone,orderdate,status FROM orders LIMIT ". $start.", ". $rowsperpage;
		$result = $GLOBALS['pdo']->query($sql);
		//echo $sql1;
	} 
	catch (PDOException $e)
	{
		$output = 'Error fetching orders. '.$e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		exit();
	}

	foreach ($result as $row)
	{
		$Allorders[] = array('id'=>$row['id'],'email' =>$row['email'],'phone'=>$row['phone'],'orderdate'=>$row['orderdate'],'status'=>$row['status']);
	}

	$totalOrders=array();
	if(isset($Allorders))
	{
		foreach($Allorders as $allorder)
		{
			foreach ($orders as $order) 
			{
				if($allorder['id'] == $order['id'])///Selects Orders from Same email on the same date
				{
					if(!in_array($order, $totalOrders))
					{
						array_push($totalOrders, $order);

					}
					break;
				}
			}
		}
	}

	$totalUniqueOrders=count($All);
	$maxpage=ceil($totalUniqueOrders/$rowsperpage);
	
//......................................................../////////////

if(isset($_GET['openOrder']) and strlen($_GET['openOrder'])>1)
{	

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

	
	$getOrders=array();
	$orderID=$_GET['openOrder'];
	foreach($orders as $order)
	{
		if($order['id']==$orderID)
		{
			if(!in_array($order, $getOrders))
			{
				array_push($getOrders, $order);
			}
		}
	}

	include $_SERVER['DOCUMENT_ROOT'].'/admin/sales/salesview.html.php';
	exit();
}

if(isset($_POST['OID']))
{
	//echo $_POST['UID'];
	$thisOID=$_POST['OID'];
	$thisUID=$_POST['UID'];
	foreach($users as $user)
	{
		if($user['id']==$thisUID)
		{
			$Ufname=$user['fname'];
			$Usname = $user['sname'];
			$Uphone = $user['phone'];
			$Uemail=$user['email'];
			$Uaddress=$user['address'];
			break;
		}
	}
	
//////////...........................................
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

	
	$getOrders=array();
	$orderID=$thisOID;
	foreach($orders as $order)
	{
		if($order['id']==$orderID)
		{
			if(!in_array($order, $getOrders))
			{
				array_push($getOrders, $order);
			}
		}
	}
	// $total = count($getOrders)*$price;
	// if(count($ordertotals)==0)
	// {
	// 	try 
	// 		{
	// 			$sql="INSERT INTO ordertotal SET orderid=:orderid,total=:total";
	// 			$s=$GLOBALS['pdo']->prepare($sql);
	// 			$s->bindValue(':orderid',$orderID);
	// 			$s->bindValue(':total',$total);
	// 			$s->execute();
	// 		} 
	// 		catch (PDOException $e)
	// 		{
				
	// 		}
	// 		break;
	// }
	// else
	// {
	// 	$foundid=false;
	// 	foreach($ordertotals as $ordertotal)
	// 	{
	// 		if($ordertotal['orderid']==$orderID)
	// 		{

	// 			$foundid=true;
	// 			break;
	// 		}
			
	// 	}
	// 	if(!$foundid)
	// 	{
	// 			try 
	// 			{
	// 				$sql="INSERT INTO ordertotal SET orderid=:orderid,total=:total";
	// 				$s=$GLOBALS['pdo']->prepare($sql);
	// 				$s->bindValue(':orderid',$orderID);
	// 				$s->bindValue(':total',$total);
	// 				$s->execute();
	// 			} 
	// 			catch (PDOException $e)
	// 			{
					
	// 			}
	// 	}
	// }
	
	//////////////////////////..............................


	include 'salesview.html.php';
	exit();
}

//////////////////////Logout/////////////////////////////////////////////////////////////
if(isset($_GET['logout']))
{
	session_start();
	unset($_SESSION['loggedIn']);
    unset($_SESSION['email']);
	unset($_SESSION['password']);
	unset($_SESSION['cart']);
	header('Location:.');
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////SET PRICE////////////////////////////////////////////////

if(isset($_POST['setprice']) and isset($_POST['price']))
{
	$cansetprice=false;

	if(adminHasRole('user manager') and adminHasRole('sales manager') and adminHasRole('HR manager'))
	{
		$cansetprice=true;
	}
	if($cansetprice)
	{
		try 
		{
			$sql="UPDATE uirprice set price=".intVal($_POST['price']);
			$result=$GLOBALS['pdo']->query($sql);		
		} 
		catch (PDOException $e) 
		{
			$output="Unable to set UIR Price";
			include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
		}
		$price=intVal($_POST['price']);
	}
	else
	{
		echo "<script>
		alert('You are not authorized to set UIR Price');
		</script>";
	}
	
}
/////////////////////////////////////////////////////////////////////////////////////////



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





include 'sales.html.php';
exit()
?>