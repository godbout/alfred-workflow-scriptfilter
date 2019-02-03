<?php

namespace App;

class Item
{
    const FIELDSALLOWED = [
        'uid',
        'title',
        'subtitle',
        'arg',
        'valid',
        'match',
        'autocomplete',
        'quicklookurl'
    ];

    private $fields = [];

    public function valid($validity = true)
    {
        $this->fields['valid'] = (bool) $validity;
    }

    public function copy($text)
    {
        $this->fields['text']['copy'] = $text;
    }

    public function largetype($text)
    {
        $this->fields['text']['largetype'] = $text;
    }

    public function __call($name, $arguments)
    {
        if (in_array($name, self::FIELDSALLOWED)) {
            $this->fields[$name] = reset($arguments);

            return $this;
        }

        throw new \Exception("'$name' is not a valid ScriptFilter item field.");
    }

    public function toArray()
    {
        return $this->fields;
    }
}
