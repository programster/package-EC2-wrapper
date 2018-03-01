AWS EC2 Wrapper for PHP
========================

This package wraps around Amazon's SDK for EC2 to provide a more object-orientated interface. 
Thus the developer will spend less time looking up the parameters they can pass into an array.
This version of the wrapper is based on [version 3 of the SDK](https://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Ec2.Ec2Client.html).

## Example Usage

```php
<?php 

require_once(__DIR__ . '/vendor/autoload.php');

// create the ec2 client.
$ec2Client = new iRAP\Ec2Wrapper\Ec2Client(
    'myApiKey', 
    'myApiSecret', 
    \iRAP\Ec2Wrapper\Enums\AwsRegion::create_EU_W1()
);

$ubuntuImage = 'ami-cc166eb5';

$launchSpec = new \iRAP\Ec2Wrapper\Objects\LaunchSpecification(
    \iRAP\Ec2Wrapper\Enums\Ec2InstanceType::createT2($size=1),  // 1 = nano
    $ubuntuImage,
    "Name for my instance"
);

// launch 3 instances
$request = new iRAP\Ec2Wrapper\Requests\RequestRunInstances($launchSpec, 3, 3); 
$launchResponse = $ec2client->launchInstances($request);

// get info on the instances we launched.
$launchedInstances = $launchResponse->getEc2Instances();

// Get all of our running instances...
$response = $ec2client->describeInstances();
$instances = $response->getEc2Instances();

// ...and terminate them.
foreach ($instances as $instance)
{
    /* @var $instance \iRAP\Ec2Wrapper\Objects\Ec2Instance */
    $instance->terminate($ec2client);
}
```