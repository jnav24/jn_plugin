<?php
use PHPUnit\Framework\TestCase;
use App\Models\Pages;
use Twigger\Twigger;
use Faker\Factory as Faker;

class PagesTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function setUp()
    {
        $this->faker = Faker::create();
        $this->path = __DIR__ . '/../App/resources/views';
        $this->twig = new Twigger($this->path);

        $options = Mockery::mock('overload:App\Models\Options');
        $options->shouldReceive('geturl')->once()->andReturn(['option_value' => 'http://pi.dev/jn-wpPlugin_new']);
        $this->page = new App\Controllers\PageController($options);
    }

    public function tearDown()
    {
        fake()->truncate();
        Mockery::close();
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
            'modules' => [],
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
        $needle = $this->faker->imageUrl($width = 640, $height = 480);
        $pageContentFromDB = array(
            'module_banner_0' => [
                'banner_img' => $needle
            ]
        );

        Pages::create(['page_content' => $this->page->serialize($pageContentFromDB)]);
        $page = Pages::first();
        $haystack = $this->page->edit($page->page_id);
        $this->assertContains($needle, $haystack);
    }

    public function testStripUrlFromImgReturnImgName()
    {
        $img_url = 'http://pi.dev/jn-wpPlugin_new/wp-content/plugins/jn_plugin/App/resources/images/placeholder.jpg';
        $actual = $this->page->stripUrlFromImg($img_url);
        $expect = 'placeholder.jpg';
        $this->assertEquals($expect, $actual);
    }
}