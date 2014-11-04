zone
=====

[![Build Status](https://travis-ci.org/commerceguys/zone.svg?branch=master)](https://travis-ci.org/commerceguys/zone)

A PHP 5.4+ zone management library.

```php
use CommerceGuys\Addressing\Repository\SubdivisionRepository;
use CommerceGuys\Addressing\Model\Address;
use CommerceGuys\Zone\Model\Zone;
use CommerceGuys\Zone\Model\ZoneMemberCountry;
use CommerceGuys\Zone\Model\ZoneMemberZone;

// Create the German VAT zone (Germany and 4 Austrian postal codes).
$germanyZoneMember = new ZoneMemberCountry();
$germanyZoneMember->setCountryCode('DE');
$austriaZoneMember = new ZoneMemberCountry();
$austriaZoneMember->setCountryCode('AT');
$austriaZoneMember->setIncludedPostalCodes('6691, 6991:6993');

$zone = new Zone();
$zone->setId('german_vat');
$zone->setName('German VAT');
$zone->setScope('tax');
$zone->setMembers(array($germanyZoneMember, $austriaZoneMember));

$austrianAddress = new Address();
$austrianAddress->setCountryCode('AT');
$austrianAddress->setPostalCode('6692');
echo $zone->match($austrianAddress); // true

// Create a zone for shipping purposes that matches California and Washington.
$subdivisionRepository = new SubdivisionRepository();
$california = $subdivisionRepository->get('US-CA');
$washington = $subdivisionRepository->get('US-WA');

$californiaZoneMember = new ZoneMemberCountry();
$californiaZoneMember->setCountryCode('US');
$californiaZoneMember->setAdministrativeArea($california);
$washingtonZoneMember = new ZoneMemberCountry();
$washingtonZoneMember->setCountryCode('US');
$washingtonZoneMember->setAdministrativeArea($washington);

$zone = new Zone();
$zone->setId('california_washington');
$zone->setName('California & Washington');
$zone->setScope('shipping');
$zone->setMembers(array($californiaZoneMember, $washingtonZoneMember));
```

