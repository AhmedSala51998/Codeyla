<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // هنا تجيب اللغة من الفورم
    $lang = $_POST['lang'] ?? 'ar';

    // الرسائل حسب اللغة
    $messages = [
      'ar' => [
        'success' => '✅ تم إرسال الرسالة بنجاح',
        'fail'    => '❌ فشل في الإرسال: ',
        'method'  => '❌ طريقة الإرسال غير صحيحة.'
      ],
      'en' => [
        'success' => '✅ Message sent successfully',
        'fail'    => '❌ Failed to send: ',
        'method'  => '❌ Invalid request method.'
      ]
    ];

    $msg = $messages[$lang] ?? $messages['ar'];

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

        $mail->Subject = 'New Sweepicode Message';

        $logoUrl = 'https://codeyla.com/assets/img/logo_email.png';
  
       $body = '
        <div style="background-color: #f4f4f7; padding: 40px 0; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; direction: rtl; text-align: right;">
          <table align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 600px; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.07);">
        
            <!-- Header -->
            <tr>
              <td style="padding: 40px 40px 10px; text-align: center;">
                <a href="https://codeyla.com/" target="_blank" style="text-decoration: none;">
                  <img src="' . $logoUrl . '" alt="Sweepicode Logo" style="width: 240px; margin-bottom: 20px;">
                </a>
                <h1 style="margin: 0; font-size: 22px; font-weight: 700; color: #333333;">رسالة جديدة من عميل عبر الموقع</h1>
              </td>
            </tr>
        
            <!-- Greeting -->
            <tr>
              <td style="padding: 10px 40px 0;">
               <p style="font-size: 16px; color: #444;">مرحبًا فريق Sweepicode،</p>
              </td>
            </tr>
        
            <!-- Body Content -->
            <tr>
              <td style="padding: 10px 40px 0;">
                <p style="font-size: 16px; color: #444; line-height: 1.7;">
                  تلقينا رسالة جديدة من أحد العملاء عبر نموذج التواصل على موقعكم بتاريخ <strong>' . date("Y-m-d") . '</strong>. التفاصيل كما يلي:
                </p>
        
                <p style="font-size: 16px; color: #444; line-height: 1.7; margin-top: 20px;">
                  <strong>الاسم:</strong> ' . htmlspecialchars($_POST['name']) . '<br>
                  <strong>البريد الإلكتروني:</strong> 
                  <a href="mailto:' . htmlspecialchars($_POST['email']) . '" style="color: #f4a835; font-weight: bold;" target="_blank">' . htmlspecialchars($_POST['email']) . '</a><br>
                  <strong>الموضوع:</strong> ' . htmlspecialchars($_POST['subject']) . '<br>
                  <strong>رقم الهاتف:</strong> ' . htmlspecialchars($_POST['phone']) . '<br>
                </p>
        
                <p style="font-size: 16px; color: #444; line-height: 1.7; margin-top: 10px;">
                  <strong>نص الرسالة:</strong><br>
                  <span style="white-space: pre-line;">' . nl2br(htmlspecialchars($_POST['message'])) . '</span>
                </p>
        
                <p style="font-size: 16px; color: #444; line-height: 1.7; margin-top: 20px;">
                  يُرجى مراجعة الرسالة والتواصل مع العميل لمناقشة التفاصيل وتقديم العرض المناسب.
                </p>
        
                <p style="font-size: 16px; color: #444; line-height: 1.7;">
                  شكرًا لكم.
                </p>
              </td>
            </tr>
        
            <!-- Footer -->
            <tr>
              <td style="padding: 30px 40px; text-align: center;">
                <p style="font-size: 15px; color: #999; line-height: 1.6;">
                  تم إرسال هذه الرسالة عبر نموذج "تواصل معنا" على موقع Sweepicode. نلتزم بسياسات الخصوصية وشروط الاستخدام.
                </p>
                <p style="font-size: 14px; color: #aaa;">
                  <a href="https://codeyla.com/privacy" style="color: #aaa; text-decoration: underline;" target="_blank">سياسة الخصوصية</a>
                </p>
                <p style="font-size: 13px; color: #aaa; margin-top: 15px;">
                  © ' . date('Y') . ' Sweepicode. جميع الحقوق محفوظة.
                </p>
              </td>
            </tr>
        
          </table>
        </div>
        ';


        $mail->isHTML(true);
        $mail->Body = $body;

        $mail->send();

        echo json_encode([
          'status' => 'success',
          'message' => $msg['success']
        ]);
        
    } catch (Exception $e) {
        // ❌ خطأ
        echo json_encode([
          'status' => 'error',
          'message' => $msg['fail'] . $mail->ErrorInfo
        ]);
    }

} else {
    echo json_encode([
      'status' => 'error',
      'message' => $msg['method'] ?? '❌ طريقة الإرسال غير صحيحة.'
    ]);
}
