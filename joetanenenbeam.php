<?php

use Alfred\Workflows\Workflow;

require 'vendor/autoload.php';

$workflow = new Workflow;

// add variables
$workflow->variable('fruit', 'apple')
    ->variable('vegetables', 'carrots');

$workflow->result()
    ->uid('bob-belcher')
    ->title('Bob')
    ->subtitle('Head Burger Chef')
    ->quicklookurl('http://www.bobsburgers.com')
    ->type('default')
    ->arg('bob')
    ->valid(true)
    ->icon('bob.png')
    ->mod('cmd', 'Search for Bob', 'search')
    ->text('copy', 'Bob is the best!')
    ->autocomplete('Bob Belcher');

$workflow->result()
    ->uid('linda-belcher')
    ->title('Linda')
    ->subtitle('Wife')
    ->quicklookurl('http://www.bobsburgers.com')
    ->type('default')
    ->arg('linda')
    ->valid(true)
    ->icon('linda.png')
    ->mod('cmd', 'Search for Linda', 'search')
    ->text('largetype', 'Linda is the best!')
    ->autocomplete('Linda Belcher');

echo $workflow->output();
