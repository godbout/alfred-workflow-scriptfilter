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
        $this->item->uid('a uid');

        $this->assertSame(['uid' => 'a uid'], $this->item->toArray());
    }

    /** @test */
    public function it_may_have_a_title()
    {
        $this->item->title('some title');

        $this->assertSame(['title' => 'some title'], $this->item->toArray());
    }

    /** @test */
    public function it_may_have_a_subtitle()
    {
        $this->item->subtitle('the subtitle');

        $this->assertSame(['subtitle' => 'the subtitle'], $this->item->toArray());
    }

    /** @test */
    public function it_may_have_an_arg()
    {
        $this->item->arg('argument');

        $this->assertSame(['arg' => 'argument'], $this->item->toArray());
    }

    /** @test */
    public function it_may_have_an_icon()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_may_be_valid()
    {
        $this->item->valid();

        $this->assertSame(['valid' => true], $this->item->toArray());


        $this->item->valid('slfj');

        $this->assertSame(['valid' => true], $this->item->toArray());


        $this->item->valid(true);

        $this->assertSame(['valid' => true], $this->item->toArray());
    }

    /** @test */
    public function it_may_not_be_valid()
    {
        $this->item->valid(false);

        $this->assertSame(['valid' => false], $this->item->toArray());
    }

    /** @test */
    public function it_may_have_a_match_option()
    {
        $this->item->match('no fire without a match');

        $this->assertSame(['match' => 'no fire without a match'], $this->item->toArray());
    }

    /** @test */
    public function it_may_have_autocomplete()
    {
        $this->item->autocomplete('a complete auto');

        $this->assertSame(['autocomplete' => 'a complete auto'], $this->item->toArray());
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
    public function it_may_have_a_copy_option()
    {
        $this->item->copy('within text');

        $this->assertSame(['text' => ['copy' => 'within text']], $this->item->toArray());
    }

    /** @test */
    public function it_may_have_a_largetype_option()
    {
        $this->item->largetype('that IS large');

        $this->assertSame(['text' => ['largetype' => 'that IS large']], $this->item->toArray());
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

        $this->assertSame(['quicklookurl' => 'https://www.alfredapp.com/'], $this->item->toArray());
    }
}
