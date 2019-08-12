# Laravel - PhpIPAM (IN DEVELOPEMENT)

[![Latest Stable Version](https://poser.pugx.org/axsor/laravel-phpipam/v/stable.png)](https://packagist.org/packages/axsor/laravel-phpipam)
[![Build Status](https://travis-ci.org/sorribes22/laravel-phpipam.svg?branch=master)](https://travis-ci.org/sorribes22/laravel-phpipam)
[![StyleCI](https://github.styleci.io/repos/200661780/shield?branch=master)](https://github.styleci.io/repos/200661780)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sorribes22/laravel-phpipam/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sorribes22/laravel-phpipam/?branch=master)

> [PhpIPAM](https://phpipam.net/) wrapper for laravel

Atention: Lastest stable version is from [this repository](https://github.com/E-Ports/laravel-phpipam).
Actual developement is not finished yet and posted to [packagist](https://packagist.org/packages/axsor/laravel-phpipam).

## Index
* [Installation](#installation)
* [Configuration](#configuration)
* [How to use](#how-to-use)
* [Available methods](#available-methods)
* [License](#license)

## Installation
Install it via composer:

`composer require axsor/laravel-phpipam`

If you are using Laravel 5.4 or lower you must add PhpIPAMServiceProvider to
your `config/app.php`:

```php
'providers' => [
    Axsor\PhpIPAM\PhpIPAMServiceProvider::class,
],
```

Higher versions will [auto-discover](https://medium.com/@taylorotwell/package-auto-discovery-in-laravel-5-5-ea9e3ab20518) it.

## Configuration

Edit your `.env` file and add your **PhpIPAM credentials**:
```cmake
PHPIPAM_URL=https://your-phpipam-server/api
PHPIPAM_USER=username
PHPIPAM_PASSWORD=password
PHPIPAM_APP="phpipam application"
PHPIPAM_TOKEN="phpipam application token"
```
And run `php artisan config:cache` to reload config cache.

If you want to edit config file, you have to publish it using the next command.

`php artisan vendor:publish --provider="Axsor\\PhpIPAM\\PhpIPAMServiceProvider" --tag="config"
`

If in some moment you want to use other different configuration you can set it:
```php
$config = [
    'url' => 'https://phpipam.net/api',
    'user' => 'alex',
    'pass' => 'secure',
    'app' => 'api-client',
    'token' => 'my_awesome_token'
];

PhpIPAM::use($config)->address(22); // Sets custom configuration before execute method

PhpIPAM::ping(22); // Keeps custom configuration when execute method

PhpIPAM::useDefaultConfig(); // Discard custom configuration and uses default configuration
```

## How to use
Most of methods returns Models (Address, Subnet, ...), [Collections](https://laravel.com/docs/collections) of models
or action results as boolean ('created', 'updated', ...).

When you call PhpIPAM model you can pass the **ID** or the **model** that contains the id. ex. `PhpIPAM::subnet($subnetId)` will return same than `PhpIPAM::subnet($subnetObject)`.

```php
use Axsor\PhpIPAM\Facades\PhpIPAM;

class MyController extends Controller
{
    public function ping(Request $request, $addressId)
    {
        return PhpIPAM::ping($addressId); // Returns true if address is online
    }

    public function address(Request $request, $addressId)
    {
        $user = Auth::user();

        $config = config('phpipam');
        $config['user'] = $user->phpipam_user;
        $config['pass'] = $user->phpipam_pass;

        return PhpIPAM::use($config)->address($addressId); // Returns address using custom config
    }

    public function addressEdit(Request $request, $addressId)
    {
        $address = PhpIPAM::address($addressId);

        $address->hostname = 'New Hostname';

        $address->edit();

        // Or
        PhpIPAM::addressUpdate($addressId);

        // Or
        $address = PhpIPAM::address($addressId);
        // Do some actions with address
        $newData = [...];
        PhpIPAM::addressUpdate($address, $newData);
    }
}
```

## Available methods
All api calls are **wrapped** by the controllers into Models, [Collections](https://laravel.com/docs/collections) or simple data types.

(Pending:) If you want to **get the response content without wrapping** you can use the same command adding "Raw" as suffix. ex. `PhpIPAM::addressRaw($address)`. That will return you an associative array with the response content.

The model methods will call Global methods;
### Section
#### Global methods
```php
PhpIPAM::sections();
PhpIPAM::section($section);
PhpIPAM::sectionSubnets($section);
PhpIPAM::sectionByName($section);
PhpIPAM::sectionCreate($section);
PhpIPAM::sectionUpdate($section, $newData);
PhpIPAM::sectionDrop($section);
```

#### Model methods
```php
$section->update();
$section->drop();
```

### Address
#### Global methods
```php
PhpIPAM::address($address);
PhpIPAM::ping($address);
PhpIPAM::addressByIp("10.140.128.1");
PhpIPAM::addressByHostname("phpipam.net");
PhpIPAM::addressCustomFields();
PhpIPAM::tags();
PhpIPAM::tag($tag);
PhpIPAM::tagAddresses($tag);
PhpIPAM::addressCreate($data);
PhpIPAM::addressUpdate($address, $data);
PhpIPAM::addressDrop($address);
```

#### Model methods
```php
$address->update();
$address->drop();
$address->ping();
```

## License
[GPL-3.0](./LICENSE)
