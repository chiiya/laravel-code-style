<?php declare(strict_types=1);

namespace Chiiya\LaravelCodeStyle;

use GrumPHP\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class GrumPHPExtensionLoader implements ExtensionInterface
{
    public function load(ContainerBuilder $container): void
    {
        $container
            ->register('task.tlint', TLintTask::class)
            ->addArgument(new Reference('process_builder'))
            ->addArgument(new Reference('formatter.raw_process'))
            ->addTag('grumphp.task', ['task' => 'tlint']);
        $container
            ->register('task.rector', RectorTask::class)
            ->addArgument(new Reference('process_builder'))
            ->addArgument(new Reference('formatter.raw_process'))
            ->addTag('grumphp.task', ['task' => 'rector']);
    }
}
