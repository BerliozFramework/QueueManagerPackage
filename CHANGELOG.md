# Change Log

All notable changes to this project will be documented in this file. This project adheres
to [Semantic Versioning] (http://semver.org/). For change log format,
use [Keep a Changelog] (http://keepachangelog.com/).

## [2.0.0] - 2025-05-19

No changes were introduced since the previous beta 5 release.

## [2.0.0-beta5] - 2025-02-03

### Added

- New `backoff` option

### Changed

- Bump library `belioz/queue-manager` to 1.0.0-beta8 minimal

## [2.0.0-beta4] - 2025-01-27

### Added

- New `retry_time` config for queues `AwsSqsQueue` and `DbQueue`

### Changed

- Bump library `belioz/queue-manager` to 1.0.0-beta7 minimal

## [2.0.0-beta3] - 2025-01-21

### Added

- New `delay-no-job` argument for `queue:worker` command

### Changed

- Bump library `belioz/queue-manager` to 1.0.0-beta4
- Improve output of `queue:size` command

## [2.0.0-beta2] - 2024-11-28

### Added

- New `BerliozCommandJobHandler` handler to execute Berlioz command
- New `BerliozSystemJobHandler` handler to execute shell command

## [2.0.0-beta1] - 2024-11-25

Start development.
