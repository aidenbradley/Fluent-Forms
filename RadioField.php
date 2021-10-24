<?php

namespace Drupal\helpers\FormElements;

use Drupal\helpers\FormElements\Base\FormElementBuilder;

class RadioField extends FormElementBuilder
{
    /** @var array */
    protected $options = [];

    public function elementType(): string
    {
        return 'radios';
    }

    /** @param array|callable|string $options */
    public function setOptions($options): self
    {
        if (is_callable($options)) {
            $options = call_user_func_array($options, []);
        }

        foreach ((array) $options as $key => $option) {
            $this->setOption($key, $option);
        }

        return $this;
    }

    /** @param string|array $option */
    public function setOption(string $key, $option): self
    {
        if (is_array($option)) {
            $this->options = array_merge($this->options, $option);

            return $this;
        }

        $this->options[$key] = $option;

        return $this;
    }

    public function build(): array
    {
        return array_merge(parent::build(), [
            '#options' => $this->options,
        ]);
    }
}
