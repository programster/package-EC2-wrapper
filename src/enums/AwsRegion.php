<?php

namespace iRAP\Ec2Wrapper\Enums;

/* 
 * This is an 'enum' representing the regions in amazon.
 */

class AwsRegion
{
    private $m_region = null;
    
    
    # Define the constants for easily specifying regions.
    public static function create_US_E1()
    {
        $region = new AwsRegion('us-east-1');
        return $region;
    }
    
    public static function create_virginia()
    {
        return self::create_US_E1();
    }
    
    public static function create_US_W1()
    {
        $region = new AwsRegion('us-west-1');
        return $region;
    }
    
    public static function create_california()
    {
        return self::create_US_W1();
    }
    
    public static function create_US_W2()
    {
        $region = new AwsRegion('us-west-2');
        return $region;
    }
    
    public static function create_oregon()
    {
        return self::create_US_W2();
    }
    
    public static function create_EU_W1()
    {
        $region = new AwsRegion('eu-west-1');
        return $region;
    }
    
    public static function create_ireland()
    {
        return self::create_EU_W1();
    }
    
    public static function create_EU_W2()  { return new AwsRegion('eu-west-2'); }
    public static function create_london() { return self::create_EU_W2(); }
    public static function create_EU_W3()  { return new AwsRegion('eu-west-3'); }
    public static function create_paris()  { return self::create_EU_W3(); }
    
    public static function create_APAC_SE1()
    {
        $region = new AwsRegion('ap-southeast-1');
        return $region;
    }
    
    public static function create_singapore()
    {
        return self::create_APAC_SE1();
    }
    
    public static function create_APAC_SE2()
    {
        $region = new AwsRegion('ap-southeast-2');
        return $region;
    }
    
    public static function create_sydney()
    {
        return self::create_APAC_SE2();
    }
    
    public static function create_APAC_NE1()
    {
        $region = new AwsRegion('ap-northeast-1');
        return $region;
    }
    
    public static function create_tokyo()
    {
        return self::create_APAC_NE1();
    }
    
    public static function create_US_GOV1()
    {
        $region = new AwsRegion('us-gov-west-1');
        return $region;
    }
    
    public static function create_SA_E1()
    {
        $region = new AwsRegion('sa-east-1');
        return $region;
    }
    
    public static function create_sao_paulo()
    {
        return self::create_SA_E1();
    }
    
    
    public static function create_from_string($regionString)
    {
        $regionString = strtolower($regionString);
        
        $allowedRegions = array(
            'sa-east-1',
            'us-gov-west-1',
            'ap-northeast-1',
            'ap-southeast-2',
            'ap-southeast-1',
            'eu-west-1',
            'us-west-2',
            'us-east-1'
        );
        
        if (!in_array($regionString, $allowedRegions))
        {
            throw new \Exception('Invalid region specified: ' . $regionString);
        }
        
        $regionObj = new AwsRegion($regionString);
        return $regionObj;
    }
    
    
    private function __construct($region)
    {
        $this->m_region = $region;
    }
    
    
    public function __toString() 
    {
        return $this->m_region;
    }
}
