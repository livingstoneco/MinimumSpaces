<?php

declare(strict_types=1);

namespace MinimumSpaces\Tests;

use Illuminate\Support\Facades\Validator;
use MinimumSpaces\Rules\MinimumSpaces;

final class ValidatorExtensionTest extends TestCase
{
    public function test_min_spaces_rule_fails_with_package_message(): void
    {
        $validator = Validator::make(
            ['message' => 'hello'],
            ['message' => 'min_spaces:1']
        );

        self::assertTrue($validator->fails());
        self::assertSame(MinimumSpaces::MESSAGE, $validator->errors()->first('message'));
    }

    public function test_min_spaces_rule_passes_when_enough_spaces(): void
    {
        $validator = Validator::make(
            ['message' => 'hello world'],
            ['message' => 'min_spaces:1']
        );

        self::assertTrue($validator->passes());
    }

    public function test_min_spaces_defaults_to_one_when_parameter_omitted(): void
    {
        $validator = Validator::make(
            ['message' => 'hello'],
            ['message' => 'min_spaces']
        );

        self::assertTrue($validator->fails());
        self::assertSame(MinimumSpaces::MESSAGE, $validator->errors()->first('message'));
    }

    public function test_min_spaces_respects_numeric_parameter(): void
    {
        $validator = Validator::make(
            ['message' => 'one two three'],
            ['message' => 'min_spaces:2']
        );

        self::assertTrue($validator->passes());
    }

    public function test_object_rule_and_string_rule_produce_same_message(): void
    {
        $withString = Validator::make(
            ['a' => 'x'],
            ['a' => 'min_spaces:1']
        );
        $withObject = Validator::make(
            ['b' => 'x'],
            ['b' => [new MinimumSpaces(1)]]
        );

        self::assertTrue($withString->fails());
        self::assertTrue($withObject->fails());
        self::assertSame($withString->errors()->first('a'), $withObject->errors()->first('b'));
    }

    public function test_string_rule_message_can_be_overridden_via_validator_messages(): void
    {
        $validator = Validator::make(
            ['m' => 'hello'],
            ['m' => 'min_spaces:1'],
            ['m.min_spaces' => 'Not enough spaces, please explain more.']
        );

        self::assertTrue($validator->fails());
        self::assertSame('Not enough spaces, please explain more.', $validator->errors()->first('m'));
    }

    public function test_object_rule_accepts_custom_message_in_constructor(): void
    {
        $validator = Validator::make(
            ['body' => 'short'],
            ['body' => [new MinimumSpaces(1, 'Custom object message.')]]
        );

        self::assertTrue($validator->fails());
        self::assertSame('Custom object message.', $validator->errors()->first('body'));
    }
}
