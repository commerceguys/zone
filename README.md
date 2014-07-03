Zone
====

Zone checks if an address matches a set of conditions

```php
use DrupalCommerce\Zone\ZoneManager;
use DrupalCommerce\Zone\Zone;

$zoneManager = new ZoneManager;
$zoneManager->addZoneFromDefinition($DEVATZone);

$zone = ZoneManager::createZoneFromDefinition($ESVATZone);
$zoneManager->addZone($zone);

$zone = $zoneManager->match($address);
```
German VAT Zone
```yaml
country: DE
not-postcode: ['27498', '78266']
```

Spaish VAT Zone
```yaml
country: ES
not-postcode: '(35|38)[0-9]{3}'
```
