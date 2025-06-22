<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$data = json_decode(file_get_contents("php://input"));

$to = "ryojiithangkhiew@gmail.com";
$subject = "New VSF Application";
$message = "New Application Submission:\n\n";
$message .= "Full Name: " . $data->fullName . "\n";
$message .= "Email: " . $data->email . "\n";
$message .= "Age: " . $data->age . "\n";
$message .= "Experience: " . $data->experience . " years\n";
$message .= "Motivation:\n" . $data->motivation . "\n";

$headers = "From: " . $data->email;

if (mail($to, $subject, $message, $headers)) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false]);
}
?>
