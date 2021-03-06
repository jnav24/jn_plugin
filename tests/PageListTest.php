<?php
use PHPUnit\Framework\TestCase;
use App\Models\Pages;
use Twigger\Twigger;

class PageListTest  extends TestCase
{
    public function setUp()
    {
        fake()->truncate();
        $this->twig = new Twigger(__DIR__ . '/../App/resources/views/tests');
    }

    public function tearDown()
    {
        fake()->truncate();
    }

    public function testGetAllPagesReturnHighestId()
    {
        fake()->create('Pages', 10);
        fake()->create('Pages', 15);
        fake()->create('Pages', 26);

        $pages = Pages::orderBy('page_id', 'desc')->first();
        $this->assertEquals(51, $pages->page_id);
    }

    public function testGetAllPagesReturnHtml()
    {
        fake()->create('Pages', 1);

        $pages = Pages::all()->toArray();
        $expect = "<h1>" . $pages[0]['page_name'] . "</h1>";
        $actual = $this->twig->render('allPages.twig', ['pages' => $pages]);

        $this->assertEquals($expect, $actual);
    }
}