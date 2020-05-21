<?php
namespace CarloNicora\Minimalism\Services\Mailer\Modules;

use CarloNicora\Minimalism\Services\Mailer\Abstracts\AbstractMailerService;
use CarloNicora\Minimalism\Services\Mailer\Objects\Email;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use RuntimeException;

class MandrillappMailerService extends AbstractMailerService {
    /** @var string  */
    private string $host = 'smtp.mandrillapp.com';

    /** @var int  */
    private int $port = 587;

    /**
     * @inheritDoc
     */
    public function send(Email $email): bool
    {
        $mail = new PHPMailer();

        $mail->IsSMTP();

        $mail->Host = $this->host;
        $mail->Port = $this->port;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        $mail->Username = $this->configData->username;
        $mail->Password = $this->configData->password;

        $mail->From = $this->configData->senderEmail;
        $mail->FromName = $this->configData->senderName;

        $mail->IsHTML(true);
        $mail->Subject = $email->subject;
        $mail->Body    = $email->body;

        foreach ($email->recipients as $recipient) {
            try {
                $mail->AddAddress($recipient['email'], $recipient['name']);
            } catch (Exception $e) {
                throw new RuntimeException('Invalid email');
            }
        }

        try {
            if (!$mail->Send()) {
                throw new RuntimeException('Email cannot be sent: ' . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            throw new RuntimeException('Email cannot be sent: ' . $mail->ErrorInfo);
        }

        return true;
    }
}