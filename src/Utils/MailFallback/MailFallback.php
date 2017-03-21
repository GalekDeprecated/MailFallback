<?php

namespace Galek\MailFallback;

use Nette\Mail\FallbackMailer;
use Nette\Mail\SendmailMailer;
use Nette\Mail\SmtpMailer;
use Nette\Mail\IMailer;
use Nette\Mail\Message;

class MailFallback
{
    private $retryCount = 3;
    private $retryWaitTime = 1000;

    /** @var FallbackMailer */
    private $fallbackMailer;

    public function __construct($config)
    {
        $mailers = $this->prepare($config);

        $this->fallbackMailer = new FallbackMailer($mailers, $this->retryCount, $this->retryWaitTime);
    }

    private function prepare($config = [])
    {
        if (isset($config['retryCount'])) {
            $this->retryCount = $config['retryCount'];
            unset($config['retryCount']);
        }

        if (isset($config['retryWaitTime'])) {
            $this->retryWaitTime = $config['retryWaitTime'];
            unset($config['retryWaitTime']);
        }

        $mailers = [];

        foreach ($config as $mailer) {
            if (empty($mailer['smtp'])) {
                $mailers[] = new SendmailMailer();
            } else {
                $mailers[] = new SmtpMailer($mailer);
            }
        }

        return $mailers;
    }

    public function send(Message $mail)
    {
        $this->fallbackMailer->send($mail);
    }

    public function addMailer(IMailer $mailer)
    {
        $this->fallbackMailer->addMailer($mailer);
    }

}