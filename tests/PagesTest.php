<?php
use PHPUnit\Framework\TestCase;
use App\Models\Pages;
use App\Providers\TwigProvider;
use Faker\Factory as Faker;

class PagesTest extends TestCase
{
    public function setUp()
    {
        $this->faker = Faker::create();
        $this->path = __DIR__ . '/../App/resources/views';
        $this->twig = new TwigProvider($this->path);
    }

    public function tearDown()
    {
        fake()->truncate();
    }

    public function testgetViewReturn404()
    {
        $actual = $expect = 'not working';
        $file = 'cool.twig';
        if(!file_exists($this->path . '/' . $file))
        {
            $actual = $this->twig->render('errors/404.twig', ['file' => $file]);
        }

        $this->assertNotEquals($expect, $actual);
    }
    
    public function testIndexReturnSampleHtml()
    {
        fake()->create('Pages', 10);
        $page = Pages::find(rand(1,10))->toArray();

        $expect = '<h1>' . $page['page_name'] . '</h1>
<h5>' . date('Y-m-d', strtotime($page['created_at'])) . '</h5>
<p>'. $page['page_content'] . '</p>
<a href="'. $page['page_url'] .'">Click me</a>';

        $actual = $this->twig->render('tests/index.twig', $page);
        $this->assertEquals($expect, $actual);
    }

    public function testStoreReturnIdGreaterThanZero()
    {
        $post = [
            'page_content' => 'Something',
            'page_name' => 'from test',
            'page_url' => 'from-test',
            'created_by' => '1',
            'modified_by' => '1',
            'created_at' => '2015-10-25 16:24:00',
            'updated_at' => '2015-10-25 16:24:00',
        ];

        $page = new Pages();
        $page->page_content = $post['page_content'];
        $page->page_name = $post['page_name'];
        $page->page_url = $post['page_url'];
        $page->created_by = $post['created_by'];
        $page->modified_by = $post['modified_by'];
        $page->created_at = $post['created_at'];
        $page->updated_at = $post['updated_at'];
        $page->save();

        $actual = Pages::first();
        $this->assertGreaterThan(0, $actual->page_id);
    }

    public function testUpdateReturnsNotEqual()
    {
        fake()->create('Pages', 10);
        $id = 5;

        $page = Pages::find($id);
        $expect = $page->page_url;

        $page->page_url = "http://www.justinnavarro.net";
        $page->save();
        $actual = $page->page_url;

        $this->assertNotEquals($expect, $actual);
    }
    
    public function testDestroyReturnNotEquals()
    {
        fake()->create('Pages', 10);
        $id = 6;

        $expect = Pages::count();
        Pages::destroy($id);
        $actual = Pages::count();

        $this->assertNotEquals($expect, $actual);
    }
    
    public function testEditNewPageReturnsDataFromModules()
    {
        $options = Mockery::mock('App\Models\Options');
        $options->shouldReceive('geturl')->once()->andReturn(['option_value' => 'http://pi.dev/jn-wpPlugin_new']);

        $needle = $this->faker->name;
        $pageContentFromDB = array(
            'module_banner_0' => [
                'banner_name' => $needle
            ]
        );

        $page = new App\Controllers\PageController($options);
        Pages::create(['page_content' => $page->serialize($pageContentFromDB)]);
        $haystack = $page->edit(Pages::first()->toArray());
        $this->assertContains($needle, $haystack);
    }
}