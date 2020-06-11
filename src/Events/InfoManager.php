<?php
namespace CarloNicora\Minimalism\Services\Mailer\Events;

use CarloNicora\Minimalism\Core\Events\Abstracts\AbstractInfoEvent;

class InfoManager extends AbstractInfoEvent
{
    /** @var string  */
    protected string $serviceName = 'minimalism-service-mailer';
}