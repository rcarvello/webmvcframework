<?php
declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/framework',
        __DIR__ . '/controllers',
        __DIR__ . '/models',
        __DIR__ . '/views',
        __DIR__ . '/util',
        __DIR__ . '/classes',
    ])
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRules([
        'nullable_type_declaration_for_default_null_value' => true,
    ]);

foreach ($finder as $file) {
    echo $file->getRealPath() . PHP_EOL;
}
