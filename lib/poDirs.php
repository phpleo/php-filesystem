<?php

class poDirs
{

    private $_path = null;

    public function simpleMkDir($mode = 0777)
    {
        $mkd = false;
        $path = $this->getPath();

        if (!file_exists($path))
        {
            $mkd = mkdir($path, $mode);

            if (!is_writable($path))
                chmod($path, $mode);
        }

        return $mkd;
    }

    // {{{ get / set: path
    public function setPath($v, $id = null)
    {
        if ($id == null)
            $this->_path = $v;
        else
            $this->_path = sprintf($v, $id);
    }

    public function getPath()
    {
        return $this->_path;
    }
    // }}

}