<?php

namespace Docler\Language;

use Docler\Config\Config;
use Docler\Language\Backend\Filesystem;


use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Business logic related to generating language files.
 */
abstract class AbstractLanguageBatch implements LanguageBatchBoInterface
{
    /**
     * Contains the applications which ones require translations.
     *
     * @var array
     */
    protected $applications = array();

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var BackendInterface
     */
    protected $backend;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        Backend             $backend = null,
        ConfigInterface     $config = null,
        LoggerInterface     $logger = null
    )
    {
        $this->config   = $config   ?? new Config;
        $this->backend  = $backend  ?? new Filesystem;
        $this->logger   = $logger;

        // This is done in order to provide a logger for any client
        // not using the factory
        if (!$this->logger) {
            $this->logger = new Logger(__CLASS__);
            $this->logger->pushHandler(new StreamHandler(STDOUT));
        }
    }

    protected function log($msg, $level = 'info')
    {
        if ($this->logger) {
            $this->logger->$level($msg);
        }
    }
}
