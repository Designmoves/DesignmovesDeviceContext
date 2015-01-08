<?php
/**
 * Copyright (c) 2014 - 2015, Designmoves (http://www.designmoves.nl)
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * * Neither the name of Designmoves nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace DesignmovesDeviceContextTest\Controller\Plugin;

use DesignmovesDeviceContext\Controller\Plugin\DeviceContext as DeviceContextPlugin;
use Detection\MobileDetect;
use PHPUnit_Framework_TestCase;
use ReflectionMethod;

/**
 * @coversDefaultClass DesignmovesDeviceContext\Controller\Plugin\DeviceContext
 * @uses               DesignmovesDeviceContext\Controller\Plugin\DeviceContext
 */
class DeviceContextTest extends PHPUnit_Framework_TestCase
{
    const USER_AGENT_COMPUTER = 'Mozilla/5.0 (Windows NT 6.0; rv:29.0) Gecko/20100101 Firefox/29.0';
    const USER_AGENT_TABLET   = 'Mozilla/5.0 (Linux; U; Android 2.2; en-us; SCH-I800 Build/FROYO) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';
    const USER_AGENT_PHONE    = 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16';

    /**
     * @var MobileDetect
     */
    protected $mobileDetect;

    /**
     * @var DeviceContextPlugin
     */
    protected $plugin;

    public function setUp()
    {
        $this->mobileDetect = new MobileDetect;
        $this->plugin       = new DeviceContextPlugin($this->mobileDetect);
    }

    /**
     * @covers ::__construct
     */
    public function testMobileDetectIsSetOnConstruct()
    {
        $this->assertSame($this->mobileDetect, self::readAttribute($this->plugin, 'mobileDetect'));
    }

    /**
     * @covers ::__invoke
     */
    public function test__invokeReturnsMobileDetect()
    {
        $this->assertInstanceOf('Detection\MobileDetect', $this->plugin->__invoke());
    }

    /**
     * @covers ::getDeviceType
     */
    public function testCanGetDeviceTypeComputer()
    {
        $this->assertSame('computer', DeviceContextPlugin::DEVICE_TYPE_COMPUTER);

        $this->mobileDetect->setUserAgent(static::USER_AGENT_COMPUTER);
        $this->assertSame(DeviceContextPlugin::DEVICE_TYPE_COMPUTER, $this->plugin->getDeviceType());
    }

    /**
     * @covers ::getDeviceType
     */
    public function testCanGetDeviceTypeTablet()
    {
        $this->assertSame('tablet', DeviceContextPlugin::DEVICE_TYPE_TABLET);

        $this->mobileDetect->setUserAgent(static::USER_AGENT_TABLET);
        $this->assertSame(DeviceContextPlugin::DEVICE_TYPE_TABLET, $this->plugin->getDeviceType());
    }

    /**
     * @covers ::getDeviceType
     */
    public function testCanGetDeviceTypePhone()
    {
        $this->assertSame('phone', DeviceContextPlugin::DEVICE_TYPE_PHONE);

        $this->mobileDetect->setUserAgent(static::USER_AGENT_PHONE);
        $this->assertSame(DeviceContextPlugin::DEVICE_TYPE_PHONE, $this->plugin->getDeviceType());
    }

    /**
     * @covers ::isComputer
     */
    public function testCanDetectComputer()
    {
        $this->mobileDetect->setUserAgent(static::USER_AGENT_COMPUTER);
        $this->assertTrue($this->plugin->isComputer());
    }

    /**
     * @covers ::isPhone
     */
    public function testCanDetectPhone()
    {
        $this->mobileDetect->setUserAgent(static::USER_AGENT_PHONE);
        $this->assertTrue($this->plugin->isPhone());
    }

    /**
     * @cover ::toArray
     */
    public function testCanGetArrayRepresentation()
    {
        $this->mobileDetect->setUserAgent(static::USER_AGENT_COMPUTER);

        $assertion = array(
            'deviceType' => DeviceContextPlugin::DEVICE_TYPE_COMPUTER,
            'isComputer' => true,
            'isMobile'   => false,
            'isPhone'    => false,
            'isTablet'   => false,
            'userAgent'  => static::USER_AGENT_COMPUTER,
        );
        $this->assertSame($assertion, $this->plugin->toArray());
    }

    /**
     * @covers ::getMobileDetect
     */
    public function testCanGetMobileDetect()
    {
        $method = new ReflectionMethod($this->plugin, 'getMobileDetect');
        $method->setAccessible(true);

        $this->assertSame($this->mobileDetect, $method->invoke($this->plugin));
    }
}
