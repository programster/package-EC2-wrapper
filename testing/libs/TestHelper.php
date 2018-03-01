<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TestHelper
{
    /**
     * Create an ec2 instance. 
     * Most tests require there to be an instance to terminate/describe/stop etc.
     * @param iRAP\Ec2Wrapper\Ec2Client $ec2client
     * @return \iRAP\Ec2Wrapper\Objects\Ec2Instance
     */
    public static function createEc2Instance(iRAP\Ec2Wrapper\Ec2Client $ec2client) : \iRAP\Ec2Wrapper\Objects\Ec2Instance
    {
        $ubuntuImage = 'ami-cc166eb5';
        
        $launchSpecification = new \iRAP\Ec2Wrapper\Objects\LaunchSpecification(
            \iRAP\Ec2Wrapper\Enums\Ec2InstanceType::createT2(1), 
            $ubuntuImage
        );
        
        $request = new iRAP\Ec2Wrapper\Requests\RequestRunInstances($launchSpecification, 1, 1);
        $response = $ec2client->launchInstances($request);
        $ec2Instances = $response->getEc2Instances();
        $ec2Instance = $ec2Instances[0];
        return $ec2Instance;
    }
}

