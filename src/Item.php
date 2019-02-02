<?php

namespace App;

class Item
{
    const ALLOWEDFIELDS = [
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
        $this->fields['valid'] = $validity;
    }

    public function __call($name, $arguments)
    {
        if (in_array($name, self::ALLOWEDFIELDS)) {
            $this->fields[$name] = reset($arguments);

            return $this;
        }

        throw new \Exception("'$name' is not a valid ScriptFilter item field.");
    }
}
