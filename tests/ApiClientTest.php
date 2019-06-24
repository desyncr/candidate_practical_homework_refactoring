<?php

use PHPUnit\Framework\TestCase;
use Docler\Api\ApiCall;
use Docler\Api\ApiClient;

class ApiClientCallTest extends TestCase
{
    public function testThrowsExceptionOnInvalidArgument()
    {
        $client = new ApiClient(new ApiCall);
        $this->expectException(Exception::class);
        $res = $client->get('app', 'en', 'unknown');
    }

    public function testCanGetLanguageFiles()
    {
        $client = new ApiClient(new ApiCall);
        $res = $client->get('app', 'en', ApiClient::GENERATOR_TYPE_LANG);
        $this->assertNotNull($res);
    }
}
