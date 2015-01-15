# Tactician Bernard Queueing

[![Author](http://img.shields.io/badge/author-@sagikazarmark-blue.svg?style=flat-square)](https://twitter.com/sagikazarmark)
[![Latest Version](https://img.shields.io/github/release/thephpleague/tactician-bernard-queueing.svg?style=flat-square)](https://github.com/thephpleague/tactician-bernard-queueing/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/thephpleague/tactician-bernard-queueing.svg?style=flat-square)](https://travis-ci.org/thephpleague/tactician-bernard-queueing)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/thephpleague/tactician-bernard-queueing.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/tactician-bernard-queueing)
[![Quality Score](https://img.shields.io/scrutinizer/g/thephpleague/tactician-bernard-queueing.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/tactician-bernard-queueing)
[![HHVM Status](https://img.shields.io/hhvm/thephpleague/tactician-bernard-queueing.svg?style=flat-square)](http://hhvm.h4cc.de/package/thephpleague/tactician-bernard-queueing)
[![Total Downloads](https://img.shields.io/packagist/dt/league/tactician-bernard-queueing.svg?style=flat-square)](https://packagist.org/packages/league/tactician-bernard-queueing)

**Remote command bus plugin for [Tactician](http://tactician.thephpleague.com) based on [Bernard](http://bernardphp.com).**


## Install

Via Composer

``` bash
$ composer require league/tactician-bernard-queueing
```


## Usage

Install tactician-bernard-queueing in both your application and (if you have any) dedicated worker package/instance.

You can run your consumer directly using your application, however you should avoid it if possible. Bootstrapping your application consumes more resource than necessary. (That said, sometimes it is simply easier.) In this case you have to make sure that you provide your consumer instance with all the data it needs: database connection details, required dependencies, etc.


### Remote execution

To send a command to it's destination, simply create a remote executing command bus, and use it like you would use any other:

``` php
use League\Tactician\BernardQueueingCommandBus;

// ...create a Bernard\Queue instance
// make sure to add the appropriate serializers

$commandBus = new BernardQueueingCommandBus($queue);

$commandBus->execute($command);
```


### Consuming commands

On the other side of the message queue you must set up a consumer:

``` php
use League\Tactician\BernardQueueing\Consumer;
use League\Tactician\BernardQueueing\Listener\CommandLimit;

// ... create your inner CommandBus

$consumer = new Consumer($commandBus);

$consumer->consume($queue);
```


### Consuming commands in an event-driven way

You can also use some event-driven logic:

``` php
use League\Tactician\BernardQueueing\EventableConsumer;
use League\Tactician\BernardQueueing\Listener\CommandLimit;

// ... create your inner EventableCommandBus

$consumer = new EventableConsumer($eventableCommandBus);

// execute maximum of 10 commands
$consumer->addListener(new CommandLimit(10));

$consumer->consume($queue);
```

List of available listeners:

- `CommandLimit`: limits how many commands the consumer can execute
- `TimeLimit`: limits how long the consumer can run
- `Wait`: wait for some time at the end of each cycle


## Testing

``` bash
$ phpspec run
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [Ross Tuck](https://github.com/rosstuck)
- [Márk Sági-Kazár](https://github.com/sagikazarmark)
- [All Contributors](https://github.com/thephpleague/tactician-bernard-queueing/contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
