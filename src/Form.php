<?php

namespace Drupal\fluent_forms;

use Drupal\fluent_forms\Contracts\FormElementContract;

/**
 * @method static \Drupal\fluent_forms\FormElements\Markup markup(string $title)
 * @method static \Drupal\fluent_forms\FormElements\AddressField addressField(string $fieldName, ?string $title = null)
 * @method static \Drupal\fluent_forms\FormElements\CheckboxField checkboxField(string $fieldName, ?string $title = null)
 * @method static \Drupal\fluent_forms\FormElements\EmailField emailField(string $fieldName, ?string $title = null)
 * @method static \Drupal\fluent_forms\FormElements\MultiSelectField multiSelectField(string $fieldName, ?string $title = null)
 * @method static \Drupal\fluent_forms\FormElements\SelectField selectField(string $fieldName, ?string $title = null)
 * @method static \Drupal\fluent_forms\FormElements\TextAreaField textAreaField(string $fieldName, ?string $title = null)
 * @method static \Drupal\fluent_forms\FormElements\TextField textField(string $fieldName, ?string $title = null)
 * @method static \Drupal\fluent_forms\FormElements\UrlField urlField(string $fieldName, ?string $title = null)
 * @method static \Drupal\fluent_forms\FormElements\RadioField radioField(string $fieldName, ?string $title = null)
 * @method static \Drupal\fluent_forms\FormElements\HiddenField hiddenField(string $fieldName, ?string $title = null)
 * @method static \Drupal\fluent_forms\FormElements\PasswordField passwordField(string $fieldName, ?string $title = null)
 * @method static \Drupal\fluent_forms\FormElements\EntityAutocomplete entityAutocomplete(string $fieldName, ?string $title = null)
 * @method static \Drupal\fluent_forms\FormElements\SubmitButton submitButton(string $fieldName, ?string $title = null)
 */
class Form
{
    /** @var array */
    protected static $elements = [];

    /** @var callable */
    protected static $defaultValueHandler;

    /** @var self */
    private static $instance;

    public static function setDefaultValueHandler(callable $callable): self
    {
        $instance = self::getInstance();

        $instance::$defaultValueHandler = $callable;

        return $instance;
    }

    private static function getInstance(): self
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }

        return new self();
    }

    public static function build(): array
    {
        $instance = self::getInstance();

        $renderArray = collect($instance::$elements)->mapWithKeys(function (FormElementContract $element) {
            return [$element->getFieldName() => $element->build()];
        })->toArray();

        $instance::$elements = [];

        return $renderArray;
    }

    public function __call(string $method, array $args): self
    {
        /** @var callable $callable */
        $callable = [end(self::$elements), $method];

        call_user_func_array($callable, $args);

        return self::getInstance();
    }

    public static function __callStatic(string $method, array $args): self
    {
        $instance = self::getInstance();

        if (method_exists($instance, $method) === false) {
            /** @var callable $callable */
            $callable = [__NAMESPACE__ . '\FormElements\\' . ucfirst($method), 'create'];

            /** @var \Drupal\fluent_forms\Contracts\FormElementContract $element */
            $element = call_user_func_array($callable, $args);

            self::$elements[$element->getFieldName()] = $element;
        }

        return $instance;
    }
}
