# Queue Manager package for Berlioz Framework

[![Latest Version](https://img.shields.io/packagist/v/berlioz/queue-manager-package.svg?style=flat-square)](https://github.com/BerliozFramework/QueueManagerPackage/releases)
[![Software license](https://img.shields.io/github/license/BerliozFramework/QueueManagerPackage.svg?style=flat-square)](https://github.com/BerliozFramework/QueueManagerPackage/blob/main/LICENSE)
[![Build Status](https://img.shields.io/github/actions/workflow/status/BerliozFramework/QueueManagerPackage/tests.yml?branch=main&style=flat-square)](https://github.com/BerliozFramework/QueueManagerPackage/actions/workflows/tests.yml?query=branch%3Amain)
[![Quality Grade](https://img.shields.io/codacy/grade/e5985e0b3d2d4b2bbb8ac6c0ce169100/main.svg?style=flat-square)](https://www.codacy.com/manual/BerliozFramework/QueueManagerPackage)
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

* **PHP** ^8.0
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
          ]
        }
      ],
      handlers: {},
      factories: [
        ""
      ]
    },
    
    dsn: null,
    read_dsn: null,
    schemas: [],
    dynamic_events: true,
    types: {}
  }
}
```