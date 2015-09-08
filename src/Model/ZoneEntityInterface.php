<?php

namespace CommerceGuys\Zone\Model;

use CommerceGuys\Addressing\Model\AddressInterface;

interface ZoneEntityInterface extends ZoneInterface
{
    /**
     * Sets the zone id.
     *
     * @param string $id The zone id.
     */
    public function setId($id);

    /**
     * Sets the zone name.
     *
     * @param string $name The zone name.
     */
    public function setName($name);

    /**
     * Sets the zone scope.
     *
     * @param string $scope The zone scope.
     */
    public function setScope($scope);

    /**
     * Sets the zone priority.
     *
     * @param int $priority The zone priority.
     */
    public function setPriority($priority);

    /**
     * Sets the zone members.
     *
     * @param ZoneMemberEntityInterface[] $members The zone members.
     */
    public function setMembers($members);

    /**
     * Adds a zone member.
     *
     * @param ZoneMemberEntityInterface $member The zone member.
     */
    public function addMember(ZoneMemberEntityInterface $member);

    /**
     * Removes a zone member.
     *
     * @param ZoneMemberEntityInterface $member The zone member.
     */
    public function removeMember(ZoneMemberEntityInterface $member);

    /**
     * Checks whether the zone has a zone member.
     *
     * @param ZoneMemberEntityInterface $member The zone member.
     *
     * @return bool True if the zone member was found, false otherwise.
     */
    public function hasMember(ZoneMemberEntityInterface $member);
}
