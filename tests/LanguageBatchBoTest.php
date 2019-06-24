<?php

use PHPUnit\Framework\TestCase;

use Docler\Language\LanguageBatchBo;
use Docler\Config\Config;

class LanguageBatchBoTest extends TestCase
{
    private $service;

    public function setUp() : void
    {
        $this->service = new LanguageBatchBo();
        $cache_path = Config::get('system.paths.root') . '/cache';
        @rmdir($cache_path);
    }

    public function testCanGetLanguageBatchBo()
    {
        $this->service->generateLanguageFiles();

        $cache_path = Config::get('system.paths.root') . '/cache';
        foreach (Config::get('system.translated_applications') as $application => $langs) {
            $this->assertTrue(is_dir(sprintf("%s/%s", $cache_path, $application)));

            foreach ($langs as $lang) {
                $lang_file = sprintf('%s/%s/%s.php', $cache_path, $application, $lang);
                $this->assertTrue(file_exists($lang_file));
            }
        }
    }

    public function testCanGenerateAppletLanguageXmlFiles()
    {
        $this->service->generateAppletLanguageXmlFiles();

        $flash_path = Config::get('system.paths.root') . '/cache/flash';
        $this->assertTrue(is_dir($flash_path));

        foreach (['en'] as $applet_lang) {
            $lang_file = sprintf('%s/lang_%s.xml', $flash_path, $applet_lang);
            $this->assertTrue(file_exists($lang_file));

            $xml = simplexml_load_string(file_get_contents($lang_file), 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->assertNotNull($xml);
            $this->assertNotNull($xml->button_go_private);
        }
    }
}
