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

use Aws\Sqs\SqsClient;
use Berlioz\QueueManager\Queue\AwsSqsQueue;
use Generator;

class AwsSqsQueueFactory implements QueueFactory
{
    /**
     * @inheritDoc
     */
    public static function getQueueClass(): string
    {
        return AwsSqsQueue::class;
    }

    /**
     * @inheritDoc
     */
    public static function createFromConfig(array $config): Generator
    {
        $sqsClient = new SqsClient($config['client'] ?? []);

        foreach ((array)($config['name'] ?? []) as $name => $url) {
            yield new AwsSqsQueue(
                sqsClient: $sqsClient,
                queueUrl: $url,
                name: is_int($name) ? $url : $name,
            );
        }
    }
}
