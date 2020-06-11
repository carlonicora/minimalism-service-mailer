<?php
namespace CarloNicora\Minimalism\Services\Mailer\Events;

use CarloNicora\Minimalism\Core\Events\Abstracts\AbstractErrorEvent;
use CarloNicora\Minimalism\Core\Events\Interfaces\EventInterface;
use CarloNicora\Minimalism\Core\Modules\Interfaces\ResponseInterface;
use Exception;

class ErrorManager extends AbstractErrorEvent
{
    /** @var string  */
    protected string $serviceName = 'minimalism-service-mailer';

    /**
     * @param Exception $exception
     * @return EventInterface
     */
    public static function FAILED_TO_CREATE_EMAIL_BODY(Exception $exception): EventInterface
    {
        return new self(1, ResponseInterface::HTTP_STATUS_500,'Failed to create email body', null, $exception);
    }

    /**
     * @param string $errorInfo
     * @return EventInterface
     */
    public static function EMAIL_NOT_SENT(string $errorInfo): EventInterface
    {
        return new self(2, ResponseInterface::HTTP_STATUS_500,'Email cannot be sent: ' . $errorInfo);
    }

    /**
     * @param Exception $exception
     * @return EventInterface
     */
    public static function FAILED_TO_SEND_EMAIL(Exception $exception): EventInterface
    {
        return new self(3, ResponseInterface::HTTP_STATUS_500,'Failed to send an email',null, $exception);
    }

    /**
     * @param Exception $exception
     * @return EventInterface
     */
    public static function INVALID_EMAIL(Exception $exception): EventInterface
    {
        return new self(4, ResponseInterface::HTTP_STATUS_400,'Invalid email',null, $exception);
    }

    /**
     * @return EventInterface
     */
    public static function NO_TEMPLATE_DIRECTORY(): EventInterface
    {
        return new self(5, ResponseInterface::HTTP_STATUS_400,'A template directory is required to use a template file');
    }

    /**
     * @param Exception $exception
     * @return EventInterface
     */
    public static function SENDGRID_FAILED_TO_SET_FROM(Exception $exception): EventInterface
    {
        return new self(6, ResponseInterface::HTTP_STATUS_500,'Sendgrid failed to set From field',null, $exception);
    }

    /**
     * @param Exception $exception
     * @return EventInterface
     */
    public static function SENDGRID_FAILED_TO_SET_SUBJECT(Exception $exception): EventInterface
    {
        return new self(7, ResponseInterface::HTTP_STATUS_500,'Sendgrid failed to set Subject',null, $exception);
    }
}