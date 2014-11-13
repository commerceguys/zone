<?php

namespace CommerceGuys\Zone\Model;

use CommerceGuys\Addressing\Model\AddressInterface;

interface ZoneInterface
{
    /**
     * Gets the zone id.
     *
     * @return string The zone id.
     */
    public function getId();

    /**
     * Sets the zone id.
     *
     * @param string $id The zone id.
     */
    public function setId($id);

    /**
     * Gets the zone name.
     *
     * @return string The zone name.
     */
    public function getName();

    /**
     * Sets the zone name.
     *
     * @param string $name The zone name.
     */
    public function setName($name);

    /**
     * Gets the zone scope.
     *
     * @return string The zone scope.
     */
    public function getScope();

    /**
     * Sets the zone scope.
     *
     * @param string $scope The zone scope.
     */
    public function setScope($scope);

    /**
     * Gets the zone priority.
     *
     * Zones with higher priority will be matched first.
     *
     * @return int The zone priority.
     */
    public function getPriority();

    /**
     * Sets the zone priority.
     *
     * @param int $priority The zone priority.
     */
    public function setPriority($priority);

    /**
     * Gets the zone members.
     *
     * @return ZoneMemberInterface[] The zone members.
     */
    public function getMembers();

    /**
     * Sets the zone members.
     *
     * @param ZoneMemberInterface[] $members The zone members.
     */
    public function setMembers($members);

    /**
     * Checks whether the zone has zone members.
     *
     * @return bool True if the zone has zone members, false otherwise.
     */
    public function hasMembers();

    /**
     * Adds a zone member.
     *
     * @param ZoneMemberInterface $member The zone member.
     */
    public function addMember(ZoneMemberInterface $member);

    /**
     * Removes a zone member.
     *
     * @param ZoneMemberInterface $member The zone member.
     */
    public function removeMember(ZoneMemberInterface $member);

    /**
     * Checks whether the zone has a zone member.
     *
     * @param ZoneMemberInterface $member The zone member.
     *
     * @return bool True if the zone member was found, false otherwise.
     */
    public function hasMember(ZoneMemberInterface $member);

    /**
     * Checks whether the provided address belongs to the zone.
     *
     * @param AddressInterface $address The address.
     *
     * @return bool True if the provided address belongs to the zone,
     *              false otherwise.
     */
    public function match(AddressInterface $address);
}
