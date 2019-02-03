<?php

namespace App\Traits;

use App\Icon;

trait HasIcon
{
    public function icon(Icon $icon)
    {
        $this->fields['icon'] = $icon->toArray();

        return $this;
    }
}
