<?php
use PHPUnit\Framework\TestCase;
use App\Containers\TwigContainer;

class TwigTest extends TestCase
{
    public function setUp()
    {}

    public function tearDown()
    {}

    public function testOptionsArrayReturnEqualBaseUrl()
    { 
        $options = \Mockery::mock('App\Models\Options');
        $options->shouldReceive('geturl')->once()->andReturn(['option_value' => 'http://pi.dev/jn-wpPlugin_new']);

        $twig = new TwigContainer(__DIR__ . '/../App/Views', $options);
        $actual = $twig->options;
        $expect = 'http://pi.dev/jn-wpPlugin_new';
        $this->assertEquals($expect, $actual['base_url']);
    }
}