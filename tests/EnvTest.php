<?php
use App\Managers\EnvManager as Env;

class EnvTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->env = new Env();
	}

	public function tearDown()
	{}

    public function testGetLoadReturnString()
    {
        $this->env->setPath(__DIR__.'/');
        $this->env->load();
        $actual = Env::getEnv('test');
        $expect = "blah";
		$this->assertEquals($expect, $actual);
    }

    public function testSetPathReturnsTrueToLoadDefaults()
    {
        $env = new Env();
        $env->setPath(__DIR__.'/../App/');
		$this->assertTrue($env->loadDefaults);
    }

    public function testGetEnvReturnDefault()
    {
        $expect = 'default';
        $actual = Env::getEnv('putest', 'default');
        $this->assertEquals($actual, $expect);
    }
}
