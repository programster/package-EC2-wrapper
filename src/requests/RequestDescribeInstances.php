<?php

namespace Programster\Ec2Wrapper\Requests;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RequestDescribeInstances extends AbstractEc2Request
{
    private $m_filters = null;
    
    
    /**
     * Create a request for fetching information about instances.
     * @param AmazonRegion $region - the region that you want the instances for. Unfortunately it
     *                               is not possible to get instances for all regions in one request
     * @param Array $instance_ids - optionally specify an array of instance ids to describe
     * @return RequestDescribeInstances
     */
    public function __construct(array $instance_ids=array())
    {
        if (is_array($instance_ids))
        {
            $this->m_instance_ids = $instance_ids;
        }
    }
    
    
    protected function getOptionsArray() 
    {
        $options = array();
        
        if ($this->m_filters != null)
        {
            $options['Filters'] = $this->m_filters->toArray();
        }
        
        if (count($this->m_instance_ids) > 0)
        {
            $options['InstanceIds'] = $this->m_instance_ids;
        }
        
        return $options;
    }
    
    
    /**
     * Sends the request to AWS. Note that this function is not public. You need to call "send" 
     * instead which leads to this being called.
     * @param AmazonEC2 $ec2
     * @param array $opt - the optional parameters to be sent.
     * @return CFResponse $response
     */
    protected function sendRequest(\Aws\Ec2\Ec2Client $ec2, array $opt) : \Programster\Ec2Wrapper\Responses\AbstractResponse
    {
        $rawResponse = $ec2->describeInstances($opt);
        return new \Programster\Ec2Wrapper\Responses\DescribeInstancesResponse($rawResponse);
    }
    
    
    /**
     * Add an instance to the list of instance you wish to have described. Note that if you do not
     * use this method at least once, then all instances will be considered.
     * @param String $instanceId - the ID of an instance we wish to have described.
     */
    public function addInstanceID($instanceId)
    {
        $this->m_instance_ids[] = $instanceId;
    }
    
    
    /**
     * Set a filter for the instances we wish to retrieve.
     * @param \Programster\Ec2Wrapper\Objects\AmazonFilter $filter
     * @return void.
     */
    public function set_filter(\Programster\Ec2Wrapper\Objects\AmazonFilter $filter)
    {
        $this->m_filters = $filter;
    }
}

