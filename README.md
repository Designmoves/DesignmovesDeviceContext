DesignmovesDeviceContext
========================

Zend Framework 2 module for detecting mobile devices. This module uses
[Mobile-Detect](https://github.com/serbanghita/Mobile-Detect) for detecting devices.

## Usage

### Controller plugin

The controller plugin proxies the Mobile Detect class and has some additional methods:
<dl>
  <dt>getDeviceType()</dt>
  <dd>Returns the name of the device (computer/phone/tablet)</dd>
  <dt>isComputer()</dt>
  <dd>Determines whether the device is a computer or not</dd>
  <dt>isPhone()</dt>
  <dd>Determines whether the device is a phone or not</dd>
  <dt>toArray()</dt>
  <dd>Returns an array representation of the detected data:
<pre><ocde>
array (size=6)
  'deviceType' => string 'computer' (length=8)
  'isComputer' => boolean true
  'isMobile' => boolean false
  'isPhone' => boolean false
  'isTablet' => boolean false
  'userAgent' => string 'Mozilla/5.0 (Windows NT 6.0; rv:30.0) Gecko/20100101 Firefox/30.0' (length=65)
</code></pre>
  </dd>
</dl>

### View helper

The view helper proxies the controller plugin and therefore has the same methods available.

### Template listener

If enabled this can alter the template being used when a mobile device is detected.

### Layout listener

If enabled this can alter the layout being used when a mobile device is detected.
