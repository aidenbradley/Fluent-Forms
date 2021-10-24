<?php

namespace Drupal\helpers\FormElements;

use Drupal\helpers\FormElements\Base\FormElementBuilder;

class AddressField extends FormElementBuilder
{
    public function elementType(): string
    {
        return 'address';
    }
}
