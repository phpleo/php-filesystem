<?php

/**
 * poDownload offers convenience methods for force dowload of files
 *
 * @package    phpleo
 * @subpackage internet
 * @author     Pedro Hernández - phpleo <phpleo [at] gmail [dot] com>
 * @version
 */
class poDownload
{

    /**
     * Series of headers for force download
     *
     * @todo ¿que pasa cuando no existe el archivo?
     */
    static public function force($filePath, $newName = null)
    {
        if (file_exists($filePath))
        {
            $fileName = basename($filePath);
            $fileSize = filesize($filePath);

            if ($newName)
                $fileName = $newName;

            header('Pragma: no-cache');
            header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            header('Content-Transfer-Encoding: binary');
            header('Content-type: application/force-download');
            //header('Content-type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.$fileName);
            header('Content-Length: '.$fileSize);

            readfile($filePath);
            exit(0);
        }

        header("HTTP/1.0 404 Not Found");
        header('Content-Type: text/html');
        exit('<html><head><title>404 Not Found</title></head><body>404 Not Found</body></html>');
    }

    static public function sfForce()
    {
        
    }

}