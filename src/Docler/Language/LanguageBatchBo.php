<?php

namespace Docler\Language;

use Docler\Config\Config;
use Docler\Api\ApiCall;

use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo extends AbstractLanguageBatch
{
    /**
     * Starts the language file generation.
     *
     * @return void
     */
    public function generateLanguageFiles()
    {
        // The applications where we need to translate.
        $this->applications = $this->config::get('system.translated_applications');

        $this->log('Generating language files');
        foreach ($this->applications as $application => $languages) {
            $this->log(sprintf('[APPLICATION: %s]', $application));

            foreach ($languages as $language) {
                $this->log(sprintf('[LANGUAGE: %s]', $language));

                if ($this->getLanguageFile($application, $language)) {
                    $this->log(' OK');
                } else {
                    throw new \Exception('Unable to generate language file!');
                }
            }
        }
    }

    /**
     * Gets the language file for the given language and stores it.
     *
     * @param string $application   The name of the application.
     * @param string $language      The identifier of the language.
     *
     * @throws CurlException   If there was an error during the download of the language file.
     *
     * @return bool   The success of the operation.
     */
    protected function getLanguageFile($application, $language)
    {
        $result = false;
        $languageResponse = $this->api::call(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getLanguageFile'
            ),
            array('language' => $language)
        );

        try {

            $this->checkForApiErrorResult($languageResponse);

        } catch (\Exception $e) {
            throw new \Exception(
                sprintf(
                    'Error during getting language file: (%s/%s)',
                    $application,
                    $language
                )
            );
        }

        // If we got correct data we store it.
        $destination = $this->getLanguageCachePath($application) . $language . '.php';

        return (bool)$this->backend->put($destination, $languageResponse['data']);
    }

    /**
     * Gets the language files for the applet and puts them into the cache.
     *
     * @throws Exception   If there was an error.
     *
     * @return void
     */
    public function generateAppletLanguageXmlFiles()
    {
        // List of the applets [directory => applet_id].
        $applets = array(
            'memberapplet' => 'JSM2_MemberApplet',
        );

        $this->log('Getting applet language XMLs..');

        foreach ($applets as $appletDirectory => $appletLanguageId) {
            $this->log(sprintf('Getting > %s (%s) language xmls..', $appletLanguageId, $appletDirectory));
            $languages = $this->getAppletLanguages($appletLanguageId);
            if (empty($languages)) {
                throw new \Exception(
                    sprintf(
                        'There is no available languages for the %s',
                        $appletLanguageId
                    )
                );
            } else {
                $this->log(sprintf(' - Available languages: %s', implode(', ', $languages)));
            }

            $path = Config::get('system.paths.root') . '/cache/flash';
            foreach ($languages as $language) {
                $xmlContent = $this->getAppletLanguageFile($appletLanguageId, $language);
                $xmlFile    = sprintf('%s/lang_%s.xml', $path, $language);
                if (strlen($xmlContent) == $this->backend->put($xmlFile, $xmlContent)) {
                    $this->log(sprintf(" OK saving %s was successful.", $xmlFile));
                } else {
                    throw new \Exception(
                        sprintf(
                            'Unable to save applet: (%s) language: (%s) xml (%s)!',
                            $appletLanguageId,
                            $language,
                            $xmlFile
                        )
                    );
                }
            }
            $this->log(sprintf(' < %s (%s) language xml cached.', $appletLanguageId, $appletDirectory));
        }

        $this->log('Applet language XMLs generated.');
    }
}
