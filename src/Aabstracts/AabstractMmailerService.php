<?php
namespace carlonicora\minimalism\services\mailer\Aabstracts;

use carlonicora\minimalism\core\services\abstracts\abstractService;
use carlonicora\minimalism\core\services\factories\servicesFactory;
use carlonicora\minimalism\core\services\interfaces\serviceConfigurationsInterface;
use carlonicora\minimalism\services\mailer\Cconfigurations\mmailerConfigurations;
use carlonicora\minimalism\services\mailer\Iinterfaces\mmailerServiceInterface;
use carlonicora\minimalism\services\mailer\Oobjects\eemail;

abstract class aabstractMmailerService extends abstractService implements mmailerServiceInterface {
    /** @var mmailerConfigurations  */
    protected mmailerConfigurations $configData;

    /**
     * abstractMailerService constructor.
     * @param serviceConfigurationsInterface $configData
     * @param servicesFactory $services
     */
    public function __construct(serviceConfigurationsInterface $configData, servicesFactory $services){
        parent::__construct($configData, $services);

        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->configData = $configData;
    }

    /**
     * @param string $senderEmail
     * @param string $senderName
     */
    final public function setSender(string $senderEmail, string $senderName): void {
        $this->configData->senderEmail = $senderEmail;
        $this->configData->senderName = $senderName;
    }

    /**
     * @param eemail $email
     * @return bool
     */
    abstract public function send(eemail $email): bool;
}