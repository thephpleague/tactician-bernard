# Tactician Bernard Queueing

[![Author](http://img.shields.io/badge/author-@sagikazarmark-blue.svg?style=flat-square)](https://twitter.com/sagikazarmark)
[![Latest Version](https://img.shields.io/github/release/thephpleague/tactician-bernard-queueing.svg?style=flat-square)](https://github.com/thephpleague/tactician-bernard-queueing/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/thephpleague/tactician-bernard-queueing.svg?style=flat-square)](https://travis-ci.org/thephpleague/tactician-bernard-queueing)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/thephpleague/tactician-bernard-queueing.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/tactician-bernard-queueing)
[![Quality Score](https://img.shields.io/scrutinizer/g/thephpleague/tactician-bernard-queueing.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/tactician-bernard-queueing)
[![HHVM Status](https://img.shields.io/hhvm/league/tactician-bernard-queueing.svg?style=flat-square)](http://hhvm.h4cc.de/package/league/tactician-bernard-queueing)
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

To send a command to it's destination, simply pass the middleware to the Command Bus. Currently only commands implementing `League\Tactician\Bernard\QueueableCommand` can be passed to the queue, other commands will be passed to the next middleware in the chain.

``` php
use League\Tactician\Bernard\QueueMiddleware;
use League\Tactician\CommandBus;

// ... create a Bernard\Queue instance
// make sure to add the appropriate serializers
// see official documentation

$queueMiddleware = new QueueMiddleware($queue);

$commandBus = new CommandBus([$queueMiddleware]);
$commandBus->handle($command);
```


### Consuming commands

On the other side of the message queue you must set up a consumer:

``` php
use League\Tactician\Bernard\Consumer;
use League\Tactician\Bernard\Listener\CommandLimit;
use League\Tactician\CommandBus;

// inject some middlewares
$commandBus = new CommandBus([]);

$consumer = new Consumer();

$consumer->consume($queue, $commandBus);
```


### Consuming commands in an event-driven way

You can also use some event-driven logic. Make sure to install the Command Events package:

``` bash
$ composer require league/tactician-command-events
```

To learn about using the Command Events plugins check the [documentation](http://tactician.thephpleague.com/plugins/event-middleware/).


#### Limit maximum amount of commands

``` php
use League\Tactician\Bernard\Listener\CommandLimit;

$eventMiddleware->addListener(new CommandLimit($consumer, 10));
```

#### Limit the maximum time (in seconds) the consumer can run

``` php
use League\Tactician\Bernard\Listener\TimeLimit;

$eventMiddleware->addListener(new TimeLimit($consumer, 10));
```

#### Wait for a specific time (in seconds) after every cycle

``` php
use League\Tactician\Bernard\Listener\Wait;

$eventMiddleware->addListener(new Wait($consumer, 1));
```


You can optionally pass the time in microseconds:

``` php
use League\Tactician\Bernard\Listener\Wait;

$eventMiddleware->addListener(new Wait($consumer, 10000, true));
```


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
