<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and get form inputs
    $firstName = htmlspecialchars(trim($_POST["name_contact"] ?? ''));
    $lastName = htmlspecialchars(trim($_POST["lastname_contact"] ?? ''));
    $email = htmlspecialchars(trim($_POST["email_contact"] ?? ''));
    $phone = htmlspecialchars(trim($_POST["phone_contact"] ?? ''));
    $message = htmlspecialchars(trim($_POST["message_contact"] ?? ''));

    // Validate required fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($message)) {
        echo "Please fill all required fields.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Compose email
    $to = "jyotihospitalityminds@gmail.com";  // Change to your actual email address
    $subject = "New Contact Form Submission";
    $headers = "From: $firstName $lastName <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $body = "New message from contact form:\n\n";
    $body .= "Name: $firstName $lastName\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Message:\n$message\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo "Thank you! Your message has been sent.";
    } else {
        echo "Error sending message. Please try again later.";
    }
} else {
    echo "Invalid request method.";
}
?>
