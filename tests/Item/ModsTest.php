<?php

namespace Tests\Item;

use App\Item;
use App\Mods\Fn;
use App\Mods\Alt;
use App\Mods\Cmd;
use App\Mods\Ctrl;
use App\Mods\Shift;
use PHPUnit\Framework\TestCase;

final class ItemModsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->item = Item::create();
    }

    /** @test */
    public function it_may_have_no_modifier()
    {
        $this->assertSame([], $this->item->toArray());
    }

    /** @test */
    public function it_may_have_one_modifier()
    {
        $this->item->mod(
            Ctrl::create()
                ->arg('new argument')
                ->subtitle('a nice sub')
                ->valid()
        );

        $output = [
            'mods' => [
                'ctrl' => [
                    'arg' => 'new argument',
                    'subtitle' => 'a nice sub',
                    'valid' => true,
                ],
            ]
        ];

        $this->assertSame($output, $this->item->toArray());
    }

    /** @test */
    public function it_may_have_several_modifiers()
    {
        $this->item->mods(
            Shift::create()
                ->arg('argh')
                ->valid(false),
            Ctrl::create()
                ->subtitle('undertitle')
        );

        $output = [
            'mods' => [
                'shift' => [
                    'arg' => 'argh',
                    'valid' => false,
                ],
                'ctrl' => [
                    'subtitle' => 'undertitle',
                ],
            ]
        ];

        $this->assertSame($output, $this->item->toArray());
    }

    /** @test */
    public function it_may_have_all_the_modifiers_available()
    {
        $this->item->mods(
            Shift::create()
                ->arg('shift'),
            Fn::create()
                ->arg('fn'),
            Ctrl::create()
                ->arg('ctrl'),
            Alt::create()
                ->arg('alt'),
            Cmd::create()
                ->arg('cmd')
        );

        $output = [
            'mods' => [
                'shift' => [
                    'arg' => 'shift',
                ],
                'fn' => [
                    'arg' => 'fn',
                ],
                'ctrl' => [
                    'arg' => 'ctrl',
                ],
                'alt' => [
                    'arg' => 'alt',
                ],
                'cmd' => [
                    'arg' => 'cmd',
                ],
            ]
        ];

        $this->assertSame($output, $this->item->toArray());
    }
}
