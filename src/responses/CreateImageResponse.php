<?php

/* 
 * A response for a DescribeInstances request.
 */

namespace iRAP\Ec2Wrapper\Responses;

class CreateImageResponse extends AbstractResponse
{
    private $m_imageID;
    
    
    public function __construct($rawAmazonResponse)
    {
        parent::__construct();
        $this->m_imageID = $rawAmazonResponse->get('ImageId');
    }
    
    
    # Accessors
    public function getImageID() { return $this->m_imageID; }
}


/*
 * Example raw response:
 * 
Aws\Result Object
(
    [data:Aws\Result:private] => Array
        (
            [ImageId] => ami-4290d73b
            [@metadata] => Array
                (
                    [statusCode] => 200
                    [effectiveUri] => https://ec2.eu-west-1.amazonaws.com
                    [headers] => Array
                        (
                            [content-type] => text/xml;charset=UTF-8
                            [transfer-encoding] => chunked
                            [vary] => Accept-Encoding
                            [date] => Thu, 01 Mar 2018 20:00:42 GMT
                            [server] => AmazonEC2
                        )

                    [transferStats] => Array
                        (
                            [http] => Array
                                (
                                    [0] => Array
                                        (
                                        )

                                )

                        )

                )

        )

)
 
 */