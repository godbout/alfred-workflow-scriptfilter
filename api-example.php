<?php

use Alfred\ScriptFilter;

$script = ScriptFilter::create()
    ->add($item)
    ->rerun(1)
    ->output();

$script->output();

ScriptFilter::add($item, $variable, $anotherItem, $secondVariable);

ScriptFilter::add($item);

ScriptFilter::output();

Variable::create()
    ->name('fruit')
    ->value('banana');

Variable::create('fruit', 'banana');


$scriptFilter = new ScriptFilter;

$scriptFilter->item()
    ->uid();

ScriptFilter::create(
    Variable::create('fruit', 'apple')
);

ScritFilter::create()
    ->variable('fruit', 'orange')
    ->variable('car', 'megane')
    ->item(Item::create()
        ->variable('some', 'sfsd')
        ->variable('sdfs', 'sdfs')
        ->icon(Icon::createFileicon('path')))
    ->item(Item::create())
    ->rerun(3.4);

ScriptFilter::rerun(2);

ScriptFilter::add(Variable::create('fruit', apple));
ScriptFilter::add(
    Item::create()
        ->uid('something')
        ->title('title'),
    Item::create()
        ->match('something to match')
);

foreach ($items as $item) {
    ScriptFilter::add($item);
}


Variable::create()
    ->name('sdfljd')
    ->value('sdfljksdf');

Icon::create()
    ->path('something');

ScriptFilter::add($item, $variable, $item, $item);

ScriptFilter::add($arrayOfItemsAndVariables);

ScriptFilter::add($item)->output();


ScriptFilter::output();
