<?php

class TestStopInstances extends AbstractTest
{
    public function getDescription(): string 
    {
        return "Test that we can stop a running instance.";
    }
    
    
    public function run(\Programster\Ec2Wrapper\Ec2Client $ec2client) 
    {
        $ec2Instance = TestHelper::deployStoppedInstance($ec2client);
        
        try 
        {
            $startRequest = new \Programster\Ec2Wrapper\Requests\RequestStartInstances(
                array($ec2Instance->getInstanceId())
            );
            
            /* @var $response Programster\Ec2Wrapper\Responses\StartInstancesResponse */
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
                
                $newCopyOfInstance = \Programster\Ec2Wrapper\Objects\Ec2Instance::createFromID(
                    $ec2Instance->getInstanceId(), 
                    $ec2client
                );
                
                if ($newCopyOfInstance->getStateString() === \Programster\Ec2Wrapper\Enums\Ec2State::STATE_RUNNING)
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

