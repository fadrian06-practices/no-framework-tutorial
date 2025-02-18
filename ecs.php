<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use SlevomatCodingStandard\Sniffs\Classes\ClassConstantVisibilitySniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\NewWithoutParenthesesSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\AlphabeticallySortedUsesSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\DisallowGroupUseSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\MultipleUsesPerLineSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\NamespaceSpacingSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\ReferenceUsedNamesOnlySniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UseSpacingSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\UnionTypeHintFormatSniff;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return ECSConfig::configure()
    ->withParallel()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/ecs.php', __DIR__ . '/rector.php'])
    ->withSkip([BlankLineAfterOpeningTagFixer::class, OrderedImportsFixer::class, NewWithBracesFixer::class])
    ->withSets([
        SetList::PSR_12,
        SetList::STRICT,
        SetList::ARRAY,
        SetList::SPACES,
        SetList::DOCBLOCK,
        SetList::CLEAN_CODE,
        SetList::COMMON,
        SetList::COMMENTS,
        SetList::NAMESPACES,
        SetList::SYMPLIFY,
        SetList::CONTROL_STRUCTURES,
    ])
  // force visibility declaration on class constants
    ->withConfiguredRule(ClassConstantVisibilitySniff::class, [
        'fixable' => true,
    ])
  // sort all use statements
    ->withRules([
        AlphabeticallySortedUsesSniff::class,
        DisallowGroupUseSniff::class,
        MultipleUsesPerLineSniff::class,
        NamespaceSpacingSniff::class,
    ])
  // import all namespaces, and even php core functions and classes
    ->withConfiguredRule(
        ReferenceUsedNamesOnlySniff::class,
        [
            'allowFallbackGlobalConstants' => false,
            'allowFallbackGlobalFunctions' => false,
            'allowFullyQualifiedGlobalClasses' => false,
            'allowFullyQualifiedGlobalConstants' => false,
            'allowFullyQualifiedGlobalFunctions' => false,
            'allowFullyQualifiedNameForCollidingClasses' => true,
            'allowFullyQualifiedNameForCollidingConstants' => true,
            'allowFullyQualifiedNameForCollidingFunctions' => true,
            'searchAnnotations' => true,
        ]
    )
  // define newlines between use statements
    ->withConfiguredRule(UseSpacingSniff::class, [
        'linesCountBeforeFirstUse' => 1,
        'linesCountBetweenUseTypes' => 1,
        'linesCountAfterLastUse' => 1,
    ])
  // strict types declaration should not be on same line as opening tag
    ->withConfiguredRule(
        DeclareStrictTypesSniff::class,
        [
            'declareOnFirstLine' => false,
            'spacesCountAroundEqualsSign' => 0,
        ]
    )
  // disallow ?Foo typehint in favor of Foo|null
    ->withConfiguredRule(UnionTypeHintFormatSniff::class, [
        'withSpaces' => 'no',
        'shortNullable' => 'no',
        'nullPosition' => 'last',
    ])
  // Remove useless parentheses in new statements
    ->withRules([NewWithoutParenthesesSniff::class]);
