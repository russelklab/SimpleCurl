<?php
require_once __DIR__.'/../SimpleCurl.php';

class SimpleCurlTest extends PHPUnit_Framework_TestCase
{
    public function testSimpleCurl()
    {
        $curl = SimpleCurl::init();

        $data = array('name' => 'test', 'file' => '@'.__DIR__.'/testfile');

        $this->assertTrue(is_object($curl));
        $this->assertTrue(is_resource($curl->getCurlResource()));

        $curl->setUrl('http://www.google.com');
        $curl->setPostField($data);
        $curl->setReturnTransfer();
        $curl->setHeader(true);
        $curl->setHeaderOutput(true);

        $contents = $curl->exec();
        $curl_options = $curl->info();

        $this->assertNotEmpty($contents);
        $this->assertTrue(is_array($curl_options));
        $this->assertEquals($curl_options['url'], 'http://www.google.com');
        $this->stringContains($curl_options['request_header'], 'POST');
        $this->stringContains($curl_options['request_header'], 'multipart/form-data');
    }
}
