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

namespace DesignmovesDeviceContextTest\Listener;

use DesignmovesDeviceContext\Listener\LayoutListener;
use DesignmovesDeviceContext\Options\ModuleOptions;
use PHPUnit_Framework_TestCase;
use ReflectionMethod;
use Zend\EventManager\EventManager;
use Zend\EventManager\SharedEventManager;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

/**
 * @coversDefaultClass DesignmovesDeviceContext\Listener\LayoutListener
 * @uses               DesignmovesDeviceContext\Listener\LayoutListener
 * @uses               DesignmovesDeviceContext\Options\MobileOptions
 * @uses               DesignmovesDeviceContext\Options\ModuleOptions
 */
class LayoutListenerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MvcEvent
     */
    protected $event;

    /**
     * @var LayoutListener
     */
    protected $listener;

    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * Mock object
     *
     * @var Zend\View\Resolver\AggregateResolver
     */
    protected $resolverMock;

    public function setUp()
    {
        $this->event    = new MvcEvent;

        $this->resolverMock = $this->getMock('Zend\View\Resolver\AggregateResolver');
        $this->options      = new ModuleOptions;
        $this->listener     = new LayoutListener($this->resolverMock, $this->options);
    }

    /**
     * @covers ::__construct
     */
    public function testResolverIsSetOnConstruct()
    {
        $this->assertSame($this->resolverMock, self::readAttribute($this->listener, 'resolver'));
    }

    /**
     * @covers ::__construct
     */
    public function testModuleOptionsIsSetOnConstruct()
    {
        $this->assertSame($this->options, self::readAttribute($this->listener, 'moduleOptions'));
    }

    /**
     * @covers ::attach
     */
    public function testAttachesLayoutListener()
    {
        $eventManager = new EventManager;
        $eventManager->setSharedManager(new SharedEventManager);
        $eventManager->attach($this->listener);

        $id               = 'Zend\Mvc\Application';
        $event            = MvcEvent::EVENT_RENDER;
        $listeners        = $eventManager->getSharedManager()->getListeners($id, $event);
        $expectedCallback = array($this->listener, 'setMobileLayout');
        $expectedPriority = 1;

        $found = false;
        foreach ($listeners as $listener) {
            $callback = $listener->getCallback();
            if ($callback === $expectedCallback) {
                if ($listener->getMetadatum('priority') == $expectedPriority) {
                    $found = true;
                    break;
                }
            }
        }

        $this->assertTrue($found, 'Listener not found');
    }

    /**
     * @covers ::setMobileLayout
     */
    public function testSetMobileLayoutReturnsEarlyWhenIsNotMobileContext()
    {
        $this->options->setIsMobileContext(false);

        $mobileOptions = $this->options->getMobile();
        $mobileOptions->setLayoutTemplate('foo/bar');

        $viewModel = new ViewModel;
        $this->event->setViewModel($viewModel);

        $this->listener->setMobileLayout($this->event);
        $this->assertNotSame('foo/bar', $viewModel->getTemplate());
    }

    /**
     * @covers ::setMobileLayout
     */
    public function testSetMobileLayoutReturnsEarlyWhenUseMobileLayoutIsFalse()
    {
        $this->options->setIsMobileContext(true);

        $mobileOptions = $this->options->getMobile();
        $mobileOptions->setLayoutTemplate('foo/bar');
        $mobileOptions->setUseMobileLayout(false);

        $viewModel = new ViewModel;
        $this->event->setViewModel($viewModel);

        $this->listener->setMobileLayout($this->event);
        $this->assertNotSame('foo/bar', $viewModel->getTemplate());
    }

    /**
     * @covers ::setMobileLayout
     */
    public function testSetMobileLayoutReturnsEarlyWhenResultIsResponseInterface()
    {
        $this->options->setIsMobileContext(true);

        $mobileOptions = $this->options->getMobile();
        $mobileOptions->setLayoutTemplate('foo/bar');

        $viewModel = new ViewModel;
        $this->event->setViewModel($viewModel);

        $this->event->setResponse(new HttpResponse);

        $this->listener->setMobileLayout($this->event);
        $this->assertNotSame('foo/bar', $viewModel->getTemplate());
    }

    /**
     * @covers ::setMobileLayout
     */
    public function testSetMobileLayoutReturnsEarlyWhenViewModelIsNotModelInterface()
    {
        $this->options->setIsMobileContext(true);
        $returnValue = $this->listener->setMobileLayout($this->event);

        $this->assertNull($returnValue);
    }

    /**
     * @covers ::setMobileLayout
     */
    public function testSetMobileLayoutReturnsEarlyWhenViewModelHasParent()
    {
        $this->options->setIsMobileContext(true);

        $mobileOptions = $this->options->getMobile();
        $mobileOptions->setLayoutTemplate('foo/bar');

        $viewModel = new ViewModel;
        $viewModel->setOptions(array(
            'has_parent' => true,
        ));
        $this->event->setViewModel($viewModel);

        $this->listener->setMobileLayout($this->event);
        $this->assertNotSame('foo/bar', $viewModel->getTemplate());
    }

    /**
     * @covers ::setMobileLayout
     */
    public function testCanSetMobileLayout()
    {
        $this->options->setIsMobileContext(true);

        $mobileOptions = $this->options->getMobile();
        $mobileOptions->setLayoutTemplate('foo/bar');

        $viewModel = new ViewModel;
        $this->event->setViewModel($viewModel);

        $this->resolverMock
             ->expects($this->once())
             ->method($this->equalTo('resolve'))
             ->with($this->equalTo('foo/bar'))
             ->will($this->returnValue(true));

        $this->listener->setMobileLayout($this->event);

        $this->assertSame('foo/bar', $viewModel->getTemplate());
    }

    /**
     * @covers ::getModuleOptions
     */
    public function testCanGetModuleOptions()
    {
        $method = new ReflectionMethod($this->listener, 'getModuleOptions');
        $method->setAccessible(true);

        $this->assertSame($this->options, $method->invoke($this->listener));
    }

    /**
     * @covers ::getResolver
     */
    public function testCanGetResolver()
    {
        $method = new ReflectionMethod($this->listener, 'getResolver');
        $method->setAccessible(true);

        $this->assertSame($this->resolverMock, $method->invoke($this->listener));
    }
}
