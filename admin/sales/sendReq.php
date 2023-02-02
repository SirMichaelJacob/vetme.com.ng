<?php

include $_SERVER['DOCUMENT_ROOT'].'/includes/iknowdb.inc.php';
require $_SERVER['DOCUMENT_ROOT'].'/controller.php';
require $_SERVER['DOCUMENT_ROOT'].'/class.phpmailer.php';
require $_SERVER['DOCUMENT_ROOT'].'/class.smtp.php';


$urID=$_POST['urID'];


	
			
			try 
			{
				$sql="SELECT status FROM orders where id=:id and userid=:userid";
				$s=$GLOBALS['pdo']->prepare($sql);
				$s->bindValue(':id',$_POST['orID']);
				$s->bindValue(':userid',$urID);
				$s->execute();
			} 
			catch (PDOException $e)
			{
				$output="Failed to fetch order ".$e->getMessage();
				include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
			}
			$row=$s->fetch();

			if($row[0]=="PROCESSED")
			{
				$processed=true;
			}
			else
			{
				$processed=false;
			}

			// foreach($orders as $order)
			// {
			// 	if(($order['id']==$_POST['orID']) and ($order['userid']==$_POST['urID']) and ($order['status']=='PROCESSED'))
			// 	{
			// 		$processed=true;
			// 		break;
			// 	}
			// }


			if(!$processed)
			{
				try 
				{
					$sql="UPDATE orders SET status='PROCESSED' where id=:id and userid=:userid";
					$s=$GLOBALS['pdo']->prepare($sql);
					$s->bindValue(':userid',$urID);
					$s->bindValue(':id',$_POST['orID']);
					$s->execute();
				} 
				catch (PDOException $e) 
				{
					$output="Failed to update orders ".$e->getMessage();
					include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
				}
				//////////////////////////////Get USERNAME////////////////////////////////////////////
				foreach($orders as $order)
	            {
	                if($order['id']==$_POST['orID'])
	                {
	                    $GLOBALS['client'] = $order['email'];
	                    break;
	                }
	            }   


				//////////////////////////////////////////////////////////////////////////////////////

				try 
				{
					$sql="INSERT INTO message SET userid=:userid,content=:content,date=CURDATE()";
					$s=$GLOBALS['pdo']->prepare($sql);
					$s->bindValue(':userid',$urID);
					$s->bindValue(':content',"Your Contact was request by ".redactEmail($GLOBALS['client'])."\r\n and has been sent.");
					$s->execute();
				} 
				catch (PDOException $e) 
				{
					$output="Failed to send notification ".$e->getmessage();
					include $_SERVER['DOCUMENT_ROOT'].'/includes/output.html.php';
				}

				try 
				{
				     $mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch
                
                     $mail->IsSMTP(); // telling the class to use SMTP
                     $mail->IsHTML(true);
					foreach($users as $user)
					{
						if($user['id']==$urID)
						{
				// 			$email=$GLOBALS['client'];
				// 			$headers = "From: sales@vetme.com.ng". "\r\n" .  'Reply-To:requests@vetme.com.ng' . "\r\n";
				// 			$msg="FIRSTNAME: ".$user['fname']."\r\n"."SURNAME: ".$user['sname']."GENDER: ".$user['gender']."\r\n"."PHONE: ".$user['phone']."\r\n"."EMAIL: ".$user['email']."\r\n"."DATE OF BIRTH: ".$user['dob']."\r\n"."STATE OF RESIDENCE: ".$user['state']."\r\n"."ADDRESS: ".$user['address']."\r\n"."SKILL LEVEL: ".$user['desc']."\r\n";
				// 			$subject = "vetMe USER DETAILS - ";
				// 		    $to = $GLOBALS['client'];
				// 		    mail($to, $subject, $msg, $headers);
				// 		    break;
                        
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
                              $mail->AddReplyTo('sales@vetme.com.ng');
                              $recipient=$GLOBALS['client'];
                              $mail->AddAddress("$recipient",'Customer UIR');
                              $mail->SetFrom('feedback@vetme.com.ng','VetMe NIGERIA');
                              $mail->AddReplyTo('sales@vetme.com.ng');
                              $mail->Subject = "VetMe User Details";
                            //   $mail->AltBody = "FIRSTNAME: ".$user['fname']."\r\n"."SURNAME: ".$user['sname']."GENDER: ".$user['gender']."\r\n"."PHONE: ".$user['phone']."\r\n"."EMAIL: ".$user['email']."\r\n"."DATE OF BIRTH: ".$user['dob']."\r\n"."STATE OF RESIDENCE: ".$user['state']."\r\n"."ADDRESS: ".$user['address']."\r\n"."SKILL LEVEL: ".$user['desc']."\r\n"; // optional - MsgHTML will create an alternate automatically
                            
                            $NAME=$user['fname']." ".$user['sname'];
                            $GENDER=$user['gender'];
                            $PHONE=$user['phone'];
                            $EMAIL=$user['email'];
                            $DOB=$user['dob'];
                            $STATE=$user['state'];
                            $ADDRESS=$user['address'];
                            $DESC= $user['desc'];
                            
                            $msg="<html>
                                    <head>
                                    	<title>VETME USER INFORMATION</title>
                                    </head>
                                    <body>
                                    	<h2>VETME USER INFORMATION</h2>
                                    	
                                    	<p>NAME: $NAME</p>
                                    	<p>GENDER: $GENDER</p>
                                    	<p>PHONE: $PHONE</p>
                                    	<p>EMAIL: $EMAIL</p>
                                    	<p>DATE OF BIRTH: $DOB</p>
                                    	<p>STATE OF RESIDENCE: $STATE</p>
                                    	<p>ADDRESS: $ADDRESS</p>
                                    	<p>SKILL LEVEL: $DESC</p>
                                    </body>
                                    </html>";
                              $mail->Body = $msg;
                              //$mail->MsgHTML(file_get_contents('contents.html'));
                              //$mail->AddAttachment('images/phpmailer.gif');      // attachment
                              //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
                              $mail->Send();
                             
                            } catch (phpmailerException $e) {
                              //echo $e->errorMessage(); //Pretty error messages from PHPMailer
                            } catch (Exception $e) {
                              //echo $e->getMessage(); //Boring error messages from anything else!
                            }
                            break;
						}
					}			
					
				} 
				catch (Exception $e) 
				{
					$output="Failed to send USER INFORMATION to Email address.";
					include'output.html.php';
					exit();
				}
                echo "User Information has been sent! \r\n Done";

			}
			else
			{

				
				// $msg="You have already vetted this user.";
				echo "You have already processed this request.";
			}








?>