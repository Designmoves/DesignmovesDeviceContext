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

namespace DesignmovesDeviceContextTest\Factory\Options;

use DesignmovesDeviceContext\Factory\Options\ModuleOptionsFactory;
use PHPUnit_Framework_TestCase;
use Zend\Config\Config;
use Zend\ServiceManager\ServiceManager;

/**
 * @coversDefaultClass DesignmovesDeviceContext\Factory\Options\ModuleOptionsFactory
 */
class ModuleOptionsFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleOptionsFactory
     */
    protected $factory;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $this->factory        = new ModuleOptionsFactory;
        $this->serviceManager = new ServiceManager;
    }

    /**
     * @covers ::createService
     */
    public function testCanCreateService()
    {
        $config = new Config(array(
            'designmoves_device_context' => array(),
        ));
        $this->serviceManager->setService('Config', $config);

        $options = $this->factory->createService($this->serviceManager);
        $this->assertInstanceOf('DesignmovesDeviceContext\Options\ModuleOptions', $options);
    }
}
