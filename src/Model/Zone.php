<?php

namespace CommerceGuys\Zone\Model;

use CommerceGuys\Addressing\Model\AddressInterface;
use CommerceGuys\Zone\Exception\UnexpectedTypeException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
     * @var int
     */
    protected $priority;

    /**
    * Creates a Zone instance.
    */
    public function __construct()
    {
      $this->members = new ArrayCollection();
    }

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
        // The interface doesn't typehint $children to allow other
        // implementations to avoid using Doctrine Collections if desired.
        if (!($members instanceof Collection)) {
            throw new UnexpectedTypeException($members, 'Collection');
        }
        $this->members = $members;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasMembers()
    {
        return !$this->members->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function addMember(ZoneMemberInterface $member)
    {
        if (!$this->hasMember($member)) {
            $member->setParentZone($this);
            $this->members->add($member);
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
            $this->members->removeElement($member);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasMember(ZoneMemberInterface $member)
    {
        return $this->members->contains($member);
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
