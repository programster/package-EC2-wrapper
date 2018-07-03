<?php

/* 
 * Abstract class all tests should extend.
 */

abstract class AbstractTest
{
    protected $m_passed = false;
    
    abstract public function run(\iRAP\Ec2Wrapper\Ec2Client $ec2client);
    public function getPassed() { return $this->m_passed; }
}