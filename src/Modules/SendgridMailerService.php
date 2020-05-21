<?php
namespace CarloNicora\Minimalism\Services\Mailer\Modules;

use CarloNicora\Minimalism\Services\Mailer\Abstracts\AbstractMailerService;
use CarloNicora\Minimalism\Services\Mailer\Objects\Email;
use Exception;
use RuntimeException;
use SendGrid;
use SendGrid\Mail\Mail;

class SendgridMailerService extends AbstractMailerService {
    /**
     * @param Email $email
     * @return bool
     * @throws Exception
     */
    public function send(Email $email): bool
    {
        $sendGridEmail = new Mail();

        try {
            $sendGridEmail->setFrom($this->configData->senderEmail, $this->configData->senderName);
        } catch (SendGrid\Mail\TypeException $e) {
            throw new RuntimeException($e->getMessage());
        }

        foreach ($email->recipients as $recipient) {
            $sendGridEmail->addTo($recipient['email'], $recipient['name']);
        }

        try {
            $sendGridEmail->setSubject($email->subject);
        } catch (SendGrid\Mail\TypeException $e) {
            throw new RuntimeException($e->getMessage());
        }

        $sendGridEmail->addContent($email->contentType, $email->body);

        $sendgrid = new SendGrid($this->configData->password);
        $sendgrid->send($sendGridEmail);

        return true;
    }
}