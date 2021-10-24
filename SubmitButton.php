<?php

namespace Drupal\helpers\FormElements;

use Drupal\helpers\FormElements\Base\FormElementBuilder;

class SubmitButton extends FormElementBuilder
{
    public function elementType(): string
    {
        return 'submit';
    }
}
