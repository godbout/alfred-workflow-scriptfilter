<?php

namespace Tests;

use App\Item;
use App\Results;
use PHPUnit\Framework\TestCase;

final class ResultsTest extends TestCase
{
    /** @test */
    public function results_can_be_empty()
    {
        $results = new Results();
        $this->assertEquals('{"items":[]}', $results->output());
    }

    /** @test */
    public function results_can_contain_one_item()
    {
        $results = new Results();

        $item = new Item();

        $results->add($item);

        $this->assertCount(1, $results->items());
    }

    /** @test */
    public function results_can_contain_several_items()
    {
        $results = new Results();

        $firstItem = new Item();
        $secondItem = new Item();
        $thirdItem = new Item();

        $results->add($firstItem);
        $results->add($secondItem);
        $results->add($thirdItem);

        $this->assertCount(3, $results->items());
    }
}
