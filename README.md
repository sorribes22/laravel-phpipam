# laravel-phpipam
[![StyleCI](https://travis-ci.org/sorribes22/laravel-phpipam.svg?branch=master)](https://travis-ci.org/sorribes22/laravel-phpipam)
[![StyleCI](https://github.styleci.io/repos/200661780/shield?branch=master)](https://github.styleci.io/repos/200661780)


> [PhpIPAM](https://phpipam.net/) wrapper for laravel


## Index
* [Installation](#installation)
* [Configuration](#configuration)
* [How to use](#how-to-use)
* [License](#license)

## Installation

```bash
composer require axsor/laravel-phpipam
```

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
```bash
php artisan vendor:publish --provider="Axsor\\PhpIPAM\\PhpIPAMServiceProvider" --tag="config"
```

## How to use
```php
use PhpIPAM;

class MyController extends Controller
{
    public function ping(Request $request, $addressId)
    {
        return PhpIPAM::ping($addressId); // Returns true if address is online
    }
    
    public function address(Request $request, $addressId)
    {
        $user = Auth::user();
        
        $config = [
            'url' => env('PHPIPAM_URL'),
            'user' => $user->phpipam_user,
            'pass' => $user->phpipam_pass,
            'app' => env('PHPIPAM_APP'),
            'token' => env('PHPIPAM_TOKEN'),
        ];
        
        return PhpIPAM::use($config)->address($addressId); // Returns address using custom config
    }
}
```

## License
[GPL-3.0](./LICENSE)
