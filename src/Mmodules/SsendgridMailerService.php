<?php
namespace carlonicora\minimalism\services\mailer\Mmodules;

use carlonicora\minimalism\services\mailer\Aabstracts\aabstractMmailerService;
use carlonicora\minimalism\services\mailer\Oobjects\eemail;
use Exception;
use RuntimeException;
use SendGrid;
use SendGrid\Mail\Mail;

class ssendgridMailerService extends aabstractMmailerService {
    /**
     * @param eemail $email
     * @return bool
     * @throws Exception
     */
    public function send(eemail $email): bool {
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