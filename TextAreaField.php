<?php

namespace Drupal\helpers\FormElements;

use Drupal\Core\Database\Driver\mysql\Schema;
use Drupal\helpers\FormElements\Base\FormElementBuilder;

class TextAreaField extends FormElementBuilder
{
    /** @var int */
    private $length = Schema::COMMENT_MAX_COLUMN;

    /** @var string */
    protected $description = '255 Character Limit';

    public function elementType(): string
    {
        return 'textarea';
    }

    public function maxLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function build(): array
    {
        return array_merge(parent::build(), [
            '#attributes' => [
                'maxlength' => $this->length,
            ],
        ]);
    }
}
