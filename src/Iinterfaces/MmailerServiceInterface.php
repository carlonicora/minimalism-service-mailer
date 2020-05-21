<?php
namespace carlonicora\minimalism\services\mailer\Iinterfaces;

use carlonicora\minimalism\core\services\factories\servicesFactory;
use carlonicora\minimalism\services\mailer\Cconfigurations\mmailerConfigurations;
use carlonicora\minimalism\services\mailer\Oobjects\eemail;

interface mmailerServiceInterface {
    /**
     * mailerServiceInterface constructor.
     * @param mmailerConfigurations $configurations
     * @param servicesFactory $services
     */
    public function __construct(mmailerConfigurations $configurations, servicesFactory $services);

    /**
     * @param string $senderEmail
     * @param string $senderName
     */
    public function setSender(string $senderEmail, string $senderName):void;

    /**
     * @param eemail $email
     * @return bool
     */
    public function send(eemail $email):bool;
}