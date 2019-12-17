<?php

/* 
 * Object to request the creation of an AMI image of an EC2 instance.
 */


namespace Programster\Ec2Wrapper\Requests;

class RequestCreateImage extends AbstractEc2Request
{
    private $m_noReboot;
    private $m_imageName;
    private $m_description;
    private $m_instanceID;
    private $m_blockDevices = array();
    
    
    /**
     * Create a request for cancelling spot instances.
     * @param AmazonRegion $region - the region the spot requests were made to.
     * @param mixed $spot_request_id - a single spot request id, or an array list of spot request ids.
     */
    public function __construct(string $instanceID, string $imageName, string $description, bool $noReboot)
    {
        $this->m_instanceID = $instanceID;
        $this->m_imageName = $imageName;
        $this->m_description = $description;
        $this->m_noReboot = $noReboot;
    }
    
    
    /**
     * Optionally specify the block devices that you want in the AMI. 
     * Without this, we will just snapshot all block devices.
     * @param \Programster\Ec2Wrapper\Objects\BlockDevice $blockDevice
     */
    public function addBlockDevice(\Programster\Ec2Wrapper\Objects\BlockDevice $blockDevice)
    {
        $this->m_blockDevices = $blockDevice;
    }
    
    
    /**
     * There are no options that we need to add. The generic ones such as curlopt are added by 
     * parent 
     * @return Array - all the options array parameters for cancel_spot_instance_requests.
     */
    protected function getOptionsArray()
    {
        $options = array(
            'Description' => $this->m_description,
            'DryRun' => false,
            'InstanceId' => $this->m_instanceID,
            'Name' => $this->m_imageName,
            'NoReboot' => $this->m_noReboot,
        );
        
        if (count($this->m_blockDevices) > 0)
        {
            $options['BlockDeviceMappings'] = array();
            
            foreach ($this->m_blockDevices as $blockDevice)
            {
                /* @var $blockDevice Programster\Ec2Wrapper\Objects\BlockDevice */
                $options['BlockDeviceMappings'][] = $blockDevice->toArray();
            }
        }
        
        return $options;
    }
    
    
    protected function sendRequest(\Aws\Ec2\Ec2Client $ec2, array $opt) : \Programster\Ec2Wrapper\Responses\AbstractResponse
    {
        try
        {
            $rawResponse = $ec2->createImage($opt);
        } 
        catch (\Aws\Ec2\Exception\Ec2Exception $ex) 
        {
            return \Programster\Ec2Wrapper\Responses\CreateImageResponse::createFromException($ex);
        }
        
        return new \Programster\Ec2Wrapper\Responses\CreateImageResponse($rawResponse);
    }
}