<?php
/**
 * This no replace acceptance testing.
 *
 * For acceptance testing view test/ folder.
 */
require_once(dirname(__FILE__).'/../lib/poDownload.class.php');

$file = (isset($_GET['file'])) ? $_GET['file'] : '';
$filepath = dirname(__FILE__).'/'.$file;

poDownload::force($filepath);