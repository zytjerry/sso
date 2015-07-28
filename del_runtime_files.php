<?php
function deleteFile($path, &$result)
{
    if (!is_dir($path)) {
        $result = $path . ': Sorry, the path is not a directory.';
        return;
    }
    $dh = opendir($path);
    while ($file = readdir($dh)) {
        if ($file != '.' && $file != '..') {
            $file = $path . '/' . $file;
            if (is_file($file)) {
                if (unlink($file)) {
                    $result = $result . $file . '<br/>';
                }
            } else if (is_dir($file)) {
                deleteFile($file, $result);
            }
        }
    }
}

header('Content-type: text/html; charset=utf-8');
$result = 'The following files are deleted: <br />';
$curr_dir = dirname(__FILE__);
deleteFile($curr_dir . '/Application/Runtime', $result);
echo $result;
exit(0);

