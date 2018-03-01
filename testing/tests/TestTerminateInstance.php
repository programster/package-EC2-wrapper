<?php


class TestTerminateInstance extends AbstractTest
{
    public function run(\iRAP\Ec2Wrapper\Ec2Client $ec2client)
    {
        $ec2Instance1 = TestHelper::createEc2Instance($ec2client);
        $terminationResponse = $ec2Instance1->terminate($ec2client);
    }
}