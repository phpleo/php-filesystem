<?php
require_once('PHPUnit/Framework.php');
require_once(dirname(__FILE__).'/../../bootstrap/plBootstrapUnit.php');
require_once(dirname(__FILE__).'/../../../filesystem/plFiles.php');

class poFilesTest extends PHPUnit_Framework_TestCase
{

    protected function setUp() {
        $this->files = new poFiles();
        $this->bootstrap = new poBootstrapUnit();

        $this->path = $this->bootstrap->getTestTrashDir();
    }

    // {{{ splitFilenameExt
    public function testSplitFilenameWithoutExtension()
    {
        $filename = 'file';
        $split = $this->files->splitFilename($filename);

        $this->assertEquals($split['name'], 'file', 'El nombre no coincide.');
        $this->assertEquals($split['extension'], '', 'La extension no coincide.');
    }

    public function testSplitFilenameExtOneDot()
    {
        $filename = 'file.txt';
        $split = $this->files->splitFilename($filename);

        $this->assertEquals($split['name'], 'file');
        $this->assertEquals($split['extension'], 'txt');
    }

    public function testSplitFilenameExtMultipleDot()
    {
        $filename = 'file.with.multiple.dot.á.$.txt';
        $split = $this->files->splitFilename($filename);

        $this->assertEquals($split['name'], 'file.with.multiple.dot.á.$');
        $this->assertEquals($split['extension'], 'txt');
    }
    // }}}

    // {{{ encryptName
    public function testEncryptNameWithoutSeed()
    {
        $filename = 'file.txt';
        $md5Filename = md5('file').'.txt';
        $encryptName = $this->files->encryptName($filename);

        $this->assertEquals($encryptName, $md5Filename);
    }

    public function testEncryptNameWithSeed()
    {
        $filename = 'file.txt';
        $encryptName = $this->files->encryptName($filename, true);
        $md5Filename = md5($this->files->getSeed().'file').'.txt';

        $this->assertEquals($encryptName, $md5Filename);
    }

    public function testEncryptNameReturnOnlyName()
    {
        $filename = 'file.txt';
        $md5Filename = md5('file');
        $encryptName = $this->files->encryptName($filename, false, true);
        
        $this->assertEquals($encryptName, $md5Filename, sprintf('%s != %s', $encryptName, $name));
    }
    // }}}

    // {{{ changeName
    public function testChangeNameEqual()
    {
        $filename = 'file.txt';

        $changeName = $this->files->changeName($filename);
        $this->assertEquals($changeName, $filename);
    }

    public function testChangeNamePrefix()
    {
        $filename = 'file.txt';
        $prefix = 'prefix_';

        $changeName = $this->files->changeName($filename, $prefix);
        $prefixFilename = $prefix.$filename;
        $this->assertEquals($changeName, $prefixFilename);
    }

    public function testChangeNameSufix()
    {
        $filename = 'file.txt';
        $sufix = '_sufix';

        $changeName = $this->files->changeName($filename, '', $sufix);
        $filenameSufix = 'file_sufix.txt';
        $this->assertEquals($changeName, $filenameSufix);
    }

    public function testChangeNamePrefixSufix()
    {
        $filename = 'file.txt';
        $prefix = 'prefix_';
        $sufix = '_sufix';

        $changeName = $this->files->changeName($filename, $prefix, $sufix);
        $prefixFilenameSufix = 'prefix_file_sufix.txt';
        $this->assertEquals($changeName, $prefixFilenameSufix);
    }

    public function testChangeNamePrefixSufixOnlyName()
    {
        $filename = 'file.txt';
        $prefix = 'prefix_';
        $sufix = '_sufix';

        $changeName = $this->files->changeName($filename, $prefix, $sufix, true);
        $prefixFilenameSufix = 'prefix_file_sufix';
        $this->assertEquals($changeName, $prefixFilenameSufix);
    }
    // }}}

}