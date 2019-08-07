# laravel-phpipam
[![StyleCI](https://travis-ci.org/sorribes22/laravel-phpipam.svg?branch=master)](https://travis-ci.org/sorribes22/laravel-phpipam)
[![StyleCI](https://github.styleci.io/repos/200661780/shield?branch=master)](https://github.styleci.io/repos/200661780)


> [PhpIPAM](https://phpipam.net/) wrapper for laravel


## Index
* [Configuration](#installation)
* [Config](#config)

## Installation

```bash
composer require axsor/laravel-phpipam
```

## Config
If you want to edit config file, you have to publish it using the next command.
```bash
php artisan vendor:publish --provider="Axsor\\PhpIPAM\\PhpIPAMServiceProvider" --tag="config"
```

## License
[GPL-3.0](./LICENSE.md)
