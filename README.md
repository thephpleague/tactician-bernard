# Doris

[![Latest Version](https://img.shields.io/github/release/indigophp/doris.svg?style=flat-square)](https://github.com/indigophp/doris/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/indigophp/doris/develop.svg?style=flat-square)](https://travis-ci.org/indigophp/doris)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/indigophp/doris.svg?style=flat-square)](https://scrutinizer-ci.com/g/indigophp/doris)
[![Quality Score](https://img.shields.io/scrutinizer/g/indigophp/doris.svg?style=flat-square)](https://scrutinizer-ci.com/g/indigophp/doris)
[![HHVM Status](https://img.shields.io/hhvm/indigophp/doris.svg?style=flat-square)](http://hhvm.h4cc.de/package/indigophp/doris)
[![Total Downloads](https://img.shields.io/packagist/dt/indigophp/doris.svg?style=flat-square)](https://packagist.org/packages/indigophp/doris)

**Doris is a remote command bus implementation based on [Bernard](http://bernardphp.com) and [Tactician](https://github.com/rosstuck/tactician).**


## Install

Via Composer

``` bash
$ composer require indigophp/doris
```


### Temporary workaround

Tactician is not yet released. Until it gets released, add this to the `composer.json`:

``` json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/rosstuck/tactician.git"
    }
]
```


## Usage

Install Doris in both your application and (if you have any) dedicated worker package/instance.

You can run your consumer directly using your application, however you should avoid it if possible. Bootstrapping your application consumes more resource than necessary. (That said, sometimes it is simply easier.) In this case you have to make sure that you provide your consumer instance with all the data it needs: database connection details, required dependencies, etc.


## Testing

``` bash
$ phpspec run
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

*Name refers to the film [Bernard and Doris](http://www.imdb.com/title/tt0470732/).*

- [Márk Sági-Kazár](https://github.com/sagikazarmark)
- [All Contributors](https://github.com/indigophp/doris/contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
