<?php

namespace Drupal\fluent_forms\FormElements;

use Drupal\fluent_forms\Base\FormElementBuilder;
use Illuminate\Contracts\Support\Arrayable;

class SelectField extends FormElementBuilder
{
    /** @var array */
    protected $options = [];

    public function elementType(): string
    {
        return 'select';
    }

    /**
     * @param array|callable|string $options
     * @return static
     */
    public function setOptions($options)
    {
        if (is_callable($options)) {
            $options = call_user_func_array($options, []);
        }

        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        if (is_array($options)) {
            if (isset($options[0])) {
                foreach ($options as $value) {
                    $this->options[$value] = $value;
                }
            } else {
                foreach ($options as $key => $value) {
                    $this->options[$key] = $value;
                }
            }
        }

        return $this;
    }

    /** @param string|array $option */
    public function setOption($option): self
    {
        if (is_array($option)) {
            [$key, $value] = $option;

            $this->options[$key] = $value;

            return $this;
        }

        $this->options[$option] = $option;

        return $this;
    }

    public function build(): array
    {
        return array_merge([
            '#options' => $this->options,
        ], parent::build());
    }
}
