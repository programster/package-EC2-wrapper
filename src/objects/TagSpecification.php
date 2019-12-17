<?php

/* 
 * This class is based upon:
 * http://docs.aws.amazon.com/AWSSDKforPHP/latest/#m=AmazonEC2/request_spot_instances
 * but as you can see the documentation is not finished, making it hard to complete this.
 */

namespace Programster\Ec2Wrapper\Objects;

class TagSpecification
{
    private $m_resourceType; # no idea what this is yet
    private $m_tags; # no idea what this is yet.
    
    public function __construct(\Programster\Ec2Wrapper\Enums\ResourceType $type, Tag ...$tags) 
    {
        if (count($tags) === 0)
        {
            throw new \Exception("Cannot create tag specfication with no tags.");
        }
        
        $this->m_resourceType = $type;
        $this->m_tags = $tags;
    }
    
    
    public function toArray()
    {
        $tagsArray = array();
        
        foreach ($this->m_tags as $tag)
        {
            $tagsArray[] = $tag->toArray();
        }
        
        return array(
            'ResourceType'  => (string) $this->m_resourceType,
            'Tags' => $tagsArray
        );
    }
}