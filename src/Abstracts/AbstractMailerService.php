<?php
namespace CarloNicora\Minimalism\Services\Mailer\Abstracts;

use CarloNicora\Minimalism\Services\Mailer\Interfaces\MailerServiceInterface;
use CarloNicora\Minimalism\Services\Mailer\Objects\Email;

abstract class AbstractMailerService implements MailerServiceInterface
{
    /** @var string|null  */
    protected ?string $senderEmail=null;

    /** @var string|null  */
    protected ?string $senderName=null;

    /**
     * AbstractMailerService constructor.
     * @param string|null $username
     * @param string|null $password
     */
    public function __construct(
        protected ?string $username,
        protected ?string $password,
    )
    {
    }

    /**
     * @param string $senderEmail
     * @param string $senderName
     */
    final public function setSender(string $senderEmail, string $senderName): void
    {
        $this->senderEmail = $senderEmail;
        $this->senderName = $senderName;
    }

    /**
     * @param Email $email
     * @return bool
     */
    abstract public function send(Email $email): bool;
}