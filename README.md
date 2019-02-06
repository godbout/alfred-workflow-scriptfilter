# Alfred Workflow PHP

## Why

Starting with Alfred 3.4.1 you can define [variables][1] for individual items and
variables and icon for each various modifiers (ctrl, cmd, shift, fn, alt) of each item.
That makes rendering the results for Alfred a little tougher than usual with the current tools
available, hence this package.

If you don't need the new fields introduced by Alfred 3.4.1 and 3.5, you might want to use
Joe Tannenbaum's [package][2]. His API might be a little less heavier than mine.

## Installation

```php
composer require godbout/alfred-workflow-php
```

## Usage

There is only one script filter by... script, so the `ScriptFilter` class is a singleton. You can create many
instances of all the other classes: `Item`, `Variable`, `Icon`, and the `Mod` classes: `Ctrl`, `Fn`, `Shift`, `Alt`, and `Cmd`.

You may check the structure and options of the Alfred Script Filter JSON Format here: https://www.alfredapp.com/help/workflows/inputs/script-filter/json/

```php
use Godbout/ScriptFilter;

ScriptFilter::create();

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

echo ScriptFilter::output();
```

will result in:

```
{
    "rerun":4.5,
    "variables":{
        "food":"chocolate",
        "dessert":"red beans"
    },
    "items":[
        {
            "uid":"uidd",
            "title":"titlee",
            "subtitle":"subtitlee",
            "arg":"argg",
            "icon":{
                "path":"icon path"
            },
            "valid":true,
            "match":"matchh",
            "autocomplete":"autocompletee",
            "mods":{
                "ctrl":{
                    "arg":"ctrl arg",
                    "subtitle":"ctrl subtitle",
                    "valid":true
                }
            },
            "text":{
                "copy":"copyy",
                "largetype":"largetypee"
            },
            "quicklookurl":"quicklookurll"
        },
        {
            "icon":{
                "path":"icon pathh",
                "type":"fileicon"
            },
            "mods":{
                "shift":{
                    "subtitle":"shift subtitle"
                },
                "fn":{
                    "arg":"fn arg",
                    "valid":true
                }
            }
        },
        {
            "mods":{
                "alt":{
                    "icon":{
                        "path":"alt icon path",
                        "type":"fileicon"
                    },
                    "variables":{
                        "grade":"colonel",
                        "drug":"power"
                    }
                }
            },
            "variables":{
                "guitar":"fender",
                "amplifier":"orange"
            }
        }
    ]
}
```

## Helpers

There's a couple of helpers that should make your code a bit more enjoyable to write. Or not.

### ScriptFilter

The ScriptFilter can be written using a fluent interface:

```php
ScriptFilter::create()
    ->item($item)
    ->variable($variable)
    ->items($anotherItem, $oneMoreItem)
    ->variables($aVariable, $anotherVariable)
    ->rerun(4);
```

### Icon

```php
Icon::create('~/Desktop');
/**
 * is the same as
 */
Icon::create()
    ->path('~/Desktop');


Icon::createFileicon('~/Desktop');
/**
 * is the same as
 */
Icon::create('~/Desktop')
    ->fileicon();


Icon::createFiletype('~/Desktop');
/**
 * is the same as
 */
Icon::create()
    ->path('~/Desktop')
    ->filetype();
```

### Variable

```php
Variable::create('guitar', 'fender');
/**
 * is the same as
 */
Variable::create()
    ->name('guitar')
    ->value('fender');
```

## Full API

You might want to check the tests to see the full API: [tests][3]

The API should mostly help you avoid typing too much and putting wrong data
where Alfred is expecting something strict.

## Alternatives

* [alfred-workflow][2] by Joe Tannenbaum


[1]: https://www.alfredapp.com/help/workflows/inputs/script-filter/json/#variables
[2]: https://github.com/joetannenbaum/alfred-workflow
[3]: https://github.com/godbout/alfred-workflow-php/tree/master/tests
