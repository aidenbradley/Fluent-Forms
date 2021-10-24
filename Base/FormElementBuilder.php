<?php

namespace Drupal\helpers\FormElements\Base;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormStateInterface;
use Drupal\helpers\FormElements\Contracts\FormElementContract;
use Drupal\helpers\FormElements\SelectField;
use Tightenco\Collect\Contracts\Support\Arrayable;

abstract class FormElementBuilder implements FormElementContract
{
    /** @var string */
    protected $fieldName;

    /** @var string */
    protected $title;

    /** @var string */
    protected $placeholder;

    /** @var mixed */
    protected $defaultValue;

    /** @var mixed */
    protected $value;

    /** @var bool */
    protected $isRequired = false;

    /** @var array */
    protected $states = [
        'visible' => [],
        'required' => [],
    ];

    /** @var callable */
    protected $validationHandler;

    /** @var string */
    protected $description;

    /** @var bool */
    protected $access = true;

    /** @var string */
    protected $emptyValue;

    public static function create(string $fieldName, ?string $title = null): self
    {
        if ($title === null) {
            $fieldTitle = str_replace('field_', '', $fieldName);

            $title = str_replace('_', ' ', $fieldTitle);

            $title = ucwords($title);
        }

        $fieldName = strtolower(str_replace(' ', '_', $fieldName));

        return new static($fieldName, $title);
    }

    final public function __construct(string $fieldName, string $title)
    {
        $this->fieldName = $fieldName;
        $this->title = $title;
    }

    public function placeholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function emptyValue(string $emptyValue): self
    {
        $this->emptyValue = $emptyValue;

        return $this;
    }

    protected function getPlaceholder(): string
    {
        return $this->placeholder ?? $this->title;
    }

    /** @param string|array|int $defaultValue */
    public function defaultValue($defaultValue): self
    {
        if (is_callable($defaultValue)) {
            $defaultValue = call_user_func($defaultValue);
        }

        if (is_string($defaultValue) || is_int($defaultValue) || is_array($defaultValue)) {
            $this->defaultValue = $defaultValue;
        }

        return $this;
    }

    /** @param string|array $value */
    public function value($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function isRequired(bool $isRequired = true): self
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    public function access(bool $access): self
    {
        $this->access = $access;

        return $this;
    }

    /**
     * Determines when this field should be visible based on a given input having a specific value
     *
     * @param string|array|Arrayable $value
     */
    public function visibleWhen(string $inputName, $value): self
    {
        if ($value instanceof Arrayable) {
            $value = $value->toArray();
        }

        foreach ((array) $value as $conditional) {
            $this->states['visible'][] = [
                ':input[name="' . $inputName . '"]' => ['value' => $conditional],
            ];
        }

        return $this;
    }

    /**
     * This will only indicate it's required on the frontend. There is currently a bug open in core for required state.
     * For now, add your own validation handler using `::validationHandler`
     * https://www.drupal.org/project/drupal/issues/2855139
     *
     * @param string|array|Arrayable $value
     */
    public function requiredWhen(string $inputName, $value): self
    {
        if ($value instanceof Arrayable) {
            $value = $value->toArray();
        }

        foreach ((array) $value as $conditional) {
            $this->states['required'][] = [
                ':input[name="' . $inputName . '"]' => ['value' => $conditional],
            ];
        }

        return $this;
    }

    /**
     * This will only indicate it's required on the frontend. There is currently a bug open in core for required state.
     * For now, add your own validation handler using `::validationHandler`
     * https://www.drupal.org/project/drupal/issues/2855139
     *
     * @param string|array $value
     */
    public function visibleAndRequiredWhen(string $inputName, $value): self
    {
        return $this->visibleWhen($inputName, $value)->requiredWhen($inputName, (array) $value);
    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function validationHandler(callable $validationHandler): self
    {
        $this->validationHandler = $validationHandler;

        return $this;
    }

    public function getFieldName(): string
    {
        return str_replace(' ', '_', $this->fieldName);
    }

    public function validateElement(array &$form, FormStateInterface $formState): AjaxResponse
    {
        $formState->setValidationComplete(false);

        $element = $formState->getTriggeringElement();

        $fieldName = $element['#field_name'] ?? $element['#name'] ?? null;

        if ($fieldName === null) {
            return new AjaxResponse();
        }

        $fieldNameElement = str_replace('_', '-', $fieldName);

        $validationHandler = $element['#ajax']['#validation_handler'];

        $callbackResult = call_user_func_array($validationHandler, [&$form, $formState]);

        if ($callbackResult instanceof AjaxResponse) {
            $formState->setValidationComplete(true);

            return $callbackResult;
        }

        $response = new AjaxResponse();

        $errors = $formState->getErrors();

        foreach ($formState->getErrors() as $error) {
            $response->addCommand(new CssCommand(
                '#edit-' . $fieldNameElement,
                ['border' => '1px solid red']
            ));
            $response->addCommand(new HtmlCommand(
                '.' . $fieldNameElement . '-validate-message',
                '<span style="color: red">' . $error . '</span>'
            ));
        }

        if ($errors === []) {
            $response->addCommand(new CssCommand('#edit-' . $fieldNameElement, ['border' => []]));
            $response->addCommand(new HtmlCommand('.' . $fieldNameElement . '-validate-message', ''));
        }

        $formState->setValidationComplete(true);

        return $response;
    }

    public function build(): array
    {
        $fieldValidationElementClass = str_replace('_', '-', $this->fieldName) . '-validate-message';

        $defaultValue = $this->defaultValue ?? '';

        $title = $this->title;
        if ($this->isRequired) {
            $title = $title . ' <span class="builder-required">*</span>';
        }

        $build = [
            '#type' => $this->elementType(),
            '#title' => $title,
            '#description' => $this->description,
            '#placeholder' => $this->getPlaceholder(),
            '#required' => $this->isRequired,
            '#name' => $this->getFieldName(),
            '#field_prefix' => '<span class="' . $fieldValidationElementClass . '"></span> ',
            '#access' => $this->access,
        ];

        if ($defaultValue) {
            $build['#default_value'] = $defaultValue;
        }

        if ($this->isRequired && $this->emptyValue) {
            $build['#empty_value'] = $this->emptyValue;

            if ($this instanceof SelectField) {
                $build['#empty_option'] = $this->emptyValue;
            }
        }

        if (isset($this->states)) {
            $build['#states'] = $this->states;
        }

        if (isset($this->validationHandler)) {
            $build['#ajax'] = [
                'callback' => [$this, 'validateElement'],
                'effect' => 'fade',
                'wrapper' => $this->fieldName . '_wrapper',
                'method' => 'replace',
                'event' => 'change',
                'progress' => [
                    'type' => 'throbber',
                    'message' => null,
                ],
                '#validation_handler' => $this->validationHandler,
            ];

            $build['#element_validate'] = [$this->validationHandler];
        }

        if (isset($this->value)) {
            $build['#value'] = $this->value;
        }

        $build['#attributes']['class'][] = str_replace('field_', '', $this->fieldName);

        return $build;
    }
}
