<?php

namespace CommerceGuys\Zone\Model;

use CommerceGuys\Addressing\Model\AddressInterface;

interface ZoneMemberEntityInterface extends ZoneMemberInterface
{
    /**
     * Sets the zone member id.
     *
     * @param string $id The zone member id.
     */
    public function setId($id);

    /**
     * Sets the zone member name.
     *
     * @param string $name The zone member name.
     */
    public function setName($name);

    /**
     * Sets the parent zone.
     *
     * @param ZoneEntityInterface|null $parentZone The parent zone.
     */
    public function setParentZone(ZoneEntityInterface $parentZone = null);
}
