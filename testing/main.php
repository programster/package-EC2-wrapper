<?php

/* 
 * Run the tests.
 */

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/Settings.php');

$classDirs = array(
    __DIR__, 
    __DIR__ . '/tests',
    __DIR__ . '/libs',
);

new \iRAP\Autoloader\Autoloader($classDirs);

$ec2Client = new iRAP\Ec2Wrapper\Ec2Client(
    API_KEY, 
    API_SECRET, 
    \iRAP\Ec2Wrapper\Enums\AwsRegion::create_EU_W1()
);

$tests = iRAP\CoreLibs\Filesystem::getDirContents(
    $dir=__DIR__ . '/tests', 
    $recursive=true, 
    $includePath=false, 
    $onlyFiles=true
);

foreach ($tests as $testFilename)
{
    $testName = substr($testFilename, 0, -4);
    
    /* @var $testToRun AbstractTest */
    $testToRun = new $testName();
    $testToRun->run($ec2Client);
    
    if ($testToRun->getPassed())
    {
        print $testName . ": \e[32mPASSED\e[0m" . PHP_EOL;
    }
    else 
    {
        print $testName . ": \e[31mFAILED\e[0m" . PHP_EOL;
    }
}
