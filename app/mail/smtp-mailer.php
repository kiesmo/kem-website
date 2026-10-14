<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

function kem_send_smtp_mail(array $smtp, array $message): void
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $smtp['host'];
        $mail->Port = $smtp['port'];
        $mail->SMTPAuth = true;
        $mail->Username = $smtp['username'];
        $mail->Password = $smtp['password'];
        $mail->SMTPSecure = $smtp['encryption'] === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAutoTLS = true;
        $mail->Timeout = $smtp['timeout'];
        $mail->SMTPDebug = 0;
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $mail->Encoding = PHPMailer::ENCODING_QUOTED_PRINTABLE;
        $mail->XMailer = null;
        $mail->setFrom($message['from_email'], $message['from_name'], false);
        $mail->Sender = $message['from_email'];
        $mail->addAddress($message['recipient']);
        $mail->addReplyTo($message['reply_to'], $message['reply_name']);
        foreach ($message['attachments'] as $attachment) {
            $mail->addAttachment($attachment['path'], $attachment['name'], PHPMailer::ENCODING_BASE64, $attachment['mime']);
        }
        $mail->isHTML(false);
        $mail->Subject = $message['subject'];
        $mail->Body = $message['body'];
        $mail->send();
    } catch (PHPMailerException $e) {
        $detail = $mail->ErrorInfo !== '' ? $mail->ErrorInfo : $e->getMessage();
        throw new RuntimeException($detail, 0, $e);
    }
}
