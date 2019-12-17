<?php

/* 
 * A library to help with testing.
 */

class TestHelper
{
    /**
     * Create an ec2 instance and return it once it is in the running state.
     * Most tests require there to be an instance to terminate/describe/stop etc.
     * @param Programster\Ec2Wrapper\Ec2Client $ec2client
     * @return \Programster\Ec2Wrapper\Objects\Ec2Instance
     */
    public static function createEc2Instance(Programster\Ec2Wrapper\Ec2Client $ec2client) : \Programster\Ec2Wrapper\Objects\Ec2Instance
    {
        $ubuntuImage = 'ami-cc166eb5';
        
        $launchSpecification = new \Programster\Ec2Wrapper\Objects\LaunchSpecification(
            \Programster\Ec2Wrapper\Enums\Ec2InstanceType::createT2(1), 
            $ubuntuImage
        );
        
        $request = new Programster\Ec2Wrapper\Requests\RequestRunInstances($launchSpecification, 1, 1);
        $response = $ec2client->launchInstances($request);
        $ec2Instances = $response->getEc2Instances();
        $ec2Instance = $ec2Instances[0];
        $instanceIds = array($ec2Instance->getInstanceId());
        
        // wait for instance to get into the running state.
        while ($ec2Instance->getStateString() !== \Programster\Ec2Wrapper\Enums\Ec2State::STATE_RUNNING)
        {
            sleep(10); // give the instance time to spawn
            $describeInstanceResponse = $ec2client->describeInstances($instanceIds);
            $describedInstances = $describeInstanceResponse->getEc2Instances();
            $ec2Instance = $describedInstances[0];
        }
        
        return $ec2Instance;
    }
    
    
    /**
     * Deploy a stopped instance. You may need to do this to test starting it etc.
     * @throws Exception - if failed to stop the instance.
     */
    public static function deployStoppedInstance(Programster\Ec2Wrapper\Ec2Client $ec2client) : \Programster\Ec2Wrapper\Objects\Ec2Instance
    {
        $ec2Instance = TestHelper::createEc2Instance($ec2client);
        
        $stopRequest = new \Programster\Ec2Wrapper\Requests\RequestStopInstances(
            array($ec2Instance->getInstanceId()), 
            $force=false
        );
        
        /* @var $response Programster\Ec2Wrapper\Responses\StopInstancesResponse */
        $response = $ec2client->stopInstances($stopRequest);
        
        // wait for the instance to stop.
        $maxWaitTime = 60;
        $timeStart = time();
        $instanceStopped = false;
        
        while ($instanceStopped === FALSE)
        {
            if ((time() - $timeStart) > $maxWaitTime)
            {
                break;
            }
            
            $newCopyOfInstance = \Programster\Ec2Wrapper\Objects\Ec2Instance::createFromID(
                $ec2Instance->getInstanceId(), 
                $ec2client
            );
            
            if ($newCopyOfInstance->getStateString() === \Programster\Ec2Wrapper\Enums\Ec2State::STATE_STOPPED)
            {
                $instanceStopped = true;
            }
        }
        
        if ($instanceStopped === FALSE)
        {
            throw new Exception("Failed to deploy a stopped instance.");
        }
        
        return $newCopyOfInstance;
    }
}

