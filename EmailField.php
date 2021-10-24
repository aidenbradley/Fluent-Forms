<?php

namespace Drupal\helpers\FormElements;

use Drupal\helpers\FormElements\Base\FormElementBuilder;

class EmailField extends FormElementBuilder
{
    public function elementType(): string
    {
        return 'email';
    }
}
