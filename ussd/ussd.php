<?php
header("Content-type:text/plane");

require('../AfricasTalkingGateway.php');

require('config.php');



if(empty($textFromUser)){

	$textFromUser = "0";

}else{

	$textFromUser = "0*".$textFromUser;

	$phone_number = $_POST['phoneNumber'];

$textFromUser = $_POST['text'];

$sessionID = $_POST['sessionId'];

$serviceCode = $_POST['serviceCode'];


}

$inputArray = explode("*", $textFromUser);

$level = count($inputArray);

switch ($level) {

	case 1:

		$response = "CON Welcome to Purge Transportation Logistics";

	    $response .= "\n 1. Register";

	    $response .= "\n 2. Request for transportation";

	    echo $response;

		break;

	case 2:		

		 if($inputArray[1]   ==  1) {

		 	echo "CON What is is your name?";



		 }elseif ($inputArray[1] == 2) {
		 	$checkmembers = $dbConnection->query("SELECT * FROM payments WHERE phone_number = '$phone_number' ");

		 	if($checkmembers->num_rows == 0) 

		 		echo "END User with phone_number $phone_number has no account";

		 	else{

		 		while ($results = $checkmembers->fetch_assoc()) {

		 			echo "CON ".$results['name']."\n Enter the number of trees";

		 		}

		 	}
				
					  

		 
		 }else{

		 	echo "END Invalid option";

		 }
		  
		break;

	case 3: 

	     if($inputArray[1]   ==  1) {

		 	$user_name = $inputArray[2];

		 	$saveUser =$dbConnection->query("INSERT INTO payments(phone_number,name)VALUES('$phone_number','$user_name')");

		 	if($saveUser){

		 		$message = "Hello ".$user_name." Thank you for requesting you will be notified shortly about your transportation details ltd";		        
				$apikey     = "3a2fb28179d1cdcbfb2b008da831df787b8a88897ceedd5e4360973b9576319a";			 
				$gateway    = new AfricasTalkingGateway("sandbox", $apikey,"sandbox");

				$gateway->sendMessage($phone_number, $message); 

				echo "END Thank you for your request"; 

		 	}else{

		 		echo "END Failed to register ".$sqliCon->error;

		 	}


		 }elseif ($inputArray[1] == 2) {

		 	$number_of_trees = $inputArray[2];

		 	$checkmembers = $sqliCon->query("SELECT id,name FROM members WHERE phone_number = '$phone_number'");

		 	if($checkmembers->num_rows == 1){
		 
		 	while ($rows = $checkmembers->fetch_assoc()) {

		 		$member_id = $rows['id'];

		 	    $member_name = $rows['name'];

		 	    $sqliCon->query("INSERT INTO trees(member_id,number_of_trees)VALUES('$member_id','$number_of_trees')");

		 	    $message = "Hello $member_name, Thank you for conserving the climate. You have recorded $number_of_trees tree(s)";
			    $apikey     = "3a2fb28179d1cdcbfb2b008da831df787b8a88897ceedd5e4360973b9576319a";			 
			    $gateway    = new AfricasTalkingGateway("sandbox", $apikey,"sandbox");
			    $gateway->sendMessage($phone_number, $message);
		 	    echo "END $message";
		 		 
		 	}

		 }else{

		 	echo "END No user found";

		 }
	 
	}  

	 
		break;
	
	default:

		echo"The option selected is not valid";

		break;
}
?>
