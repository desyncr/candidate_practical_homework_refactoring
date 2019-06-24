<?php

use PHPUnit\Framework\TestCase;

use Docler\Language\Backend\Filesystem;
use Docler\Language\Backend\Memory;

class LanguageBackendTest extends TestCase
{
    public function testCanUseForSimpleStrings()
    {
        $memory = new Memory;
        $value = 'value';
        $memory->put('key', $value);

        $this->assertTrue($memory->exists('key'));
        $this->assertEquals($value, $memory->get('key'));
    }

    public function testCanUseFilesystemForSimpleStrings()
    {
        $fs = new Filesystem;
        $value = 'value';
        $key = tempnam('/tmp', __CLASS__);
        $fs->put($key, $value);

        $this->assertTrue($fs->exists($key));
        $this->assertEquals($value, $fs->get($key));
    }

    public function testCanRemoveElement()
    {
        $memory = new Memory;
        $value = 'value';
        $key = tempnam('/tmp', __CLASS__);
        $memory->put($key, $value);

        $this->assertTrue($memory->exists($key));
        $this->assertEquals($value, $memory->get($key));

        $memory->remove($key);
        $this->assertFalse($memory->exists($key));
    }
}
