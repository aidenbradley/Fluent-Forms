<?php

namespace Drupal\Tests\fluent_forms\Unit;

use Drupal\fluent_forms\Form;
use Drupal\Tests\UnitTestCase;

class FormElementBuilderTest extends UnitTestCase
{
    /** @test */
    public function strips_field_from_machine_name(): void
    {
        Form::textField('field_address');

        $build = Form::build();

        $this->assertArrayHasKey('field_address', $build);
        $this->assertEquals($build['field_address']['#name'], 'field_address');

        $renderArray = $build['field_address'];

        $this->assertEquals('textfield', $renderArray['#type']);
        $this->assertEquals('Address', $renderArray['#title']);
    }

    /** @test */
    public function address_field(): void
    {
        $title = 'Enter Address';

        Form::addressField($title);

        $build = Form::build();

        $this->assertArrayHasKey('enter_address', $build);
        $this->assertEquals($build['enter_address']['#name'], 'enter_address');

        $renderArray = $build['enter_address'];

        $this->assertEquals('address', $renderArray['#type']);
        $this->assertEquals($title, $renderArray['#title']);
    }

    /** @test */
    public function checkbox_field(): void
    {
        $title = 'Select Yes Or No';

        Form::checkboxField($title);

        $build = Form::build();

        $this->assertArrayHasKey('select_yes_or_no', $build);
        $this->assertEquals($build['select_yes_or_no']['#name'], 'select_yes_or_no');

        $renderArray = $build['select_yes_or_no'];

        $this->assertEquals('checkbox', $renderArray['#type']);
        $this->assertEquals($title, $renderArray['#title']);
    }

    /** @test */
    public function email_field(): void
    {
        $title = 'Your Email Address';

        Form::emailField($title);

        $build = Form::build();

        $this->assertArrayHasKey('your_email_address', $build);
        $this->assertEquals($build['your_email_address']['#name'], 'your_email_address');

        $renderArray = $build['your_email_address'];

        $this->assertEquals('email', $renderArray['#type']);
        $this->assertEquals($title, $renderArray['#title']);
    }

    /** @test */
    public function markup(): void
    {
        $title = 'Example text to render';

        Form::markup($title);

        $build = Form::build();

        $renderArray = reset($build);

        $this->assertEquals($title, $renderArray['#markup']);
    }

    /** @test */
    public function multi_select_field(): void
    {
        $title = 'Select Your Examples';

        Form::multiSelectField($title);

        $build = Form::build();

        $this->assertArrayHasKey('select_your_examples', $build);
        $this->assertEquals($build['select_your_examples']['#name'], 'select_your_examples');

        $renderArray = $build['select_your_examples'];

        $this->assertEquals('select', $renderArray['#type']);
        $this->assertTrue($renderArray['#multiple']);
        $this->assertEquals($title, $renderArray['#title']);
    }

    /** @test */
    public function select_field(): void
    {
        $title = 'Select Your Examples';

        Form::selectField($title);

        $build = Form::build();

        $this->assertArrayHasKey('select_your_examples', $build);
        $this->assertEquals($build['select_your_examples']['#name'], 'select_your_examples');

        $renderArray = $build['select_your_examples'];

        $this->assertEquals('select', $renderArray['#type']);
        $this->assertEquals($title, $renderArray['#title']);
    }

    /** @test */
    public function select_processes_arrayables(): void
    {
        $title = 'Select Your Examples';

        $options = collect([
            'test' => 'test',
            'second' => 'second',
            'item' => 'item',
        ]);

        Form::selectField($title)->setOptions($options);

        $build = Form::build();

        $renderArray = $build['select_your_examples'];

        $this->assertEquals($options->toArray(), $renderArray['#options']);
    }

    /** @test */
    public function text_area_field(): void
    {
        $title = 'Text Area For Examples';

        Form::textAreaField($title);

        $build = Form::build();

        $this->assertArrayHasKey('text_area_for_examples', $build);
        $this->assertEquals($build['text_area_for_examples']['#name'], 'text_area_for_examples');

        $renderArray = $build['text_area_for_examples'];

        $this->assertEquals('textarea', $renderArray['#type']);
        $this->assertEquals($title, $renderArray['#title']);
    }

    /** @test */
    public function text_field(): void
    {
        $title = 'Text Field Example';

        Form::textField($title);

        $build = Form::build();

        $this->assertArrayHasKey('text_field_example', $build);
        $this->assertEquals($build['text_field_example']['#name'], 'text_field_example');

        $renderArray = $build['text_field_example'];

        $this->assertEquals('textfield', $renderArray['#type']);
        $this->assertEquals($title, $renderArray['#title']);
    }

    /** @test */
    public function url_field(): void
    {
        $title = 'URL Field Example';

        Form::urlField($title);

        $build = Form::build();

        $this->assertArrayHasKey('url_field_example', $build);
        $this->assertEquals($build['url_field_example']['#name'], 'url_field_example');

        $renderArray = $build['url_field_example'];

        $this->assertEquals('url', $renderArray['#type']);
        $this->assertEquals($title, $renderArray['#title']);
    }

    /** @test */
    public function radio_field(): void
    {
        $title = 'Radio Field Example';

        Form::radioField($title);

        $build = Form::build();

        $this->assertArrayHasKey('radio_field_example', $build);
        $this->assertEquals($build['radio_field_example']['#name'], 'radio_field_example');

        $renderArray = $build['radio_field_example'];

        $this->assertEquals('radios', $renderArray['#type']);
        $this->assertEquals($title, $renderArray['#title']);
    }

    /** @test */
    public function hidden_field(): void
    {
        $title = 'Example text to render';

        Form::hiddenField('Hidden Field')->defaultValue($title);

        $build = Form::build();

        $this->assertArrayHasKey('hidden_field', $build);

        $renderArray = $build['hidden_field'];

        $this->assertEquals('hidden', $renderArray['#type']);
        $this->assertEquals($title, $renderArray['#value']);
    }

    /** @test */
    public function password_field(): void
    {
        $title = 'Password Field Example';

        Form::passwordField($title);

        $build = Form::build();

        $this->assertArrayHasKey('password_field_example', $build);
        $this->assertEquals($build['password_field_example']['#name'], 'password_field_example');

        $renderArray = $build['password_field_example'];

        $this->assertEquals('password', $renderArray['#type']);
        $this->assertEquals($title, $renderArray['#title']);
    }

    /** @test */
    public function entity_autocomplete(): void
    {
        Form::entityAutocomplete('invoiceable_user')
            ->targets('user')
            ->selectionHandler('default:my_selection_handler')
            ->selectionSettings([
                'selection_1' => 'setting_1',
                'selection_2' => 'setting_2',
            ])
            ->size(10)
            ->maxLength(20);

        $build = Form::build();

        $this->assertArrayHasKey('invoiceable_user', $build);
        $this->assertEquals($build['invoiceable_user']['#name'], 'invoiceable_user');

        $renderArray = $build['invoiceable_user'];

        $this->assertEquals('entity_autocomplete', $renderArray['#type']);
        $this->assertEquals('user', $renderArray['#target_type']);
        $this->assertEquals('default:my_selection_handler', $renderArray['#selection_handler']);
        $this->assertEquals([
            'selection_1' => 'setting_1',
            'selection_2' => 'setting_2',
        ], $renderArray['#selection_settings']);
        $this->assertEquals(10, $renderArray['#size']);
        $this->assertEquals(20, $renderArray['#maxlength']);
    }

    /** @test */
    public function set_access(): void
    {
        Form::textField('my_field')->access(true);

        $build = Form::build();

        $this->assertTrue($build['my_field']['#access']);

        Form::textField('My Field')->access(false);

        $build = Form::build();

        $this->assertFalse($build['my_field']['#access']);
    }

    /** @test */
    public function set_placeholder(): void
    {
        $title = 'Text Field Example';
        $placeholderText = 'My Placeholder';

        Form::textField('text_field_example', $title)->placeholder($placeholderText);

        $build = Form::build();

        $this->assertEquals($placeholderText, $build['text_field_example']['#placeholder']);
    }

    /** @test */
    public function set_default_value(): void
    {
        $title = 'Text Field Example';
        $defaultValueText = 'My Default Value';

        Form::textField('text_field_example', $title)->defaultValue($defaultValueText);

        $build = Form::build();

        $this->assertEquals($defaultValueText, $build['text_field_example']['#default_value']);
    }

    /** @test */
    public function set_value(): void
    {
        $title = 'Text Field Example';
        $defaultValueText = 'My Default Value';

        Form::textField('text_field_example', $title)->value($defaultValueText);

        $build = Form::build();

        $this->assertEquals($defaultValueText, $build['text_field_example']['#value']);
    }

    /** @test */
    public function set_is_required(): void
    {
        $title = 'Required Text Field';

        Form::textField($title)->isRequired();

        $title = 'Not Required Text Field';

        Form::textField($title)->isRequired(false);

        $build = Form::build();

        $this->assertTrue($build['required_text_field']['#required']);
        $this->assertFalse($build['not_required_text_field']['#required']);
    }

    /** @test */
    public function set_description(): void
    {
        $title = 'Text Field Example';
        $descriptionText = 'Example Description';

        Form::textField('text_field_example', $title)->description($descriptionText);

        $build = Form::build();

        $this->assertEquals($descriptionText, $build['text_field_example']['#description']);
    }

    /** @test */
    public function set_validation_handler(): void
    {
        $title = 'Text Field Example';

        /** @var $callable */
        $callable = [$this, 'validationHandler'];

        Form::textField($title)->validationHandler($callable);

        $build = Form::build();

        $render = $build['text_field_example'];

        $this->assertEquals($callable, $render['#ajax']['#validation_handler']);

        call_user_func_array($render['#ajax']['#validation_handler'], []);

        // we expect the callable above to call the validationHandler method on
        // this class which increases the assertion count by 1.
        $this->assertEquals(1, $this->getNumAssertions());
    }

    /** @test */
    public function use_callable_to_set_select_field_options(): void
    {
        $selectElement = Form::selectField('example_select')->setOptions([$this, 'selectCallable']);

        $this->assertEquals(
            array_values($this->selectCallable()),
            array_values($selectElement->build()['example_select']['#options'])
        );

        $closure = function () {
            return [
                'anonymous',
                'anonymous 2',
                'anonymous 3',
            ];
        };

        $selectElement = Form::selectField('example_select')->setOptions($closure);

        $this->assertEquals(
            array_values($closure()),
            array_values($selectElement->build()['example_select']['#options'])
        );
    }

    /** @test */
    public function use_callable_to_set_default_value(): void
    {
        Form::textField('example_text')->defaultValue([$this, 'textCallable']);

        $build = Form::build();

        $this->assertEquals($this->textCallable(), $build['example_text']['#default_value']);

        $closure = function () {
            return 'closure example';
        };

        Form::textField('example_text')->defaultValue($closure);

        $build = Form::build();

        $this->assertEquals($closure(), $build['example_text']['#default_value']);
    }

    /** @test */
    public function submit(): void
    {
        Form::submitButton('submit')->value('Submit this');

        $build = Form::build();

        $this->assertArrayHasKey('submit', $build);
        $this->assertEquals($build['submit']['#name'], 'submit');

        $renderArray = $build['submit'];

        $this->assertEquals('submit', $renderArray['#type']);
        $this->assertEquals('Submit this', $renderArray['#value']);
    }

    public function textCallable(): string
    {
        return 'example value';
    }

    public function selectCallable(): array
    {
        return [
            'test',
            'test 2',
            'test 3',
        ];
    }

    public function validationHandler(): void
    {
        $this->addToAssertionCount(1);
    }
}
