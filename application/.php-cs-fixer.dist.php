<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'tests'])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'phpdoc_to_comment' => false,
    ])
    ->setFinder($finder)
    ;