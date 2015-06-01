<?php

namespace CommerceGuys\Zone\Tests\Model;

use CommerceGuys\Zone\Model\ZoneMemberCountry;

/**
 * @coversDefaultClass \CommerceGuys\Zone\Model\ZoneMemberCountry
 */
class ZoneMemberCountryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ZoneMemberZone
     */
    protected $zoneMember;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->zoneMember = new ZoneMemberCountry();
    }

    /**
     * @covers ::getCountryCode
     * @covers ::setCountryCode
     */
    public function testCountryCode()
    {
        $this->zoneMember->setCountryCode('CN');
        $this->assertEquals('CN', $this->zoneMember->getCountryCode());
    }

    /**
     * @covers ::getAdministrativeArea
     * @covers ::setAdministrativeArea
     */
    public function testAdministrativeArea()
    {
        $administrativeArea = $this
            ->getMockBuilder('CommerceGuys\Addressing\Model\Subdivision')
            ->disableOriginalConstructor()
            ->getMock();

        $this->zoneMember->setAdministrativeArea($administrativeArea);
        $this->assertSame($administrativeArea, $this->zoneMember->getAdministrativeArea());
    }

    /**
     * @covers ::getLocality
     * @covers ::setLocality
     */
    public function testLocality()
    {
        $locality = $this
            ->getMockBuilder('CommerceGuys\Addressing\Model\Subdivision')
            ->disableOriginalConstructor()
            ->getMock();

        $this->zoneMember->setLocality($locality);
        $this->assertSame($locality, $this->zoneMember->getLocality());
    }

    /**
     * @covers ::getDependentLocality
     * @covers ::setDependentLocality
     */
    public function testDependentLocality()
    {
        $dependentLocality = $this
            ->getMockBuilder('CommerceGuys\Addressing\Model\Subdivision')
            ->disableOriginalConstructor()
            ->getMock();

        $this->zoneMember->setDependentLocality($dependentLocality);
        $this->assertSame($dependentLocality, $this->zoneMember->getDependentLocality());
    }

    /**
     * @covers ::match
     *
     * @uses \CommerceGuys\Zone\Model\ZoneMemberCountry::setCountryCode
     * @uses \CommerceGuys\Zone\Model\ZoneMemberCountry::setAdministrativeArea
     * @uses \CommerceGuys\Zone\Model\ZoneMemberCountry::setLocality
     * @uses \CommerceGuys\Zone\Model\ZoneMemberCountry::setDependentLocality
     * @uses \CommerceGuys\Zone\Model\PostalCodeMatcherTrait
     * @dataProvider addressProvider
     */
    public function testMatch($address, $expectedResult)
    {
        $mockBuilder = $this
            ->getMockBuilder('CommerceGuys\Addressing\Model\Subdivision')
            ->disableOriginalConstructor();

        $administrativeArea = $mockBuilder->getMock();
        $administrativeArea
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('CN-13'));
        $locality = $mockBuilder->getMock();
        $locality
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('CN-13-e8dfb8'));
        $dependentLocality = $mockBuilder->getMock();
        $dependentLocality
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('CN-13-e8dfb8-269b0a'));

        $this->zoneMember->setCountryCode('CN');
        $this->zoneMember->setAdministrativeArea($administrativeArea);
        $this->zoneMember->setLocality($locality);
        $this->zoneMember->setDependentLocality($dependentLocality);
        $this->zoneMember->setIncludedPostalCodes('123456');

        $this->assertEquals($expectedResult, $this->zoneMember->match($address));
    }

    /**
     * Provides addresses and the expected match results.
     */
    public function addressProvider()
    {
        $emptyAddress = $this->getAddress();
        $countryAddress = $this->getAddress('CN');
        $administrativeAreaAddress = $this->getAddress('CN', 'CN-13');
        $localityAddress = $this->getAddress('CN', 'CN-13', 'CN-13-e8dfb8');
        $dependentLocalityAddress = $this->getAddress('CN', 'CN-13', 'CN-13-e8dfb8', 'CN-13-e8dfb8-269b0a');
        $fullAddress = $this->getAddress('CN', 'CN-13', 'CN-13-e8dfb8', 'CN-13-e8dfb8-269b0a', '123456');

        return [
            [$emptyAddress, false],
            [$countryAddress, false],
            [$administrativeAreaAddress, false],
            [$localityAddress, false],
            [$dependentLocalityAddress, false],
            [$fullAddress, true],
        ];
    }

    /**
     * Returns a mock address.
     *
     * @param string $countryCode        The country code.
     * @param string $administrativeArea The administrative area id.
     * @param string $locality           The locality id.
     * @param string $dependentLocality  The dependent locality id.
     * @param string $postalCode         The postal code.
     *
     * @return \CommerceGuys\Addressing\Model\Address
     */
    protected function getAddress(
        $countryCode = null,
        $administrativeArea = null,
        $locality = null,
        $dependentLocality = null,
        $postalCode = null
    ) {
        $address = $this
            ->getMockBuilder('CommerceGuys\Addressing\Model\Address')
            ->disableOriginalConstructor()
            ->getMock();
        if ($countryCode) {
            $address
                ->expects($this->any())
                ->method('getCountryCode')
                ->will($this->returnValue($countryCode));
        }
        if ($administrativeArea) {
            $address
                ->expects($this->any())
                ->method('getAdministrativeArea')
                ->will($this->returnValue($administrativeArea));
        }
        if ($locality) {
            $address
                ->expects($this->any())
                ->method('getLocality')
                ->will($this->returnValue($locality));
        }
        if ($dependentLocality) {
            $address
                ->expects($this->any())
                ->method('getDependentLocality')
                ->will($this->returnValue($dependentLocality));
        }
        if ($postalCode) {
            $address
                ->expects($this->any())
                ->method('getPostalCode')
                ->will($this->returnValue($postalCode));
        }

        return $address;
    }
}
