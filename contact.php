<?php
// PHP Script for Contact Form Submission

// Define the recipient email address (Client's Email)
$receiving_email_address = 'yousafyaseen957@gmail.com'; 

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Sanitize and Validate Inputs
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST["subject"]), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    // Basic validation
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        echo "Error: Please complete the form and provide a valid email address.";
        exit;
    }

    // 2. Construct the Email Content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // 3. Set Email Headers
    $email_headers = "From: " . $name . " <" . $email . ">\r\n";
    $email_headers .= "Reply-To: " . $email . "\r\n";
    $email_headers .= "MIME-Version: 1.0\r\n";
    $email_headers .= "Content-type: text/plain; charset=utf-8\r\n";

    // 4. Send the Email
    // The mail() function is used to send the email.
    if (mail($receiving_email_address, $subject, $email_content, $email_headers)) {
        // Success
        http_response_code(200);
        echo "Thank you! Your message has been sent successfully.";
    } else {
        // Failure
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }

} else {
    // If accessed directly without POST method
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>