<?php
namespace CarloNicora\Minimalism\Services\Mailer\Interfaces;

use CarloNicora\Minimalism\core\Services\Factories\ServicesFactory;
use CarloNicora\Minimalism\Services\Mailer\Configurations\MailerConfigurations;
use CarloNicora\Minimalism\Services\Mailer\Objects\Email;

interface MailerServiceInterface
{
    /**
     * mailerServiceInterface constructor.
     * @param MailerConfigurations $configurations
     * @param ServicesFactory $services
     */
    public function __construct(MailerConfigurations $configurations, ServicesFactory $services);

    /**
     * @param string $senderEmail
     * @param string $senderName
     */
    public function setSender(string $senderEmail, string $senderName):void;

    /**
     * @param Email $email
     * @return bool
     */
    public function send(Email $email):bool;
}