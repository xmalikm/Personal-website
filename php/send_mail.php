<?php

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->safeLoad();

function sendResponse($response, $message) {
    echo json_encode([
        'response' => $response,
        'message' => '<div class="alert alert-' . ($response === 'error' ? 'danger' : 'success') . ' alert-dismissible fade show text-start"><i class="fa fa-exclamation-triangle me-1"></i> ' . $message . ' <button type="button" class="btn-close text-1 mt-1" data-bs-dismiss="alert"></button></div>'
    ]);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');
$recaptcha_token = $_POST['recaptcha_token'] ?? '';

// form fields validation rules
if (empty($name) || strlen($name) > 100 || !preg_match('/^[\p{L}\p{N} \-\'\.]{2,100}$/u', $name)) {
    sendResponse('error', 'Invalid name format!');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254) {
    sendResponse('error', 'Invalid email address!');
}
if (empty($message) || strlen($message) < 10 || strlen($message) > 2000) {
    sendResponse('error', 'Message must be between 10 and 2000 characters!');
}
if (empty($recaptcha_token)) {
    sendResponse('error', 'Missing reCAPTCHA token!');
}

// reCaptcha validation
$recaptcha_secret = $_ENV['RECAPTCHA_SECRET'];
$recaptcha_response = file_get_contents(
    "https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_token"
);
$recaptcha_data = json_decode($recaptcha_response, true);
if (!$recaptcha_data['success'] || $recaptcha_data['score'] < 0.5) {
    sendResponse('error', 'Failed reCAPTCHA validation!');
}

// send e-mail logic
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->addAddress('xmalikm3@gmail.com');
    $mail->setFrom($_ENV['SMTP_USERNAME'], 'malikmartin.sk');
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'New message' . ' [' . $_POST['name'] . ']';
    $mail->Body = '<table align="center" border="0" cellpadding="0" cellspacing="20" height="100%" width="100%">
                        <tr>
                            <td align="center" valign="top">
                                <table width="600" bgcolor="#f8f6fe" cellpadding="7" style="font-size:16px; padding:30px; line-height: 28px;">
                                    <tr>
                                        <td style="text-align:right; padding-right: 20px;" width="100" valign="top"><strong>Name:</strong></td>
                                        <td>' . $_POST['name'] . '</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right; padding-right: 20px;" width="100" valign="top"><strong>Email:</strong></td>
                                        <td>' . $_POST['email'] . '</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right; padding-right: 20px;" width="100" valign="top"><strong>Message:</strong></td>
                                        <td>' . $_POST['message'] . '</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>';

    try {
        $response = $mail->send();
        sendResponse('success', 'Thank you for contacting me. I will respond as soon as possible.');
    } catch (\Exception $e) {
        sendResponse('error', 'Message could not be sent: ' . $e->getMessage());
    }
} catch (\Exception $e) {
    sendResponse('error', $mail->ErrorInfo);
}
?>