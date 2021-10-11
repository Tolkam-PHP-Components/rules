# tolkam/rules

Tools for validating data against predefined rules

## Usage

````php
use Tolkam\Rules\Rule;
use Tolkam\Rules\FlattenStrategy\DefaultFlattenStrategy;

// input data
$input = [
    'a' => [
        'aa' => new \DateTime,
        'ab' => 500,
    ],
    'b' => null,
    'c' => [
        [
            'ip' => null,
            'hash' => null,
        ],
        [
            'hash' => false,
        ],
    ],
];

// rules to validate the input against
$rules = new Rule\Arr([
    'a' => new Rule\Arr([
        'aa' => new Rule\Type(\DateTime::class),
        'ab' => new Rule\NotEmpty(new Rule\Type('integer')),
        'ac' => new Rule\Arr([
            'aca' => new Rule\Type('array'),
        ]),
    ]),
    'b' => new Rule\Sequence(
        new Rule\NotEmpty,
        new Rule\Choice(['x', 'y', 'z'])
    ),
    'c' => new Rule\ArrayOf(
        new Rule\Arr([
            'hash' => new Rule\Type('string'),
            'ip' => new Rule\Type('string'),
        ])
    ),
    'd' => new Rule\NotEmpty,
]);

// apply rules and get failures, if any
$result = $rules
    ->apply($input)
    ->flatten(new DefaultFlattenStrategy)
    ->toArray();
````

## Documentation

The code is rather self-explanatory and API is intended to be as simple as possible. Please, read the sources/Docblock if you have any questions. See [Usage](#usage) for quick start.

## License

Proprietary / Unlicensed 🤷
