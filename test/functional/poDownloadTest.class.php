<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

/**
 * poDownloadTest
 *
 * For this test im use the following local url:
 * http://internet-lib.localhost/
 *
 * @author     Pedro Hernández - phpleo <phpleo [at] gmail [dot] com>
 */
class poDownloadTest extends PHPUnit_Extensions_SeleniumTestCase
{
    
    public static $browsers = array(
        array(
            'name'    => 'Firefox 3.6 on Linux Ubuntu 9.10',
            'browser' => '*firefox /opt/firefox2.6/firefox',
            'timeout' => 30000,
            ),
        );

    protected function setUp()
    {
        $this->setBrowserUrl('http://internet-lib.localhost/');
    }

    public function testDownloadOk()
    {
        $this->open('http://internet-lib.localhost/force-download.php?file=test.pdf');
        $this->assertPromptPresent();
    }

    /**
     * when the result contain 404 Not Found
     */
    public function testDownloadFail()
    {
        $this->open('http://internet-lib.localhost/force-download.php?file=somefile.pdf');
        $this->assertTextPresent('404 Not Found');
    }
}