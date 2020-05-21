<?php
namespace CarloNicora\Minimalism\Services\Mailer\Abstracts;

use CarloNicora\Minimalism\core\Services\Abstracts\AbstractService;
use CarloNicora\Minimalism\core\Services\Factories\ServicesFactory;
use CarloNicora\Minimalism\core\Services\Interfaces\serviceConfigurationsInterface;
use CarloNicora\Minimalism\Services\Mailer\Configurations\MailerConfigurations;
use CarloNicora\Minimalism\Services\Mailer\Interfaces\MailerServiceInterface;
use CarloNicora\Minimalism\Services\Mailer\Objects\Email;

abstract class AbstractMailerService extends AbstractService implements MailerServiceInterface {
    /** @var MailerConfigurations  */
    protected MailerConfigurations $configData;

    /**
     * abstractMailerService constructor.
     * @param ServiceConfigurationsInterface $configData
     * @param ServicesFactory $services
     */
    public function __construct(ServiceConfigurationsInterface $configData, ServicesFactory $services)
    {
        parent::__construct($configData, $services);

        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->configData = $configData;
    }

    /**
     * @param string $senderEmail
     * @param string $senderName
     */
    final public function setSender(string $senderEmail, string $senderName): void
    {
        $this->configData->senderEmail = $senderEmail;
        $this->configData->senderName = $senderName;
    }

    /**
     * @param Email $email
     * @return bool
     */
    abstract public function send(Email $email): bool;
}