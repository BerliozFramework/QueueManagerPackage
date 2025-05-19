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

namespace Berlioz\Package\QueueManager;

use Berlioz\Config\ConfigInterface;
use Berlioz\Config\ExtendedJsonConfig;
use Berlioz\Core\Core;
use Berlioz\Core\Package\AbstractPackage;
use Berlioz\Package\QueueManager\Factory\QueueFactories;
use Berlioz\QueueManager\Handler\JobHandlerManager;
use Berlioz\QueueManager\QueueManager;
use Berlioz\ServiceContainer\Service;

class BerliozPackage extends AbstractPackage
{
    /**
     * @inheritDoc
     */
    public static function config(): ?ConfigInterface
    {
        return new ExtendedJsonConfig(
            implode(
                DIRECTORY_SEPARATOR,
                [
                    __DIR__,
                    '..',
                    'resources',
                    'config.default.json',
                ]
            ), true
        );
    }

    /**
     * @inheritDoc
     */
    public static function register(Core $core): void
    {
        $queueFactoriesService = new Service(QueueFactories::class);
        self::addService($core, $queueFactoriesService);

        $jobHandlerManagerService = new Service(JobHandlerManager::class);
        $jobHandlerManagerService->setFactory(BerliozPackage::class . '::jobHandlerManagerFactory');
        self::addService($core, $jobHandlerManagerService);

        $queueManagerService = new Service(QueueManager::class);
        $queueManagerService->setFactory(BerliozPackage::class . '::queueManagerFactory');
        self::addService($core, $queueManagerService);
    }

    public static function jobHandlerManagerFactory(Core $core): JobHandlerManager
    {
        $jobManager = new JobHandlerManager(container: $core->getServiceContainer());

        $handlers = $core->getConfig()->get('berlioz.queues.handlers', []);
        array_walk(
            $handlers,
            fn($handlerClass, $jobName) => $jobManager->addHandler($jobName, $handlerClass),
        );

        return $jobManager;
    }

    public static function queueManagerFactory(Core $core, QueueFactories $factories): QueueManager
    {
        $queues = array_map(
            fn($v) => iterator_to_array($factories->createFromConfig($v), false),
            $core->getConfig()->get('berlioz.queues.queues', [])
        );
        $queues = array_merge(...$queues);

        return new QueueManager(...$queues);
    }
}
