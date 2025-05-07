<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Replace with your SMTP server (Gmail, Outlook, etc.)
        $mail->SMTPAuth   = true;
        $mail->Username   = 'fundyfilms@gmail.com'; // Replace with your email
        $mail->Password   = 'awhv bdqx jtvq nyuj'; // Replace with your email password or App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS or SSL
        $mail->Port       = 587; // 465 for SSL, 587 for TLS

        // Email Details
        $mail->setFrom('fundyfilms@gmail.com', 'Website Notification');
        $mail->addAddress('fundyfilms@gmail.com'); // Change to your recipient email
        $mail->Subject = "User Location Notification";
        $mail->Body    = "User's Latitude: $latitude\nUser's Longitude: $longitude";

        // Send Email
        $mail->send();
        echo json_encode(["status" => "success", "message" => "Email sent successfully."]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Email failed: {$mail->ErrorInfo}"]);
    }
}
?>

