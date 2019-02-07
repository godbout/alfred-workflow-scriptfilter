<?php

namespace Godbout\Alfred\Traits;

use Godbout\Alfred\Icon;

trait HasIcon
{
    public function icon(Icon $icon)
    {
        $this->fields['icon'] = $icon->toArray();

        return $this;
    }
}
