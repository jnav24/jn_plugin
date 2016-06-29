<?php
use PHPUnit\Framework\TestCase;
use App\Models\Pages;

class PageListTest  extends TestCase
{
    public function setUp()
    {}

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
}