<?php

namespace App;

use App\Item;

class ScriptFilter
{
    private $items = [];

    public function output()
    {
        $items = ['items' => $this->items];

        return json_encode($items);
    }

    public function add(Item $item)
    {
        $this->items['items'][] = json_encode($item);
    }

    public function items()
    {
        return $this->items['items'];
    }

    public function item()
    {
        $item = new Item;

        $this->add($item);

        return $item;
    }
}
