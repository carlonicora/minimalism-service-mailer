<?php
namespace CarloNicora\Minimalism\Services\Mailer\Objects;

use Exception;
use RuntimeException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\ArrayLoader;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;

class Email
{
    /** @var array  */
    public array $recipients = [];

    /** @var string|null  */
    public ?string $subject=null;

    /** @var string|null  */
    public ?string $body=null;

    /** @var string  */
    public string $contentType = 'text/html';

    /** @var Environment|null  */
    private ?Environment $template=null;

    /** @var string|null */
    private ?string $templateName=null;

    /** @var array|null  */
    private ?array $templateDirectory=null;
    /**
     * email constructor.
     * @param string $subject
     * @param array|null $templateDirectory
     */
    public function __construct(string $subject, ?array $templateDirectory=null)
    {
        $this->subject = $subject;

        if ($templateDirectory !== null) {
            $this->templateDirectory = $templateDirectory;
        }
    }

    /**
     * @param string $body
     */
    public function addBody(string $body) : void
    {
        $this->body = $body;
    }

    /**
     * @param string $template
     */
    public function addTemplate(string $template): void
    {
        $this->templateName = 'email.twig';
        $arrayLoader = new ArrayLoader([
            $this->templateName => $template
        ]);

        if ($this->templateDirectory !== null){
            $filesystemLoader = new FilesystemLoader($this->templateDirectory);
            $loader = new ChainLoader([$arrayLoader, $filesystemLoader]);
        } else {
            $loader = new ChainLoader([$arrayLoader]);
        }

        $this->template = new Environment($loader);
    }

    /**
     * @param string $templateName
     * @throws Exception
     */
    public function addTemplateFile(string $templateName): void
    {
        if ($this->templateDirectory === null) {
            throw new RuntimeException('No configured email template directory', 500);
        }

        $this->templateName = $templateName;

        $loader = new FilesystemLoader($this->templateDirectory);

        $this->template = new Environment($loader);
    }

    /**
     * @param string $email
     * @param string|null $name
     */
    public function addRecipient(string $email, string $name = null): void
    {
        $this->recipients[] = [
            'email' => $email,
            'name' => $name
        ];
    }

    /**
     * @param array $parameters
     * @throws Exception
     */
    public function addParameters(array $parameters): void
    {
        try {
            $this->body = $this->template->render($this->templateName, $parameters);
        } catch (LoaderError | RuntimeError | SyntaxError) {
            throw new RuntimeException('Error creating the email content', 500);
        }
    }
}