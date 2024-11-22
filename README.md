# Queue Manager package for Berlioz Framework

[![Latest Version](https://img.shields.io/packagist/v/berlioz/hector-package.svg?style=flat-square)](https://github.com/BerliozFramework/HectorPackage/releases)
[![Software license](https://img.shields.io/github/license/BerliozFramework/HectorPackage.svg?style=flat-square)](https://github.com/BerliozFramework/HectorPackage/blob/2.x/LICENSE)
[![Build Status](https://img.shields.io/github/workflow/status/BerliozFramework/HectorPackage/Tests/2.x.svg?style=flat-square)](https://github.com/BerliozFramework/HectorPackage/actions/workflows/tests.yml?query=branch%3A2.x)
[![Quality Grade](https://img.shields.io/codacy/grade/a9ede0ed09604616b38e78cbde18f2fe/2.x.svg?style=flat-square)](https://www.codacy.com/manual/BerliozFramework/HectorPackage)
[![Total Downloads](https://img.shields.io/packagist/dt/berlioz/hector-package.svg?style=flat-square)](https://packagist.org/packages/berlioz/hector-package)

This package is intended to provide **Queue Manager** in **Berlioz Framework**.

For more information, and use of Berlioz Framework, go to website and online documentation :
https://getberlioz.com

## Installation

### Composer

You can install **Hector Package** with [Composer](https://getcomposer.org/), it's the recommended installation.

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