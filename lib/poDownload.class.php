<?php

/**
 * poDownload offers convenience methods for force dowload of files
 *
 * @package    phpleo
 * @subpackage internet
 * @author     Pedro Hernández - phpleo <fabien.potencier@symfony-project.com>
 * @version
 */
class poDownload
{

    /**
     * Series of headers for force download
     *
     * @todo ¿que pasa cuando no existe el archivo?
     */
    static public function force($filePath, $newName)
    {
        if (file_exists($filePath))
        {
            $filename = basename($filePath);
            $n = sprintf('%s_%s.%s', $newName, date('(Y-m-d_H:i:s)'), 'csv');

            header('Content-Transfer-Encoding: binary');
            header('Content-type: application/force-download');
            header('Content-type: application/octet-stream');
            header(sprintf('Content-Disposition: attachment; filename="%s"', $n));
            header('Content-Length: '.filesize($filePath));
            readfile($filePath);
        }
    }

    static public function sfForce()
    {
        
    }

}