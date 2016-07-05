<?php
use PHPUnit\Framework\TestCase;

class SessionTest  extends TestCase
{
    public function setUp()
    {}

    public function tearDown()
    {}

    public function testIfKeyExistsReturnsFalse()
    { 
        $expectFalse = session()->has('some_key');
        $this->assertFalse($expectFalse);
    }

    public function testPutKeyAndCheckIfKeyExistsReturnsTrue()
    {
        session()->put('some_key', 'from test');
        $expectTrue = session()->has('some_key');
        $this->assertTrue($expectTrue);
    }

    public function testFlashMessagingReturnsMessage()
    {
        $expect = 'some message';
        session()->flash('msg', $expect);
        $actual = session()->get('msg');
        $this->assertEquals($expect, $actual);
    }

    public function testFlashMessageIfDeletesFromSessionReturnsFalse()
    {
        session()->flash('msg', 'test message');
        session()->get('msg');
        $this->assertFalse(session()->has('msg'));
    }
}