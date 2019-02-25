<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Godbout\Alfred\Workflow\Icon;
use Godbout\Alfred\Workflow\Item;
use Godbout\Alfred\Workflow\Mods\Fn;
use Godbout\Alfred\Workflow\Mods\Alt;
use Godbout\Alfred\Workflow\Variable;
use Godbout\Alfred\Workflow\Mods\Ctrl;
use Godbout\Alfred\Workflow\Mods\Shift;
use Godbout\Alfred\Workflow\ScriptFilter;

final class ScriptFilterTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();

        ScriptFilter::destroy();
    }

    /** @test */
    public function the_output_may_contain_zero_item()
    {
        $output = ['items' => []];

        $this->assertEquals(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function the_output_may_contain_an_empty_item()
    {
        $item = Item::create();

        ScriptFilter::add($item);

        $output = ['items' => [
            [],
        ]];

        $this->assertEquals(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function the_output_may_contain_an_item()
    {
        $item = Item::create()
            ->uid('the uid')
            ->title('a nice title')
            ->autocomplete('auto');

        ScriptFilter::add($item);

        $output = ['items' => [
            [
                'uid' => 'the uid',
                'title' => 'a nice title',
                'autocomplete' => 'auto',
            ],
        ]];

        $this->assertEquals(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function the_output_may_contain_several_items()
    {
        $firstItem = Item::create()
            ->subtitle('under')
            ->icon(Icon::create('pathicon'))
            ->valid();

        $secondItem = Item::create()
            ->match('fire')
            ->type('file')
            ->largetype('huge letters');

        ScriptFilter::add($firstItem);
        ScriptFilter::add($secondItem);

        $output = ['items' => [
            [
                'subtitle' => 'under',
                'icon' => ['path' => 'pathicon'],
                'valid' => true,
            ],
            [
                'match' => 'fire',
                'type' => 'file',
                'text' => ['largetype' => 'huge letters'],
            ],
        ]];

        $this->assertEquals(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function multiple_items_can_be_added_together_through_the_add_method()
    {
        $firstItem = Item::create()
            ->uid('1234')
            ->title('click');

        $secondItem = Item::create()
            ->largetype('big big big letters')
            ->valid(false);

        ScriptFilter::add($firstItem, $secondItem);

        $output = ['items' => [
            [
                'uid' => '1234',
                'title' => 'click',
            ],
            [
                'text' => ['largetype' => 'big big big letters'],
                'valid' => false,
            ],
        ]];

        $this->assertEquals(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function it_may_be_rerun_automatically()
    {
        ScriptFilter::rerun();

        $this->assertEquals(json_encode(['items' => []]), ScriptFilter::output());

        ScriptFilter::rerun(0);

        $this->assertEquals(json_encode(['items' => []]), ScriptFilter::output());

        ScriptFilter::rerun(3.4);

        $this->assertEquals(json_encode(['rerun' => 3.4, 'items' => []]), ScriptFilter::output());
    }

    /** @test */
    public function it_may_be_emptied()
    {
        $this->assertEquals(json_encode(['items' => []]), ScriptFilter::output());

        ScriptFilter::rerun(1.2);

        ScriptFilter::add(
            Variable::create('gender', 'undefined')
        );

        ScriptFilter::add(
            Item::create()
                ->title('good title')
        );

        $output = [
            'rerun' => 1.2,
            'variables' => [
                'gender' => 'undefined',
            ],
            'items' => [
                ['title' => 'good title'],
            ],
        ];

        $this->assertEquals(json_encode($output), ScriptFilter::output());

        ScriptFilter::reset();

        $this->assertEquals(json_encode(['items' => []]), ScriptFilter::output());
    }

    /** @test */
    public function the_output_may_contain_one_variable()
    {
        ScriptFilter::add(
            Variable::create('fruit', 'tomato')
        );

        $output = [
            'variables' => [
                'fruit' => 'tomato',
            ],
            'items' => [],
        ];

        $this->assertEquals(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function the_output_may_contain_multiple_variables()
    {
        ScriptFilter::add(
            Variable::create('fruit', 'cucumber'),
            Variable::create('vegetable', 'rhubarb')
        );

        $output = [
            'variables' => [
                'fruit' => 'cucumber',
                'vegetable' => 'rhubarb',
            ],
            'items' => [],
        ];

        $this->assertEquals(json_encode($output), ScriptFilter::output());
    }

    /** @test */
    public function the_output_may_contain_every_field_available_up_to_alfred_3_5()
    {
        ScriptFilter::add(
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
        );

        ScriptFilter::add(
            Variable::create('food', 'chocolate'),
            Variable::create('dessert', 'red beans')
        );

        ScriptFilter::rerun(4.5);

        $anotherItem = Item::create()
            ->icon(
                Icon::createFileicon('icon pathh')
            )
            ->mods(
                Shift::create()
                    ->subtitle('shift subtitle'),
                Fn::create()
                    ->arg('fn arg')
                    ->valid(true)
            );

        $thirdItem = Item::create()
            ->variables(
                Variable::create('guitar', 'fender'),
                Variable::create('amplifier', 'orange')
            )
            ->mod(
                Alt::create()
                    ->icon(
                        Icon::createFileicon('alt icon path')
                    )
                    ->variables(
                        Variable::create('grade', 'colonel'),
                        Variable::create('drug', 'power')
                    )
            );

        ScriptFilter::add($anotherItem, $thirdItem);

        $output = [
            'rerun' => 4.5,
            'variables' => [
                'food' => 'chocolate',
                'dessert' => 'red beans',
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
                        ],
                    ],
                    'text' => [
                        'copy' => 'copyy',
                        'largetype' => 'largetypee',
                    ],
                    'quicklookurl' => 'quicklookurll',
                ],
                [
                    'icon' => [
                        'path' => 'icon pathh',
                        'type' => 'fileicon',
                    ],
                    'mods' => [
                        'shift' => [
                            'subtitle' => 'shift subtitle',
                        ],
                        'fn' => [
                            'arg' => 'fn arg',
                            'valid' => true,
                        ],
                    ],
                ],
                [
                    'variables' => [
                        'guitar' => 'fender',
                        'amplifier' => 'orange',
                    ],
                    'mods' => [
                        'alt' => [
                            'icon' => [
                                'path' => 'alt icon path',
                                'type' => 'fileicon',
                            ],
                            'variables' => [
                                'grade' => 'colonel',
                                'drug' => 'power',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertJsonStringEqualsJsonString(json_encode($output), ScriptFilter::output());
    }
}
