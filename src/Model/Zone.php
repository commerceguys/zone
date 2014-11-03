<?php

namespace CommerceGuys\Zone\Model;

use CommerceGuys\Addressing\Model\AddressInterface;

class Zone implements ZoneInterface
{
    /**
     * Zone id.
     *
     * @var string
     */
    protected $id;

    /**
     * Zone name.
     *
     * @var string
     */
    protected $name;

    /**
     * Zone scope.
     *
     * @var string
     */
    protected $scope;

    /**
     * Zone priority.
     *
     * @var integer
     */
    protected $priority;

    /**
     * Zone members.
     *
     * @var array
     */
    protected $members;

    /**
     * Returns the string representation of the zone.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * {@inheritdoc}
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * {@inheritdoc}
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * {@inheritdoc}
     */
    public function setMembers($members)
    {
        $this->members = $members;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasMembers()
    {
        return !empty($this->members);
    }

    /**
     * {@inheritdoc}
     */
    public function addMember(ZoneMemberInterface $member)
    {
        if (!$this->hasMember($member)) {
            $member->setParentZone($this);
            $this->members[] = $member;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeMember(ZoneMemberInterface $member)
    {
        if ($this->hasMember($member)) {
            $member->setParentZone(null);
            // Remove the member and rekey the array.
            $index = array_search($member, $this->members);
            unset($this->members[$index]);
            $this->members = array_values($this->members);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasMember(ZoneMemberInterface $member)
    {
        return in_array($member, $this->members);
    }

    /**
     * {@inheritdoc}
     */
    public function match(AddressInterface $address)
    {
        foreach ($this->members as $member) {
            if ($member->match($address)) {
                return true;
            }
        }

        return false;
    }
}
