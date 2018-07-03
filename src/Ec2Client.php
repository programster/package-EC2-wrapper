<?php

/* 
 * Client for interfacing with AWS Ec2
 * You may find this useful:
 * http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-ec2-2015-04-15.html
 */

namespace iRAP\Ec2Wrapper;

class Ec2Client
{
    private $m_client;
    
    public function __construct(string $apiKey, string $apiSecret, \iRAP\Ec2Wrapper\Enums\AwsRegion $region)
    {
        $credentials = array(
            'key'    => $apiKey,
            'secret' => $apiSecret
        );
        
        $params = array(
            'credentials' => $credentials,
            'version'     => '2016-11-15',
            'region'      => (string) $region,
        );
        
        $this->m_client = new \Aws\Ec2\Ec2Client($params);
    }
    
    
    /**
     * Creates an Amazon EBS-backed AMI from an Amazon EBS-backed instance that is either running 
     * or stopped. If you customized your instance with instance store volumes or EBS volumes 
     * in addition to the root device volume, the new AMI contains block device mapping 
     * information for those volumes. When you launch an instance from this new AMI, the 
     * instance automatically launches with those additional volumes.
     * https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-ec2-2016-11-15.html#createimage
     */
    public function createImage(string $instanceID, string $imageName, string $description, bool $noReboot) : Responses\CreateImageResponse
    {
        if (strlen($imageName) > 128)
        {
            throw new Exception("{$imageName} is too long for the name of an image.");
        }
        
        if (strlen($imageName) < 3)
        {
            throw new Exception("{$imageName} is too short for the name of an image.");
        }
        
        /* @todo validate $imagename. Can only contain letters, numbers, and the following special chars ( ) . - / and _ */
        
        $request = new Requests\RequestCreateImage(
            $instanceID, 
            $imageName, 
            $description, 
            $noReboot
        );
        
        return $request->send($this->m_client);
    }
    
    
    /**
     * Describe the specified instances, or get info on all instances if no instance IDs are provided.
     * @param array $instanceIds - array of instance IDs to describe. If empty all instances returned.
     * http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-ec2-2015-04-15.html#describeinstances
     * @return \iRAP\Ec2Wrapper\Responses\DescribeInstancesResponse
     */
    public function describeInstances(array $instanceIds=array()) : Responses\DescribeInstancesResponse
    {
        $request = new Requests\RequestDescribeInstances($instanceIds);
        return $request->send($this->m_client);
    }
    
    
    /**
     * Launch some on demand instances (fixed price).
     * http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-ec2-2015-04-15.html#runinstances
     */
    public function runInstances(Requests\RequestRunInstances $request) : Responses\LaunchInstancesResponse
    {
        return $request->send($this->m_client);        
    }
    
    
    /**
     * Alias for runInstances() 
     * Launch some on demand instances (fixed price).
     * @param \iRAP\Ec2Wrapper\Requests\RequestRunInstances $request
     * @return type
     */
    public function deployInstances(Requests\RequestRunInstances $request) : Responses\LaunchInstancesResponse
    {
        return $this->runInstances($request);
    }
    
    
    /**
     * Alias for runInstances() 
     * Launch some on demand instances (fixed price).
     * @param \iRAP\Ec2Wrapper\Requests\RequestRunInstances $request
     * @return type
     */
    public function launchInstances(Requests\RequestRunInstances $request) : Responses\LaunchInstancesResponse
    {
        return $this->runInstances($request);
    }
    
    
    /**
     * Alias for RunInstances
     */
    public function requestOnDemandInstances(Requests\RequestRunInstances $request) : Responses\LaunchInstancesResponse
    {
        return $this->runInstances($request);
    }
    
    
    /**
     * Send a request to start some stopped instances.
     * @param \iRAP\Ec2Wrapper\Requests\RequestStartInstances $request
     * @return \iRAP\Ec2Wrapper\Responses\StartInstancesResponse
     */
    public function startInstances(Requests\RequestStartInstances $request) : Responses\StartInstancesResponse
    {
        return $request->send($this->m_client);
    }
    
    
    /**
     * Send a request to stop some EC2 instances.
     * Refer to https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-ec2-2016-11-15.html#stopinstances
     * @param \iRAP\Ec2Wrapper\Requests\RequestStopInstances $request
     * @return \iRAP\Ec2Wrapper\Responses\StopInstancesResponse
     */
    public function stopInstances(Requests\RequestStopInstances $request) : Responses\StopInstancesResponse
    {
        return $request->send($this->m_client);
    }
    
    
    /**
     * Send a request to terminate instances.
     * http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-ec2-2015-04-15.html#terminateinstances
     * @param \iRAP\Ec2Wrapper\Requests\RequestTerminateInstance $request
     * @return \Aws\Result
     */
    public function terminateInstances(\iRAP\Ec2Wrapper\Requests\RequestTerminateInstance $request)
    {
        return $request->send($this->m_client);
    }
}