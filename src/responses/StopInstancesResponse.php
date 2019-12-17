<?php

/* 
 * A response for a stop instances request.
 */

namespace Programster\Ec2Wrapper\Responses;

class StopInstancesResponse extends AbstractResponse
{
    private $m_instances;
    
    
    public function __construct($rawAmazonResponse)
    {
        parent::__construct();
        
        /* @var $rawAmazonResponse \Aws\Result */
        $ec2InstanceStdObjs = $rawAmazonResponse->get('StoppingInstances');
        
        foreach ($ec2InstanceStdObjs as $ec2StdObj)
        {
            $this->m_instances[] = $ec2StdObj['InstanceId'];
        }
        
        return $rawAmazonResponse;
    }
    
    
    # Accessors
    public function getEc2InstanceIds() { return $this->m_instances; }
}



/*
 * Example response

{
    "StoppingInstances": [
        {
            "CurrentState": {
                "Code": 64,
                "Name": "stopping"
            },
            "InstanceId": "i-0213d34f2759f697d",
            "PreviousState": {
                "Code": 16,
                "Name": "running"
            }
        }
    ],
    "@metadata": {
        "statusCode": 200,
        "effectiveUri": "https:\/\/ec2.eu-west-1.amazonaws.com",
        "headers": {
            "content-type": "text\/xml;charset=UTF-8",
            "content-length": "579",
            "date": "Tue, 03 Jul 2018 13:53:42 GMT",
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

 */