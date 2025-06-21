<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "ryojiithangkhiew@email.com";  // ← Replace with your actual email address
    $subject = "New VSF Application";

    $name = htmlspecialchars(string: $_POST["fullName"]);
    $email = htmlspecialchars(string: $_POST["email"]);
    $age = htmlspecialchars(string: $_POST["age"]);
    $experience = htmlspecialchars(string: $_POST["experience"]);
    $motivation = htmlspecialchars(string: $_POST["motivation"]);

    $message = "
    New application received:\n
    Name: $name\n
    Email: $email\n
    Age: $age\n
    Experience: $experience years\n
    Motivation:\n$motivation
    ";

    $headers = "ryojiithangkhiew@email.com\r\n";  // ← Optional: change domain
    $headers .= "Reply-To: $email\r\n";

    if (mail(to: $to, subject: $subject, message: $message, additional_headers: $headers)) {
        http_response_code(response_code: 200);
        echo "Success";
    } else {
        http_response_code(response_code: 500);
        echo "Failed to send email";
    }
} else {
    http_response_code(response_code: 403);
    echo "Invalid request";
}
