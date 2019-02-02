<?php

namespace Tests\Unit;

use App\Item;
use PHPUnit\Framework\TestCase;

final class ItemTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->item = new Item();
    }
    /** @test */
    public function it_may_have_a_uid()
    {
        $this->item->uid('desktop');

        $this->assertTrue(true);
    }

    /** @test */
    public function it_may_have_a_title()
    {
        $this->item->title('Desktop');

        $this->assertTrue(true);
    }

    /** @test */
    public function it_may_have_a_subtitle()
    {
        $this->item->subtitle('~/Desktop');

        $this->assertTrue(true);
    }

    /** @test */
    public function it_may_have_an_arg()
    {
        $this->item->arg('~/Desktop');

        $this->assertTrue(true);
    }

    /** @test */
    public function it_may_have_an_icon()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_may_have_be_valid_or_not()
    {
        $this->item->valid();
        $this->item->valid(true);
        $this->item->valid(false);

        $this->assertTrue(true);
    }

    /** @test */
    public function it_may_have_a_match_option()
    {
        $this->item->match('my family photos');

        $this->assertTrue(true);
    }

    /** @test */
    public function it_may_have_autocomplete()
    {
        $this->item->autocomplete('string');

        $this->assertTrue(true);
    }

    /** @test */
    public function it_may_have_a_type()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_may_have_mods()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_may_have_a_text_option()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_may_have_a_quicklookurl()
    {
        $this->item->quicklookurl('https://www.alfredapp.com/');

        $this->assertTrue(true);
    }
}
