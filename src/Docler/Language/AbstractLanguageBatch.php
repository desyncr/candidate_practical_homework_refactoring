<?php

namespace Docler\Language;

use Docler\Config\ConfigInterface;
use Docler\Config\Config;

use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Business logic related to generating language files.
 */
abstract class AbstractLanguageBatch implements LanguageBatchInterface
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
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor
     *
     * @param ConfigInterface    $config  A config interface
     * @param LoggerInterface    $logger  A logger inteface
     */
    public function __construct(
        ConfigInterface     $config = null,
        LoggerInterface     $logger = null
    ) {
        $this->config   = $config   ?? new Config;
        $this->logger   = $logger;

        // This is done in order to provide a logger for any client
        // not using the factory
        if (!$this->logger) {
            $this->logger = new Logger(__CLASS__);
            $this->logger->pushHandler(new StreamHandler(STDOUT));
        }
    }

    /**
     * Helper method to log if any logger is setup.
     *
     * @param string $msg   Message to log
     * @param string $level Logging level (info, error, debug)
     */
    protected function log($msg, $level = 'info')
    {
        if ($this->logger) {
            $this->logger->$level($msg);
        }
    }
}
