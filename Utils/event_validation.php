<?php
require 'Constants.php';
$ename = ""; //Event Name
$desc = ""; //Description
$img = ""; //Image
$category = ""; //category
$address = ""; //address
$days = ""; //days
$city = ""; //City
$state = ""; //state
$country= ""; // Country
$zip= ""; // Zip Code	
$address = "" //Address
$stdate = "" //Start Date
$endate = "" //End Date
$sttime = "" //Start Time
$entime = "" //End Time
$error_array = array(); //Holds error messages

$conn = mysqli_connect(SERVER_NAME, USER_NAME, PASSWORD, DATABASE_NAME);
                    // Check connection
                    if (!$conn) {
                      die("Connection failed: " . mysqli_connect_error());
                    }
					  
if(isset($_POST['create_submit'])){

	//Registration form values

	//Event name
	$ename = strip_tags(mysqli_real_escape_string($conn, $_POST['ename'])); //Remove html tags
	$ename = str_replace(' ', '', $fname); //remove spaces
	$ename = ucfirst(strtolower($fname)); //Uppercase first letter
	$_SESSION['ename'] = $ename; //Stores first name into session variable

	//Description
	$desc  = strip_tags(mysqli_real_escape_string($conn, $_POST['message'])); //Remove html tags
	$desc  = str_replace(' ', '', $lname); //remove spaces
	$desc  = ucfirst(strtolower($lname)); //Uppercase first letter
	$_SESSION['desc'] = $desc;//Stores last name into session variable


	//city
	$city = strip_tags(mysqli_real_escape_string($conn, $_POST['city'])); //Remove html tags
	$city = str_replace(' ', '', $city); //remove spaces
	$city = strtolower($city); //Lower case everything
	$_SESSION['city'] = $city; //Stores email into session variable

	//state
	$state = strip_tags(mysqli_real_escape_string($conn, $_POST['state'])); //Remove html tags
	$state = str_replace(' ', '', $state); //remove spaces
	$state = strtolower($state); //Lower case everything
	$_SESSION['state'] = $state; //Stores email into session variable

	//country
	$country = strip_tags(mysqli_real_escape_string($conn, $_POST['country'])); //Remove html tags
	$country = str_replace(' ', '', $country); //remove spaces
	$country = strtolower($country); //Lower case everything
	$_SESSION['country'] = $country; //Stores email into session variable


	//address1
	$address1 = strip_tags(mysqli_real_escape_string($conn, $_POST['address-line1'])); //Remove html tags
	$address1 = str_replace(' ', '', $address1); //remove spaces
	$address1 = strtolower($address1); //Lower case everything
	

	//address2
	$address2 = strip_tags(mysqli_real_escape_string($conn, $_POST['address-line2'])); //Remove html tags
	$address2 = str_replace(' ', '', $address2); //remove spaces
	$address2 = strtolower($address2); //Lower case everything

	if(!empty($_POST['weekdays'])) {
		foreach($_POST['weekdays'] as $check) {
				echo $check; //echoes the value set in the HTML form for each checked checkbox.
							 //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
							 //in your case, it would echo whatever $row['Report ID'] is equivalent to.
		}
	}	
	else{
		array_push($error_array, "Please select days the event will be open<br>");
	}

	if(!empty($_POST['category'])) {
		foreach($_POST['category'] as $check) {
				echo $check; //echoes the value set in the HTML form for each checked checkbox.
							 //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
							 //in your case, it would echo whatever $row['Report ID'] is equivalent to.
		}
	}	
	else{
		array_push($error_array, "Please select categories for the event<br>");
	}
	
	if (strlen($address2) < 1){
	$address = $address1
	}
	else{$address = $address1 ." ". $address2}
	$_SESSION['address'] = $address; //Stores email into session variable
	
	if(strlen($address1) < 2){
		array_push($error_array, "Please put your address<br>");
	}

	if(strlen($ename) > 50 || strlen($ename) < 2){
		array_push($error_array, "Your event name must be between 2 and 25 characters<br>");
	}

	if(strlen($desc) > 150 || strlen($desc) < 20){
		array_push($error_array, "Your description must be between 20 and 150 characters<br>");
	}


	if(strlen($country) < 3){
		array_push($error_array, "Please select your country<br>");
	}


	if(empty($error_array)) {
		
		$query = mysqli_query($conn, "INSERT INTO Member(FirstName,LastName,EMail,Password,Phone,City,Zip,State,Country) VALUES ('$fname', '$lname','$email','$password','$phone','$city','$zip','$state','$country')");		
		
	array_push($error_array, "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>");	
	
		//Clear session variables 
		$_SESSION['fname'] = "";
		$_SESSION['lname'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['city'] = "";
		$_SESSION['phone'] = "";
		$_SESSION['country'] = "";	
		$_SESSION['state'] = "";	
		$_SESSION['zip'] = "";	
	}	//empty error array	
	

}
?>