<?php

use PHPUnit\Framework\TestCase;
use Language\ApiCall;

class ApiCallTest extends TestCase
{
    public function testCanGetLanguageFile()
    {
        $res = ApiCall::call(
            'system_api',
            'language_api',
            [
                'system' => 'LanguageFiles',
                'action' => 'getLanguageFile'
            ],
            ['language' => 'en']
        );

        $expected = ['status' => 'OK'];
        $this->assertEquals($expected['status'], $res['status']);
    }

    public function testCanGetAppletLanguages()
    {
        $res = ApiCall::call(
            'system_api',
            'language_api',
            [
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguages'
            ],
            ['language' => 'en']
        );

        $expected = ['status' => 'OK', 'data' => ['en']];
        $this->assertEquals($expected, $res);
    }

    public function testCanGetAppletLanguageFile()
    {
        $res = ApiCall::call(
            'system_api',
            'language_api',
            [
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguageFile'
            ],
            ['language' => 'en']
        );

        $expected = ['status' => 'OK'];
        $this->assertEquals($expected['status'], $res['status']);

        $xml = simplexml_load_string($res['data'], 'SimpleXMLElement', LIBXML_NOCDATA);
        $this->assertNotNull($xml);
        $this->assertNotNull($xml->button_go_private);
    }
}
