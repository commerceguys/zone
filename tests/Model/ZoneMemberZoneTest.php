<?php

namespace CommerceGuys\Zone\Tests\Model;

use CommerceGuys\Zone\Model\ZoneMemberZone;

/**
 * @coversDefaultClass \CommerceGuys\Zone\Model\ZoneMemberZone
 */
class ZoneMemberZoneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ZoneMemberZone
     */
    protected $zoneMember;

    public function setUp()
    {
        $this->zoneMember = new ZoneMemberZone();
    }

    /**
     * @covers ::getZone
     * @covers ::setZone
     */
    public function testZone()
    {
        $zone = $this
            ->getMockBuilder('CommerceGuys\Zone\Model\Zone')
            ->getMock();

        $this->zoneMember->setZone($zone);
        $this->assertEquals($zone, $this->zoneMember->getZone());
    }

    /**
     * @covers ::match
     * @uses \CommerceGuys\Zone\Model\ZoneMemberZone::setZone
     */
    public function testMatch()
    {
        $address = $this
            ->getMockBuilder('CommerceGuys\Addressing\Model\Address')
            ->getMock();
        $matchingZone = $this
            ->getMockBuilder('CommerceGuys\Zone\Model\Zone')
            ->getMock();
        $matchingZone
            ->expects($this->any())
            ->method('match')
            ->with($address)
            ->will($this->returnValue(true));
        $nonMatchingZone = $this
            ->getMockBuilder('CommerceGuys\Zone\Model\Zone')
            ->getMock();
        $nonMatchingZone
            ->expects($this->any())
            ->method('match')
            ->with($address)
            ->will($this->returnValue(false));

        $this->zoneMember->setZone($matchingZone);
        $this->assertEquals(true, $this->zoneMember->match($address));

        $this->zoneMember->setZone($nonMatchingZone);
        $this->assertEquals(false, $this->zoneMember->match($address));
    }
}
