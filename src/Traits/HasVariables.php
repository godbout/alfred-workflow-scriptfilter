<?php

namespace App\Traits;

use App\Variable;

trait HasVariables
{
    public $variables = null;

    public function variable(Variable $variable)
    {
        $this->variables = array_merge((array) $this->variables, $variable->toArray());

        return $this;
    }

    public function variables(Variable ...$variables)
    {
        foreach ($variables as $variable) {
            $this->variable($variable);
        }

        return $this;
    }
}
