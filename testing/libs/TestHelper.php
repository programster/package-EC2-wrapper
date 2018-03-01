<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TestHelper
{
    /**
     * Create an ec2 instance and return it once it is in the running state.
     * Most tests require there to be an instance to terminate/describe/stop etc.
     * @param iRAP\Ec2Wrapper\Ec2Client $ec2client
     * @return \iRAP\Ec2Wrapper\Objects\Ec2Instance
     */
    public static function createEc2Instance(iRAP\Ec2Wrapper\Ec2Client $ec2client) : \iRAP\Ec2Wrapper\Objects\Ec2Instance
    {
        $ubuntuImage = 'ami-cc166eb5';
        
        $launchSpecification = new \iRAP\Ec2Wrapper\Objects\LaunchSpecification(
            \iRAP\Ec2Wrapper\Enums\Ec2InstanceType::createT2(1), 
            $ubuntuImage
        );
        
        $request = new iRAP\Ec2Wrapper\Requests\RequestRunInstances($launchSpecification, 1, 1);
        $response = $ec2client->launchInstances($request);
        $ec2Instances = $response->getEc2Instances();
        $ec2Instance = $ec2Instances[0];
        $instanceIds = array($ec2Instance->getInstanceId());
        
        // wait for instance to get into the running state.
        while ($ec2Instance->getStateString() !== "running")
        {
            print "Spawning instance is in the {$ec2Instance->getStateString()} state." . PHP_EOL;
            sleep(10); // give the instance time to spawn
            print "Checking if EC2 instance has finished spawning...." . PHP_EOL;
            $describeInstanceResponse = $ec2client->describeInstances($instanceIds);
            $describedInstances = $describeInstanceResponse->getEc2Instances();
            $ec2Instance = $describedInstances[0];
        }
        
        return $ec2Instance;
    }
}

