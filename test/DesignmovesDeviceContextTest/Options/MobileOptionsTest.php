<?php
/**
 * Copyright (c) 2014, Designmoves http://www.designmoves.nl
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

use DesignmovesDeviceContext\Options\MobileOptions;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass DesignmovesDeviceContext\Options\MobileOptions
 */
class MobileOptionsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MobileOptions
     */
    protected $options;

    public function setUp()
    {
        $this->options = new MobileOptions;
    }

    public function testStrictModeIsEnabled()
    {
        $this->assertTrue(self::readAttribute($this->options, '__strictMode__'));
    }

    /**
     * @covers ::getHostnamePattern
     */
    public function testCanGetDefaultHostnamePattern()
    {
        $this->assertSame('~^m\.~Di', $this->options->getHostnamePattern());
    }

    /**
     * @covers ::setHostnamePattern
     * @covers ::getHostnamePattern
     */
    public function testCanSetHostnamePattern()
    {
        $this->options->setHostnamePattern('foo');
        $this->assertSame('foo', $this->options->getHostnamePattern());
    }

    /**
     * @covers ::getLayoutTemplate
     */
    public function testCanGetDefaultLayoutTemplate()
    {
        $this->assertSame('layout/mobile', $this->options->getLayoutTemplate());
    }

    /**
     * @covers ::setLayoutTemplate
     * @covers ::getLayoutTemplate
     */
    public function testCanSetLayoutTemplate()
    {
        $this->options->setLayoutTemplate('foo/bar');
        $this->assertSame('foo/bar', $this->options->getLayoutTemplate());
    }

    /**
     * @covers ::getTemplateSuffix
     */
    public function testCanGetDefaultTemplateSuffix()
    {
        $this->assertSame('mobile.phtml', $this->options->getTemplateSuffix());
    }

    /**
     * @covers ::setTemplateSuffix
     * @covers ::getTemplateSuffix
     */
    public function testCanSetTemplateSuffix()
    {
        $this->options->setTemplateSuffix('foo.bar');
        $this->assertSame('foo.bar', $this->options->getTemplateSuffix());
    }

    /**
     * @covers ::getUseMobileLayout
     * @covers ::useMobileLayout
     */
    public function testCanGetDefaultUseMobileLayout()
    {
        $this->assertTrue($this->options->getUseMobileLayout());
        $this->assertTrue($this->options->useMobileLayout());
    }

    /**
     * @covers ::setUseMobileLayout
     * @covers ::getUseMobileLayout
     * @covers ::useMobileLayout
     */
    public function testCanSetUseMobileLayout()
    {
        $this->options->setUseMobileLayout(true);
        $this->assertTrue($this->options->getUseMobileLayout());
        $this->assertTrue($this->options->useMobileLayout());

        $this->options->setUseMobileLayout(false);
        $this->assertFalse($this->options->getUseMobileLayout());
        $this->assertFalse($this->options->useMobileLayout());
    }

    /**
     * @covers ::getUseMobileViews
     * @covers ::useMobileViews
     */
    public function testCanGetDefaultUseMobileViews()
    {
        $this->assertTrue($this->options->getUseMobileViews());
        $this->assertTrue($this->options->useMobileViews());
    }

    /**
     * @covers ::setUseMobileViews
     * @covers ::getUseMobileViews
     * @covers ::useMobileViews
     */
    public function testCanSetUseMobileViews()
    {
        $this->options->setUseMobileViews(true);
        $this->assertTrue($this->options->getUseMobileViews());
        $this->assertTrue($this->options->useMobileViews());

        $this->options->setUseMobileViews(false);
        $this->assertFalse($this->options->getUseMobileViews());
        $this->assertFalse($this->options->useMobileViews());
    }
}
