# laravel-phpipam
> Connection between laravel and [PhpIPAM](https://phpipam.net/)

This package is in developement but some functionalities are working yet.
If you want to improve this package fork it and pull request.

## Index
* [Configuration](#configuration)
* [Usage](#usage)
    * [Section](#section)
    * [Subnet](#subnet)
    * [Address](#address)
    * [Locations](#locations)

## Configuration
Must to add this keys into `.env` file.

```
PHPIPAM_API_URL=http://127.0.0.1/phpipam/api
PHPIPAM_API_USER=user_phpipam
PHPIPAM_API_PASS=password_user_phpipam
PHPIPAM_API_APP=phpipam_app_name
PHPIPAM_API_KEY=phpipam_api_key
```

## Usage
To call PhpIPAM facade use next **use**:

`use Axsor\LaravelPhpIPAM\PhpIPAMFacade as PhpIPAM;`

The return is **laravel model** in case of fetch single item.
In case of fetch more than one item the return will be **Collection** of laravel model.
In case can't use model or connection the return will be the result of API call.

### Section
```
use Axsor\LaravelPhpIPAM\PhpIPAMFacade as PhpIPAM;

// Get all sections
PhpIPAM::sections();

// Get section
PhpIPAM::section(1);
PhpIPAM::section("Section 1");

// Get subnets of section
PhpIPAM::sectionSubnets(1);
PhpIPAM::section(4)->subnets();

// Get custom fields
PhpIPAM::sectionCustomFields(1);
PhpIPAM::section("Section 1")->customFields();
```

### Subnet
```
use Axsor\LaravelPhpIPAM\PhpIPAMFacade as PhpIPAM;

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

### Address
```
use Axsor\LaravelPhpIPAM\PhpIPAMFacade as PhpIPAM;

// Create Address giving all data ('subnetId' and 'ip' included)
PhpIPAM::createAddress([
    "subnetId" => "1",
    "ip" => "10.0.1.2",
    "description" => "Testing create giving IP",
    "hostname" => "Testing Create",
    "tag" => "2",
    "location" => "1",
    "note" => "Lorem ipsum dolor sit amet",
]);

// Create Address with first IP free
PhpIPAM::createFirstFreeAddress($subnet, [
    "description" => "Testing create",
    "hostname" => "TestingHostname",
    "tag" => "2",
    "location" => "0",
    "note" => "My firts IP",
]);

// Get all tags
PhpIPAM::tags();
```

### Locations
```
use Axsor\LaravelPhpIPAM\PhpIPAMFacade as PhpIPAM;

// Get all subnets of location
PhpIPAM::subnetLocations(1);

// Get all devices of location -> not finished/tested
PhpIPAM::deviceLocations(1);

// Get all racks of location -> not finished/tested
PhpIPAM::rackLocations(1);
```
