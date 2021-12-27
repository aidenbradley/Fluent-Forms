<?php

namespace Drupal\fluent_forms\FormElements;

use Drupal\fluent_forms\Base\FormElementBuilder;

class CheckboxField extends FormElementBuilder
{
    public function elementType(): string
    {
        return 'checkbox';
    }
}
