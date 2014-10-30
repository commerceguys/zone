<?php

namespace CommerceGuys\Zone\Tests\Model;

/**
 * @coversDefaultClass \CommerceGuys\Zone\Model\PostalCodeMatcherTrait
 */
class PostalCodeMatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DummyZoneMember
     */
    protected $zoneMember;

    public function setUp()
    {
        $this->zoneMember = new DummyZoneMember();
    }

    /**
     * @covers ::getIncludedPostalCodes
     * @covers ::setIncludedPostalCodes
     */
    public function testIncludedPostalCodes()
    {
        $this->zoneMember->setIncludedPostalCodes('123, 456, 789');
        $this->assertEquals('123, 456, 789', $this->zoneMember->getIncludedPostalCodes());
    }

    /**
     * @covers ::getExcludedPostalCodes
     * @covers ::setExcludedPostalCodes
     */
    public function testExcludedPostalCodes()
    {
        $this->zoneMember->setExcludedPostalCodes('123, 456, 789');
        $this->assertEquals('123, 456, 789', $this->zoneMember->getExcludedPostalCodes());
    }

    /**
     * @covers ::matchPostalCode
     * @covers ::buildPostalCodeList
     * @uses \CommerceGuys\Zone\Model\PostalCodeMatcherTrait::setIncludedPostalCodes()
     * @uses \CommerceGuys\Zone\Model\PostalCodeMatcherTrait::setExcludedPostalCodes()
     */
    public function testMatch()
    {
        // Test empty rules.
        $address = $this->getAddress('123');
        $this->zoneMember->setIncludedPostalCodes(null);
        $this->zoneMember->setExcludedPostalCodes(null);
        $this->assertEquals(true, $this->zoneMember->match($address));

        // Test regular expressions.
        $matchingAddress = $this->getAddress('203');
        $nonMatchingAddress = $this->getAddress('202');
        $this->zoneMember->setIncludedPostalCodes('/(20)[0-9]{1}/');
        $this->zoneMember->setExcludedPostalCodes('/(20)[0-2]{1}/');
        $this->assertEquals(true, $this->zoneMember->match($matchingAddress));
        $this->assertEquals(false, $this->zoneMember->match($nonMatchingAddress));

        // Test lists
        $matchingAddress = $this->getAddress('34');
        $nonMatchingAddress = $this->getAddress('35');
        $this->zoneMember->setIncludedPostalCodes('10, 20, 30:40');
        $this->zoneMember->setExcludedPostalCodes('35');
        $this->assertEquals(true, $this->zoneMember->match($matchingAddress));
        $this->assertEquals(false, $this->zoneMember->match($nonMatchingAddress));
    }

    /**
     * Returns a mock address with the provided postal code.
     *
     * @param string $postalCode The postal code.
     *
     * @return \CommerceGuys\Addressing\Model\Address
     */
    protected function getAddress($postalCode = null)
    {
        $address = $this
            ->getMockBuilder('CommerceGuys\Addressing\Model\Address')
            ->getMock();
        if ($postalCode) {
            $address
                ->expects($this->any())
                ->method('getPostalCode')
                ->will($this->returnValue($postalCode));
        }

        return $address;
    }
}
