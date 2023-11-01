<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="captcha-google.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
  <body>
      <div class="contact-form">
          <h2>CONTACT FORM</h2>
          <form method="post" action="">
              <input type="text" name="name" placeholder="Your Name" required>
              <input type="text" name="phone" placeholder="Phone No" required>
              <input type="email" name = "email" placeholder="Your Email" required>
              <textarea name="message" placeholder="Your Message" required></textarea>
              <div class="g-recaptcha" data-sitekey="6Lfxo40oAAAAAKcQJ8uAdjmih5HWEqlIvWSU21m_"></div>
              <input type="submit" name="submit" value="Send Message" class="submit-btn">
          </form>
          <div class="status">
              <?php
              if(isset($_POST['submit'])) 
              {
                $User_name = $_POST['name'];
                $phone = $_POST['phone'];
                $user_mail = $_POST['email'];
                $user_message = $_POST['message'];

                $email_from = 'info@whiteboardconsultant.com';
                $email_subject = "New Form Submission";
                $email_body = 
                    "Name: $User_name.\n".
                    "Phone No.: $phone.\n".
                    "Email Id: $user_mail.\n".
                    "User Message: $user_message.\n";
                $to_email = "info@whiteboardconsultant.com";
                $headers = "From: $email_from \r\n";
                $headers .= "Reply-To: $user_mail\r\n";
                
                $secretKey = "6Lfxo40oAAAAAAtA47LNgPq_Zpa2Oh8h6PSogN0N";
                $responseKey = $_POST['g-recaptcha-response'];
                $UserIP = $_SERVER['REMOTE_ADDR'];

                $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$UserIP";
                  
                  $response = file_get_contents($url);
                  $response = json_decode($response);

                  if ($response->success)
                  {
                      mail($to_email,$email_subject,$email_body,$headers);
                      echo "Message Sent Successfully";
                  }
                  else
                  {
                      echo "<span>Invalid Captcha, Please try again</span>";
                  }
                
              }   
              ?>
          </div>
      </div>      
</body>
</html>
