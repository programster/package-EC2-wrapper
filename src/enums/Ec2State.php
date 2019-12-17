<?php

namespace Programster\Ec2Wrapper\Enums;

/*
 * A class to act as an ENUM for all the possible states an EC2 instance can be in.
 * Please refer to: https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-instance-lifecycle.html 
 * and https://docs.aws.amazon.com/AWSEC2/latest/APIReference/API_InstanceState.html
 */


class Ec2State
{
    const STATE_REBOOTING = "rebooting";
    const STATE_PENDING = "pending";
    const STATE_RUNNING = "running";
    const STATE_STOPPING = "stopping";
    const STATE_STOPPED = "stopped";
    const STATE_SHUTTING_DOWN = "shutting-down";
    const STATE_TERMINATED = "terminated";
    
    private $m_state;
    
    
    public function __construct(string $state)
    {
        $possibleStates = array(
            Ec2State::STATE_REBOOTING,
            Ec2State::STATE_PENDING,
            Ec2State::STATE_RUNNING,
            Ec2State::STATE_STOPPING,
            Ec2State::STATE_STOPPED,
            Ec2State::STATE_SHUTTING_DOWN,
            Ec2State::STATE_TERMINATED,
        );
        
        if (!in_array($state, $possibleStates))
        {
            throw new Exception("Invalid state string: $state");
        }
        
        $this->m_state = $state;
    }
    
    
    /**
     * Define the toString method so we can place this object directly in calls without using a 
     * method.
     * @return String - the instanceType.
     */
    public function __toString() 
    {
        return $this->m_state;
    }
}
