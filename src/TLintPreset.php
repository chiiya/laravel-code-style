<?php declare(strict_types=1);

namespace Chiiya\LaravelCodeStyle;

use Tighten\TLint\Formatters;
use Tighten\TLint\Linters\ApplyMiddlewareInRoutes;
use Tighten\TLint\Linters\ArrayParametersOverViewWith;
use Tighten\TLint\Linters\MailableMethodsInBuild;
use Tighten\TLint\Linters\NoDatesPropertyOnModels;
use Tighten\TLint\Linters\NoDocBlocksForMigrationUpDown;
use Tighten\TLint\Linters\NoJsonDirective;
use Tighten\TLint\Linters\NoSpaceAfterBladeDirectives;
use Tighten\TLint\Linters\QualifiedNamesOnlyForClassName;
use Tighten\TLint\Linters\RemoveLeadingSlashNamespaces;
use Tighten\TLint\Linters\RequestHelperFunctionWherePossible;
use Tighten\TLint\Linters\RequestValidation;
use Tighten\TLint\Linters\SpaceAfterBladeDirectives;
use Tighten\TLint\Linters\SpacesAroundBladeRenderContent;
use Tighten\TLint\Presets\PresetInterface;

class TLintPreset implements PresetInterface
{
    public function getLinters(): array
    {
        return [
            ApplyMiddlewareInRoutes::class,
            ArrayParametersOverViewWith::class,
            MailableMethodsInBuild::class,
            NoDatesPropertyOnModels::class,
            NoDocBlocksForMigrationUpDown::class,
            NoSpaceAfterBladeDirectives::class,
            QualifiedNamesOnlyForClassName::class,
            RemoveLeadingSlashNamespaces::class,
            RequestHelperFunctionWherePossible::class,
            RequestValidation::class,
            SpaceAfterBladeDirectives::class,
            SpacesAroundBladeRenderContent::class,
            NoJsonDirective::class,
        ];
    }

    public function getFormatters(): array
    {
        return [Formatters\NoDocBlocksForMigrationUpDown::class];
    }
}
