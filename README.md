# MailFallback

MailFallback is Extension for [Nette mail](https://github.com/nette/mail)

Requirements
------------
Galek/MailFallback requires PHP 5.6 or higher.

- [nette/di](https://github.com/nette/di) 2.4 or higher
- [nette/mail](https://github.com/nette/mail) 2.4 or higher

Installation
=======

The best way install Galek/MailFallback is using [Composer](http://getcomposer.org/):

```sh
$ composer require galek/mail-fallback
```

Usage:
======

### config.neon ###

```neon
extensions: 
    mailFallback: Galek\MailFallback\FallbackExtension
    
mailFallback:
    retryCount: 3
    retryWaitTime: 1000
    default:
        smtp: true
        host: 'smtp.server.com'
        port: 25
        secure: 'tls'
        username: 'my@server.com'
        password: 'mySecretPassword'
```

### Presenter ###

```php
    /** @var \Galek\MailFallback\MailFallback @inject */
    public $mailer;
    
    public function sendMail(\Nette\Mail\Message $mail)
    {
        $mailer = $this->mailer;
        $mailer->send($mail);
    }
```