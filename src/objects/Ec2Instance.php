<?php

/* 
 * This object represents an ec2 instance as described from a describeInstances request.
 */

namespace iRAP\Ec2Wrapper\Objects;

class Ec2Instance
{
    private $m_instance_id;
    private $m_image_id;
    private $m_instance_state_code;
    private $m_instance_state_name;
    private $m_private_dns_name;
    private $m_dns_name;
    private $m_state_transition_reason;
    private $m_state_reason_code;
    private $m_state_reason_message;
    private $m_key_name;
    private $m_ami_launch_index;
    private $m_product_codes;
    private $m_instance_type; # # e.g. t1.micro
    private $m_launch_time; # unix timestamp
    private $m_placement;
    private $m_kernel_id;
    private $m_monitoring_state;
    private $m_subnet_id;
    private $m_vpc_id;
    private $m_private_ip_address;
    private $m_ip_address;
    private $m_source_dest_check;
    private $m_tags = array();
    private $m_group_set;
    private $m_architecture;
    private $m_root_device_type;
    private $m_root_device_name;
    private $m_block_device_mappings;
    private $m_instance_lifecycle;
    private $m_spot_instance_request_id; # may or may not be set
    private $m_virtualization_type;
    private $m_client_token;
    private $m_tag_set;
    private $m_hypervisor;
    private $m_network_interfaces;
    private $m_ebs_optimized; # flag
    private $m_security_groups; # array of objects with GroupName and GroupId
    
    private function __construct() {}
    
    
    /**
     * Creates an Ec2Instance object from the $item stdObject returned from an amazon request.
     * Unfortunately without casting, all values get set as simplexml objects.
     * @param \stdClass $item
     * @return Ec2Instance
     */
    public static function createFromAwsItem($item)
    {
        $ec2Instance = new Ec2Instance();
        
        $ec2Instance->m_instance_id                 = $item['InstanceId'];
        $ec2Instance->m_image_id                    = $item['ImageId'];
        $ec2Instance->m_instance_state_code         = intval($item['State']['Code']); # e.g 16 (running)
        $ec2Instance->m_instance_state_name         = $item['State']['Name']; # e.g. running
        $ec2Instance->m_private_dns_name            = $item['PrivateDnsName'];
        $ec2Instance->m_dns_name                    = $item['PublicDnsName'];
        $ec2Instance->m_state_transition_reason     = $item['StateTransitionReason']; #unknown object
        $ec2Instance->m_ami_launch_index            = intval($item['AmiLaunchIndex']);
        
        
        $ec2Instance->m_product_codes               = $item['ProductCodes']; # array of something (empty in example given)
        $ec2Instance->m_instance_type               = $item['InstanceType']; // e.g. "t2.micro"
        
        # It's odd, but the LaunchTime objects attributes are all lowercase unlike everything else.
        $ec2Instance->m_launch_time                 = strtotime((string)$item['LaunchTime']); # 2015-09-18 13:48:08
        
        $ec2Instance->m_placement                   = \iRAP\Ec2Wrapper\Objects\Placement::createFromAwsApi($item['Placement']);
        
        $ec2Instance->m_monitoring_state            = $item['Monitoring']['State']; # e.g. "disabled"
        
        if (isset($item['SubnetId']))
        {
            $ec2Instance->m_subnet_id                   = $item['SubnetId']; # e.g. "subnet-f7b4479d"
        }
        
        if (isset($item['VpcId']))
        {
            $ec2Instance->m_vpc_id                      = $item['VpcId']; # e.g. vpc-f6b4479c"
        }
        
        if (isset($item['PrivateIpAddress']))
        {
            $ec2Instance->m_private_ip_address          = $item['PrivateIpAddress']; # "172.31.33.19"
        }
        
        if (isset($item['StateReason']))
        {
            $ec2Instance->m_state_reason_code           = $item['StateReason']['Code']; # "pending"
            $ec2Instance->m_state_reason_message        = $item['StateReason']['Message']; # "pending"
        }
        
        $ec2Instance->m_architecture                = $item['Architecture']; # "x86_64"
        $ec2Instance->m_root_device_type            = $item['RootDeviceType'];
        $ec2Instance->m_root_device_name            = $item['RootDeviceName'];
        $ec2Instance->m_block_device_mappings       = $item['BlockDeviceMappings']; # this is an array of objects
        $ec2Instance->m_virtualization_type         = $item['VirtualizationType']; # "hvm"
        $ec2Instance->m_client_token                = $item['ClientToken'];
        $ec2Instance->m_security_groups             = $item['SecurityGroups'];
        
        if (isset($item['SourceDestCheck']))
        {
            $ec2Instance->m_source_dest_check           = $item['SourceDestCheck']; # boolean value
        }
        
        $ec2Instance->m_hypervisor                  = $item['Hypervisor']; # "xen"
        $ec2Instance->m_network_interfaces          = $item['NetworkInterfaces']; #  this is an object that needs def
        $ec2Instance->m_ebs_optimized               = $item['EbsOptimized']; # boolean value
        
        if (isset($item['Tags']))
        {
            foreach ($item['Tags'] as $tag)
            {
                $ec2Instance->m_tags[] = new Tag($tag['Key'], $tag['Value']);
            }
        }
        
        
        // These items were not in the request for RunInstances, however they may be in the
        // request for spot instances?
        $ec2Instance->m_instance_lifecycle          = @$item['instanceLifecycle'];
        $ec2Instance->m_spot_instance_request_id    = @$item['spotInstanceRequestId'];
        $ec2Instance->m_tag_set                     = @$item['tagSet']; # this is an object that needs defining.
        $ec2Instance->m_key_name                    = @$item['keyName'];
        $ec2Instance->m_kernel_id                   = @$item['kernelId'];
        $ec2Instance->m_ip_address                  = @$item['ipAddress'];
        
        return $ec2Instance;
    }
    
    
    /**
     * Terminate the instance
     * @param \iRAP\Ec2Wrapper\Ec2Client $client
     * @return \iRAP\Ec2Wrapper\Responses\TerminateInstanceResponse
     */
    public function terminate(\iRAP\Ec2Wrapper\Ec2Client $client) : \iRAP\Ec2Wrapper\Responses\TerminateInstanceResponse
    {
        $terminationRequest = new \iRAP\Ec2Wrapper\Requests\RequestTerminateInstance($this->getInstanceId());
        return $client->terminateInstances($terminationRequest);
    }
    
    
    /**
     * Get the name a human assigned to the instance (through tags).
     * There may not be a name, in which case will return ""
     */
    public function getName() : string
    {
        $name = "";
        
        if (count($this->m_tags) > 0)
        {
            foreach ($this->m_tags as $tag)
            {
                /* @var $tag Tag */
                if ($tag->getKey() === "Name")
                {
                    $name = $tag->getValue();
                    break;
                }
            }
        }
        
        return $name;
    }
    
    
    # Direct Accessors
    public function getInstanceId()     { return $this->m_instance_id; }
    public function getStateString()    { return $this->m_instance_state_name; }
    public function getDeploymentTime() { return $this->m_launch_time; }
    public function getTags()           { return $this->m_tags; }
    
    
    # These accessors may not have a value.
    public function getSpotInstanceRequestId() { return $this->m_spot_instance_request_id; }
}

