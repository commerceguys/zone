<?php

namespace CommerceGuys\Zone\Tests\Model;

use CommerceGuys\Addressing\Model\AddressInterface;
use CommerceGuys\Zone\Model\ZoneMember;
use CommerceGuys\Zone\Model\PostalCodeMatcherTrait;

/**
 * Dummy repository used for testing the PostalCodeMatcherTrait.
 */
class DummyZoneMember extends ZoneMember
{
    use PostalCodeMatcherTrait;

    /**
     * {@inheritdoc}
     */
    public function match(AddressInterface $address)
    {
        return $this->matchPostalCode($address->getPostalCode());
    }
}
