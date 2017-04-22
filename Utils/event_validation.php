<?php

require 'Constants.php';					  
$ename = ""; //Event Name
$desc = ""; //Description
$img = ""; //Image
$address = ""; //address
$city = ""; //City
$state = ""; //state
$country= ""; // Country
$zip= ""; // Zip Code	
$stdate = ""; //Start Date
$endate = ""; //End Date
$sttime = ""; //Start Time
$entime = ""; //End Time
$error_array = array(); //Holds error messages
$dayofweek = array();
$catint = array();

$target_dir = "../Images/Events/";
$uploadOk = 1;



$conn = mysqli_connect(SERVER_NAME, USER_NAME, PASSWORD, DATABASE_NAME);
                    // Check connection
                    if (!$conn) {
                      die("Connection failed: " . mysqli_connect_error());
                    }
		

if(isset($_POST['create_submit'])){
	//Images


$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} 

else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


		$imageName = $target_dir . $ename . "." . $imageFileType;
		$imageName = str_replace("../", "", $imageName);
	


	//Event name
	$ename = strip_tags(mysqli_real_escape_string($conn, $_POST['ename'])); //Remove html tags
	$ename = str_replace(' ', '', $ename); //remove spaces
	$ename = ucfirst(strtolower($ename)); //Uppercase first letter
	$_SESSION['ename'] = $ename; //Stores first name into session variable

	//Description
	$desc  = strip_tags(mysqli_real_escape_string($conn, $_POST['message'])); //Remove html tags
	$desc  = str_replace(' ', '', $desc); //remove spaces
	$desc  = ucfirst(strtolower($desc)); //Uppercase first letter
	$_SESSION['desc'] = $desc;//Stores last name into session variable


	//MemberId
	$memid = strip_tags(mysqli_real_escape_string($conn, $_POST['membid'])); //Remove html tags
	$memid = str_replace(' ', '', $memid); //remove spaces
	$_SESSION['memid'] = $memid; //Stores email into session variable

	//start time
	$sttime = strip_tags(mysqli_real_escape_string($conn, $_POST['start_time'])); //Remove html tags
	$_SESSION['sttime'] = $sttime; //Stores email into session variable

	//end time
	$entime = strip_tags(mysqli_real_escape_string($conn, $_POST['end_time'])); //Remove html tags
	$_SESSION['entime'] = $entime; //Stores email into session variable
	//start date
	
	$stdate = strip_tags(mysqli_real_escape_string($conn, $_POST['start_date'])); //Remove html tags
	$stdate = date('Y-m-d', strtotime(str_replace('/', '-', $stdate)));
	$_SESSION['stdate'] = $stdate; //Stores email into session variable

	//start date
	$endate = strip_tags(mysqli_real_escape_string($conn, $_POST['end_date'])); //Remove html tags
	$endate = date('Y-m-d', strtotime(str_replace('/', '-', $endate)));
	$_SESSION['endate'] = $endate; //Stores email into session variable

	//zipcode
	$zip = strip_tags(mysqli_real_escape_string($conn, $_POST['zipcode'])); //Remove html tags
	$zip = str_replace(' ', '', $zip); //remove spaces
	$zip = strtolower($zip); //Lower case everything
	$_SESSION['zip'] = $zip; //Stores email into session variable
	
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
		foreach($_POST['weekdays'] as $wday) {

				array_push($dayofweek,$wday);				
		}
	}	
	else{
		array_push($error_array, "Please select days the event will be open<br>");
	}

	if(!empty($_POST['category'])) {
		foreach($_POST['category'] as $cat) {

				array_push($catint,$cat);
		}
	}	
	else{
		array_push($error_array, "Please select categories for the event<br>");
	}



	if(strlen($ename) > 50 || strlen($ename) < 2){
		array_push($error_array, "Your event name must be between 2 and 25 characters<br>");
	}

	if(strlen($desc) > 150 || strlen($desc) < 20){
		array_push($error_array, "Your description must be between 20 and 150 characters<br>");
	}



	if(strlen($country) < 2){
		array_push($error_array, "Please select your country<br>");
	}

	if(strlen($address1) < 2){
		array_push($error_array, "Please put your address<br>");
	}

	if (strlen($address2) < 1){
		$address = $address1;
	}
	else{
		$address = $address1 ." ". $address2;
	}

	$_SESSION['address'] = $address; //Stores email into session variable
/*		echo "<br/>event". $ename; //Event Name
		echo "<br/>desc". $desc; //Description
		echo "<br/>img". $img; //Image
		echo "<br/>addre". $address; //address
		echo "<br/>city". $city; //City
		echo "<br/>state". $state; //state
		echo "<br/>country". $country; // Country
		echo "<br/>zip". $zip; // Zip Code	
		echo "<br/>st date". $stdate; //Start Date
		echo "<br/>en date". $endate; //End Date
		echo "<br/>st time". $sttime; //Start Time
		echo "<br/>en time". $entime; //End Time
		echo "<br/>week". print_r($dayofweek);
		echo "<br/>cat". print_r($catint);
		echo "<br/>mmID" . $memid;
		echo "<br/>emial". $_SESSION['EMail'];
	
*/
	$dayofweek = join(', ', $dayofweek); // converting array to comma separated string

	if(empty($error_array)) {


	
		$query = mysqli_query($conn, "insert into Event(OrganizerId,Title,Description,Days,StartDate,EndDate,StartTime,EndTime,Street,City,Zip,State,Country,Image) values ('$memid','$ename','$desc','$dayofweek','$stdate','$endate','$sttime','$entime','$address','$city','$zip','$state','$country','$tmp_file')");		
		array_push($error_array, "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>");	
		
		header("Location: event.php?eventid=" . mysqli_insert_id($conn));

	}

	

}
?>