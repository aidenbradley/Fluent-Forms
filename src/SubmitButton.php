<?php

namespace Drupal\fluent_forms\FormElements;

use Drupal\fluent_forms\FormElements\Base\FormElementBuilder;

class SubmitButton extends FormElementBuilder
{
    public function elementType(): string
    {
        return 'submit';
    }
}
