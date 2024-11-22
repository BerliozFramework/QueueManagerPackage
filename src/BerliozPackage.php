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

use Berlioz\Config\Adapter\JsonAdapter;
use Berlioz\Config\ConfigInterface;
use Berlioz\Core\Package\AbstractPackage;
use Berlioz\Package\QueueManager\Container\QueueManagerProvider;
use Berlioz\ServiceContainer\Container;

class BerliozPackage extends AbstractPackage
{
    /**
     * @inheritDoc
     */
    public static function config(): ?ConfigInterface
    {
        return new JsonAdapter(__DIR__ . '/../resources/config.default.json5', true);
    }

    /**
     * @inheritDoc
     */
    public static function register(Container $container): void
    {
        $container->addProvider(new QueueManagerProvider());
    }
}
