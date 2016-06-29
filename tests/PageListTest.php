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

    public function testGetAllPages()
    {
        fake()->create('Pages', 1);
        var_dump(Pages::all()->toArray());
        $this->assertTrue(true);
    }
}