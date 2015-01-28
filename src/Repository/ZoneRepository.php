<?php

namespace CommerceGuys\Zone\Repository;

use CommerceGuys\Addressing\Provider\DataProvider;
use CommerceGuys\Addressing\Provider\DataProviderInterface;
use CommerceGuys\Zone\Exception\UnknownZoneException;
use CommerceGuys\Zone\Model\Zone;
use CommerceGuys\Zone\Model\ZoneMemberCountry;
use CommerceGuys\Zone\Model\ZoneMemberZone;

/**
 * Manages zones based on JSON definitions.
 */
class ZoneRepository implements ZoneRepositoryInterface
{
    /**
     * The path where zone definitions are stored.
     *
     * @var string
     */
    protected $definitionPath;

    /**
     * The address data provider.
     *
     * Used for loading subdivisions.
     *
     * @var DataProviderInterface
     */
    protected $addressDataProvider;

    /**
     * Zone index.
     *
     * @var array
     */
    protected $zoneIndex = array();

    /**
     * Zones.
     *
     * @var array
     */
    protected $zones = array();

    /**
     * Creates a ZoneRepository instance.
     *
     * @param string                $definitionPath      Path to the zone definitions.
     * @param DataProviderInterface $addressDataProvider The address data provider.
     */
    public function __construct($definitionPath, DataProviderInterface $addressDataProvider = null)
    {
        $this->definitionPath = $definitionPath;
        $this->addressDataProvider = $addressDataProvider ?: new DataProvider();
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if (!isset($this->zones[$id])) {
            $definition = $this->loadDefinition($id);
            $this->zones[$id] = $this->createZoneFromDefinition($definition);
        }

        return $this->zones[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function getAll($scope = null)
    {
        // Build the list of all available zones.
        if (empty($this->zoneIndex)) {
            if ($handle = opendir($this->definitionPath)) {
                while (false !== ($entry = readdir($handle))) {
                    if (substr($entry, 0, 1) != '.') {
                        $id = strtok($entry, '.');
                        $this->zoneIndex[] = $id;
                    }
                }
                closedir($handle);
            }
        }

        // Load each zone, filter by scope if needed.
        $zones = array();
        foreach ($this->zoneIndex as $id) {
            $zone = $this->get($id);
            if (is_null($scope) || ($zone->getScope() == $scope)) {
                $zones[$id] = $this->get($id);
            }
        }

        return $zones;
    }

    /**
     * Loads the zone definition for the provided id.
     *
     * @param string $id The zone id.
     *
     * @return array The zone definition.
     */
    protected function loadDefinition($id)
    {
        $filename = $this->definitionPath . $id . '.json';
        $definition = @file_get_contents($filename);
        if (empty($definition)) {
            throw new UnknownZoneException($id);
        }
        $definition = json_decode($definition, true);
        $definition['id'] = $id;

        return $definition;
    }

    /**
     * Creates a Zone instance from the provided definition.
     *
     * @param array $definition The zone definition.
     *
     * @return Zone
     */
    protected function createZoneFromDefinition(array $definition)
    {
        $zone = new Zone();
        $zone->setId($definition['id']);
        $zone->setName($definition['name']);
        if (isset($definition['scope'])) {
            $zone->setScope($definition['scope']);
        }
        if (isset($definition['priority'])) {
            $zone->setPriority($definition['priority']);
        }
        // Add the zone members.
        foreach ($definition['members'] as $memberDefinition) {
            if ($memberDefinition['type'] == 'country') {
                $zoneMember = $this->createZoneMemberCountryFromDefinition($memberDefinition);
                $zone->addMember($zoneMember);
            } elseif ($memberDefinition['type'] == 'zone') {
                $zoneMember = $this->createZoneMemberZoneFromDefinition($memberDefinition);
                $zone->addMember($zoneMember);
            }
        }

        return $zone;
    }

    /**
     * Creates a ZoneMemberCountry instance from the provided definition.
     *
     * @param array $definition The zone member definition.
     *
     * @return ZoneMemberCountry
     */
    protected function createZoneMemberCountryFromDefinition(array $definition)
    {
        $zoneMember = new ZoneMemberCountry();
        $zoneMember->setId($definition['id']);
        $zoneMember->setName($definition['name']);
        $zoneMember->setCountryCode($definition['country_code']);
        if (isset($definition['administrative_area'])) {
            $administrativeArea = $this->addressDataProvider->getSubdivision($definition['administrative_area']);
            $zoneMember->setAdministrativeArea($administrativeArea);
        }
        if (isset($definition['locality'])) {
            $locality = $this->addressDataProvider->getSubdivision($definition['locality']);
            $zoneMember->setLocality($locality);
        }
        if (isset($definition['dependent_locality'])) {
            $dependentLocality = $this->addressDataProvider->getSubdivision($definition['dependent_locality']);
            $zoneMember->setDependentLocality($dependentLocality);
        }
        if (isset($definition['included_postal_codes'])) {
            $zoneMember->setIncludedPostalCodes($definition['included_postal_codes']);
        }
        if (isset($definition['excluded_postal_codes'])) {
            $zoneMember->setExcludedPostalCodes($definition['excluded_postal_codes']);
        }

        return $zoneMember;
    }

    /**
     * Creates a ZoneMemberZone instance from the provided definition.
     *
     * @param array $definition The zone member definition.
     *
     * @return ZoneMemberZone
     */
    protected function createZoneMemberZoneFromDefinition(array $definition)
    {
        $zone = $this->get($definition['zone']);
        $zoneMember = new ZoneMemberZone();
        $zoneMember->setId($definition['id']);
        $zoneMember->setZone($zone);

        return $zoneMember;
    }
}
