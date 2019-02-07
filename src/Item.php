<?php

namespace Godbout\Alfred;

use ReflectionClass;
use Godbout\Alfred\Mods\Fn;
use Godbout\Alfred\Mods\Alt;
use Godbout\Alfred\Mods\Cmd;
use Godbout\Alfred\Mods\Mod;
use Godbout\Alfred\Mods\Ctrl;
use Godbout\Alfred\Mods\Shift;
use Godbout\Alfred\Traits\HasIcon;
use Godbout\Alfred\Traits\HasVariables;

class Item
{
    use HasIcon, HasVariables;

    const FIELDS_ALLOWED = [
        'variables',
        'uid',
        'title',
        'subtitle',
        'arg',
        'icon',
        'valid',
        'match',
        'autocomplete',
        'type',
        'mods',
        'text',
        'quicklookurl',
    ];

    const TYPES_ALLOWED = [
        'default',
        'file',
        'file:skipcheck',
    ];

    const MODS_ALLOWED = [
        Shift::class,
        Fn::class,
        Ctrl::class,
        Alt::class,
        Cmd::class,
    ];

    const ICONTYPES_ALLOWED = [
        'fileicon',
        'filetype',
    ];

    private $fields = [];

    public static function create()
    {
        return new Item;
    }

    public static function createDefault()
    {
        return Item::create()->type('default');
    }

    public static function createFile()
    {
        return Item::create()->type('file');
    }

    public static function createSkipcheck()
    {
        return Item::create()->type('file:skipcheck');
    }

    public function valid($validity = true)
    {
        $this->fields['valid'] = (bool) $validity;

        return $this;
    }

    public function text($type, $text)
    {
        if (method_exists($this, $type)) {
            $this->$type($text);
        }

        return $this;
    }

    public function copy($text)
    {
        $this->fields['text']['copy'] = $text;

        return $this;
    }

    public function largetype($text)
    {
        $this->fields['text']['largetype'] = $text;

        return $this;
    }

    public function default()
    {
        return $this->type();
    }

    public function file()
    {
        return $this->type('file');
    }

    public function skipcheck()
    {
        return $this->type('file:skipcheck');
    }

    public function type($type = 'default')
    {
        if (in_array($type, self::TYPES_ALLOWED)) {
            $this->fields['type'] = $type;
        }

        return $this;
    }

    public function mods(Mod ...$mods)
    {
        foreach ($mods as $mod) {
            $this->mod($mod);
        }

        return $this;
    }

    public function mod(Mod $mod)
    {
        if (in_array(get_class($mod), self::MODS_ALLOWED)) {
            $this->fields['mods'][$this->getModName($mod)] = $mod->toArray();
        }

        return $this;
    }

    public function __call($name, $arguments)
    {
        if (in_array($name, self::FIELDS_ALLOWED)) {
            $this->fields[$name] = reset($arguments);

            return $this;
        }

        throw new \Exception("'$name' is not a valid Item field.");
    }

    public function toArray()
    {
        if ($this->variables !== null) {
            $this->fields['variables'] = $this->variables;
        }

        return $this->fields;
    }

    private function getModName(Mod $mod)
    {
        return strtolower((new ReflectionClass($mod))->getShortName());
    }
}
