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

namespace Berlioz\Package\QueueManager\Factory;

use Berlioz\QueueManager\Queue\MemoryQueue;
use Generator;

class MemoryQueueFactory implements QueueFactory
{
    /**
     * @inheritDoc
     */
    public static function getQueueClass(): string
    {
        return MemoryQueue::class;
    }

    /**
     * @inheritDoc
     */
    public static function createFromConfig(array $config): Generator
    {
        foreach ((array)($config['name'] ?? []) as $name) {
            yield new MemoryQueue(
                name: $name,
                retryTime: (int)($config['retry_time'] ?? 30),
                maxAttempts: (int)($config['max_attempts'] ?? 5),
            );
        }
    }
}
