<?php

namespace Docler\Language;

/**
 * Business logic related to generating language files.
 */
interface LanguageBatchBoInterface
{
    /**
     * Starts the language file generation.
     *
     * @return void
     */
    public function generateLanguageFiles();

    /**
     * Gets the language files for the applet and puts them into the cache.
     *
     * @throws Exception   If there was an error.
     *
     * @return void
     */
    public function generateAppletLanguageXmlFiles();
}
