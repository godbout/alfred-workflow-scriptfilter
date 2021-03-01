<?php

namespace Godbout\Alfred\Workflow;

use Godbout\Alfred\Workflow\Mods\Alt;
use Godbout\Alfred\Workflow\Mods\Cmd;
use Godbout\Alfred\Workflow\Mods\Ctrl;
use Godbout\Alfred\Workflow\Mods\Fnn;
use Godbout\Alfred\Workflow\Mods\Mod;
use Godbout\Alfred\Workflow\Mods\Shift;
use Godbout\Alfred\Workflow\Traits\HasIcon;
use Godbout\Alfred\Workflow\Traits\HasVariables;
use ReflectionClass;

class Item
{
    use HasIcon;
    use HasVariables;

    private const FIELDS_ALLOWED = [
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

    private const TYPES_ALLOWED = [
        'default',
        'file',
        'file:skipcheck',
    ];

    private const MODS_ALLOWED = [
        Shift::class,
        Fnn::class,
        Ctrl::class,
        Alt::class,
        Cmd::class,
    ];

    private const ICONTYPES_ALLOWED = [
        'fileicon',
        'filetype',
    ];

    private $fields = [];

    public static function create()
    {
        return new self();
    }

    public static function createDefault()
    {
        return self::create()->type('default');
    }

    public static function createFile()
    {
        return self::create()->type('file');
    }

    public static function createSkipcheck()
    {
        return self::create()->type('file:skipcheck');
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

    public function __get($name)
    {
        if (in_array($name, self::FIELDS_ALLOWED)) {
            return $this->fields[$name];
        }

        throw new \Exception("'$name' is not a valid Item field.");
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
        return strtolower(
            (new ReflectionClass($mod))->getShortName() === 'Fnn' ? 'Fn' : (new ReflectionClass($mod))->getShortName()
        );
    }
}
