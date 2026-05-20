# Minimum Spaces (Laravel)

Validation for Laravel 11+ that requires a field to contain at least a given number of space characters (`U+0020`).

The default validation message is:

> We couldn't deliver your message. Please try again with a little more detail.

You can override it per rule or when calling the validator (see below).

## Installation

```bash
composer require livingstoneco/minimum-spaces
```

Laravel will register the service provider automatically (package discovery).

## Usage

### Rule object (recommended)

```php
use MinimumSpaces\Rules\MinimumSpaces;

$request->validate([
    'message' => ['required', 'string', new MinimumSpaces(2)],
]);
```

### String rule alias

```php
$request->validate([
    'message' => ['required', 'string', 'min_spaces:2'],
]);
```

The numeric parameter is the minimum number of spaces required.

### Custom error message

**Rule object** — pass a second argument:

```php
new MinimumSpaces(2, 'My custom error message.')
```

**String rule or any validator** — pass a messages array (attribute + snake-case rule name):

```php
$request->validate(
    ['message' => ['required', 'string', 'min_spaces:2']],
    ['message.min_spaces' => 'Please add more detail before sending.'],
);

// Or with Validator::make / FormRequest::validateResolved patterns:
Validator::make($data, $rules, [
    'message.min_spaces' => 'Please add more detail before sending.',
]);
```

## Testing

Clone the package and run:

```bash
composer install
composer test
```

## License

MIT
