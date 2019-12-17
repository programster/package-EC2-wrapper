<?php

namespace Programster\Ec2Wrapper\Enums;

/* 
 * An object to represent the type of an EC2 Instance. 
 * Refer to https://aws.amazon.com/ec2/pricing/on-demand/
 */

class Ec2InstanceType
{
    private $m_instanceType;
    
    
    /**
     * Create a micro instance. This is the only instance whereby the amount of compute capability
     * is not guaranteed, and is also the only instance that is available for free/trial.
     * @param void
     * @return Ec2InstanceType
     */
    public static function createT1() : Ec2InstanceType
    {
        $ec2InstanceType = new Ec2InstanceType('t1.micro');
        return $ec2InstanceType;
    }
    
    
    /**
     * Create a t2 (burstable) intance
     * @param int $size - int between 1 and 4 with 1 being the smallest size for t2.micro.
     * @return Ec2InstanceType
     */
    public static function createT2(int $size) : Ec2InstanceType
    {
        if ($size > 7 || $size < 1)
        {
            throw new \Exception("Invalid size specified.");
        }
        
        $sizeMap = array(
            1 => 't2.nano',
            2 => 't2.micro',
            3 => 't2.small',
            4 => 't2.medium',
            5 => 't2.large',
            6 => 't2.xlarge',
            7 => 't2.2xlarge',
        );
        
        $ec2InstanceType = $sizeMap[$size];
        return new Ec2InstanceType($ec2InstanceType);
    }
    
    
    /**
     * Create one of the new general purpose Instances.
     * @param int $size - integer between 1 - 6 representing the size of the instance
     *  1 -  2 vcpu   8 ECU,   8 GiB Ram
     *  2 -  4 vcpu  16 ECU   16 GiB Ram
     *  3 -  8 vcpu  31 ECU   31 GiB Ram
     *  4 - 16 vcpu  60 ECU   64 GiB Ram
     *  5 - 48 vcpu 173 ECU  192 GiB Ram
     *  6 - 96 vcpu 345 ECU  384 GiB Ram
     * 
     * @param bool $addNvme - whether to deploy an instance with local nvme storate (m5d)
     * @return \Programster\Ec2Wrapper\Enums\Ec2InstanceType
     * @throws \Exception if size is not within range.
     */
    public static function createGeneralPurposeNew($size, bool $addNvme) : Ec2InstanceType
    {
        if ($addNvme)
        {
            switch ($size)
            {        
                case 1:
                {
                    $ec2InstanceType = new Ec2InstanceType('m5d.large');
                }
                break;
                
                case 2:
                {
                    $ec2InstanceType = new Ec2InstanceType('m5d.xlarge');
                }
                break;
                
                case 3:
                {
                    $ec2InstanceType = new Ec2InstanceType('m5d.2xlarge');
                }
                break;
                
                case 4:
                {
                    $ec2InstanceType = new Ec2InstanceType('m5d.4xlarge');
                }
                break;
                
                case 5:
                {
                    $ec2InstanceType = new Ec2InstanceType('m5d.12xlarge');
                }
                break;
                
                case 6:
                {
                    $ec2InstanceType = new Ec2InstanceType('m5d.24xlarge');
                }
                break;
                
                default:
                {
                    $err_msg = 'createGeneralPurpose - Unrecognized size: ' . $size . '. Please ' .
                               'provide a value between 1 and 5';
                    
                    throw new \Exception($err_msg);
                }
            }
        }
        else
        {
            switch ($size)
            {        
                case 1:
                {
                    $ec2InstanceType = new Ec2InstanceType('m5.large');
                }
                break;
                
                case 2:
                {
                    $ec2InstanceType = new Ec2InstanceType('m5.xlarge');
                }
                break;
                
                case 3:
                {
                    $ec2InstanceType = new Ec2InstanceType('m5.2xlarge');
                }
                break;
                
                case 4:
                {
                    $ec2InstanceType = new Ec2InstanceType('m5.4xlarge');
                }
                break;
                
                case 5:
                {
                    $ec2InstanceType = new Ec2InstanceType('m5.12xlarge');
                }
                break;
                
                case 6:
                {
                    $ec2InstanceType = new Ec2InstanceType('m5.24xlarge');
                }
                break;
                
                default:
                {
                    $err_msg = 'createGeneralPurpose - Unrecognized size: ' . $size . '. Please ' .
                               'provide a value between 1 and 5';
                    
                    throw new \Exception($err_msg);
                }
            }
        }
        
        
        return $ec2InstanceType;
    }
    
    
    /**
     * Create one of the old general purpose instances.
     * @param int $size - int between 1 and 4 representing the size of instance (1 being smallest)
     *                    1 - m4 large
     *                    2 - m4 xlarge
     *                    3 - m4 2xlarge
     *                    4 - m4 4xlarge
     *                    5 - m4 10xlarge
     *                    6 - m4 16xlarge
     * @throws Exception if size is not an integer between 1 and 4.
     */
    public static function createGeneralPurposeOld($size) : Ec2InstanceType
    {
        switch ($size)
        {
            case 1:
            {
                $ec2InstanceType = new Ec2InstanceType('m4.large');
            }
            break;
            
            case 2:
            {
                $ec2InstanceType = new Ec2InstanceType('m4.xlarge');
            }
            break;
            
            case 3:
            {
                $ec2InstanceType = new Ec2InstanceType('m4.2xlarge');
            }
            break;
            
            case 4:
            {
                $ec2InstanceType = new Ec2InstanceType('m4.4xlarge');
            }
            break;
            
            case 5:
            {
                $ec2InstanceType = new Ec2InstanceType('m4.10xlarge');
            }
            break;
            
            case 6:
            {
                $ec2InstanceType = new Ec2InstanceType('m4.16xlarge');
            }
            break;
        
            default:
            {
                $err_msg = 'createGeneralPurpose - Unrecognized size: ' . $size . '. Please ' .
                           'provide a value between 1 and 6';
                
                throw new \Exception($err_msg);
            }
        }
    }
    
    
    /**
     * Create an instance that is targetted towards high amounts of RAM (r4 series)
     * @param int $size - the size of the instance with 1 being the smallest and 6 being largest
     *                  1 -  15.25 GiB
     *                  2 -  30.5 GiB
     *                  3 -  61   GiB
     *                  4 - 122   GiB
     *                  5 - 244   GiB
     *                  6 - 488   GiB
     * @throws Exception if size was not a valid number.
     */
    public static function createHighMemory($size) : Ec2InstanceType
    {
        switch ($size)
        {        
            case 1:
            {
                $ec2InstanceType = new Ec2InstanceType('r4.large');
            }
            break;
        
            case 2:
            {
                $ec2InstanceType = new Ec2InstanceType('r4.xlarge');
            }
            break;
            
            case 3:
            {
                $ec2InstanceType = new Ec2InstanceType('r4.2xlarge');
            }
            break;
            
            case 4:
            {
                $ec2InstanceType = new Ec2InstanceType('r4.4xlarge');
            }
            break;
            
            case 5:
            {
                $ec2InstanceType = new Ec2InstanceType('r4.8xlarge');
            }
            break;
        
            case 6:
            {
                $ec2InstanceType = new Ec2InstanceType('r4.16xlarge');
            }
            break;
            
            default:
            {
                $err_msg = 'createHighMemory - Unrecognized size: ' . $size . '. Please ' .
                           'provide a value between 1 and 6';
                
                throw new \Exception($err_msg);
            }
        }
    }
    
    
    /**
     * Create one of the new Compute optimized instances. (e.g. c3 family)
     * @param int $size - integer between 1-5 to represent the size of the instance with 1 being
     *                    the smallest, and 4 being the largest and most expensive.
     *                    Each step in size doubles the compute capability and price.
     * @return \Ec2InstanceType
     * @throws Exception if $size provided was not an allowed value.
     */
    public static function createOldHighCpu($size) : Ec2InstanceType
    {
        switch ($size)
        {
            case 1:
            {
                $ec2InstanceType = new Ec2InstanceType('c4.large');
            }
            break;
            
            case 2:
            {
                $ec2InstanceType = new Ec2InstanceType('c4.xlarge');
            }
            break;
            
            case 3:
            {
                $ec2InstanceType = new Ec2InstanceType('c4.2xlarge');
            }
            break;
            
            case 4:
            {
                $ec2InstanceType = new Ec2InstanceType('c4.4xlarge');
            }
            break;
            
            case 5:
            {
                $ec2InstanceType = new Ec2InstanceType('c4.8xlarge');
            }
            break;
            
            default:
            {
                $err_msg = 'Unrecognized size: ' . $size . '. Please provide a value between ' .
                           '1 and 5';
                
                throw new \Exception($err_msg);
            }
        }
        
        return $ec2InstanceType;
    }
    
    
    /**
     * Create one of the new Compute optimized instances. (e.g. c5 family)
     * @param int $size - integer between 1-6 to represent the size of the instance with 1 being
     *                    the smallest, and 4 being the largest and most expensive.
     *                    Each step in size doubles the compute capability and price.
     * @param bool $includeLocalNvmeStorage - if true, will deploy a c5d instance instead of a c5
     *                                        which is a little more but has local NVME storage.
     * @return \Programster\Ec2Wrapper\Enums\Ec2InstanceType
     * @throws \Exception if $size provided was not an allowed value.
     */
    public static function createNewHighCpu(int $size, bool $includeLocalNvmeStorage) : Ec2InstanceType
    {
        if ($includeLocalNvmeStorage)
        {
            switch ($size)
            {
                case 1:
                {
                    $ec2InstanceType = new Ec2InstanceType('c5d.large');
                }
                break;
                
                case 2:
                {
                    $ec2InstanceType = new Ec2InstanceType('c5d.xlarge');
                }
                break;
                
                case 3:
                {
                    $ec2InstanceType = new Ec2InstanceType('c5d.2xlarge');
                }
                break;
                
                case 4:
                {
                    $ec2InstanceType = new Ec2InstanceType('c5d.4xlarge');
                }
                break;
                
                case 5:
                {
                    $ec2InstanceType = new Ec2InstanceType('c5d.9xlarge');
                }
                break;
                
                case 6:
                {
                    $ec2InstanceType = new Ec2InstanceType('c5d.18xlarge');
                }
                break;
                
                default:
                {
                    $err_msg = 'Unrecognized size: ' . $size . '. Please provide a value between ' .
                               '1 and 6';

                    throw new \Exception($err_msg);
                }
            }
        }
        else
        {
            switch ($size)
            {
                case 1:
                {
                    $ec2InstanceType = new Ec2InstanceType('c4.large');
                }
                break;
                
                case 2:
                {
                    $ec2InstanceType = new Ec2InstanceType('c4.xlarge');
                }
                break;
                
                case 3:
                {
                    $ec2InstanceType = new Ec2InstanceType('c4.2xlarge');
                }
                break;
                
                case 4:
                {
                    $ec2InstanceType = new Ec2InstanceType('c4.4xlarge');
                }
                break;
                
                case 5:
                {
                    $ec2InstanceType = new Ec2InstanceType('c4.8xlarge');
                }
                break;
                
                default:
                {
                    $err_msg = 'Unrecognized size: ' . $size . '. Please provide a value between ' .
                               '1 and 6';
                    
                    throw new \Exception($err_msg);
                }
            }
        }
        
        
        return $ec2InstanceType;
    }
    
    
    /**
     * Create a high IO storage optimized instance (SSD local storage)
     * @param int $size - int between 1 and 4
     */
    public static function createHighIo($size) : Ec2InstanceType
    {
        switch ($size)
        {
            case 1:
            {
                $ec2InstanceType = new Ec2InstanceType('i2.xlarge');
            }
            break;
            
            case 2:
            {
                $ec2InstanceType = new Ec2InstanceType('i2.2xlarge');
            }
            break;
            
            case 3:
            {
                $ec2InstanceType = new Ec2InstanceType('i2.4xlarge');
            }
            break;
            
            case 4:
            {
                $ec2InstanceType = new Ec2InstanceType('i2.8xlarge');
            }
            break;
            
            default:
            {
                $err_msg = 'Unrecognized size: ' . $size . '. Please provide a value between ' .
                           '1 and 4';
                
                throw new \Exception($err_msg);
            }
        }
        
        return $ec2InstanceType;
    }
    
    
    
    /**
     * Allows the user to create one of this object from passing a string which is validated.
     * @param String $size - the size of the instance in Amazon string form.
     * @return Ec2InstanceType
     * @throws Exception if an unrecognized size/type is given.
     */
    public static function createFromString($size) : Ec2InstanceType
    {
        $allowedTypes = array(
            't1.micro',
            
            # burstable
            't2.micro',
            't2.small',
            't2.medium',
            't2.large',
            't2.xlarge',
            't2.2xlarge',
            
            'm1.small',
            'm1.medium',
            'm1.large',
            'm1.xlarge',
            
            // High Memory
            'r4.large',
            'r4.xlarge',
            'r4.2xlarge',
            'r4.4xlarge',
            'r4.8xlarge',
            'r4.16xlarge',
            
            // general purpose
            'm2.xlarge',
            'm2.2xlarge',
            'm2.4xlarge',
            'm3.xlarge',
            'm3.4xlarge',
            
            'm4.large',
            'm4.xlarge',
            'm4.2xlarge',
            'm4.4xlarge',
            'm4.10xlarge',
            'm4.16xlarge',
            
            'm5.large',
            'm5.xlarge',
            'm5.2xlarge',
            'm5.4xlarge',
            'm5.12xlarge',
            'm5.24xlarge',
            
            'm5d.large',
            'm5d.xlarge',
            'm5d.2xlarge',
            'm5d.4xlarge',
            'm5d.12xlarge',
            'm5d.24xlarge',
            
            // High CPU
            'c3.large',
            'c3.xlarge',
            'c3.2xlarge',
            'c3.4xlarge',
            'c3.8xlarge',
            
            'c4.large',
            'c4.xlarge',
            'c4.2xlarge',
            'c4.4xlarge',
            'c4.8xlarge',
            
            'c5.large',
            'c5.xlarge',
            'c5.2xlarge',
            'c5.4xlarge',
            'c5.9xlarge',
            'c5.18xlarge',
            
            'c5d.large',
            'c5d.xlarge',
            'c5d.2xlarge',
            'c5d.4xlarge',
            'c5d.9xlarge',
            'c5d.18xlarge',
            
            // istorage optimized
            'i2.xlarge',
            'i2.2xlarge',
            'i2.4xlarge',
            'i2.8xlarge',
            
            // High I/O
            'hi1.4xlarge',
            'hs1.8xlarge',
            
            // Cluster
            'cc1.4xlarge',
            'cc2.8xlarge',
            'cg1.4xlarge',
        );
        
        if (!in_array($size, $allowedTypes))
        {
            throw new \Exception('Invalid instance size: [' . $size . ']');
        }
        
        return new Ec2InstanceType($size);
    }
    
    
    private function __construct($instanceType)
    {
        $this->m_instanceType = $instanceType;
    }
    
    
    /**
     * Define the toString method so we can place this object directly in calls without using a 
     * method.
     * @return String - the instanceType.
     */
    public function __toString() 
    {
        return $this->m_instanceType;
    }
}
