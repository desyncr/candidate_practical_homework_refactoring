<?php

namespace Docler\Language;

use Docler\Config\Config;

use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LanguageBatchBoFactory
{
    public static function create()
    {
        $logger = new Logger(__CLASS__);
        $logger->pushHandler(new StreamHandler(STDOUT));

        $service = new LanguageBatchBo(
            new Config,
            $logger
        );

        return $service;
    }
}
