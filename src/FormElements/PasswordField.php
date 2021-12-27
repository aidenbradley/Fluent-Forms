<?php

namespace Drupal\fluent_forms\FormElements;

use Drupal\fluent_forms\Base\FormElementBuilder;

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
