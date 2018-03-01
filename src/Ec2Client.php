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
    public function createImage(Objects\Ec2Instance $instance, string $imageName, string $description, bool $noReboot) : Responses\CreateImageResponse
    {
        $request = new Requests\RequestCreateImage(
            $instance, 
            $imageName, 
            $description, 
            $noReboot
        );
        
        return $request->send($this->m_client);
    }
    
    
    /**
     * http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-ec2-2015-04-15.html#createsnapshot
     */
    public function createSnapshot()
    {
        
    }
    
    
    public function deleteSnapshot()
    {
        
    }
    
    
    public function cancelSpotInstanceRequests()
    {
        
    }
    
    
    /**
     * 
     * http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-ec2-2015-04-15.html#describeinstances
     */
    public function describeInstances(\iRAP\Ec2Wrapper\Requests\RequestDescribeInstances $request) : Responses\DescribeInstancesResponse
    {
        return $request->send($this->m_client);
    }
    
    
    /**
     * Launch some on demand instances (fixed price).
     * http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-ec2-2015-04-15.html#runinstances
     */
    public function runInstances(\iRAP\Ec2Wrapper\Requests\RequestRunInstances $request) : Responses\LaunchInstancesResponse
    {
        return $request->send($this->m_client);        
    }
    
    
    /**
     * Alias for runInstances() 
     * Launch some on demand instances (fixed price).
     * @param \iRAP\Ec2Wrapper\Requests\RequestRunInstances $request
     * @return type
     */
    public function deployInstances(\iRAP\Ec2Wrapper\Requests\RequestRunInstances $request) : Responses\LaunchInstancesResponse
    {
        return $this->runInstances($request);
    }
    
    /**
     * Alias for runInstances() 
     * Launch some on demand instances (fixed price).
     * @param \iRAP\Ec2Wrapper\Requests\RequestRunInstances $request
     * @return type
     */
    public function launchInstances(\iRAP\Ec2Wrapper\Requests\RequestRunInstances $request) : Responses\LaunchInstancesResponse
    {
        return $this->runInstances($request);
    }
    
    
    /**
     * Alias for RunInstances
     */
    public function requestOnDemandInstances()
    {
        $this->runInstances();
    }
    
    
    public function requestSpotInstances()
    {
        
    }
    
    
    public function requestSpotFleet()
    {
        
    }
    
    
    /**
     * http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-ec2-2015-04-15.html#startinstances
     */
    public function startInstances()
    {
        
    }
    
    
    public function stopInstances()
    {
        
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