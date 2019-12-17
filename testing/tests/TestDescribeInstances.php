<?php

class TestDescribeInstances extends AbstractTest
{
    public function getDescription(): string 
    {
        return "Test that we can describe the deployed instances.";
    }
    
    
    public function run(\Programster\Ec2Wrapper\Ec2Client $ec2client) 
    {
        $ec2Instance1 = TestHelper::createEc2Instance($ec2client);
        $ec2Instance2 = TestHelper::createEc2Instance($ec2client);
        
        try 
        {
            $response = $ec2client->describeInstances();
            $instances = $response->getEc2Instances();
            
            if (count($instances) == 2)
            {
                $this->m_passed = true;
            }
            else
            {
                $this->m_passed = false;
            }
        } 
        finally 
        {
            $ec2Instance1->terminate($ec2client);
            $ec2Instance2->terminate($ec2client);
        }
    }
}

