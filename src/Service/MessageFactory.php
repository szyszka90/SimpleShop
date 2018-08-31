<?php

namespace App\Service;

use Twig\Environment;

class MessageFactory
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var string
     */
    private $from;

    public function __construct(\Swift_Mailer $mailer, Environment $environment, string $from)
    {
        $this->mailer = $mailer;
        $this->environment = $environment;
        $this->from = $from;
    }

    public function getMessage(string $to, string $subject, string $template, array $parameters): \Swift_Message
    {
        return (new \Swift_Message($subject))
            ->setFrom($this->from)
            ->setTo($to)
            ->setBody(
                $this->environment->render($template, $parameters)
            );
    }
}