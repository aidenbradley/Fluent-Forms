<?php

namespace Drupal\fluent_forms\FormElements;

use Drupal\fluent_forms\Base\FormElementBuilder;

class AddressField extends FormElementBuilder
{
    public function elementType(): string
    {
        return 'address';
    }
}
