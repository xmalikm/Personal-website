<?php

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__.'/../../config/');
$dotenv->safeLoad();

if (isset($_POST['name'], $_POST['email'], $_POST['message'])) {
	$mail = new PHPMailer(true);
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->Host = $_ENV['MAIL_HOST'];
	$mail->Username = $_ENV['MAIL_USERNAME'];
	$mail->Password = $_ENV['MAIL_PASSWORD'];
	$mail->addAddress('xmalikm3@gmail.com');
	$mail->setFrom('info@malikmartin.sk', 'Martin Malik');
	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Subject = 'Form Response from Your Website' . ' [' . $_POST['name'] . ']';
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
		echo json_encode(array('response' => 'success', 'Message' => '<div class="alert alert-success alert-dismissible fade show text-start"><i class="fa fa-check-circle"></i> Thank you for contacting me. I will respond as soon as possible. <button type="button" class="btn-close text-1 mt-1" data-bs-dismiss="alert"></button></div>'));
		exit;
	} catch (\Exception $e) {
		echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-start"><i class="fa fa-exclamation-triangle me-1"></i> Message could not be sent: ' . $e->getMessage() . '<button type="button" class="btn-close text-1 mt-1" data-bs-dismiss="alert"></button></div>'));
		exit;
	}
} else {
    echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-start"><i class="fa fa-exclamation-triangle me-1"></i> Username, e-mail and message are required! <button type="button" class="btn-close text-1 mt-1" data-bs-dismiss="alert"></button></div>'));
    exit;
}
?>