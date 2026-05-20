<?php

declare(strict_types=1);

namespace MinimumSpaces\Tests;

use MinimumSpaces\Rules\MinimumSpaces;
use PHPUnit\Framework\TestCase;

final class MinimumSpacesRuleTest extends TestCase
{
    public function test_passes_when_space_count_equals_minimum(): void
    {
        $failures = [];
        (new MinimumSpaces(2))->validate('body', 'one two three', static function (string $message) use (&$failures): void {
            $failures[] = $message;
        });

        self::assertSame([], $failures);
    }

    public function test_passes_when_space_count_exceeds_minimum(): void
    {
        $failures = [];
        (new MinimumSpaces(1))->validate('body', 'hello world test', static function (string $message) use (&$failures): void {
            $failures[] = $message;
        });

        self::assertSame([], $failures);
    }

    public function test_counts_all_ascii_space_characters(): void
    {
        $failures = [];
        (new MinimumSpaces(2))->validate('body', 'a  b', static function (string $message) use (&$failures): void {
            $failures[] = $message;
        });

        self::assertSame([], $failures);
    }

    public function test_fails_with_fixed_message_when_below_minimum(): void
    {
        $failures = [];
        (new MinimumSpaces(2))->validate('body', 'one two', static function (string $message) use (&$failures): void {
            $failures[] = $message;
        });

        self::assertSame([MinimumSpaces::MESSAGE], $failures);
    }

    public function test_fails_with_fixed_message_when_value_is_not_string(): void
    {
        $failures = [];
        (new MinimumSpaces(0))->validate('body', ['nested'], static function (string $message) use (&$failures): void {
            $failures[] = $message;
        });

        self::assertSame([MinimumSpaces::MESSAGE], $failures);
    }

    public function test_constructor_rejects_negative_minimum(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Minimum spaces must be zero or greater.');

        new MinimumSpaces(-1);
    }

    public function test_minimum_of_zero_allows_string_without_spaces(): void
    {
        $failures = [];
        (new MinimumSpaces(0))->validate('body', 'nospaces', static function (string $message) use (&$failures): void {
            $failures[] = $message;
        });

        self::assertSame([], $failures);
    }

    public function test_uses_custom_message_when_provided(): void
    {
        $failures = [];
        (new MinimumSpaces(1, 'Please add more detail.'))->validate('body', 'nospaces', static function (string $message) use (&$failures): void {
            $failures[] = $message;
        });

        self::assertSame(['Please add more detail.'], $failures);
    }
}
