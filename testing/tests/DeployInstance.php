<?php

class DeployInstanceTest extends AbstractTest
{
    public function run(\iRAP\Ec2Wrapper\Ec2Client $ec2client)
    {
        $ubuntuImage = 'ami-cc166eb5';
        
        $launchSpecification = new \iRAP\Ec2Wrapper\Objects\LaunchSpecification(
            \iRAP\Ec2Wrapper\Enums\Ec2InstanceType::createT2(1), 
            $ubuntuImage
        );
        
        $request = new iRAP\Ec2Wrapper\Requests\RequestRunInstances($launchSpecification, 1, 1);
        $response = $ec2client->launchInstances($request);
        
        var_dump($response);
    }
}

main();