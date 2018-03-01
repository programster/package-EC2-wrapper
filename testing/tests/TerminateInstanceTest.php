<?php


class TerminateInstanceTest extends AbstractTest
{
    public function run(\iRAP\Ec2Wrapper\Ec2Client $ec2client)
    {
        $ubuntuImage = 'ami-47a23a30';
        
        $launchSpecification = new \iRAP\Ec2Wrapper\Objects\LaunchSpecification(
            \iRAP\Ec2Wrapper\Enums\Ec2InstanceType::createT2(1), 
            $ubuntuImage
        );
        
        $request = new iRAP\Ec2Wrapper\Requests\RequestRunInstances($launchSpecification, 1, 1);
        $ec2client->runInstances($request);

        $instances = $request->getSpawnedInstances();

        $terminationRequest = new \iRAP\Ec2Wrapper\Requests\RequestTerminateInstance($instances);
        $response = $ec2client->terminateInstances($terminationRequest);
        var_dump($response);
    }
}


main();