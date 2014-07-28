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

namespace DesignmovesDeviceContext\Controller\Plugin;

use Detection\MobileDetect;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class DeviceContext extends AbstractPlugin
{
    /**@#+
     * constants
     */
    const DEVICE_TYPE_COMPUTER = 'computer';
    const DEVICE_TYPE_PHONE    = 'phone';
    const DEVICE_TYPE_TABLET   = 'tablet';
    /**@#-*/

    /**
     * @var MobileDetect
     */
    protected $mobileDetect;

    /**
     * @param MobileDetect $mobileDetect
     */
    public function __construct(MobileDetect $mobileDetect)
    {
        $this->mobileDetect = $mobileDetect;
    }

    /**
     * Proxy for MobileDetect
     *
     * @param  string $methodName
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($methodName, $arguments)
    {
        $mobileDetect = $this->getMobileDetect();
        $callback     = array($mobileDetect, $methodName);

        return call_user_func_array($callback, $arguments);
    }

    /**
     * @return MobileDetect
     */
    public function __invoke()
    {
        return $this->getMobileDetect();
    }

    /**
     * Get device type
     *
     * @return string
     */
    public function getDeviceType()
    {
        if ($this->isTablet()) {
            return static::DEVICE_TYPE_TABLET;
        }

        if ($this->isPhone()) {
            return static::DEVICE_TYPE_PHONE;
        }

        return static::DEVICE_TYPE_COMPUTER;
    }

    /**
     * Determine whether the device is a computer
     *
     * Returns true when:
     * - MobileDetect::isMobile() returns false and
     * - MobileDetect::isTablet() returns false
     *
     * @return bool
     */
    public function isComputer()
    {
        return !$this->isMobile() and !$this->isTablet();
    }

    /**
     * Determine whether the device is a phone
     *
     * Returns true when:
     * - MobileDetect::isMobile() returns true and
     * - MobileDetect::isTablet() returns false
     *
     * @return bool
     */
    public function isPhone()
    {
        return $this->isMobile() and !$this->isTablet();
    }

    /**
     * Array representation of some device info
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'deviceType' => $this->getDeviceType(),
            'isComputer' => $this->isComputer(),
            'isMobile'   => $this->isMobile(),
            'isPhone'    => $this->isPhone(),
            'isTablet'   => $this->isTablet(),
            'userAgent'  => $this->getUserAgent(),
        );
    }

    /**
     * @return MobileDetect
     */
    protected function getMobileDetect()
    {
        return $this->mobileDetect;
    }
}
