<?php
use PHPUnit\Framework\TestCase;

class PageListTest  extends TestCase
{
    public function setUp()
    {}

    public function tearDown()
    {}

    public function testGetAllPages()
    {
        fake()->create('Pages', 1);
        $this->assertTrue(true);
    }
}