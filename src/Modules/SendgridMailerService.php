<?php
namespace CarloNicora\Minimalism\Services\Mailer\Modules;

use CarloNicora\Minimalism\Services\Mailer\Abstracts\AbstractMailerService;
use CarloNicora\Minimalism\Services\Mailer\Objects\Email;
use Exception;
use RuntimeException;
use SendGrid;
use SendGrid\Mail\Mail;
use SendGrid\Mail\TypeException;

class SendgridMailerService extends AbstractMailerService
{
    /**
     * @param Email $email
     * @return bool
     * @throws Exception
     */
    public function send(Email $email): bool
    {
        $sendGridEmail = new Mail();

        try {
            $sendGridEmail->setFrom($this->senderEmail, $this->senderName);
        } catch (TypeException) {
            throw new RuntimeException('Email failed to be sent from the sender', 500);
        }

        foreach ($email->recipients as $recipient) {
            $sendGridEmail->addTo($recipient['email'], $recipient['name']);
        }

        try {
            $sendGridEmail->setSubject($email->subject);
        } catch (TypeException) {
            throw new RuntimeException('Email failed to be sent to recipient', 500);
        }

        $sendGridEmail->addContent($email->contentType, $email->body);

        $sendgrid = new SendGrid($this->password);
        $sendgrid->send($sendGridEmail);

        return true;
    }
}