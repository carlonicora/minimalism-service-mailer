<?php
namespace CarloNicora\Minimalism\Services\Mailer\Factories;

use CarloNicora\Minimalism\Core\Services\Abstracts\AbstractServiceFactory;
use CarloNicora\Minimalism\Core\Services\Factories\ServicesFactory;
use CarloNicora\Minimalism\Services\Mailer\Configurations\MailerConfigurations;
use CarloNicora\Minimalism\Services\Mailer\Interfaces\MailerServiceInterface;
use Exception;

class ServiceFactory extends AbstractServiceFactory
{
    /**
     * ServiceFactory constructor.
     * @param ServicesFactory $services
     * @throws Exception
     */
    public function __construct(ServicesFactory $services)
    {
        $this->configData = new MailerConfigurations();

        parent::__construct($services);
    }

    /**
     * @param ServicesFactory $services
     * @return MailerServiceInterface
     */
    public function create(ServicesFactory $services) : MailerServiceInterface
    {
        $mailerClass = $this->configData->getMailerClass();

        /** @var MailerServiceInterface $response */
        $response = new $mailerClass($this->configData, $services);

        return $response;
    }
}