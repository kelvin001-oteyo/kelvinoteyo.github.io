<?php
header('Content-Type: text/plain');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Method not allowed');
}

// Required fields
$required = ['name', 'email', 'message'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        http_response_code(400);
        die("Error: $field is required");
    }
}

// Validate email
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    die('Error: Invalid email format');
}

// Sanitize data
$name = htmlspecialchars($_POST['name']);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars($_POST['message']);

// Email configuration
$to = 'oteyikelvin@gmail.com';
$subject = 'New Contact Form Submission';
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$messageBody = "Name: $name\nEmail: $email\n\nMessage:\n$message";

// Send email
if (mail($to, $subject, $messageBody, $headers)) {
    echo 'success: Message sent successfully!';
} else {
    http_response_code(500);
    echo 'error: Failed to send message';
}
