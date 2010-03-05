<?php
require_once('PHPUnit/Framework.php');
require_once(dirname(__FILE__).'/../../bootstrap/plBootstrapUnit.php');
require_once(dirname(__FILE__).'/../../../filesystem/plDirs.php');

class poDirsTest extends PHPUnit_Framework_TestCase
{

    protected function setUp() {
        $this->dirs = new poDirs();
        $this->bootstrap = new poBootstrapUnit();

        $this->path = $this->bootstrap->getTestTrashDir().'/%s';
    }

    public function testSetGetPath()
    {
        $path = $this->bootstrap->getTestTrashDir().'/%s';

        $this->dirs->setPath($path);
        $this->assertEquals($this->dirs->getPath(), $path);

        $this->dirs->setPath($path, 1);
        $this->assertEquals($this->dirs->getPath(), sprintf($path, 1));
    }

    /**
     * crear un directorio (cuando no existe)
     */
    public function testSimpleMkDirCreate()
    {
        $this->dirs->setPath($this->path, 'a');
        $mkdir = $this->dirs->simpleMkDir();

        $this->assertTrue($mkdir, 'Al parecer no se ha creado el directorio o ya existia.');
    }

    /**
     * intento de sobreescribir un carpeta cuando existe
     */
    public function testSimpleMkDirAttemptOverwrite()
    {
        $this->dirs->setPath($this->path, 'a');
        $mkdir = $this->dirs->simpleMkDir();

        $this->assertFalse($mkdir, 'Al parecer no existia la carpeta.');
    }

}