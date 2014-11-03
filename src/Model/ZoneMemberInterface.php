<?php

namespace CommerceGuys\Zone\Model;

use CommerceGuys\Addressing\Model\AddressInterface;

interface ZoneMemberInterface
{
    /**
     * Gets the zone member id.
     *
     * @return string The zone member id.
     */
    public function getId();

    /**
     * Sets the zone member id.
     *
     * @param string $id The zone member id.
     */
    public function setId($id);

    /**
     * Gets the zone member name.
     *
     * @return string The zone member name.
     */
    public function getName();

    /**
     * Sets the zone member name.
     *
     * @param string $name The zone member name.
     */
    public function setName($name);

    /**
     * Gets the parent zone.
     *
     * @return ZoneInterface|null The parent zone, if set.
     */
    public function getParentZone();

    /**
     * Sets the parent zone.
     *
     * @param ZoneInterface|null $parentZone The parent zone.
     */
    public function setParentZone(ZoneInterface $parentZone = null);

    /**
     * Checks whether the provided address belongs to the zone member.
     *
     * @param AddressInterface $address The address.
     *
     * @return boolean True if the provided address belongs to the zone member,
     *                 false otherwise.
     */
    public function match(AddressInterface $address);
}
