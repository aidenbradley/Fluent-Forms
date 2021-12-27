<?php

namespace Drupal\fluent_forms\FormElements;

use Drupal\fluent_forms\Base\FormElementBuilder;

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
