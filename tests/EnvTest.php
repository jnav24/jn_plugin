<?php

class EnvTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{}

	public function tearDown()
	{}

    public function testGetLoadReturnString()
    {
        env()->setPath(__DIR__ . '/');
        env()->load();
        $actual = env()->getEnv('test');

        $expect = "blah";
		$this->assertEquals($expect, $actual);
    }

    public function testSetPathReturnsTrueToLoadDefaults()
    {
        env()->setPath(__DIR__.'/../App/');
		$this->assertTrue(env()->loadDefaults);
    }

    public function testGetEnvReturnDefault()
    {
        $expect = 'default';
        $actual = env()->getEnv('putest', 'default');
        $this->assertEquals($actual, $expect);
    }
}
