<?php
// send-mail.php

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only POST requests allowed']);
    exit;
}

// Read raw POST body and decode JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

// Validate expected fields
$requiredFields = ['fullName', 'email', 'age', 'experience', 'motivation'];

foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Missing field: $field"]);
        exit;
    }
}

// Sanitize inputs
$fullName = filter_var($data['fullName'], FILTER_SANITIZE_STRING);
$email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
$age = intval($data['age']);
$experience = intval($data['experience']);
$motivation = filter_var($data['motivation'], FILTER_SANITIZE_STRING);

if (!$email) {
    http_response_code(400);
    echo json_encode(['error' => "Invalid email address"]);
    exit;
}

// Prepare email
$to = "ryojiithangkhiew@gmail.com"; // <-- Replace with your email
$subject = "New VSF Application from $fullName";

$message = "
New VSF Application Received:

Full Name: $fullName
Email: $email
Age: $age
Experience in combat (years): $experience

Motivation:
$motivation
";

// Headers
$headers = "From: no-reply@vsf.wuaze.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
if (mail($to, $subject, $message, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Application sent']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to send email']);
}
?>
