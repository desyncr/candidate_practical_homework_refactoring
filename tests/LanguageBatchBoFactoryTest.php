<?php

use PHPUnit\Framework\TestCase;

use Docler\Language\Backend\Filesystem;
use Docler\Language\Backend\Memory;
use Docler\Language\LanguageBatchBoFactory;
use Docler\Language\LanguageBatchBo;

class LanguageBatchBoFactoryTest extends TestCase
{
    public function testCanCreateInstance()
    {
        $instance = LanguageBatchBoFactory::create();
        $this->assertInstanceOf(LanguageBatchBo::class, $instance);
    }
}
