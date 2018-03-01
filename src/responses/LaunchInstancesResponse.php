<?php

/* 
 * A response for a DescribeInstances request.
 */

namespace iRAP\Ec2Wrapper\Responses;

class LaunchInstancesResponse extends AbstractResponse
{
    private $m_instances;
    
    
    public function __construct($rawAmazonResponse)
    {
        parent::__construct();
        /* @var $rawAmazonResponse \Aws\Result */
        $ec2InstanceStdObjs = $rawAmazonResponse->get('Instances');
        
        foreach ($ec2InstanceStdObjs as $ec2StdObj)
        {
            $this->m_instances[] = \iRAP\Ec2Wrapper\Objects\Ec2Instance::createFromAwsItem($ec2StdObj);
        }
        
        return $rawAmazonResponse;
    }
    
    
    # Accessors
    public function getEc2Instances() { return $this->m_instances; }
}
