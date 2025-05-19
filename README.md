# Queue Manager package for Berlioz Framework

[![Latest Version](https://img.shields.io/packagist/v/berlioz/queue-manager-package.svg?style=flat-square)](https://github.com/BerliozFramework/QueueManagerPackage/releases)
[![Software license](https://img.shields.io/github/license/BerliozFramework/QueueManagerPackage.svg?style=flat-square)](https://github.com/BerliozFramework/QueueManagerPackage/blob/2.x/LICENSE)
[![Build Status](https://img.shields.io/github/actions/workflow/status/BerliozFramework/QueueManagerPackage/tests.yml?branch=2.x&style=flat-square)](https://github.com/BerliozFramework/QueueManagerPackage/actions/workflows/tests.yml?query=branch%3A2.x)
[![Quality Grade](https://img.shields.io/codacy/grade/e5985e0b3d2d4b2bbb8ac6c0ce169100/2.x.svg?style=flat-square)](https://www.codacy.com/manual/BerliozFramework/QueueManagerPackage)
[![Total Downloads](https://img.shields.io/packagist/dt/berlioz/queue-manager-package.svg?style=flat-square)](https://packagist.org/packages/berlioz/queue-manager-package)

This package is intended to provide **Queue Manager** in **Berlioz Framework**.

For more information, and use of Berlioz Framework, go to website and online documentation :
https://getberlioz.com

## Installation

### Composer

You can install **Queue Manager Package** with [Composer](https://getcomposer.org/), it's the recommended installation.

```bash
$ composer require berlioz/queue-manager-package
```

### Dependencies

* **PHP** ^8.2
* Packages:
    * **berlioz/cli-core**
    * **berlioz/queue-manager**

## Configuration

Default configuration:

```json5
{
  berlioz: {
    queues: {
      queues: [
        {
          type: "Berlioz\\QueueManager\\Queue\\DbQueue",
          name: [
            "default",
            "high",
            "low"
          ],
          db: {
            dsn: "mysql:dbname=mydb;host=localhost",
            username: "myUsername",
            password: "mySuperPassword"
          }
        },
        // Case where you need to use same connection as Hector Package
        {
          type: "Berlioz\\QueueManager\\Queue\\DbQueue",
          name: [
            "default",
            "high",
            "low"
          ],
          db: {
            dsn: "{config: hector.dsn}",
            username: "{config: hector.username}",
            password: "{config: hector.password}"
          }
        }
      ],
      handlers: {
        "jobname": "MyProject\\Job\\MyJobNameHandler"
      },
      factories: [
        ""
      ]
    }
  }
}
```