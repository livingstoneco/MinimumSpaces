<?php

declare(strict_types=1);

namespace MinimumSpaces;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use MinimumSpaces\Rules\MinimumSpaces;

final class MinimumSpacesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Validator::extend(
            'min_spaces',
            static function (string $attribute, mixed $value, array $parameters, mixed $validator): bool {
                $minimum = isset($parameters[0]) ? (int) $parameters[0] : 1;

                if (! is_string($value)) {
                    return false;
                }

                return substr_count($value, ' ') >= $minimum;
            },
            MinimumSpaces::MESSAGE
        );
    }
}
