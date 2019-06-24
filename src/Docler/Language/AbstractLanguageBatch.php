<?php

namespace Docler\Language;

use Docler\Config\Config;
use Docler\Api\ApiCall;
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
     * @var ApiInterface
     */
    protected $api;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        Backend             $backend = null,
        ConfigInterface     $config = null,
        ApiInterface        $api    = null,
        LoggerInterface     $logger = null
    )
    {
        $this->config   = $config   ?? new Config;
        $this->backend  = $backend  ?? new Filesystem;
        $this->api      = $api      ?? new ApiCall;
        $this->logger   = $logger;

        // This is done in order to provide a logger for any client
        // not using the factory
        if (!$this->logger) {
            $this->logger = new Logger(__CLASS__);
            $this->logger->pushHandler(new StreamHandler(STDOUT));
        }
    }

    /**
     * Gets the directory of the cached language files.
     *
     * @param string $application   The application.
     *
     * @return string   The directory of the cached language files.
     */
    protected function getLanguageCachePath($application)
    {
        return $this->config::get('system.paths.root') . '/cache/' . $application. '/';
    }

    /**
     * Gets the available languages for the given applet.
     *
     * @param string $applet   The applet identifier.
     *
     * @return array   The list of the available applet languages.
     */
    protected function getAppletLanguages($applet)
    {
        $result = $this->api::call(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguages'
            ),
            array('applet' => $applet)
        );

        try {
            $this->checkForApiErrorResult($result);
        } catch (\Exception $e) {
            throw new \Exception('Getting languages for applet (' . $applet . ') was unsuccessful ' . $e->getMessage());
        }

        return $result['data'];
    }


    /**
     * Checks the api call result.
     *
     * @param mixed  $result   The api call result to check.
     *
     * @throws Exception   If the api call was not successful.
     *
     * @return void
     */
    protected function checkForApiErrorResult($result)
    {
        // Error during the api call.
        if ($result === false || !isset($result['status'])) {
            throw new \Exception('Error during the api call');
        }
        // Wrong response.
        if ($result['status'] != 'OK') {
            throw new \Exception('Wrong response: '
                . (!empty($result['error_type']) ? 'Type(' . $result['error_type'] . ') ' : '')
                . (!empty($result['error_code']) ? 'Code(' . $result['error_code'] . ') ' : '')
                . ((string)$result['data']));
        }
        // Wrong content.
        if ($result['data'] === false) {
            throw new \Exception('Wrong content!');
        }
    }

    /**
     * Gets a language xml for an applet.
     *
     * @param string $applet      The identifier of the applet.
     * @param string $language    The language identifier.
     *
     * @return string|false   The content of the language file or false if weren't able to get it.
     */
    protected function getAppletLanguageFile($applet, $language)
    {
        $result = $this->api::call(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguageFile'
            ),
            array(
                'applet' => $applet,
                'language' => $language
            )
        );

        try {

            $this->checkForApiErrorResult($result);

        } catch (\Exception $e) {
            throw new \Exception(
                sprintf(
                    'Getting language xml for applet: (%s) on language: (%s) was unsuccessful: %s',
                    $applet,
                    $language,
                    $e->getMessage()
                )
            );
        }

        return $result['data'];
    }

    protected function log($msg, $level = 'info')
    {
        if ($this->logger) {
            $this->logger->$level($msg);
        }
    }
}
