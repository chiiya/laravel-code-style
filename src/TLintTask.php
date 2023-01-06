<?php declare(strict_types=1);

namespace Chiiya\LaravelCodeStyle;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Runner\TaskResultInterface;
use GrumPHP\Task\AbstractExternalTask;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\Context\GitPreCommitContext;
use GrumPHP\Task\Context\RunContext;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TLintTask extends AbstractExternalTask
{
    public static function getConfigurableOptions(): OptionsResolver
    {
        $resolver = new OptionsResolver;
        $resolver->setDefaults([
            'triggered_by' => ['php'],
            'diff' => false,
        ]);

        $resolver->addAllowedTypes('triggered_by', ['array']);
        $resolver->addAllowedTypes('diff', ['bool']);

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

        $arguments = $this->processBuilder->createArgumentsForCommand('tlint');
        $arguments->add('lint');
        $arguments->addOptionalArgument('--diff', $config['diff']);
        $process = $this->processBuilder->buildProcess($arguments);
        $process->run();

        if (! $process->isSuccessful()) {
            return TaskResult::createFailed($this, $context, $this->formatter->format($process));
        }

        return TaskResult::createPassed($this, $context);
    }
}
