<?php

class TestCreateImage extends AbstractTest
{
    public function getDescription(): string 
    {
        return "Test the creating of an AMI for an ec2 instance.";
    }
    
    
    public function run(\iRAP\Ec2Wrapper\Ec2Client $ec2client) 
    {
        $ec2Instance = TestHelper::createEc2Instance($ec2client);
        $imageName = time() . '-TestImage';
        
        print "sending request to create an image of the spawned instance ({$imageName})." . PHP_EOL;
        
        try 
        {
            $response = $ec2client->createImage(
                $ec2Instance->getInstanceId(), 
                $imageName, 
                "This is a test of image creation", 
                $noReboot=true
            );
            
            $response->getImageID();
        } 
        finally 
        {
            // delete our spawned instance no matter what
            $ec2Instance->terminate($ec2client);
        }
    }
}
