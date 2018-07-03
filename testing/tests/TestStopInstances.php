<?php

class TestStopInstances extends AbstractTest
{
    public function getDescription(): string 
    {
        return "Test that we can stop a running instance.";
    }
    
    
    public function run(\iRAP\Ec2Wrapper\Ec2Client $ec2client) 
    {
        $ec2Instance = TestHelper::deployStoppedInstance($ec2client);
        
        try 
        {
            $startRequest = new \iRAP\Ec2Wrapper\Requests\RequestStartInstances(
                array($ec2Instance->getInstanceId())
            );
            
            /* @var $response iRAP\Ec2Wrapper\Responses\StartInstancesResponse */
            $response = $ec2client->startInstances($startRequest);
            
            $maxWaitTime = 60;
            $timeStart = time();
            $instanceStarted = false;
            
            while ($instanceStarted === FALSE)
            {
                if ((time() - $timeStart) > $maxWaitTime)
                {
                    break;
                }
                
                $newCopyOfInstance = \iRAP\Ec2Wrapper\Objects\Ec2Instance::createFromID(
                    $ec2Instance->getInstanceId(), 
                    $ec2client
                );
                
                if ($newCopyOfInstance->getStateString() === \iRAP\Ec2Wrapper\Enums\Ec2State::STATE_RUNNING)
                {
                    $instanceStarted = true;
                }
            }
            
            $this->m_passed = $instanceStarted;
        } 
        finally 
        {
            $ec2Instance->terminate($ec2client);
        }
    }
}

