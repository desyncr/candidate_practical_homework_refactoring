<?php

namespace Docler\Language;

use Docler\Config\Config;
use Docler\Language\Exceptions\InvalidConfigurationException;
use Docler\Language\Generators\GeneratorFactory;

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
        $generator = GeneratorFactory::create('language');

        // The applications where we need to translate.
        $this->applications = $this->config::get('system.translated_applications');

        $this->log('Generating language files');
        foreach ($this->applications as $application => $languages) {
            $this->log(sprintf('[APPLICATION: %s]', $application));

            foreach ($languages as $language) {
                $this->log(sprintf('[LANGUAGE: %s]', $language));
                $generator->generate($application, $language);
                $this->log(sprintf('OK', $language));
            }
        }
    }

    /**
     * Gets the language files for the applet and puts them into the cache.
     *
     * @throws Exception   If there was an error.
     * @throws InvalidConfigurationException If there was an error.
     *
     * @return void
     */
    public function generateAppletLanguageXmlFiles()
    {
        $generator = GeneratorFactory::create('applet');

        // List of the applets [directory => applet_id].
        $applets = array(
            'memberapplet' => 'JSM2_MemberApplet',
        );

        $this->log('Getting applet language XMLs..');
        foreach ($applets as $appletDirectory => $appletLanguageId) {
            $this->log(sprintf('Getting > %s (%s) language xmls..', $appletLanguageId, $appletDirectory));

            $languages = $generator->getLanguages($appletLanguageId);
            foreach ($languages as $language) {
                $this->log(sprintf('[LANGUAGE: %s]', $language));
                $generator->generate($appletLanguageId, $language);
                $this->log(sprintf('OK'));
            }

            $this->log(sprintf(' < %s (%s) language xml cached.', $appletLanguageId, $appletDirectory));
        }

        $this->log('Applet language XMLs generated.');
    }
}
