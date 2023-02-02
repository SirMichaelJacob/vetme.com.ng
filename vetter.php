<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/iknowdb.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/class.phpmailer.php';
include $_SERVER['DOCUMENT_ROOT'].'/class.smtp.php';
require 'controller.php';
session_start();
$continue=true;	


unset($_SESSION['vetmsg']);
	
	// $UserExists=false;
	// foreach($users as $user)
	// {

	// 	if($user['id']==$_POST['vet'])
	// 	{
	// 		$UserExists=true;
	// 		break;
	// 	}
	// }
	// if(!$UserExists)
	// {
	// 	echo "User does not exist!";
	// }
	// else
	// {
	// 	if(isLoggedIn())
	// 	{
			
	// 		foreach($vets as $vet)
	// 		{
	// 			if($vet['userid']==$_POST['vet'] and $vet['vetter']==$_SESSION['userid'] and $vet['skillid']==$_POST['sid'])
	// 			{
	// 				$continue=false;
	// 				break;
	// 			}
	// 		}

	// 		if($continue)
	// 		{
	// 			try 
	// 			{
	// 				$sql="INSERT INTO vetLog SET userid=:userid,vetter=:vetter,skillid=:skillid,date=CURDATE()";
	// 				$s=$GLOBALS['pdo']->prepare($sql);
	// 				$s->bindValue(':userid',$_POST['vet']);
	// 				$s->bindValue(':vetter',$_SESSION['userid']);
	// 				$s->bindValue(':skillid',$_POST['sid']);
	// 				$s->execute();
	// 			} 
	// 			catch (PDOException $e) 
	// 			{
	// 				$output="Failed to Vet ".$e->getMessage();
	// 				include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	// 			}
	// 			//////////////////////////////Get USERNAME////////////////////////////////////////////
	// 			foreach($users as $user)
	//             {
	//                 if($user['id']==$_SESSION['userid'])
	//                 {
	//                     $GLOBALS['username'] = strtoupper($user['sname'])." " .$user['fname'];
	//                     break;
	//                 }
	//             }   

	//             $thisSkill="";
	//             foreach($skills as $skill)
	//             {
	//                 if($_POST['sid']==$skill['id'])
	//                 {
	//                     $thisSkill = $skill['skill'];
	//                     break;
	//                 }
	//             }  

	// 			//////////////////////////////////////////////////////////////////////////////////////

	// 			try 
	// 			{
	// 				$sql="INSERT INTO message SET userid=:userid,content=:content,date=CURDATE()";
	// 				$s=$GLOBALS['pdo']->prepare($sql);
	// 				$s->bindValue(':userid',$_POST['vet']);
	// 				$s->bindValue(':content',$GLOBALS['username']." "."has just vetted you for $thisSkill.\r\n");
	// 				$s->execute();
	// 			} 
	// 			catch (PDOException $e) 
	// 			{
	// 				$output="Failed to send notification ";
	// 				include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
	// 			}


	// 			if(!isset($_SESSION))
	// 			{
	// 				session_start();
					
	// 			}
	// 			unset($_SESSION['vetmsg']);
	// 			$_SESSION['vetmsg']="Vetting Successful";
	// 			// header('Location:?view='.$_POST['vet']);
	// 			// exit();
	// 		}
	// 		else
	// 		{

	// 			if(!isset($_SESSION))
	// 			{
	// 				session_start();
					
	// 			}
	// 			unset($_SESSION['vetmsg']);
	// 			$_SESSION['vetmsg']="You have already vetted this user.";
				
	// 			// header('Location:?view='.$_POST['vet']);
	// 			// exit();
	// 		}

	// 	}
	// 	// else
	// 	// {
	// 	// 	echo 'Please Login to Vet';
	// 	// }

	// }

	if(isset($_POST['email']))
	{
		if(!isset($_SESSION))
		{
			session_start();
		}
		
		$uid=$_POST['vet'];
		$_SESSION['xemail'] = $_POST['email'];
		$foundX=false;
		$vStatus='NO';
		$vetmeUserEmail=false;

		

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
				$vetmeUserEmail=true;
				break;
			}
		}
		
		if(!$vetmeUserEmail)
		{
    		if(!$foundX and $vStatus=='NO')
    		{
    			header('Location:/?unregEmail');
    			exit();
    		}
    		elseif($foundX and $vStatus=='NO')
    		{
    			header('Location:/?unregEmail');
    			exit();
    		}
    		elseif($foundX and $vStatus=='YES')
    		{
    			$continue=true;
    			foreach($vets as $vet)
    			{
    				if($vet['userid']==$_POST['vet'] and $vet['vetter']==$_SESSION['xemail'] and $vet['skillid']==$_POST['sid'])
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
    					$s->bindValue(':vetter',$_SESSION['xemail']);
    					$s->bindValue(':skillid',$_POST['sid']);
    					$s->execute();
    				} 
    				catch (PDOException $e) 
    				{
    					$output="Failed to Vet ".$e->getMessage();
    					include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
    				}
    				//////////////////////////////Get USERNAME////////////////////////////////////////////
    				$GLOBALS['username'] = $_SESSION['xemail'];
    	            
    
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
    					$s->bindValue(':content',$GLOBALS['username']." "."has just vetted you for $thisSkill.\r\n");
    					$s->execute();
    				} 
    				catch (PDOException $e) 
    				{
    					$output="Failed to send notification ".$e->getmessage();
    					include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
    				}
    				$uid=$_POST['vet'];
    				/////////////////Send Mail to Unregistered Vetter/////////////////////////////////////////////////////////////
    				
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
                  $mail->Subject = "Vetting Successful";
                //   $mail->AltBody = "Your password on VetMe.com.ng (Nigeria's no.1 Skills repository) has been reset.\r\n Please visit www.vetMe.com.ng and Enter ".$code." to Confirm reset."; // optional - MsgHTML will create an alternate automatically
                  $mail->Body = "Thank you for vetting.\r\n You have vouched for USER-ID: ".$_POST['vet']." On VetMe.com.ng.Please visit vetme.com.ng more often";
                  //$mail->MsgHTML(file_get_contents('contents.html'));
                  //$mail->AddAttachment('images/phpmailer.gif');      // attachment
                  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
                  $mail->Send();
                 
                } catch (phpmailerException $e) {
                  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
                } catch (Exception $e) {
                  //echo $e->getMessage(); //Boring error messages from anything else!
                }
    				
    				
    				
    				////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    				
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
              $mail->Body = "Congratulations!! \r\n".$_SESSION['xemail']. " just vetted you for $thisSkill! \r\n VetMe.com.ng (Nigeria's no.1 Tech Skills repository)";
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
	
    			
                $countVet=0;
        		foreach($vets as $vet)
        	    {
        	       if($vet['userid']==$_POST['vet'])
        	       {
        	       		$countVet++;
        	       }
        
        	    }

////////////////////////////................/////////////////
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
    				echo "<script> 
    				alert('Vetting Successful! Done');
    				window.location.href='./?view=$uid';			
    				</script>";
    			}
    			else
    			{
    
    				$uid=$_POST['vet'];
    				echo "<script> 
    				alert('You have already vetted this user.');
    				window.location.href='./?view=$uid';			
    				</script>";
    				
    			}
    		}
    		}
		else
		{
			echo "<script> 
				alert('This email is already registered as a User Email.');
				window.location.href='./?view=$uid';			
				</script>";
		}
		
	}





?>