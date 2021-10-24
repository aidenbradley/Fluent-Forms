<?php

namespace Drupal\helpers\FormElements;

use Drupal\helpers\FormElements\Base\FormElementBuilder;

class TextField extends FormElementBuilder
{
    /** @var int */
    protected $maxLength = 255;

    public function elementType(): string
    {
        return 'textfield';
    }

    public function setMaxLength(int $maxLength): self
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    public function build(): array
    {
        return array_merge(parent::build(), [
            '#maxlength' => $this->maxLength,
        ]);
    }
}
