<?php

namespace Tests\Item;

use App\Icon;
use App\Item;
use App\Variable;
use PHPUnit\Framework\TestCase;

final class ItemVariableTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->item = Item::create();
    }

    /** @test */
    public function it_may_have_no_variable()
    {
        $this->assertSame([], $this->item->toArray());
    }

    /** @test */
    public function it_may_have_a_variable()
    {
        $this->item->variable(Variable::create('direction', 'left'));

        $this->assertSame(['variables' => ['direction' => 'left']], $this->item->toArray());
    }

    /** @test */
    public function it_may_have_multiple_variables()
    {
        $this->item->variables(
            Variable::create('race', 'human'),
            Variable::create('color', 'absolutely')
        );

        $output = [
            'variables' => [
                'race' => 'human',
                'color' => 'absolutely'
            ]
        ];

        $this->assertSame($output, $this->item->toArray());
    }
}
