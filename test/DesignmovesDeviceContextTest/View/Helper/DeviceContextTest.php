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

namespace DesignmovesDeviceContextTest\View\Helper;

use DesignmovesDeviceContext\Controller\Plugin\DeviceContext as DeviceContextPlugin;
use DesignmovesDeviceContext\View\Helper\DeviceContext as DeviceContextViewHelper;
use Detection\MobileDetect;
use PHPUnit_Framework_TestCase;
use ReflectionMethod;

/**
 * @coversDefaultClass DesignmovesDeviceContext\View\Helper\DeviceContext
 * @uses               DesignmovesDeviceContext\Controller\Plugin\DeviceContext
 * @uses               DesignmovesDeviceContext\View\Helper\DeviceContext
 */
class DeviceContextTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DeviceContextViewHelper
     */
    protected $helper;

    /**
     * @var DeviceContextPlugin
     */
    protected $plugin;

    public function setUp()
    {
        $this->plugin = new DeviceContextPlugin(new MobileDetect);
        $this->helper = new DeviceContextViewHelper($this->plugin);
    }

    /**
     * @covers ::__construct
     */
    public function testPluginIsSetOnConstruct()
    {
        $this->assertSame($this->plugin, self::readAttribute($this->helper, 'deviceContextPlugin'));
    }

    /**
     * @covers ::__invoke
     */
    public function test__invokeReturnsPlugin()
    {
        $this->assertSame($this->plugin, $this->helper->__invoke());
    }

    /**
     * @covers ::getDeviceContextPlugin
     */
    public function testCanGetDeviceContextPlugin()
    {
        $method = new ReflectionMethod($this->helper, 'getDeviceContextPlugin');
        $method->setAccessible(true);

        $this->assertSame($this->plugin, $method->invoke($this->helper));
    }
}
