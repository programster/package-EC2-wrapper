<?php

namespace Programster\Ec2Wrapper\Requests;

/*
 * Class for starting stopped ec2 instances.
 * Please refer to the documentation at:
 * https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-ec2-2016-11-15.html#startinstances
 */

class RequestStartInstances extends AbstractEc2Request
{
    private $m_instanceIDs;
    private $m_dryRun;
    
    
    public function __construct(array $instanceIDs, $dryRun = false)
    {
        $this->m_instanceIDs = $instanceIDs;
        $this->m_dryRun = false;
    }
    
    
    /**
     * Sends the request off to amazon API
     * The majority this functions body is sorting out the differences between this requests
     * options and the LaunchSpecification in spot_instance_request.
     * @return Array $options - the options for the request.
     */
    public function getOptionsArray()
    {
        $options = array(
            'DryRun'      => $this->m_dryRun,
            'InstanceIds' => $this->m_instanceIDs,
        );
        
        return $options;
    }
    
    
    /**
     * Send the request to start the instances!
     * @param \Aws\Ec2\Ec2Client $ec2Client - the ec2 client (from sdk) that actaully makes the requst
     * @param array $options - the optional array to put into the request generated from this object.
     */
    protected function sendRequest(\Aws\Ec2\Ec2Client $ec2Client, array $options) : \Programster\Ec2Wrapper\Responses\AbstractResponse
    {
        $response = $ec2Client->startInstances($options);
        return new \Programster\Ec2Wrapper\Responses\StartInstancesResponse($response);
    }
}

