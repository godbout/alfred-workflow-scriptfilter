<?php

use Alfred\ScriptFilter;

$scriptFilter = new ScriptFilter();

$scriptFilter->variable('fruit', 'apple')
    ->variable('vegetable', 'carrot');

$scriptFilter->variable()
    ->name('fruit')
    ->type('apple');


$variable = new Variable;
$scriptFilter->add($variable);

$item = new Item;
$scriptFilter->add($item);

$scriptFilter->item()
    ->uid()
    ->cmd();

$scriptFilter->output();
