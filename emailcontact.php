<?php
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];

$mail_to = "vipmunot@gmail.com";
$subject = $name . " from Eventpal website Reaching Out";
$email_msg = $name . " is reaching out on behalf of eventpal. The person is email is:" . $visitor_email . " The person has send following message for you:\n" . $message;
mail($mail_to,$subject,$email_msg);
$a =  "Mail Sent. Thank you " . $name . ", we will contact you shortly.";
echo "<script type='text/javascript'>alert('$a');</script>";
header("Location: register.php");

?>