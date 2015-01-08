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

namespace DesignmovesDeviceContextTest;

use DesignmovesDeviceContext\Listener\LayoutListener;
use DesignmovesDeviceContext\Listener\TemplateListener;
use DesignmovesDeviceContext\Module;
use DesignmovesDeviceContext\Options\ModuleOptions;
use PHPUnit_Framework_TestCase;
use Zend\EventManager\EventManager;
use Zend\EventManager\SharedEventManager;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\Uri\Http as HttpUri;
use Zend\View\Resolver\AggregateResolver;

/**
 * @coversDefaultClass DesignmovesDeviceContext\Module
 */
class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Module
     */
    protected $module;

    /**
     * - uri to test
     * - assertion whether it is mobile context
     */
    public function providerUri()
    {
        return array(
            array(
                'http://m.domain.tld',
                true,
            ),
            array(
                'http://www.domain.tld',
                false,
            ),
        );
    }


    public function setUp()
    {
        $this->module = new Module;
    }

    /**
     * @covers ::getAutoloaderConfig
     */
    public function testCanGetAutoloaderConfig()
    {
        $autoloaderConfig = $this->module->getAutoloaderConfig();

        $this->assertInternalType('array', $autoloaderConfig);
        $this->assertArrayHasKey('Zend\Loader\ClassMapAutoloader', $autoloaderConfig);
        $this->assertArrayHasKey('Zend\Loader\StandardAutoloader', $autoloaderConfig);
    }

    /**
     * @cover ::getConfig
     */
    public function testCanGetConfig()
    {
        $this->assertInternalType('array', $this->module->getConfig());
    }

    /**
     * @covers ::init
     */
    public function testInitAttachesContextListener()
    {
        $moduleManager = new ModuleManager(array());

        $eventManager = new EventManager;
        $eventManager->setSharedManager(new SharedEventManager);
        $moduleManager->setEventManager($eventManager);

        $this->module->init($moduleManager);

        $id               = 'Zend\Mvc\Application';
        $event            = MvcEvent::EVENT_BOOTSTRAP;
        $listeners        = $eventManager->getSharedManager()->getListeners($id, $event);
        $expectedCallback = array($this->module, 'setMobileContext');
        $expectedPriority = 100;

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
     * @covers ::onBootstrap
     * @uses   DesignmovesDeviceContext\Listener\LayoutListener
     * @uses   DesignmovesDeviceContext\Listener\TemplateListener
     */
    public function testOnBootstrapAttachesListeners()
    {
        $eventManager = new EventManager;
        $eventManager->setSharedManager(new SharedEventManager);

        $serviceManager = new ServiceManager;
        $serviceManager->setService('EventManager', $eventManager);
        $serviceManager->setService('Request', new HttpRequest);
        $serviceManager->setService('Response', new HttpResponse);

        $resolver         = new AggregateResolver;
        $moduleOptions    = new ModuleOptions;
        $templateListener = new TemplateListener($resolver, $moduleOptions);
        $serviceManager->setService('DesignmovesDeviceContext\Listener\TemplateListener', $templateListener);

        $layoutListener = new LayoutListener($resolver, $moduleOptions);
        $serviceManager->setService('DesignmovesDeviceContext\Listener\LayoutListener', $layoutListener);

        $mvcEvent    = new MvcEvent;
        $application = new Application(array(), $serviceManager);
        $mvcEvent->setApplication($application);

        $this->module->onBootstrap($mvcEvent);

        // Check for TemplateListener
        $identifier       = 'Zend\Stdlib\DispatchableInterface';
        $event            = MvcEvent::EVENT_DISPATCH;
        $listeners        = $eventManager->getSharedManager()->getListeners($identifier, $event);
        $expectedCallback = array($templateListener, 'setMobileTemplate');
        $expectedPriority = -91;

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

        $this->assertTrue($found, sprintf(
            'Listener "%s" not found',
            get_class($templateListener)
        ));

        // Check for LayoutListener
        $identifier       = 'Zend\Mvc\Application';
        $event            = MvcEvent::EVENT_RENDER;
        $listeners        = $eventManager->getSharedManager()->getListeners($identifier, $event);
        $expectedCallback = array($layoutListener, 'setMobileLayout');
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

        $this->assertTrue($found, sprintf(
            'Listener "%s" not found',
            get_class($layoutListener)
        ));
    }

    /**
     * @covers       ::setMobileContext
     * @dataProvider providerUri
     * @uses         DesignmovesDeviceContext\Options\MobileOptions
     * @uses         DesignmovesDeviceContext\Options\ModuleOptions
     */
    public function testCanSetMobileContext($uri, $isMobileContext)
    {
        $request = new HttpRequest;
        $event   = new MvcEvent;
        $event->setRequest($request);

        $serviceManager = new ServiceManager;
        $serviceManager->setService('EventManager', new EventManager);
        $serviceManager->setService('Request', $request);
        $serviceManager->setService('Response', new HttpResponse);

        $application = new Application(array(), $serviceManager);
        $event->setApplication($application);

        $moduleOptions = new ModuleOptions;
        $serviceManager->setService('DesignmovesDeviceContext\Options\ModuleOptions', $moduleOptions);

        $request->setUri(new HttpUri($uri));
        $this->module->setMobileContext($event);

        $this->assertSame($isMobileContext, $moduleOptions->isMobileContext());
    }
}
