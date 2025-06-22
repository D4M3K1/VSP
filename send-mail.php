<?php
// Set your Gmail address here
$to = "ryojiithangkhiew@gmail.com";
$subject = "New VSF Application";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Read JSON from the POST body
$input = json_decode(file_get_contents("php://input"), true);
if (!$input) {
  http_response_code(400);
  echo json_encode(["error" => "Invalid input"]);
  exit;
}

$message = "New Application Received:\n\n";
foreach ($input as $key => $value) {
  $message .= ucfirst($key) . ": " . htmlspecialchars($value) . "\n";
}

$headers = "From: vsf-form@crook.com\r\n" .
           "Reply-To: " . $input["email"] . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

$mailSuccess = mail($to, $subject, $message, $headers);

if ($mailSuccess) {
  echo json_encode(["status" => "ok"]);
} else {
  http_response_code(500);
  echo json_encode(["error" => "Failed to send"]);
}
?>
