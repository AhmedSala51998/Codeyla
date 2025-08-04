<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'codeylacompany@gmail.com';
        $mail->Password   = 'glyy cilp yhsx xwuk';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom($_POST['email'], htmlspecialchars($_POST['name']));
        $mail->addAddress('codeylacompany@gmail.com');

        $mail->Subject = 'New Codeyla Message';

        $logoUrl = 'https://raw.githubusercontent.com/AhmedSala51998/Codeyla/master/assets/img/logo.png';
        
       $body = '
        <div style="
          font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif;
          background-color: #ffffff;
          color: #121212;
          padding: 40px 15px;
          min-height: 100vh;
        ">
          <div style="
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 2px solid #f4a835;
          ">
            
            <!-- Logo Section -->
            <div style="text-align: center; padding: 40px 25px 30px;">
              <img src="' . $logoUrl . '" alt="Codeyla Logo" style="width: 140px; margin-bottom: 25px;">
              <h1 style="margin: 0; font-weight: 900; font-size: 30px; color: #f4a835; letter-spacing: 1.5px;">
                رسالة جديدة من ' . htmlspecialchars($_POST['name']) . '
              </h1>
            </div>

            <!-- Content Section -->
            <div style="padding: 30px 40px; font-size: 17px; line-height: 1.7; color: #121212;">

              <p style="direction: rtl; text-align: right; font-weight: 700; font-size: 19px; margin-bottom: 15px; color: #f4a835;">
                الاسم: <span style="font-weight: 600; color: #121212;">' . htmlspecialchars($_POST['name']) . '</span>
              </p>

              <p style="direction: rtl; text-align: right; font-weight: 700; font-size: 18px; margin-bottom: 15px; color: #f4a835;">
                البريد الالكتروني: <span style="font-weight: 600; color: #121212;">' . $_POST['email'] . '</span>
              </p>

              <p style="direction: rtl; text-align: right; font-weight: 700; font-size: 18px; margin-bottom: 15px; color: #f4a835;">
                الموضوع: <span style="font-weight: 600; color: #121212;">' . htmlspecialchars($_POST['subject'] ?? '-') . '</span>
              </p>

              <p style="direction: rtl; text-align: right; font-weight: 700; font-size: 19px; margin-top: 30px; margin-bottom: 15px; color: #f4a835;">
                الرسالة:
              </p>

              <p style="
                background-color: #ffffff; 
                border-radius: 14px; 
                font-weight: 500; 
                padding:10px;
                direction: rtl; 
                text-align: right;
                border: 2px solid #f4a835;
                box-shadow: 0 4px 8px #fffff;
                color: #5a4630;
                font-size: 16px;
              ">
                ' . nl2br(htmlspecialchars($_POST['message'])) . '
              </p>
            </div>

            <!-- Footer Section -->
            <div style="
              text-align: center; 
              background-color: #f4a835; 
              color: #FFF; 
              padding: 18px 0; 
              font-weight: 800;
              font-size: 15px;
              letter-spacing: 2px;
              border-top: 2px solid #e6a635;
            ">
              © ' . date('Y') . ' Codeyla. جميع الحقوق محفوظة
            </div>

          </div>
        </div>
      ';


        $mail->isHTML(true);
        $mail->Body = $body;

        $mail->send();

        echo json_encode([
          'status' => 'success',
          'message' => '✅ تم إرسال الرسالة بنجاح'
        ]);
    } catch (Exception $e) {
        echo json_encode([
          'status' => 'error',
          'message' => '❌ فشل في الإرسال: ' . $mail->ErrorInfo
        ]);
    }

} else {
    echo json_encode([
      'status' => 'error',
      'message' => '❌ طريقة الإرسال غير صحيحة.'
    ]);
}
