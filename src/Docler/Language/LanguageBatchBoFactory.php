<?php

namespace Docler\Language;

use Docler\Config\Config;

use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Factory to create language batch
 */
class LanguageBatchBoFactory
{
    /**
     * Returns an instance of a language generator
     *
     * @return LanguageBatchInterface
     */
    public static function create() : LanguageBatchInterface
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
