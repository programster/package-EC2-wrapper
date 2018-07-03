<?php

/* 
 * A response for a start instances request
 */

namespace iRAP\Ec2Wrapper\Responses;

class StartInstancesResponse extends AbstractResponse
{
    private $m_startingInstancesIds;
    
    
    public function __construct($rawAmazonResponse)
    {
        parent::__construct();
        
        /* @var $rawAmazonResponse \Aws\Result */
        $ec2InstanceStdObjs = $rawAmazonResponse->get('StartingInstances');
        
        foreach ($ec2InstanceStdObjs as $ec2StdObj)
        {
            $this->m_instances[] = $ec2StdObj['InstanceId'];
        }
        
        return $rawAmazonResponse;
    }
    
    
    # Accessors
    public function getEc2InstanceIds() { return $this->m_startingInstancesIds; }
}



/*
 * Example response

{
    "StartingInstances": [
        {
            "CurrentState": {
                "Code": 0,
                "Name": "pending"
            },
            "InstanceId": "i-02033a686c07a1621",
            "PreviousState": {
                "Code": 80,
                "Name": "stopped"
            }
        }
    ],
    "@metadata": {
        "statusCode": 200,
        "effectiveUri": "https:\/\/ec2.eu-west-1.amazonaws.com",
        "headers": {
            "content-type": "text\/xml;charset=UTF-8",
            "content-length": "579",
            "date": "Tue, 03 Jul 2018 14:39:51 GMT",
            "server": "AmazonEC2",
            "connection": "close"
        },
        "transferStats": {
            "http": [
                []
            ]
        }
    }
}

 * 
 */