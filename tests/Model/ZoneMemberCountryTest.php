<?php

namespace CommerceGuys\Zone\tests\Model;

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
            ->getMock();

        $this->zoneMember->setDependentLocality($dependentLocality);
        $this->assertSame($dependentLocality, $this->zoneMember->getDependentLocality());
    }
}
