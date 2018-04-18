# laravel-phpipam
> Connection between laravel and [PhpIPAM](https://phpipam.net/)


## Index
* [Configuration](#configuration)
* [Usage](#usage)
    * [Subnet](#subnet)

## Configuration
Must to add some keys into `.env` file.

```
PHPIPAM_API_URL=localhost/phpipam/api
PHPIPAM_API_USER=user_phpipam
PHPIPAM_API_PASS=password_user_phpipam
PHPIPAM_API_APP=phpipam_app_name
PHPIPAM_API_KEY=phpipam_api_key
```

## Usage
The return is laravel model in case of fetch single item.
### Subnet
```
// Get a subnet
PhpIPAM::subnet(1);

// Get subnet usage
PhpIPAM::subnetUsage(1);
PhpIPAM::subnet(1)->usage();

// Get first IP free of subnet
PhpIPAM::subnetFirstIPFree(32);
PhpIPAM::subnet(1)->firstIPFree();

// Get IP addresses of subnet
PhpIPAM::subnetAddresses(33);
PhpIPAM::subnet(33)->addresses();

// Get IP address of subnet
PhpIPAM::subnetAddress(33, "10.0.18.97");
PhpIPAM::subnet(33)->address("10.0.18.97");
```
