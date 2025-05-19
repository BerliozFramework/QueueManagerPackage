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
use Berlioz\QueueManager\Queue\PurgeableQueueInterface;
use Berlioz\QueueManager\Queue\QueueInterface;
use Berlioz\QueueManager\QueueManager;
use GetOpt\GetOpt;
use GetOpt\Option;
use Throwable;

class QueuePurgeCommand extends AbstractCommand
{
    public function __construct(
        private readonly QueueManager $queueManager,
    ) {
    }

    /**
     * @inheritDoc
     */
    public static function getDescription(): ?string
    {
        return 'Purge queues of all jobs';
    }

    /**
     * @inheritDoc
     */
    public static function getOptions(): array
    {
        return [
            (new Option('q', 'queue', GetOpt::MULTIPLE_ARGUMENT))
                ->setDescription('Queue name'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function run(GetOpt $getOpt): int
    {
        $queueManager = $this->queueManager->filter(...$getOpt->getOption('queue'));

        /** @var QueueInterface $queue */
        foreach ($queueManager->getQueues() as $queue) {
            print 'Purging queue "' . $queue->getName() . '"... ';

            try {
                if (!$queue instanceof PurgeableQueueInterface) {
                    print 'not purgeable!' . PHP_EOL;
                    continue;
                }

                $queue->purge();

                print 'done!' . PHP_EOL;
            } catch (Throwable) {
                print 'error!' . PHP_EOL;
            }
        }

        return 0;
    }
}
