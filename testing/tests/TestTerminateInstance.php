<?php


class TestTerminateInstance extends AbstractTest
{
    public function getDescription(): string 
    {
        return "Test that we can terminate an EC2 instance.";
    }
    
    
    public function run(\Programster\Ec2Wrapper\Ec2Client $ec2client)
    {
        $ec2Instance1 = TestHelper::createEc2Instance($ec2client);
        $terminationResponse = $ec2Instance1->terminate($ec2client);
    }
}