<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Programster\Ec2Wrapper\Responses;

class AbstractResponse
{
    protected $m_wasSuccess = false;
    
    
    public function __construct()
    {
        $this->m_wasSuccess = true;
    }
    
    public static function createFromException(Exception $e)
    {
        $this->m_wasSuccess = false;
    }
    
    
    public function wasSuccessful() { return $this->m_wasSuccess; }
}

