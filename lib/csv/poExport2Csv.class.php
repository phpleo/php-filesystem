<?php

/**
 * @todo tests
 * @todo documentacion
 */
abstract class poExport2Csv
{

    protected $_folderpath = '/tmp/csv';
    protected $_filepath = null;
    protected $_filename = null;
    protected $_fileext  = 'csv';

    public $header  = array();
    public $body    = array();
    public $content = array();

    public function  __construct($filename, $folderpath = null)
    {
        $this->initialize($filename, $folderpath);
    }

    protected function initialize($filename, $folderpath)
    {
        $this->setFolderpath($folderpath);
        $this->setFilename($filename);
        $this->setFilepath();

        $this->setHeader();
        $this->setBody();
    }

    public function execute()
    {
        $this->createFolder();
        $this->formatContent();
        $this->putContentAndMakeFile();
    }

    protected function createFolder()
    {
        $pod = new poDirs();
        $pod->setPath($this->getFolderpath());
        $pod->simpleMkDir();
    }

    protected function formatContent()
    {
        $bodies  = $this->getBody();
        $content = array();

        $content[] = $this->getHeader();
        foreach ($bodies as $body)
        {
            $content[] = $body;
        }

        $this->setContent($content);
    }

    /**
     * @todo mejorar para usar http://www.php.net/manual/en/function.tmpfile.php
     */
    protected function putContentAndMakeFile()
    {
        $content = $this->getContent();
        $fp = fopen($this->getFilepath(), 'w');

        foreach ($content as $c)
        {
            fputcsv($fp, $c);
        }

        fclose($fp);
    }

    /**
     * @todo mover el archivo?
     * @param <type> $path
     */
    public function save($path)
    {

    }

    public function sfForceDownload($sfAction)
    {
        $newName = sprintf('%s_%s.%s', $this->getFilename(), date('(Y-m-d_H:i:s)'), $this->_fileext);

        poDownload::sfForce($sfAction, $this->getFilepath(), $newName);
    }

    // }}}
    // {{{ folder path

    protected function setFolderpath($v = null)
    {
        if ($v != null)
        {
            $this->_folderpath = $v;
        }
    }

    protected function getFolderpath()
    {
        return $this->_folderpath;
    }

    // }}}
    // {{{ file path

    /**
     * @todo agregar la posibilidad que agrege la fecha y hora en el nombre del archivo
     */
    protected function setFilepath()
    {
        $this->_filepath = sprintf('%s/%s.%s', $this->getFolderpath(), $this->getFilename(), $this->_fileext);
    }

    public function getFilepath()
    {
        return $this->_filepath;
    }

    // }}}
    // {{{ file name

    protected function setFilename($v = null)
    {
        if ($v != null)
        {
            $this->_filename = $v;
        }
    }

    protected function getFilename()
    {
        return $this->_filename;
    }

    // }}}
    // {{{ header

    /**
     * Set header for csv file to export.
     *
     * Use in sub-classed:
     * <code>
     * public function setHeader()
     * {
     *     $this->_header = array(
     *         'header 1',
     *         ...
     *         );
     * }
     * </code>
     */
    abstract public function setHeader();

    public function getHeader()
    {
        return $this->header;
    }

    // }}}
    // {{{ body

    /**
     * Set body content for csv file to export
     *
     * Use in sub-classed:
     * <code>
     * </code>
     */
    abstract public function setBody();

    public function getBody()
    {
        return $this->body;
    }

    // }}}
    // {{{ content

    /**
     * El contenido final que ira en el archivo
     *
     * @param mixed $v
     */
    public function setContent($v)
    {
        $this->content = $v;
    }

    public function getContent()
    {
        return $this->content;
    }

    // }}}

}