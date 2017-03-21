<?php

namespace Galek\MailFallback\DI;

use Nette\DI\CompilerExtension;

class FallbackExtension extends CompilerExtension
{
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->getConfig([
            'retryCount' => 3,
            'retryWaitTime' => 1000,
            'default' => [
                'smtp' => FALSE,
                'host' => NULL,
                'port' => NULL,
                'username' => NULL,
                'password' => NULL,
                'secure' => NULL,
                'timeout' => NULL,
            ]
        ]);

        $builder->addDefinition($this->prefix('mailer'))
            ->setClass('Galek\MailFallback', [
                'config' => $config
            ]);
    }
}
