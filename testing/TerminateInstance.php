<?php

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/Settings.php');

function main()
{
    $apiKey = API_KEY;
    $secret = API_SECRET;
    $region = \iRAP\AwsWrapper\Enums\AwsRegion::create_EU_W1();
        
    $awsWrapper = new iRAP\AwsWrapper\AwsWrapper($apiKey, $secret, $region);
    $ec2Client = $awsWrapper->getEc2Client();
    
    
    $ubuntuImage = 'ami-47a23a30';
    $launchSpecification = new \iRAP\AwsWrapper\Objects\LaunchSpecification(\iRAP\AwsWrapper\Enums\Ec2InstanceType::createT2(1), $ubuntuImage);
    $request = new iRAP\AwsWrapper\Requests\RequestRunInstances($launchSpecification, 1, 1);
    $ec2Client->runInstances($request);
    
    $instances = $request->getSpawnedInstances();
        
    $terminationRequest = new \iRAP\AwsWrapper\Requests\RequestTerminateInstance($instances);
    $response = $awsWrapper->getEc2Client()->terminateInstances($terminationRequest);
    var_dump($response);
}

main();