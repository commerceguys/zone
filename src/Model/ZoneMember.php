<?php

namespace CommerceGuys\Zone\Model;

abstract class ZoneMember implements ZoneMemberInterface
{
    /**
     * Zone member id.
     *
     * @var string
     */
    protected $id;

    /**
     * Zone member name.
     *
     * @var string
     */
    protected $name;

    /**
     * The parent zone.
     *
     * @var ZoneInterface
     */
    protected $parentZone;

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
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParentZone()
    {
        return $this->parentZone;
    }

    /**
     * {@inheritdoc}
     */
    public function setParentZone(ZoneInterface $parentZone)
    {
        $this->parentZone = $parentZone;

        return $this;
    }
}
