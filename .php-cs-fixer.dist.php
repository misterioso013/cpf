<?php

$finder = PhpCsFixer\Finder::create()
  ->in([
    __DIR__ . '/src',
    __DIR__ . '/tests',
  ]);

return (new PhpCsFixer\Config())
  ->setRules([
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'no_unused_imports' => true,
    'declare_strict_types' => true,
  ])
  ->setRiskyAllowed(true)
  ->setFinder($finder);
