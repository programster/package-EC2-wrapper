<?php

/* 
 * Abstract class all tests should extend.
 */

abstract class AbstractTest
{
    abstract public function run(\iRAP\Ec2Wrapper\Ec2Client $ec2client);
}