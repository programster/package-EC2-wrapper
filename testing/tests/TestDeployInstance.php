<?php

/**
 * Test that can deploy multiple instances at once, and with a name.
 */

class TestDeployInstance extends AbstractTest
{
    public function run(\iRAP\Ec2Wrapper\Ec2Client $ec2client)
    {
        $ubuntuImage = 'ami-cc166eb5';
        
        $launchSpecification = new \iRAP\Ec2Wrapper\Objects\LaunchSpecification(
            \iRAP\Ec2Wrapper\Enums\Ec2InstanceType::createT2(1), 
            $ubuntuImage,
            "My Instance Name"
        );
        
        $request = new iRAP\Ec2Wrapper\Requests\RequestRunInstances($launchSpecification, 3, 3);
        $launchResponse = $ec2client->launchInstances($request);
        
        sleep(10);
        
        $instances = $launchResponse->getEc2Instances();
        
        foreach ($instances as $instance)
        {
            /* @var $instance \iRAP\Ec2Wrapper\Objects\Ec2Instance */
            $instance->terminate($ec2client);
        }
    }
}