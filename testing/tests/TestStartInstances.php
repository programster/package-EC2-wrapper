<?php

class TestStartInstances extends AbstractTest
{
    public function getDescription(): string 
    {
        return "Test that we can start a stopped ec2 instance.";
    }
    
    
    public function run(Programster\Ec2Wrapper\Ec2Client $ec2client) 
    {
        $ec2Instance = TestHelper::deployStoppedInstance($ec2client);
        
        try 
        {
            $startRequest = new \Programster\Ec2Wrapper\Requests\RequestStartInstances(
                array($ec2Instance->getInstanceId())
            );
            
            /* @var $response Programster\Ec2Wrapper\Responses\StopInstancesResponse */
            $response = $ec2client->startInstances($startRequest);
            
            
            // check the instance starts.
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
                $this->m_passed = true;
            }
            else
            {
                $this->m_passed = false;
            }
        } 
        finally 
        {
            $ec2Instance->terminate($ec2client);
        }
    }
}

