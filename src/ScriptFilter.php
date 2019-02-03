<?php

namespace App;

use App\Traits\HasVariables;

class ScriptFilter
{
    use HasVariables;

    private static $instance = null;

    private static $rerun = null;

    private static $items = [];

    public static function getInstance()
    {
        return self::create();
    }

    public static function create()
    {
        if (self::$instance === null) {
            self::$instance = new ScriptFilter();
        }

        return self::$instance;
    }

    public static function rerun($seconds = null)
    {
        if ($seconds >= 0.1 && $seconds <= 5.0) {
            self::$rerun = $seconds;
        }

        return self::$instance;
    }

    public function item(Item $item)
    {
        self::add($item);

        return $this;
    }

    public function items(Item ...$items)
    {
        self::add(...$items);

        return $this;
    }

    public static function add(...$objects)
    {
        foreach ($objects as $object) {
            if ($object instanceof Variable) {
                self::getInstance()->variable($object);
            }

            if ($object instanceof Item) {
                self::$items[] = $object;
            }
        }

        return self::$instance;
    }

    public static function output()
    {
        if (self::$rerun !== null) {
            $output['rerun'] = self::$rerun;
        }

        if (self::getInstance()->variables !== null) {
            $output['variables'] = self::getInstance()->variables;
        }

        $output['items'] = array_map(function ($item) {
            return $item->toArray();
        }, self::$items);

        return json_encode($output);
    }

    public static function reset()
    {
        self::$rerun = null;
        self::getInstance()->variables = null;
        self::$items = [];

        return self::$instance;
    }

    public static function destroy()
    {
        self::reset();
        self::$instance = null;

        return self::$instance;
    }
}
