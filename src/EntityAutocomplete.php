<?php

namespace Drupal\fluent_forms\FormElements;

use Drupal\fluent_forms\FormElements\Base\FormElementBuilder;

class EntityAutocomplete extends FormElementBuilder
{
    /** @var string */
    private $target = '';

    /** @var string */
    private $handler = 'default';

    /** @var array */
    private $selectionSettings = [];

    /** @var int */
    private $size = 60;

    /** @var int */
    private $maxLength;

    public function elementType(): string
    {
        return 'entity_autocomplete';
    }

    public function targets(string $entityTypeId): self
    {
        $this->target = $entityTypeId;

        return $this;
    }

    public function selectionHandler(string $handler): self
    {
        $this->handler = $handler;

        return $this;
    }

    public function selectionSettings(array $settings): self
    {
        $this->selectionSettings = $settings;

        return $this;
    }

    /** @param int|string $size */
    public function size($size): self
    {
        $this->size = (int) $size;

        return $this;
    }

    /** @param int|string $maxLength */
    public function maxLength($maxLength): self
    {
        $this->maxLength = (int) $maxLength;

        return $this;
    }

    public function build(): array
    {
        return array_merge(parent::build(), [
            '#target_type' => $this->target,
            '#selection_handler' => $this->handler,
            '#selection_settings' => $this->selectionSettings,
            '#size' => $this->size,
            '#maxlength' => $this->maxLength,
        ]);
    }
}
