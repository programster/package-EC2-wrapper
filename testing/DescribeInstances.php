<?php

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/Settings.php');

function main()
{
    $apiKey = API_KEY;
    $secret = API_SECRET;
    $region = \iRAP\Ec2Wrapper\Enums\AwsRegion::create_EU_W1();
        
    $awsWrapper = new iRAP\Ec2Wrapper\AwsWrapper($apiKey, $secret, $region);
    
    $request = new iRAP\Ec2Wrapper\Requests\RequestDescribeInstances(iRAP\Ec2Wrapper\Enums\AwsRegion::create_EU_W1());
    $response = $awsWrapper->getEc2Client()->describeInstances($request);
    
    var_dump($response);
}

main();