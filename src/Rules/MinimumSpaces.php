<?php

declare(strict_types=1);

namespace MinimumSpaces\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class MinimumSpaces implements ValidationRule
{
    public const MESSAGE = 'We couldn\'t deliver your message. Please try again with a little more detail.';

    public function __construct(
        private readonly int $minimum,
        private readonly ?string $message = null,
    ) {
        if ($this->minimum < 0) {
            throw new \InvalidArgumentException('Minimum spaces must be zero or greater.');
        }
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $message = $this->message ?? self::MESSAGE;

        if (! is_string($value)) {
            $fail($message);

            return;
        }

        if (substr_count($value, ' ') < $this->minimum) {
            $fail($message);
        }
    }
}
