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

use Berlioz\Cli\Core\Command\AbstractCommand;
use Berlioz\Cli\Core\Command\Argument;
use Berlioz\Cli\Core\Console\Environment;
use Berlioz\QueueManager\Queue\QueueInterface;
use Berlioz\QueueManager\QueueManager;
use Generator;

#[Argument('queue', prefix: 'q', longPrefix: 'queue', description: 'Queue name', castTo: 'string')]
class QueueSizeCommand extends AbstractCommand
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
        return 'Get size of queues';
    }

    /**
     * @inheritDoc
     */
    public function run(Environment $env): int
    {
        $sizes = $this->getSizes($this->queueManager->filter(...$env->getArgumentMultiple('queue')));

        $env->console()->table(iterator_to_array($sizes));

        return 0;
    }

    public function getSizes(QueueManager $queueManager): Generator
    {
        $total = 0;

        /** @var QueueInterface $queue */
        foreach ($queueManager->getQueues() as $queue) {
            yield [
                'Queue' => $queue->getName(),
                'Size' => $size = $queue->size(),
            ];
            $total += $size;
        }

        yield [
            'Queue' => '',
            'Size' => $total,
        ];
    }
}
