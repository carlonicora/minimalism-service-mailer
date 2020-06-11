<?php
namespace CarloNicora\Minimalism\Services\Mailer\Configurations;

use CarloNicora\Minimalism\Core\Services\Abstracts\AbstractServiceConfigurations;
use CarloNicora\Minimalism\Core\Services\Exceptions\ConfigurationException;

class MailerConfigurations extends AbstractServiceConfigurations
{
    /** @var string|null  */
    public ?string $username=null;

    /** @var string|null  */
    public ?string $password=null;

    /** @var string  */
    public string $mailerClass;

    /** @var string  */
    public ?string $senderEmail=null;

    /** @var string|null  */
    public ?string $senderName=null;

    /**
     * MAILERConfigurations constructor.
     * @throws ConfigurationException
     */
    public function __construct()
    {
        $this->mailerClass = '\\CarloNicora\\Minimalism\\Services\\Mailer\\Modules\\' .
            (getenv('MINIMALISM_SERVICE_MAILER_TYPE') ?: 'mandrillapp') .
            'MailerService';

        if (!class_exists($this->mailerClass)){
            throw new ConfigurationException('mailer', 'The selected mailer service does not exists!');
        }

        if (!($this->password = getenv('MINIMALISM_SERVICE_MAILER_PASSWORD'))) {
            throw new ConfigurationException('mailer', 'MINIMALISM_SERVICE_MAILER_PASSWORD is a required configuration');
        }

        $this->username = getenv('MINIMALISM_SERVICE_MAILER_USERNAME');
        $this->senderEmail = getenv('MINIMALISM_SERVICE_MAILER_SENDER_EMAIL');
        $this->senderName = getenv('MINIMALISM_SERVICE_MAILER_SENDER_NAME');
    }

    /**
     * @return string
     */
    public function getMailerClass() : string
    {
        return $this->mailerClass;
    }
}