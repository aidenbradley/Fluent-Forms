<?php

namespace Drupal\fluent_forms\FormElements;

use Drupal\Component\Utility\Random;
use Drupal\fluent_forms\FormElements\Contracts\FormElementContract;

class Markup implements FormElementContract
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $description;

    public static function create(string $title): self
    {
        return new self($title);
    }

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function build(): array
    {
        return [
            '#markup' => $this->title,
        ];
    }

    public function elementType(): string
    {
        return '';
    }

    public function defaultValue(string $value): self
    {
        return $this;
    }

    public function getFieldName(): string
    {
        return (new Random())->string(8, true);
    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
