<?php

class DescribeInstancesTest extends AbstractTest
{
    public function run(\iRAP\Ec2Wrapper\Ec2Client $ec2client) 
    {
        $request = new iRAP\Ec2Wrapper\Requests\RequestDescribeInstances(iRAP\Ec2Wrapper\Enums\AwsRegion::create_EU_W1());
        $response = $ec2client->describeInstances($request);
        var_dump($response);
    }
}

