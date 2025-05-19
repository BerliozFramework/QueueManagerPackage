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
use Berlioz\QueueManager\QueueManager;
use GetOpt\GetOpt;
use GetOpt\Option;

class QueueSizeCommand extends AbstractCommand
{
    public function __construct(
        private readonly QueueManager $queueManager,
    ) {
    }

    /**
     * @inheritDoc
     */
    public static function getShortDescription(): ?string
    {
        return 'Get size of queues';
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
        $sizes = iterator_to_array($queueManager->stats());
        $total = array_sum($sizes);

        print json_encode(['queues' => $sizes, 'total' => $total], JSON_PRETTY_PRINT);

        return 0;
    }
}
