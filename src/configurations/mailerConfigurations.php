<?php
namespace carlonicora\minimalism\services\mailer\configurations;

use carlonicora\minimalism\core\services\abstracts\abstractServiceConfigurations;
use carlonicora\minimalism\core\services\exceptions\configurationException;

class mailerConfigurations extends abstractServiceConfigurations {
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
     * @throws configurationException
     */
    public function __construct() {
        $this->mailerClass = '\\carlonicora\\minimalism\\services\\mailer\\modules\\' .
            (getenv('MINIMALISM_SERVICE_MAILER_TYPE') ?: 'mandrillapp') .
            'MailerService';

        if (!class_exists($this->mailerClass)){
            throw new configurationException('mailer', 'The selected mailer service does not exists!');
        }

        if (!getenv('MINIMALISM_SERVICE_MAILER_PASSWORD')) {
            throw new configurationException('mailer', 'MINIMALISM_SERVICE_MAILER_PASSWORD is a required configuration');
        }

        $this->username = getenv('MINIMALISM_SERVICE_MAILER_USERNAME');
        $this->password = getenv('MINIMALISM_SERVICE_MAILER_PASSWORD');

        $this->senderEmail = getenv('MINIMALISM_SERVICE_MAILER_SENDER_EMAIL');
        $this->senderName = getenv('MINIMALISM_SERVICE_MAILER_SENDER_NAME');
    }

    /**
     * @return string
     */
    public function getMailerClass() : string {
        return $this->mailerClass;
    }
}