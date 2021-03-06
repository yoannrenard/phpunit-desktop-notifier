# phpunit-desktop-notifier

[![Build Status](https://travis-ci.org/yoannrenard/phpunit-desktop-notifier.svg?branch=master)](https://travis-ci.org/yoannrenard/phpunit-desktop-notifier)

Get notified directly on your desktop that PHPUnit has finished to run your tests.

![Demo](doc/img/notifier.png)

## Installing Dependencies

Use [Composer][composer] and run :

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
    <listeners>
        ...
        <listener class="PHPUnitDesktopNotifier\Listener\PHPUnitDesktopNotifierListener" />
    </listeners>
</phpunit>
```

## Run tests

```bash
$> bin/phpunit
```

[composer]: https://getcomposer.org
