<?php

/* 
 * A response for a DescribeInstances request.
 */

namespace iRAP\Ec2Wrapper\Responses;

class DescribeInstancesResponse extends AbstractResponse
{
    private $m_instances;
    
    
    public function __construct($rawAmazonResponse)
    {
        parent::__construct();
        $reservations = $rawAmazonResponse->get('Reservations');
        
        foreach ($reservations as $reservation)
        {
            $instances = $reservation['Instances'];
            
            foreach ($instances as $instanceSetItem)
            {
                $ec2Instance = \iRAP\Ec2Wrapper\Objects\Ec2Instance::createFromAwsItem($instanceSetItem);
                $this->m_instances[] = $ec2Instance;
            }
        }
    }
    
    
    # Accessors
    public function getEc2Instances() { return $this->m_instances; }
}
