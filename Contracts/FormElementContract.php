<?php

namespace Drupal\helpers\FormElements\Contracts;

interface FormElementContract
{
    public function build(): array;

    public function elementType(): string;

    /** @return mixed */
    public function defaultValue(string $value);

    public function getFieldName(): string;

    /** @return mixed */
    public function description(string $description);
}
