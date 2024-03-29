<?php declare(strict_types=1);

use Chiiya\CodeStyle\CodeStyle;
use Rector\Config\RectorConfig;

return static function (RectorConfig $config): void {
    $config->paths([
        __DIR__.'/src',
    ]);
    $config->importNames();
    $config->import(CodeStyle::RECTOR);
};
