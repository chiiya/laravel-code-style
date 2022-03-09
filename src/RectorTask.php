<?php

namespace Chiiya\LaravelCodeStyle;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Collection\ProcessArgumentsCollection;
use GrumPHP\Fixer\Provider\FixableProcessResultProvider;
use GrumPHP\Runner\TaskResult;
use GrumPHP\Runner\TaskResultInterface;
use GrumPHP\Task\AbstractExternalTask;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\Context\GitPreCommitContext;
use GrumPHP\Task\Context\RunContext;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RectorTask extends AbstractExternalTask
{
    public static function getConfigurableOptions(): OptionsResolver
    {
        $resolver = new OptionsResolver;
        $resolver->setDefaults([
            'whitelist_patterns' => [],
            'clear-cache' => false,
            'config' => 'rector.php',
            'triggered_by' => ['php'],
            'ignore_patterns' => [],
            'no-progress-bar' => false,
            'files_on_pre_commit' => false,
            'paths' => [],
        ]);

        $resolver->addAllowedTypes('whitelist_patterns', ['array']);
        $resolver->addAllowedTypes('clear-cache', ['bool']);
        $resolver->addAllowedTypes('config', ['null', 'string']);
        $resolver->addAllowedTypes('triggered_by', ['array']);
        $resolver->addAllowedTypes('ignore_patterns', ['array']);
        $resolver->addAllowedTypes('no-progress-bar', ['bool']);
        $resolver->addAllowedTypes('files_on_pre_commit', ['bool']);
        $resolver->addAllowedTypes('paths', ['array']);

        return $resolver;
    }

    public function canRunInContext(ContextInterface $context): bool
    {
        return $context instanceof GitPreCommitContext || $context instanceof RunContext;
    }

    public function run(ContextInterface $context): TaskResultInterface
    {
        $config = $this->getConfig()->getOptions();

        $files = $context->getFiles()->extensions($config['triggered_by']);

        if (count($files) === 0) {
            return TaskResult::createSkipped($this, $context);
        }

        $arguments = $this->processBuilder->createArgumentsForCommand('rector');
        $arguments->add('process');
        $arguments->add('--dry-run');

        foreach ($config['whitelist_patterns'] as $whitelistPattern) {
            $arguments->add($whitelistPattern);
        }

        $arguments->addOptionalArgument('--config=%s', $config['config']);
        $arguments->addOptionalArgument('--clear-cache', $config['clear-cache']);
        $arguments->addOptionalArgument('--no-progress-bar', $config['clear-cache']);
        $arguments->addOptionalArgument('--ansi', true);
        $this->addPaths($arguments, $context, $files, $config);

        $process = $this->processBuilder->buildProcess($arguments);
        $process->run();

        if (! $process->isSuccessful()) {
            return FixableProcessResultProvider::provide(
                TaskResult::createFailed($this, $context, $this->formatter->format($process)),
                function () use ($arguments) {
                    $arguments->removeElement('--dry-run');

                    return $this->processBuilder->buildProcess($arguments);
                },
            );
        }

        return TaskResult::createPassed($this, $context);
    }

    /**
     * This method adds the newly committed files in pre commit context if you enabled the files_on_pre_commit flag. In
     * other cases, it falls back to the configured paths. If no paths have been set, the paths from inside your rector
     * configuration file will be used.
     */
    private function addPaths(
        ProcessArgumentsCollection $arguments,
        ContextInterface $context,
        FilesCollection $files,
        array $config,
    ): void {
        if ($context instanceof GitPreCommitContext && $config['files_on_pre_commit']) {
            $arguments->addFiles($files);

            return;
        }

        $arguments->addArgumentArray('%s', $config['paths']);
    }
}
