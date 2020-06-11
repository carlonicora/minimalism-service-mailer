<?php
namespace CarloNicora\Minimalism\Services\Mailer\Modules;

use CarloNicora\Minimalism\Services\Mailer\Abstracts\AbstractMailerService;
use CarloNicora\Minimalism\Services\Mailer\Events\ErrorManager;
use CarloNicora\Minimalism\Services\Mailer\Objects\Email;
use Exception;
use PHPMailer\PHPMailer\Exception as MailerException;
use PHPMailer\PHPMailer\PHPMailer;
use RuntimeException;

class MandrillappMailerService extends AbstractMailerService
{
    /** @var string  */
    private string $host = 'smtp.mandrillapp.com';

    /** @var int  */
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
            } catch (MailerException $e) {
                $this->services->logger()->error()->log(ErrorManager::INVALID_EMAIL($e))
                    ->throw(RuntimeException::class);
            }
        }

        try {
            if (!$mail->Send()) {
                $this->services->logger()->error()->log(ErrorManager::EMAIL_NOT_SENT($mail->ErrorInfo))
                    ->throw(RuntimeException::class);
            }
        } catch (MailerException $e) {
            $this->services->logger()->error()->log(ErrorManager::FAILED_TO_SEND_EMAIL($e))
                ->throw(RuntimeException::class);
        }

        return true;
    }
}