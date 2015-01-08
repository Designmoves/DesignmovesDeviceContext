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

namespace DesignmovesDeviceContextTest\Options;

use DesignmovesDeviceContext\Options\ModuleOptions;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass DesignmovesDeviceContext\Options\ModuleOptions
 */
class ModuleOptionsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleOptions
     */
    protected $options;

    public function setUp()
    {
        $this->options = new ModuleOptions;
    }

    public function testStrictModeIsEnabled()
    {
        $this->assertTrue(self::readAttribute($this->options, '__strictMode__'));
    }

    /**
     * @covers ::getMobile
     */
    public function testCanGetDefaultMobile()
    {
        $this->assertInstanceOf('DesignmovesDeviceContext\Options\MobileOptions', $this->options->getMobile());
    }

    /**
     * @covers ::setMobile
     * @covers ::getMobile
     */
    public function testCanSetMobile()
    {
        $this->options->setMobile(array());
        $this->assertInstanceOf('DesignmovesDeviceContext\Options\MobileOptions', $this->options->getMobile());
    }

    /**
     * @covers ::getIsMobileContext
     * @covers ::isMobileContext
     */
    public function testCanGetDefaultIsMobileContext()
    {
        $this->assertFalse($this->options->getIsMobileContext());
        $this->assertFalse($this->options->isMobileContext());
    }

    /**
     * @covers ::setIsMobileContext
     * @covers ::getIsMobileContext
     * @covers ::isMobileContext
     */
    public function testCanSetIsMobileContext()
    {
        $this->options->setIsMobileContext(true);
        $this->assertTrue($this->options->getIsMobileContext());
        $this->assertTrue($this->options->isMobileContext());

        $this->options->setIsMobileContext(false);
        $this->assertFalse($this->options->getIsMobileContext());
        $this->assertFalse($this->options->isMobileContext());
    }
}
