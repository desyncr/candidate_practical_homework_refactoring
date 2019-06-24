<?php

chdir(__DIR__);

include('../vendor/autoload.php');

$languageBatchBo = new \Docler\Language\LanguageBatchBo();
$languageBatchBo->generateLanguageFiles();
$languageBatchBo->generateAppletLanguageXmlFiles();
