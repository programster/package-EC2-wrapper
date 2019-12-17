<?php


/* 
 * Class to represent a ResourceType.
 */

namespace Programster\Ec2Wrapper\Enums;

class ResourceType
{
    private $m_type;
    
    
    private function __construct(string $type)
    {
        $this->m_type = $type;
    }
    
    
    public static function createCustomerGateway(){ return new ResourceType('customer-gateway'); }
    public static function createDhcpOptions(){ return new ResourceType('dhcp-options'); }
    public static function createImage(){ return new ResourceType('image'); }
    public static function createInstance(){ return new ResourceType('instance'); }
    public static function createInternetGateway(){ return new ResourceType('internet-gateway'); }
    public static function createNetworkAcl(){ return new ResourceType('network-acl'); }
    public static function createNetworkInterface(){ return new ResourceType('network-interface'); }
    public static function createReservedInstances(){ return new ResourceType('reserved-instances'); }
    public static function createRouteTable() { return new ResourceType('route-table'); }
    public static function createSnapshot() { return new ResourceType('snapshot'); }
    public static function createSpotInstancesRequest() { return new ResourceType('spot-instances-request'); }
    public static function createSubnet() { return new ResourceType('subnet'); }
    public static function createSecurityGroup() { return new ResourceType('security-group'); }
    public static function createVolume() { return new ResourceType('volume'); }
    public static function createVPC() { return new ResourceType('vpc'); }
    public static function createVpnConnection() { return new ResourceType('vpn-connection'); }
    public static function createVpnGateway() { return new ResourceType('vpn-gateway'); }
    
    
    public function __toString(){ return $this->m_type; }
}