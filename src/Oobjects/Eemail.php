<?php
namespace carlonicora\minimalism\services\mailer\Oobjects;

use RuntimeException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\ArrayLoader;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;

class eemail {
    /** @var array  */
    public array $recipients = [];

    /** @var string  */
    public ?string $subject=null;

    /** @var string|null  */
    public ?string $body=null;

    /** @var string  */
    public string $contentType = 'text/html';

    /** @var Environment|null  */
    private ?Environment $template=null;

    /** @var string|null */
    private ?string $templateName=null;

    /** @var string|null  */
    private ?string $templateDirectory=null;
    /**
     * email constructor.
     * @param string $subject
     * @param string|null $templateDirectory
     */
    public function __construct(string $subject, ?string $templateDirectory=null) {
        $this->subject = $subject;

        if ($templateDirectory !== null) {
            $this->templateDirectory = $templateDirectory;
        }
    }

    /**
     * @param string $body
     */
    public function addBody(string $body) : void{
        $this->body = $body;
    }

    /**
     * @param string $template
     */
    public function addTemplate(string $template): void {
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
     */
    public function addTemplateFile(string $templateName): void {
        if ($this->templateDirectory === null) {
            throw new RuntimeException('A template directory is required to use a template file');
        }

        $this->templateName = $templateName;

        $loader = new FilesystemLoader($this->templateDirectory);

        $this->template = new Environment($loader);
    }

    /**
     * @param string $email
     * @param string $name
     */
    public function addRecipient(string $email, string $name): void{
        $this->recipients[] = [
            'email' => $email,
            'name' => $name
        ];
    }

    /**
     * @param array $parameters
     */
    public function addParameters(array $parameters): void {
        try {
            $this->body = $this->template->render($this->templateName, $parameters);
        } catch (LoaderError $e) {
            throw new RuntimeException('Failed to create email body');
        } catch (RuntimeError $e) {
            throw new RuntimeException('Failed to create email body');
        } catch (SyntaxError $e) {
            throw new RuntimeException('Failed to create email body');
        }
    }
}