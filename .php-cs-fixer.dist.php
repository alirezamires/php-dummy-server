<?php

$finder = PhpCsFixer\Finder::create()
    ->in(['app', 'tests', 'database/factories', 'database/seeders'])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();

return $config->setRules(
    [
        '@Symfony' => true,
        '@PSR12' => true,
        '@PSR1' => true,
        '@PSR2' => true,
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
        'concat_space' => ['spacing' => 'one'],
        'global_namespace_import' => ['import_classes' => true, 'import_constants' => true, 'import_functions' => true],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'type_declaration_spaces' => ['elements' => ['property']],
        'php_unit_method_casing' => ['case' => 'snake_case'],
    ]
)
    ->setFinder($finder);
