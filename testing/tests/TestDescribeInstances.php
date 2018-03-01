<?php

class TestDescribeInstances extends AbstractTest
{
    public function run(\iRAP\Ec2Wrapper\Ec2Client $ec2client) 
    {
        $ec2Instance1 = TestHelper::createEc2Instance($ec2client);
        $ec2Instance2 = TestHelper::createEc2Instance($ec2client);
        
        try 
        {
            $response = $ec2client->describeInstances();
            $instances = $response->getEc2Instances();
            print "described instances: " . print_r($instances, true);
        } 
        finally 
        {
            $ec2Instance1->terminate($ec2client);
            $ec2Instance2->terminate($ec2client);
        }
    }
}

