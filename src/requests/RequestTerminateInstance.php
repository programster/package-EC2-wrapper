<?php

namespace iRAP\Ec2Wrapper\Requests;

/* 
 * A request to terminate a single or multiple instances.
 */

class RequestTerminateInstance extends Ec2RequestAbstract
{
    private $m_instance_ids = array();
    
    
    /**
     * Create a request to terminate one or more ec2 instances.
     * @param AmazonRegion $region - the region the instances are located in.
     * @param mixed $instance_ids - a single instance id or an array of instance ids
     */
    public function __construct($instance_ids)
    {        
        if (is_array($instance_ids))
        {
            $this->m_instance_ids = $instance_ids;
        }
        else
        {
            if (!is_string($instance_ids) || $instance_ids == '')
            {
                $errMsg = 'TerminateInstanceRequest: instance_ids needs to be an array of ' .
                          'instance ids or a string representing a single instance id.';
                throw new \Exception($errMsg);
            }
            
            $this->m_instance_ids[] = $instance_ids;
        }
        
    }
    
    
    protected function getOptionsArray()
    {
        return array(
            'InstanceIds' => $this->m_instance_ids
        );
    }
    
    
    /**
     * Add another instance to list of instances to terminate.
     * @param type $instance_id - the unique ID of the instance we wish to terminate.
     */
    public function add_instance($instance_id)
    {
        $this->m_instance_ids[] = $instance_id;
    }
    
    
    protected function sendRequest(\Aws\Ec2\Ec2Client $ec2, array $opt)
    {
        $response = $ec2->terminateInstances($opt);
        return $response;
    }
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

*/

