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
    private $m_state;
    private $m_private_dns_name;
    private $m_dns_name;
    private $m_state_transition_reason;
    private $m_state_reason_code;
    private $m_state_reason_message;
    private $m_key_name;
    private $m_ami_launch_index;
    private $m_product_codes;
    private $m_instance_type; # # e.g. t1.micro
    private $m_launch_time; # unix timestamp when ec2 instance deployed, not when started from stop
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
     * Create an ec2Instance object for the provided ID.
     * WARNING - this will run a request to describe the instance so it can be slow/sub-optimal
     * @param string $id
     */
    public static function createFromID(string $id, \iRAP\Ec2Wrapper\Ec2Client $client) : Ec2Instance
    {
        $response = $client->describeInstances(array($id));
        $instances = $response->getEc2Instances();
        
        if (count($instances) !== 1)
        {
            throw new Exception("Failed to load Ec2 instance: $id");
        }
        
        return \iRAP\CoreLibs\ArrayLib::getFirstElement($instances);
    }
    
    
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
        $ec2Instance->m_state                       = new \iRAP\Ec2Wrapper\Enums\Ec2State($item['State']['Name']); # e.g. running
        $ec2Instance->m_private_dns_name            = $item['PrivateDnsName'];
        $ec2Instance->m_dns_name                    = $item['PublicDnsName'];
        $ec2Instance->m_state_transition_reason     = $item['StateTransitionReason']; #unknown object
        $ec2Instance->m_ami_launch_index            = intval($item['AmiLaunchIndex']);
        
        
        $ec2Instance->m_product_codes = $item['ProductCodes']; # array of something (empty in example given)
        $ec2Instance->m_instance_type = $item['InstanceType']; // e.g. "t2.micro"
        
        # It's odd, but the LaunchTime objects attributes are all lowercase unlike everything else.
        $ec2Instance->m_launch_time = strtotime((string)$item['LaunchTime']); # 2015-09-18 13:48:08
        
        $ec2Instance->m_placement = \iRAP\Ec2Wrapper\Objects\Placement::createFromAwsApi($item['Placement']);
        
        $ec2Instance->m_monitoring_state = $item['Monitoring']['State']; # e.g. "disabled"
        
        if (isset($item['SubnetId']))
        {
            $ec2Instance->m_subnet_id = $item['SubnetId']; # e.g. "subnet-f7b4479d"
        }
        
        if (isset($item['VpcId']))
        {
            $ec2Instance->m_vpc_id = $item['VpcId']; # e.g. vpc-f6b4479c"
        }
        
        if (isset($item['PrivateIpAddress']))
        {
            $ec2Instance->m_private_ip_address = $item['PrivateIpAddress']; # "172.31.33.19"
        }
        
        if (isset($item['StateReason']))
        {
            $ec2Instance->m_state_reason_code = $item['StateReason']['Code']; # "pending"
            $ec2Instance->m_state_reason_message = $item['StateReason']['Message']; # "pending"
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
            $ec2Instance->m_source_dest_check = $item['SourceDestCheck']; # boolean value
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
        $ec2Instance->m_instance_lifecycle       = self::setIfSet($item, 'instanceLifecycle', null);
        $ec2Instance->m_spot_instance_request_id = self::setIfSet($item, 'spotInstanceRequestId', null);
        $ec2Instance->m_tag_set                  = self::setIfSet($item, 'tagSet', null); # this is an object that needs defining.
        $ec2Instance->m_key_name                 = self::setIfSet($item, 'keyName', null);
        $ec2Instance->m_kernel_id                = self::setIfSet($item, 'kernelId', null);
        $ec2Instance->m_ip_address               = self::setIfSet($item, 'ipAddress', null);
        
        return $ec2Instance;
    }
    
    
    /**
     * Helper function just to prevent undefined index warnings.
     * @param array $inputArray - the array to get a value from
     * @param mixed $index - index which may or may not be set in the array
     * @param mixed $default - default value to return if not set
     * @return mixed - the value from the array, or the default provided.
     */
    private static function setIfSet(array $inputArray, $index, $default)
    {
        return (isset($inputArray[$index])) ? $inputArray[$index] : $default;
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
     * Stop the instance.
     * @param \iRAP\Ec2Wrapper\Ec2Client $client
     * @param bool $force
     * @return \iRAP\Ec2Wrapper\Responses\StopInstancesResponse
     */
    public function stop(\iRAP\Ec2Wrapper\Ec2Client $client, bool $force) : \iRAP\Ec2Wrapper\Responses\StopInstancesResponse
    {
        $stopRequest = new \iRAP\Ec2Wrapper\Requests\RequestStopInstances(
            array($this->m_instance_id), 
            $force
        );
        
        return $client->stopInstances($stopRequest);
    }
    
    
    /**
     * Start the instance.
     * @param \iRAP\Ec2Wrapper\Ec2Client $client
     * @param bool $force
     * @return \iRAP\Ec2Wrapper\Responses\StopInstancesResponse
     */
    public function start(\iRAP\Ec2Wrapper\Ec2Client $client) : \iRAP\Ec2Wrapper\Responses\StartInstancesResponse
    {
        $startRequest = new \iRAP\Ec2Wrapper\Requests\RequestStopInstances([$this->m_instance_id]);
        return $client->startInstances($startRequest);
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
    
    
    # Accessors
    public function getInstanceId() { return $this->m_instance_id; }
    public function getStateString() : string { return (string) $this->m_state; }
    public function getDeploymentTime() { return $this->m_launch_time; }
    public function getTags()           { return $this->m_tags; }
    
    public function getState() : \iRAP\Ec2Wrapper\Enums\Ec2State 
    { 
        return $this->m_state;    
    }
    
    # These accessors may not have a value.
    public function getSpotInstanceRequestId() { return $this->m_spot_instance_request_id; }
}

