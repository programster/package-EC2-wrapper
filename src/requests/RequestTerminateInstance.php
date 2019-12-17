<?php

namespace Programster\Ec2Wrapper\Requests;

/* 
 * A request to terminate a single or multiple instances.
 */

class RequestTerminateInstance extends AbstractEc2Request
{
    private $m_instance_ids = array();
    
    
    /**
     * Create a request to terminate one or more ec2 instances.
     * @param AmazonRegion $region - the region the instances are located in.
     * @param mixed $instance_ids - a single instance id or an array of instance ids
     */
    public function __construct($instance_ids)
    {        
        if (is_array($instance_ids))
        {
            $this->m_instance_ids = $instance_ids;
        }
        else
        {
            if (!is_string($instance_ids) || $instance_ids == '')
            {
                $errMsg = 'TerminateInstanceRequest: instance_ids needs to be an array of ' .
                          'instance ids or a string representing a single instance id.';
                throw new \Exception($errMsg);
            }
            
            $this->m_instance_ids[] = $instance_ids;
        }
        
    }
    
    
    protected function getOptionsArray()
    {
        return array(
            'InstanceIds' => $this->m_instance_ids
        );
    }
    
    
    /**
     * Add another instance to list of instances to terminate.
     * @param type $instance_id - the unique ID of the instance we wish to terminate.
     */
    public function addInstance($instance_id)
    {
        $this->m_instance_ids[] = $instance_id;
    }
    
    
    protected function sendRequest(\Aws\Ec2\Ec2Client $ec2, array $opt) : \Programster\Ec2Wrapper\Responses\AbstractResponse
    {
        $response = $ec2->terminateInstances($opt);
        return new \Programster\Ec2Wrapper\Responses\TerminateInstanceResponse($response);
    }
}



