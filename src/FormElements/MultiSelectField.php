<?php

namespace Drupal\fluent_forms\FormElements;

class MultiSelectField extends SelectField
{
    /** @var bool */
    protected $chosen;

    public function build(): array
    {
        $build = collect(parent::build())
            ->merge(['#multiple' => true])
            ->toArray();

        if (isset($this->chosen)) {
            $build['#chosen'] = 1;
        }

        return $build;
    }

    public function useChosen(): self
    {
        $this->chosen = true;

        return $this;
    }
}
