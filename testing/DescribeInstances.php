<?php

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/Settings.php');

function main()
{
    $apiKey = API_KEY;
    $secret = API_SECRET;
    $region = \iRAP\AwsWrapper\Enums\AwsRegion::create_EU_W1();
        
    $awsWrapper = new iRAP\AwsWrapper\AwsWrapper($apiKey, $secret, $region);
    
    $request = new iRAP\AwsWrapper\Requests\RequestDescribeInstances(iRAP\AwsWrapper\Enums\AwsRegion::create_EU_W1());
    $response = $awsWrapper->getEc2Client()->describeInstances($request);
    
    var_dump($response);
}

main();