<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // استلم المتغيرات مع تعقيم بسيط
    $firstName = htmlspecialchars(trim($_POST['firstName'] ?? ''));
    $lastName = htmlspecialchars(trim($_POST['lastName'] ?? ''));
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $course = htmlspecialchars(trim($_POST['course'] ?? ''));
    $education = htmlspecialchars(trim($_POST['education'] ?? ''));
    $experience = htmlspecialchars(trim($_POST['experience'] ?? ''));
    $motivation = htmlspecialchars(trim($_POST['motivation'] ?? ''));
    $schedule = htmlspecialchars(trim($_POST['schedule'] ?? ''));

    if (!$firstName || !$lastName || !$email || !$course) {
        echo json_encode(['status' => 'error', 'message' => 'يرجى ملء الحقول المطلوبة.']);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'codeylacompany@gmail.com';  // غيره للإيميل الخاص بك
        $mail->Password   = 'glyy cilp yhsx xwuk';       // كلمة مرور التطبيق
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom($email, "$firstName $lastName");
        $mail->addAddress('codeylacompany@gmail.com');  // وجهة الإيميل

        $mail->Subject = 'تسجيل جديد في دورة تدريبية';

        $logoUrl = 'https://codeyla.com/assets/img/logo_email.png'; // عدل الرابط حسب شعارك الحقيقي

        $body = '
        <div style="background-color: #f4f4f7; padding: 40px 0; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; direction: rtl; text-align: right;">
        <table align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 600px; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.07);">

            <!-- Header -->
            <tr>
            <td style="padding: 40px 40px 10px; text-align: center;">
                <a href="https://codeyla.com/" target="_blank" style="text-decoration: none;">
                <img src="' . $logoUrl . '" alt="Codeyla Logo" style="width: 240px; margin-bottom: 20px;">
                </a>
                <h1 style="margin: 0; font-size: 22px; font-weight: 700; color: #333333;">تسجيل جديد في دورة تدريبية</h1>
            </td>
            </tr>

            <!-- Greeting -->
            <tr>
            <td style="padding: 10px 40px 0;">
            <p style="font-size: 16px; color: #444;">مرحبًا فريق Codeyla،</p>
            </td>
            </tr>

            <!-- Body Content -->
            <tr>
            <td style="padding: 10px 40px 0;">
                <p style="font-size: 16px; color: #444; line-height: 1.7;">
                تلقينا تسجيلًا جديدًا في الدورة بتاريخ <strong>' . date("Y-m-d") . '</strong>. التفاصيل كما يلي:
                </p>

                <p style="font-size: 16px; color: #444; line-height: 1.7; margin-top: 20px;">
                <strong>الاسم:</strong> ' . htmlspecialchars($firstName) . ' ' . htmlspecialchars($lastName) . '<br>
                <strong>البريد الإلكتروني:</strong> 
                <a href="mailto:' . htmlspecialchars($email) . '" style="color: #f4a835; font-weight: bold;" target="_blank">' . htmlspecialchars($email) . '</a><br>
                <strong>رقم الهاتف:</strong> ' . htmlspecialchars($phone) . '<br>
                <strong>الدورة المختارة:</strong> ' . htmlspecialchars($course) . '<br>
                <strong>المستوى التعليمي:</strong> ' . htmlspecialchars($education) . '<br>
                <strong>مستوى الخبرة:</strong> ' . htmlspecialchars($experience) . '<br>
                <strong>الدافع للتسجيل:</strong><br>
                <span style="white-space: pre-line;">' . nl2br(htmlspecialchars($motivation)) . '</span><br>
                <strong>جدول التعلم المفضل:</strong> ' . htmlspecialchars($schedule) . '
                </p>

                <p style="font-size: 16px; color: #444; line-height: 1.7; margin-top: 20px;">
                يُرجى مراجعة التسجيل والتواصل مع الطالب لمتابعة الإجراءات.
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
                تم إرسال هذه الرسالة عبر نموذج التسجيل في موقع Codeyla. نلتزم بسياسات الخصوصية وشروط الاستخدام.
                </p>
                <p style="font-size: 14px; color: #aaa;">
                <a href="https://codeyla.com/privacy" style="color: #aaa; text-decoration: underline;" target="_blank">سياسة الخصوصية</a>
                </p>
                <p style="font-size: 13px; color: #aaa; margin-top: 15px;">
                © ' . date('Y') . ' Codeyla. جميع الحقوق محفوظة.
                </p>
            </td>
            </tr>

        </table>
        </div>
        ';


        $mail->isHTML(true);
        $mail->Body = $body;

        $mail->send();

        echo json_encode(['status' => 'success', 'message' => 'تم إرسال بيانات التسجيل بنجاح']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء الإرسال: ' . $mail->ErrorInfo]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'طريقة الإرسال غير صحيحة']);
}
?>
