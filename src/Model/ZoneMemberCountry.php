<?php

namespace CommerceGuys\Zone\Model;

use CommerceGuys\Addressing\Model\AddressInterface;
use CommerceGuys\Addressing\Model\SubdivisionInterface;

/**
 * Matches a country, its subdivisions and postal codes.
 */
class ZoneMemberCountry extends ZoneMember
{
    use PostalCodeMatcherTrait;

    /**
     * The country code.
     *
     * @var string
     */
    protected $countryCode;

    /**
     * The administrative area.
     *
     * @var SubdivisionInterface
     */
    protected $administrativeArea;

    /**
     * The locality.
     *
     * @var SubdivisionInterface
     */
    protected $locality;

    /**
     * The dependent locality.
     *
     * @var SubdivisionInterface
     */
    protected $dependentLocality;

    /**
     * Gets the country code.
     *
     * @return string The country code.
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Sets the country code.
     *
     * @param string $countryCode The country code.
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Gets the administrative area.
     *
     * @return SubdivisionInterface|null The administrative area, or null
     *                                   if all should match.
     */
    public function getAdministrativeArea()
    {
        return $this->administrativeArea;
    }

    /**
     * Sets the administrative area.
     *
     * @param SubdivisionInterface|null $administrativeArea The administrative area.
     */
    public function setAdministrativeArea(SubdivisionInterface $administrativeArea = null)
    {
        $this->administrativeArea = $administrativeArea;

        return $this;
    }

    /**
     * Gets the locality.
     *
     * @return SubdivisionInterface|null The locality, or null if all should match.
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Sets the locality.
     *
     * @param SubdivisionInterface|null $locality The locality.
     */
    public function setLocality(SubdivisionInterface $locality = null)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Gets the dependent locality.
     *
     * @return SubdivisionInterface|null The dependent locality, or null
     *                                   if all should match.
     */
    public function getDependentLocality()
    {
        return $this->dependentLocality;
    }

    /**
     * Sets the dependent locality.
     *
     * @param SubdivisionInterface|null $dependentLocality The dependent locality.
     */
    public function setDependentLocality(SubdivisionInterface $dependentLocality = null)
    {
        $this->dependentLocality = $dependentLocality;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function match(AddressInterface $address)
    {
        if ($address->getCountryCode() != $this->countryCode) {
            return false;
        }
        if ($this->administrativeArea && $this->administrativeArea->getId() != $address->getAdministrativeArea()) {
            return false;
        }
        if ($this->locality && $this->locality->getId() != $address->getLocality()) {
            return false;
        }
        if ($this->dependentLocality && $this->dependentLocality->getId() != $address->getDependentLocality()) {
            return false;
        }
        if (!$this->matchPostalCode($address->getPostalCode())) {
            return false;
        }

        return true;
    }
}
