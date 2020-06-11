<?php
namespace CarloNicora\Minimalism\Services\Mailer\Modules;

use CarloNicora\Minimalism\Services\Mailer\Abstracts\AbstractMailerService;
use CarloNicora\Minimalism\Services\Mailer\Events\ErrorManager;
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
            $sendGridEmail->setFrom($this->configData->senderEmail, $this->configData->senderName);
        } catch (TypeException $e) {
            $this->services->logger()->error()->log(ErrorManager::SENDGRID_FAILED_TO_SET_FROM($e))
                ->throw(RuntimeException::class);
        }

        foreach ($email->recipients as $recipient) {
            $sendGridEmail->addTo($recipient['email'], $recipient['name']);
        }

        try {
            $sendGridEmail->setSubject($email->subject);
        } catch (TypeException $e) {
            $this->services->logger()->error()->log(ErrorManager::SENDGRID_FAILED_TO_SET_SUBJECT($e))
                ->throw(RuntimeException::class);
        }

        $sendGridEmail->addContent($email->contentType, $email->body);

        $sendgrid = new SendGrid($this->configData->password);
        $sendgrid->send($sendGridEmail);

        return true;
    }
}