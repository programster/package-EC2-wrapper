<?php

/*
 * Test that can deploy multiple instances at once, and with a name.
 */

class TestDeployInstance extends AbstractTest
{
    public function getDescription(): string 
    {
        return "Test the deployment of an EC2 instance.";
    }
    
    
    public function run(\Programster\Ec2Wrapper\Ec2Client $ec2client)
    {
        $ubuntuImage = 'ami-cc166eb5';
        $numInstancesToLaunch = 3;
        
        $launchSpecification = new \Programster\Ec2Wrapper\Objects\LaunchSpecification(
            \Programster\Ec2Wrapper\Enums\Ec2InstanceType::createT2(1), 
            $ubuntuImage,
            "My Instance Name"
        );
        
        $request = new Programster\Ec2Wrapper\Requests\RequestRunInstances(
            $launchSpecification, 
            $numInstancesToLaunch, 
            $numInstancesToLaunch
        );
        
        $launchResponse = $ec2client->launchInstances($request);
        
        // wait for the instances to launch
        sleep(10);
        $describeInstancesResponse = $ec2client->describeInstances();
        
        if (count($describeInstancesResponse->getEc2Instances()) == $numInstancesToLaunch)
        {
            $this->m_passed = true;
        }
        else
        {
            $this->m_passed = false;
        }
        
        // cleanup
        foreach ($launchResponse->getEc2Instances() as $instance)
        {
            /* @var $instance \Programster\Ec2Wrapper\Objects\Ec2Instance */
            $instance->terminate($ec2client);
        }
    }
}