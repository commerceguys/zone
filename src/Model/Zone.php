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
