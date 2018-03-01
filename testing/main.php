<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/Settings.php');

$apiKey = API_KEY;
$secret = API_SECRET;
$region = \iRAP\Ec2Wrapper\Enums\AwsRegion::create_EU_W1();

#$awsWrapper = new iRAP\Ec2Wrapper\AwsWrapper($apiKey, $secret, $region);
#$ec2Client = $awsWrapper->getEc2Client();