/*
 AskGC
 
 Description: Each entered valuable is compared with the value of fields in the database. If there are no issues then the password field in the database is updated to reflect the users newly desired password. The user will recieve an email confirming the change.
 */

<?php
include("dataBaseConnect.php");

$dbname = "askgc";

mysql_select_db($dbname) or die ("could not connect");


	$email = $_POST["email"];
	$current_password = $_POST["current_password"];
	$new_password = $_POST["new_password"];
	$new_confirmpassword = $_POST["confirm_new_password"];
	
	if(empty($email) || empty($current_password) || empty($new_password) || empty($new_confirmpassword))
	{
		echo "All data is required";
                exit;
	}

	if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
	{
	     $sendmsg = "ERROR NO SUCH EMAIL!";		
	     echo $sendmsg;
             exit;
	}

        
        $sql="select * from askgcUsers where username='".$email."'";

        $result = mysql_query($sql);

	if(mysql_num_rows($result)>=1)
        {
            $sql="select * from askgcUsers where username='".$email."' and password='".$current_password."'";
            $result = mysql_query($sql);

		if(mysql_num_rows($result)>=1)
		{
			if($new_password == $new_confirmpassword)
			{
				$sql = "update askgcUsers set password='".$new_password."' where username='".$email."'";
                                
				mysql_query($sql); 

                                $sql = "select * from askgcUsers where username='".$email."' and password='".$new_password."'";
                                
			
                        	$result = mysql_query($sql);

				if(mysql_num_rows($result) >= 1)
				{  
                           		while($row = mysql_fetch_array($result))
               		   		{
		  				$fname = $row["firstname"] . "";

                	   		}
                          
			   		$msg = "Your password was successfully changed.";
                           		$emailmsg = "Dear $fname,\nPlease do not reply to this email.\nYour password was successfully changed at ASKGC.\nPlease contact us if you have any questions.\nEmail: gctv@loyola.edu\nStudioPhone: (410) 617-5582\nThanks,\nThe ASKGC TEAM.";
			   		mail("$email", "YOUR ASKGC PASSWORD WAS CHANGED", $emailmsg);			           			                
			   		echo $msg;
              	          	 	exit;
	
				}

 

			}
			else
			{
		   		$sendmsg = "The new password does not match the confirm new password.";
		   		echo $sendmsg;
				exit;
			}
		}
		else
		{
			$sendmsg = "Invalid current password.";
		   	echo $sendmsg;
			exit;

		}
	}
		
	else
	{
		$sendmsg = "The email entered does not exist in our system.";
		echo $sendmsg;
		exit;

	}

    
?>
