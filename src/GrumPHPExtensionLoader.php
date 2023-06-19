<?php declare(strict_types=1);

namespace Chiiya\LaravelCodeStyle;

use GrumPHP\Extension\ExtensionInterface;

class GrumPHPExtensionLoader implements ExtensionInterface
{
    public function imports(): iterable
    {
        yield __DIR__.'/extensions.yaml';
    }
}
