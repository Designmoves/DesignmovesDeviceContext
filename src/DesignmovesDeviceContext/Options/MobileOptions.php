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

namespace DesignmovesDeviceContext\Options;

use Zend\Stdlib\AbstractOptions;

class MobileOptions extends AbstractOptions
{
    /**
     * Whether to use strict mode
     *
     * @var bool
     */
    protected $__strictMode__ = true;

    /**
     * @var string
     */
    protected $hostnamePattern = '~^m\.~Di';

    /**
     * @var string
     */
    protected $layoutTemplate = 'layout/mobile';

    /**
     * @var string
     */
    protected $templateSuffix = 'mobile.phtml';

    /**
     * Whether to use a mobile layout
     *
     * @var bool
     */
    protected $useMobileLayout = true;

    /**
     * Whether to use mobile views
     *
     * @var bool
     */
    protected $useMobileViews = true;

    /**
     * @param string $hostnamePattern
     */
    public function setHostnamePattern($hostnamePattern)
    {
        $this->hostnamePattern = $hostnamePattern;
    }

    /**
     * @return string
     */
    public function getHostnamePattern()
    {
        return $this->hostnamePattern;
    }

    /**
     * @param string $layoutTemplate
     */
    public function setLayoutTemplate($layoutTemplate)
    {
        $this->layoutTemplate = $layoutTemplate;
    }

    /**
     * @return string
     */
    public function getLayoutTemplate()
    {
        return $this->layoutTemplate;
    }

    /**
     * @param string $templateSuffix
     */
    public function setTemplateSuffix($templateSuffix)
    {
        $this->templateSuffix = $templateSuffix;
    }

    /**
     * @return string
     */
    public function getTemplateSuffix()
    {
        return $this->templateSuffix;
    }

    /**
     * @param bool $useMobileLayout
     */
    public function setUseMobileLayout($useMobileLayout)
    {
        $this->useMobileLayout = $useMobileLayout;
    }

    /**
     * @return bool
     */
    public function getUseMobileLayout()
    {
        return $this->useMobileLayout;
    }

    /**
     * Proxy for getUseMobileLayout
     *
     * @return bool
     */
    public function useMobileLayout()
    {
        return $this->getUseMobileLayout();
    }

    /**
     * @param bool $useMobileViews
     */
    public function setUseMobileViews($useMobileViews)
    {
        $this->useMobileViews = $useMobileViews;
    }

    /**
     * @return bool
     */
    public function getUseMobileViews()
    {
        return $this->useMobileViews;
    }

    /**
     * Proxy for getUseMobileViews
     *
     * @return bool
     */
    public function useMobileViews()
    {
        return $this->getUseMobileViews();
    }
}
