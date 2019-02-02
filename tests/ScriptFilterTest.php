<?php

namespace Tests;

use App\Item;
use App\Results;
use App\ScriptFilter;
use PHPUnit\Framework\TestCase;

final class ScriptFilterTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->scriptFilter = new ScriptFilter();
    }

    /** @test */
    public function the_output_may_contain_zero_item()
    {
        $this->assertEquals('{"items":[]}', $this->scriptFilter->output());
    }

    /** @test */
    public function the_output_may_contain_one_item()
    {
        $item = new Item();

        $this->scriptFilter->add($item);

        $this->assertCount(1, $this->scriptFilter->items());
    }

    /** @test */
    public function results_may_contain_several_items()
    {
        $firstItem = new Item();
        $secondItem = new Item();
        $thirdItem = new Item();

        $this->scriptFilter->add($firstItem);
        $this->scriptFilter->add($secondItem);
        $this->scriptFilter->add($thirdItem);

        $this->assertCount(3, $this->scriptFilter->items());
    }

    /** @test */
    public function an_item_can_be_added_through_the_fluent_api()
    {
        $this->assertInstanceOf(Item::class, $this->scriptFilter->item());

        $this->assertCount(1, $this->scriptFilter->items());
    }
}
