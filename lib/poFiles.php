<?php

class poFiles
{
    private $_seed = '';

    public function splitFilename($filename)
    {
        if (strpos($filename, ".") == false)
            return array('name' => $filename, 'extension' => '');

        $separate = explode(".", $filename);
        $name = array_slice($separate, 0, -1);
        $extension = array_slice($separate, -1, 1);

        return array(
            'name' => implode(".", $name),
            'extension' => $extension[0]
            );
    }

    public function encryptName($filename, $seed = false, $onlyName = false, $algorith = 'md5')
    {
        $split = $this->splitFilename($filename);
        $name = $split['name'];
        $extension = $split['extension'];

        if ($seed == true)
        {
            $this->setSeed();
            $seed = $this->getSeed();
        }
        else
        {
            $seed = '';
        }

        switch ($algorith)
        {
            case 'md5':
                $name = md5($seed.$name);
                break;

            case 'sha1':
                $name = sha1($seed.$name);
                break;
        }

        if ($onlyName)
            return $name;
        else
            return sprintf('%s.%s', $name, $extension);
    }

    public function changeName($filename, $prefix = '', $sufix = '', $onlyName = false)
    {
        $split = $this->splitFilename($filename);
        $name = $split['name'];
        $extension = $split['extension'];

        if ($onlyName)
            return sprintf('%s%s%s', $prefix, $name, $sufix);
        else
            return sprintf('%s%s%s.%s', $prefix, $name, $sufix, $extension);
    }

    public function setSeed($v = '')
    {
        if ($v == '')
            $this->_seed = strtotime('now');
        else
            $this->_seed = $v;
    }

    public function getSeed()
    {
        return $this->_seed;
    }

}