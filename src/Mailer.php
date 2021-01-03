<?php
namespace CarloNicora\Minimalism\Services\Mailer;

use CarloNicora\Minimalism\Interfaces\ServiceInterface;
use CarloNicora\Minimalism\Services\Mailer\Abstracts\AbstractMailerService;
use CarloNicora\Minimalism\Services\Mailer\Interfaces\MailerServiceInterface;
use CarloNicora\Minimalism\Services\Mailer\Objects\Email;
use RuntimeException;

class Mailer implements ServiceInterface, MailerServiceInterface
{
    /**
     * @var MailerServiceInterface|AbstractMailerService
     */
    private MailerServiceInterface|AbstractMailerService $mailer;

    /**
     * Mailer constructor.
     * @param string $MINIMALISM_SERVICE_MAILER_TYPE
     * @param string $MINIMALISM_SERVICE_MAILER_PASSWORD
     * @param string|null $MINIMALISM_SERVICE_MAILER_USERNAME
     * @param string|null $MINIMALISM_SERVICE_MAILER_SENDER_EMAIL
     * @param string|null $MINIMALISM_SERVICE_MAILER_SENDER_NAME
     */
    public function __construct(
        string $MINIMALISM_SERVICE_MAILER_TYPE,
        string $MINIMALISM_SERVICE_MAILER_PASSWORD,
        ?string $MINIMALISM_SERVICE_MAILER_USERNAME=null,
        ?string $MINIMALISM_SERVICE_MAILER_SENDER_EMAIL=null,
        ?string $MINIMALISM_SERVICE_MAILER_SENDER_NAME=null,
    )
    {
        $mailerClass = '\\CarloNicora\\Minimalism\\Services\\Mailer\\Modules\\'
            . $MINIMALISM_SERVICE_MAILER_TYPE . 'MailerService';

        if (!class_exists($mailerClass)){
            throw new RuntimeException('Configured mailer type not supported', 500);
        }

        $this->mailer = new $mailerClass(
            $MINIMALISM_SERVICE_MAILER_USERNAME,
            $MINIMALISM_SERVICE_MAILER_PASSWORD,
        );

        $this->setSender(
            senderEmail: $MINIMALISM_SERVICE_MAILER_SENDER_EMAIL ?? '',
            senderName: $MINIMALISM_SERVICE_MAILER_SENDER_NAME ?? '',
        );
    }

    /**
     *
     */
    public function initialise(): void {}

    /**
     *
     */
    public function destroy(): void {}

    /**
     * @param string $senderEmail
     * @param string $senderName
     */
    public function setSender(string $senderEmail, string $senderName): void
    {
        $this->mailer->setSender($senderEmail, $senderName);
    }

    /**
     * @param Email $email
     * @return bool
     */
    public function send(Email $email): bool
    {
        return $this->mailer->send($email);
    }
}