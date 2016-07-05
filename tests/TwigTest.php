<?php
use PHPUnit\Framework\TestCase;
use App\Containers\TwigContainer;

class TwigTest extends TestCase
{
    public function setUp()
    {}

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testOptionsArrayReturnEqualBaseUrl()
    {
        $optionsModel = Mockery::mock('overload:App\Models\Options');
        $optionsModel->shouldReceive('geturl')->once()->andReturn(['option_value' => 'http://pi.dev/jn-wpPlugin_new']);

        $twig = new TwigContainer(__DIR__ . '/../App/resources/views', $optionsModel);

        $actual = $twig->options;
        $expect = 'http://pi.dev/jn-wpPlugin_new';
        $this->assertEquals($expect, $actual['base_url']);
    }
}