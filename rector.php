<?php

declare(strict_types=1);

return static function (Rector\Config\RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/lang',
        __DIR__ . '/routes',
        __DIR__ . '/modules',
    ]);

    $rectorConfig->skip([
        \Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector::class,
        \Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::class,
        \Rector\Php81\Rector\Array_\FirstClassCallableRector::class,
        \Rector\CodeQuality\Rector\FuncCall\BoolvalToTypeCastRector::class,
        \Rector\CodeQuality\Rector\FuncCall\FloatvalToTypeCastRector::class,
        \Rector\CodeQuality\Rector\FuncCall\StrvalToTypeCastRector::class,
        \Rector\CodeQuality\Rector\FuncCall\IntvalToTypeCastRector::class,
        \Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector::class,
        \Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector::class,
        \Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class,
        \Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class,
        \Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector::class,
        \Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector::class,
        \Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector::class,
        \Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class,
        \Rector\CodingStyle\Rector\Closure\StaticClosureRector::class,
        \Rector\DeadCode\Rector\ClassMethod\RemoveDelegatingParentCallRector::class,
    ]);

    // register a single rule
    $rectorConfig->rule(\Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector::class);

    // define sets of rules
    $rectorConfig->sets([
        \Rector\Set\ValueObject\LevelSetList::UP_TO_PHP_82,
        \RectorLaravel\Set\LaravelSetList::LARAVEL_100,
        \RectorLaravel\Set\LaravelSetList::LARAVEL_CODE_QUALITY,
        \Rector\Set\ValueObject\SetList::CODE_QUALITY,
        \Rector\Set\ValueObject\SetList::CODING_STYLE,
        \Rector\Set\ValueObject\SetList::DEAD_CODE,
        \Rector\Set\ValueObject\SetList::GMAGICK_TO_IMAGICK,
        \Rector\Set\ValueObject\SetList::NAMING,
        \Rector\Set\ValueObject\SetList::PRIVATIZATION,
        \Rector\Set\ValueObject\SetList::PSR_4,
        \Rector\Set\ValueObject\SetList::TYPE_DECLARATION,
        \Rector\Set\ValueObject\SetList::EARLY_RETURN,
    ]);
};
