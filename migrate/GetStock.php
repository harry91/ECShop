<?php
//set up variables
$theData = '<?xml version="1.0"?>
<note>
    <to>php.net</to>
    <from>lymber</from>
    <heading>php http request</heading>
    <body>i love php!</body>
</note>';
$url = 'http://192.168.111.25:9765/services/stock/StockService';
//$credentials = 'user@example.com:password';
$header_array = array('Expect' => '',
                'From' => 'User A');
$ssl_array = array('version' => SSL_VERSION_SSLv3);
$options = array();
                
//create the httprequest object                
$httpRequest_OBJ = new httpRequest($url, HTTP_METH_POST, $options);
//add the content type
$httpRequest_OBJ->setContentType = 'Content-Type: application/json';
//add the raw post data
$theData = "{\"getStock\":{\"cInvCode\":\"1000001\"}}";
$httpRequest_OBJ->setRawPostData ($theData);
//send the http request
$result = $httpRequest_OBJ->send();
//print out the result
echo "<pre>"; print_r($result); echo "</pre>";
?>