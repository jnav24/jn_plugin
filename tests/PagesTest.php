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

        $options = Mockery::mock('App\Models\Options');
        $options->shouldReceive('geturl')->once()->andReturn(['option_value' => 'http://pi.dev/jn-wpPlugin_new']);
        $this->page = new App\Controllers\PageController($options);
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
            'modified_by' => '1',
        ];

        $this->page->store($post);

        $actual = Pages::first();
        $this->assertGreaterThan(0, $actual->page_id);
    }

    public function testUpdateReturnsNotEqual()
    {
        fake()->create('Pages', 10);
        $id = rand(1,10);

        $page = Pages::find($id);
        $expect = $page->page_url;

        $post['page_id'] = $id;
        $post['page_name'] = $page->page_name;
        $post['page_content'] = $page->page_content;
        $post['page_url'] = "http://www.justinnavarro.net";
        $post['modified_by'] = 24;
        $this->page->update($post);

        $actual = Pages::find($id)->page_url;

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
        $needle = $this->faker->name;
        $pageContentFromDB = array(
            'module_banner_0' => [
                'banner_name' => $needle
            ]
        );

        Pages::create(['page_content' => $this->page->serialize($pageContentFromDB)]);
        $haystack = $this->page->edit(Pages::first()->toArray());
        $this->assertContains($needle, $haystack);
    }
}