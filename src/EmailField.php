<?php

namespace Drupal\fluent_forms\FormElements;

use Drupal\fluent_forms\FormElements\Base\FormElementBuilder;

class EmailField extends FormElementBuilder
{
    public function elementType(): string
    {
        return 'email';
    }
}
