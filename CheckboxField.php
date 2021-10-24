<?php

namespace Drupal\helpers\FormElements;

use Drupal\helpers\FormElements\Base\FormElementBuilder;

class CheckboxField extends FormElementBuilder
{
    public function elementType(): string
    {
        return 'checkbox';
    }
}
