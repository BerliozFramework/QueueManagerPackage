<?php
/*
 * This file is part of Berlioz framework.
 *
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2024 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

declare(strict_types=1);

namespace Berlioz\Package\QueueManager\Command;

use Berlioz\CliCore\Command\AbstractCommand;
use Berlioz\QueueManager\Handler\JobHandlerManager;
use Berlioz\QueueManager\QueueManager;
use Berlioz\QueueManager\Worker;
use Berlioz\QueueManager\WorkerOptions;
use GetOpt\GetOpt;
use GetOpt\Option;
use Psr\Log\AbstractLogger;


#[Argument('memoryLimit', longPrefix: 'memory', description: 'Memory limit (MB)', defaultValue: 0, castTo: 'int')]
#[Argument('timeLimit', longPrefix: 'time', description: 'Time limit (in seconds)', defaultValue: 0, castTo: 'int')]
#[Argument('backoff', longPrefix: 'backoff', description: 'Backoff time (in seconds)', defaultValue: 0, castTo: 'int')]
#[Argument('killFilePath', longPrefix: 'kill-file', description: 'Kill file path', castTo: 'string')]
#[Argument('verbose', prefix: 'v', description: 'Verbose', noValue: true, castTo: 'bool')]
class QueueWorkerCommand extends AbstractCommand
{
    public function __construct(
        private readonly JobHandlerManager $jobHandlerManager,
        private readonly QueueManager $queueManager,
    ) {
    }

    /**
     * @inheritDoc
     */
    public static function getShortDescription(): ?string
    {
        return 'Start work for queues jobs';
    }

    /**
     * @inheritDoc
     */
    public static function getOptions(): array
    {
        return [
            (new Option('n', 'name', GetOpt::OPTIONAL_ARGUMENT))
                ->setDescription('Worker name'),
            (new Option('q', 'queue', GetOpt::MULTIPLE_ARGUMENT))
                ->setDescription('Queue name'),
            (new Option(null, 'limit', GetOpt::OPTIONAL_ARGUMENT))
                ->setDescription('Limit')
                ->setValidation('is_numeric'),
            (new Option(null, 'delay', GetOpt::OPTIONAL_ARGUMENT))
                ->setDescription('Delay between 2 consumption (in seconds)')
                ->setValidation('is_numeric'),
            (new Option(null, 'delay-no-job', GetOpt::OPTIONAL_ARGUMENT))
                ->setDescription('Delay if no job (in seconds)')
                ->setValidation('is_numeric'),
            (new Option(null, 'memory', GetOpt::OPTIONAL_ARGUMENT))
                ->setDescription('Memory limit (MB)')
                ->setValidation('is_numeric'),
            (new Option(null, 'time', GetOpt::OPTIONAL_ARGUMENT))
                ->setDescription('Time limit (in seconds)')
                ->setValidation('is_numeric'),
            (new Option(null, 'backoff', GetOpt::OPTIONAL_ARGUMENT))
                ->setDescription('Backoff time (in seconds)')
                ->setValidation('is_numeric'),
            (new Option(null, 'kill-file', GetOpt::OPTIONAL_ARGUMENT))
                ->setDescription('Kill file path'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function run(GetOpt $getOpt): int
    {
        $logger = new class extends AbstractLogger {
            public function log($level, $message, array $context = array()): void
            {
                $message = (string)$message;

                foreach ($context as $key => $val) {
                    $placeholder = "{" . $key . "}";

                    if (str_contains($message, $placeholder)) {
                        $val = (string)$val;
                        $message = str_replace($placeholder, $val, $message);
                        unset($context[$key]);
                    }
                }

                print $message;
            }
        };

        $worker = new Worker($this->jobHandlerManager);
        $worker->setLogger($logger);

        return $worker->run(
            $this->queueManager->filter(...$getOpt->getOption('queue')),
            new WorkerOptions(
                name: $getOpt->getOption('name') ?: null,
                limit: $getOpt->getOption('limit') ?: INF,
                memoryLimit: $getOpt->getOption('memoryLimit') ?: INF,
                timeLimit: $getOpt->getOption('timeLimit') ?: INF,
                killFilePath: $getOpt->getOption('killFilePath'),
                sleep: $getOpt->getOption('delay'),
                sleepNoJob: $getOpt->getOption('delayNoJob'),
                backoffTime: (int)$getOpt->getOption('backoff'),
            )
        );
    }
}
