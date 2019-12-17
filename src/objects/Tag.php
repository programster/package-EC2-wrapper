<?php

/* 
 * A tag object that goes within a TagSpecification.
 */

namespace Programster\Ec2Wrapper\Objects;

class Tag
{
    private $m_key;
    private $m_value;
    
    
    /**
     * Create a tag
     * @param string $key - the name/key for the tag
     * @param string $value - the value for the tag.
     */
    public function __construct(string $key, string $value)
    {
        $this->m_key = $key;
        $this->m_value = $value;
    }
    
    
    public function toArray()
    {
        return array(
            'Key' => $this->m_key,
            'Value' => $this->m_value
        );
    }
    
    
    # Accessors
    public function getKey(): string { return $this->m_key; }
    public function getValue() { return $this->m_value; }
}