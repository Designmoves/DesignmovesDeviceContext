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

namespace DesignmovesDeviceContext\Listener;

use DesignmovesDeviceContext\Options\ModuleOptions;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Model\ModelInterface;
use Zend\View\Resolver\AggregateResolver;

class LayoutListener extends AbstractListenerAggregate
{
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @var AggregateResolver
     */
    protected $resolver;

    /**
     * @param AggregateResolver $resolver
     * @param ModuleOptions     $moduleOptions
     */
    public function __construct(AggregateResolver $resolver, ModuleOptions $moduleOptions)
    {
        $this->resolver      = $resolver;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @param EventManagerInterface $eventManager
     */
    public function attach(EventManagerInterface $eventManager)
    {
        $identifier = 'Zend\Mvc\Application';
        $event      = MvcEvent::EVENT_RENDER;
        $callback   = array($this, 'setMobileLayout');
        $priority   = 1;

        $this->listeners[] = $eventManager->getSharedManager()->attach($identifier, $event, $callback, $priority);
    }

    /**
     * @param EventInterface $event
     */
    public function setMobileLayout(EventInterface $event)
    {
        if (!$this->getModuleOptions()->isMobileContext()) {
            return;
        }

        $mobileOptions = $this->getModuleOptions()->getMobile();
        if (!$mobileOptions->useMobileLayout()) {
            return;
        }

        $result = $event->getResult();
        if ($result instanceof ResponseInterface) {
            return;
        }

        $viewModel = $event->getViewModel();
        if (!$viewModel instanceof ModelInterface) {
            return;
        }

        /**
         * Layout has no parent, so check for has_parent
         */
        if (null === $viewModel->getOption('has_parent')) {
            $template = $mobileOptions->getLayoutTemplate();
            if ($this->resolver->resolve($template)) {
                $viewModel->setTemplate($template);
            }
        }
    }

    /**
     * @return ModuleOptions
     */
    protected function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    /**
     * @return AggregateResolver
     */
    protected function getResolver()
    {
        return $this->resolver;
    }
}
