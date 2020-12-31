<?php
namespace CarloNicora\Minimalism\Services\Mailer\Modules;

use CarloNicora\Minimalism\Services\Mailer\Abstracts\AbstractMailerService;
use CarloNicora\Minimalism\Services\Mailer\Objects\Email;
use Exception;
use PHPMailer\PHPMailer\Exception as MailerException;
use PHPMailer\PHPMailer\PHPMailer;
use RuntimeException;

class MandrillappMailerService extends AbstractMailerService
{
    /** @var string */
    private string $host = 'smtp.mandrillapp.com';

    /** @var int */
    private int $port = 587;

    /**
     * @param Email $email
     * @return bool
     * @throws Exception
     */
    public function send(Email $email): bool
    {
        $mail = new PHPMailer();

        $mail->IsSMTP();

        $mail->Host = $this->host;
        $mail->Port = $this->port;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        $mail->Username = $this->username;
        $mail->Password = $this->password;

        $mail->From = $this->senderEmail;
        $mail->FromName = $this->senderName;

        $mail->IsHTML(true);
        $mail->Subject = $email->subject;
        $mail->Body    = $email->body;

        foreach ($email->recipients as $recipient) {
            try {
                $mail->AddAddress($recipient['email'], $recipient['name']);
            } catch (MailerException) {
                throw new RuntimeException('Invalid sender email', 500);
            }
        }

        try {
            if (!$mail->Send()) {
                throw new RuntimeException($mail->ErrorInfo, 500);
            }
        } catch (MailerException) {
            throw new RuntimeException('Error sending the email', 500);
        }

        return true;
    }
}