<?php

namespace Drupal\helpers\FormElements;

use Drupal\helpers\FormElements\Base\FormElementBuilder;

class HiddenField extends FormElementBuilder
{
    public function elementType(): string
    {
        return 'hidden';
    }

    /** @param mixed $value */
    public function setValue($value): void
    {
        $this->defaultValue = $value;
    }

    public function build(): array
    {
        return array_merge(parent::build(), [
            '#value' => $this->defaultValue,
        ]);
    }
}
