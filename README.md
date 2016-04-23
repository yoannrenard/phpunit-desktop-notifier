# phpunit-desktop-notifier
Get notified directly on your desktop that PHPUnit has finished to run your tests.

[![Build Status](https://travis-ci.org/yoannrenard/phpunit-desktop-notifier.svg?branch=master)](https://travis-ci.org/yoannrenard/phpunit-desktop-notifier)

## Installing Dependencies

Use [Composer][composer] and run
```bash
$> php composer.phar require --dev yoannrenard/phpunit-desktop-notifier
```

## Requirements

* [Composer][composer]
* PHP >=5.5.9

## Usage

```xml
<phpunit ...>
    ...
    <listener class="PHPUnitDesktopNotifier\Listener\PHPUnitDesktopNotifierListener" />
</phpunit>
```

## Run tests

```bash
$> bin/phpunit
```

[composer]: https://getcomposer.org
