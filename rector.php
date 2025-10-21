<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/legacy',
        __DIR__ . '/public',
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_82,
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,
    ]);

    $rectorConfig->skip([
        // Evita tocar vendor y archivos generados
        __DIR__ . '/vendor',
    ]);
};
