<?php
namespace carlonicora\minimalism\services\mailer\Ffactories;

use carlonicora\minimalism\core\services\abstracts\abstractServiceFactory;
use carlonicora\minimalism\core\services\exceptions\configurationException;
use carlonicora\minimalism\core\services\factories\servicesFactory;
use carlonicora\minimalism\services\mailer\Cconfigurations\mmailerConfigurations;
use carlonicora\minimalism\services\mailer\Iinterfaces\mmailerServiceInterface;

class sserviceFactory extends abstractServiceFactory {
    /**
     * serviceFactory constructor.
     * @param servicesFactory $services
     * @throws configurationException
     */
    public function __construct(servicesFactory $services) {
        $this->configData = new mmailerConfigurations();

        parent::__construct($services);
    }

    /**
     * @param servicesFactory $services
     * @return mmailerServiceInterface
     */
    public function create(servicesFactory $services) : mmailerServiceInterface {
        $mailerClass = $this->configData->getMailerClass();

        /** @var mmailerServiceInterface $response */
        $response = new $mailerClass($this->configData, $services);

        return $response;
    }
}