<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];
    $recaptcha = $_POST["g-recaptcha-response"];

    // Verify reCAPTCHA
    $recaptchaSecret = "6Lfxo40oAAAAAAtA47LNgPq_Zpa2Oh8h6PSogN0N";
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => $recaptchaSecret,
        'response' => $recaptcha,
    ];

    $options = [
        'http' => [
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $recaptchaResult = json_decode($response);

    if ($recaptchaResult->success) {
        // reCAPTCHA validation passed, send the email
        $to = "info@whiteboardconsultant.com"; // Replace with the recipient's email address
        $subject = "Contact Form Submission from $name";
        $headers = "From: $email";

        $messageBody = "Name: $name\n";
        $messageBody .= "Email: $email\n";
        $messageBody .= "Phone: $phone\n";
        $messageBody .= "Message:\n$message\n";

        mail($to, $subject, $messageBody, $headers);

        echo "Email sent successfully!";
        // Redirect to home page
        header("Location: /index.html"); // Change "/home" to the actual path of your home page
        exit();
    } else {
        echo "reCAPTCHA verification failed.";
    }
} else {
    echo "Invalid request.";
}
?>
