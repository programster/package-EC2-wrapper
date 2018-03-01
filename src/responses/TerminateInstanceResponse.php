<?php

/* 
 * A response for a TerminateInstance request.
 */

namespace iRAP\Ec2Wrapper\Responses;

class TerminateInstanceResponse extends AbstractResponse
{
    private $m_terminatingInstanceIds;
    
    
    public function __construct($rawAmazonResponse)
    {
        parent::__construct();
        /* @var $rawAmazonResponse \Aws\Result */
        $ec2InstanceStdObjs = $rawAmazonResponse->get('TerminatingInstances');
        
        foreach ($ec2InstanceStdObjs as $ec2StdObj)
        {
            $this->m_instances[] = $ec2StdObj['InstanceId'];
        }
        
        return $rawAmazonResponse;
    }
    
    
    # Accessors
    public function getEc2InstanceIds() { return $this->m_terminatingInstanceIds; }
}



/*
 * Example response
object(Aws\Result)#123 (1) {
  ["data":"Aws\Result":private]=>
  array(2) {
    ["TerminatingInstances"]=>
    array(2) {
      [0]=>
      array(3) {
        ["InstanceId"]=>
        string(10) "i-cdc6ee6c"
        ["CurrentState"]=>
        array(2) {
          ["Code"]=>
          int(32)
          ["Name"]=>
          string(13) "shutting-down"
        }
        ["PreviousState"]=>
        array(2) {
          ["Code"]=>
          int(16)
          ["Name"]=>
          string(7) "running"
        }
      object(Aws\Result)#123 (1) {
  ["data":"Aws\Result":private]=>
  array(2) {
    ["TerminatingInstances"]=>
    array(2) {
      [0]=>
      array(3) {
        ["InstanceId"]=>
        string(10) "i-cdc6ee6c"
        ["CurrentState"]=>
        array(2) {
          ["Code"]=>
          int(32)
          ["Name"]=>
          string(13) "shutting-down"
        }
        ["PreviousState"]=>
        array(2) {
          ["Code"]=>
          int(16)
          ["Name"]=>
          string(7) "running"
        }
      }
      [1]=>
      array(3) {
        ["InstanceId"]=>
        string(10) "i-1fe5cdbe"
        ["CurrentState"]=>
        array(2) {
          ["Code"]=>
          int(32)
          ["Name"]=>
          string(13) "shutting-down"
        }
        ["PreviousState"]=>
        array(2) {
          ["Code"]=>
          int(16)
          ["Name"]=>
          string(7) "running"
        }
      }
    }
    ["@metadata"]=>
    array(3) {
      ["statusCode"]=>
      int(200)
      ["effectiveUri"]=>
      string(35) "https://ec2.eu-west-1.amazonaws.com"
      ["headers"]=>
      array(5) {
        ["content-type"]=>
        string(22) "text/xml;charset=UTF-8"
        ["transfer-encoding"]=>
        string(7) "chunked"
        ["vary"]=>
        string(15) "Accept-Encoding"
        ["date"]=>
        string(29) "Mon, 21 Sep 2015 13:18:28 GMT"
        ["server"]=>
        string(9) "AmazonEC2"
      }
    }
  }
}
}
      [1]=>
      array(3) {
        ["InstanceId"]=>
        string(10) "i-1fe5cdbe"
        ["CurrentState"]=>
        array(2) {
          ["Code"]=>
          int(32)
          ["Name"]=>
          string(13) "shutting-down"
        }
        ["PreviousState"]=>
        array(2) {
          ["Code"]=>
          int(16)
          ["Name"]=>
          string(7) "running"
        }
      }
    }
    ["@metadata"]=>
    array(3) {
      ["statusCode"]=>
      int(200)
      ["effectiveUri"]=>
      string(35) "https://ec2.eu-west-1.amazonaws.com"
      ["headers"]=>
      array(5) {
        ["content-type"]=>
        string(22) "text/xml;charset=UTF-8"
        ["transfer-encoding"]=>
        string(7) "chunked"
        ["vary"]=>
        string(15) "Accept-Encoding"
        ["date"]=>
        string(29) "Mon, 21 Sep 2015 13:18:28 GMT"
        ["server"]=>
        string(9) "AmazonEC2"
      }
    }
  }
}
 * 
 */