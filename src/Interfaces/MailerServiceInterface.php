<?php
namespace CarloNicora\Minimalism\Services\Mailer\Interfaces;

use CarloNicora\Minimalism\Services\Mailer\Objects\Email;

interface MailerServiceInterface
{    /**
     * @param string $senderEmail
     * @param string $senderName
     */
    public function setSender(string $senderEmail, string $senderName):void;

    /**
     * @param Email $email
     * @return bool
     */
    public function send(Email $email):bool;
}