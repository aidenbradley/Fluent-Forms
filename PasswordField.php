<?php

namespace Drupal\helpers\FormElements;

use Drupal\helpers\FormElements\Base\FormElementBuilder;

class PasswordField extends FormElementBuilder
{
    public function elementType(): string
    {
        return 'password';
    }

    public function build(): array
    {
        $build = parent::build();

        $build['#attributes']['autocomplete'] = 'off';

        return $build;
    }
}
