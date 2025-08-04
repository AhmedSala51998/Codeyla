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

        $mail->setFrom($_POST['email'], $_POST['name']);
        $mail->addAddress('codeylacompany@gmail.com');

        $mail->Subject = $_POST['subject'] ?? 'رسالة جديدة من الموقع';

        $body = "الاسم: " . htmlspecialchars($_POST['name']) . "<br>";
        $body .= "البريد الإلكتروني: " . htmlspecialchars($_POST['email']) . "<br>";
        $body .= "الهاتف: " . htmlspecialchars($_POST['phone'] ?? '-') . "<br>";
        $body .= "الرسالة:<br>" . nl2br(htmlspecialchars($_POST['message'])) . "<br>";

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
