<?php

namespace Tests\Helpers;

use Godbout\Alfred\Icon;
use Godbout\Alfred\Item;
use Godbout\Alfred\Mods\Fn;
use Godbout\Alfred\Mods\Alt;
use Godbout\Alfred\Variable;
use Godbout\Alfred\Mods\Ctrl;
use Godbout\Alfred\Mods\Shift;
use Godbout\Alfred\ScriptFilter;
use PHPUnit\Framework\TestCase;

final class FluentApiScriptFilterTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();

        ScriptFilter::destroy();
    }

    /** @test */
    public function an_item_may_be_added_through_a_fluent_api()
    {
        ScriptFilter::create()
            ->item(Item::create());

        $output = ['items' => [
            []
        ]];

        $this->assertSame(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function multiple_items_may_be_added_through_a_fluent_api()
    {
        ScriptFilter::create()
            ->item(Item::create()->title('first'))
            ->item(Item::create()->title('second'));

        $output = ['items' => [
            ['title' => 'first'],
            ['title' => 'second'],
        ]];

        $this->assertSame(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function multiple_items_may_be_added_with_the_same_call_through_a_fluent_api()
    {
        ScriptFilter::create()
            ->items(
                Item::create()->title('first'),
                Item::create()->title('second')
            );

        $output = ['items' => [
            ['title' => 'first'],
            ['title' => 'second'],
        ]];

        $this->assertSame(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function a_variable_may_be_added_through_a_fluent_api()
    {
        ScriptFilter::create()
            ->variable(
                Variable::create('fruit', 'tomato')
            );

        $output = [
            'variables' => [
                'fruit' => 'tomato'
            ],
            'items' => [],
        ];

        $this->assertEquals(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function multiple_variables_may_be_added_through_a_fluent_api()
    {
        ScriptFilter::create()
            ->variable(
                Variable::create('fruit', 'cucumber')
            )
            ->variable(
                Variable::create('vegetable', 'rhubarb')
            );

        $output = [
            'variables' => [
                'fruit' => 'cucumber',
                'vegetable' => 'rhubarb'
            ],
            'items' => [],
        ];

        $this->assertEquals(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function multiple_variables_may_be_added_with_the_same_call_through_a_fluent_api()
    {
        ScriptFilter::create()
            ->variables(
                Variable::create('fruit', 'cucumber'),
                Variable::create('vegetable', 'rhubarb')
            );

        $output = [
            'variables' => [
                'fruit' => 'cucumber',
                'vegetable' => 'rhubarb'
            ],
            'items' => [],
        ];

        $this->assertEquals(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function it_can_be_rerun_automatically_through_a_fluent_api()
    {
        ScriptFilter::create()->rerun(2)->rerun(3.4);

        $this->assertEquals(json_encode(['rerun' => 3.4, 'items' => []]), ScriptFilter::output());
    }

    /** @test */
    public function the_output_may_contain_every_field_available_up_to_alfred_3_5_through_a_fluent_api()
    {
        $scriptFilter = ScriptFilter::create();

        $scriptFilter
            ->item(
                Item::create()
                    ->uid('uidd')
                    ->title('titlee')
                    ->subtitle('subtitlee')
                    ->arg('argg')
                    ->icon(
                        Icon::create('icon path')
                    )
                    ->valid()
                    ->match('matchh')
                    ->autocomplete('autocompletee')
                    ->mod(
                        Ctrl::create()
                            ->arg('ctrl arg')
                            ->subtitle('ctrl subtitle')
                            ->valid()
                    )
                    ->copy('copyy')
                    ->largetype('largetypee')
                    ->quicklookurl('quicklookurll')
            )
            ->variable(
                Variable::create('food', 'chocolate')
            )
            ->variable(
                Variable::create('dessert', 'red beans')
            )
            ->rerun(4.5)
            ->item(
                Item::create()
                    ->icon(
                        Icon::create()
                            ->path('icon pathh')
                            ->fileicon()
                    )
                    ->mods(
                        Shift::create()
                            ->subtitle('shift subtitle'),
                        Fn::create()
                            ->arg('fn arg')
                            ->valid(true)
                    )
            )
            ->item(
                Item::create()
                    ->variable(Variable::create('guitar', 'fender'))
                    ->variable(Variable::create('amplifier', 'orange'))
                    ->mod(
                        Alt::create()
                            ->icon(
                                Icon::create()
                                    ->path('alt icon path')
                                    ->fileicon()
                            )
                            ->variable(Variable::create('grade', 'colonel'))
                            ->variable(Variable::create('drug', 'power'))
                    )
            );

        $output = [
            'rerun' => 4.5,
            'variables' => [
                'food' => 'chocolate',
                'dessert' => 'red beans'
            ],
            'items' => [
                [
                    'uid' => 'uidd',
                    'title' => 'titlee',
                    'subtitle' => 'subtitlee',
                    'arg' => 'argg',
                    'icon' => [
                        'path' => 'icon path',
                    ],
                    'valid' => true,
                    'match' => 'matchh',
                    'autocomplete' => 'autocompletee',
                    'mods' => [
                        'ctrl' => [
                            'arg' => 'ctrl arg',
                            'subtitle' => 'ctrl subtitle',
                            'valid' => true,
                        ]
                    ],
                    'text' => [
                        'copy' => 'copyy',
                        'largetype' => 'largetypee'
                    ],
                    'quicklookurl' => 'quicklookurll'
                ],
                [
                    'icon' => [
                        'path' => 'icon pathh',
                        'type' => 'fileicon'
                    ],
                    'mods' => [
                        'shift' => [
                            'subtitle' => 'shift subtitle'
                        ],
                        'fn' => [
                            'arg' => 'fn arg',
                            'valid' => true,
                        ]
                    ]
                ],
                [
                    'variables' => [
                        'guitar' => 'fender',
                        'amplifier' => 'orange'
                    ],
                    'mods' => [
                        'alt' => [
                            'icon' => [
                                'path' => 'alt icon path',
                                'type' => 'fileicon'
                            ],
                            'variables' => [
                                'grade' => 'colonel',
                                'drug' => 'power',
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->assertJsonStringEqualsJsonString(json_encode($output), ScriptFilter::output());
    }
}