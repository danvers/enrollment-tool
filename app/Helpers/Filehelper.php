<?php namespace helpers;
/*
 * Document Helper - collection of methods for working with documents
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 1.0
 * @date updated Feb 07, 2015
 */
class Filehelper
{
    /**
     * read data from a file
     * @param  string $file filename and extension
     * @return file data
     */
    public static function read($file)
    {
        if (!file_exists($file)) {
            return true;
        }
        if (function_exists('file_get_contents')) {
            return file_get_contents($file);
        }

        if (!$fp = @fopen($file, FOPEN_READ)) {
            return false;
        }
        flock($fp, LOCK_SH);

        $data = '';
        if (filesize($file) > 0) {
            $data =& fread($fp, filesize($file));
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        return $data;
    }

    /**
     * write data to a file
     * @param  string $path path to the file
     * @param  string $data data to be written into the file
     * @param  string $mode write mode default is w: Truncate to zero length or create file for writing.
     * @return true
     */
    public static function write($path, $data, $mode = 'w')
    {
        if (!$fp = @fopen($path, $mode)) {
            return false;
        }
        flock($fp, LOCK_EX);
        fwrite($fp, $data);
        flock($fp, LOCK_UN);
        fclose($fp);
        return true;
    }

    /**
     * deletes all files within a given path
     * @param  string $path path with files to be deleted
     * @param  boolean $del_dir
     * @param  string $mode write mode
     * @return true
     */
    function delete($path, $del_dir = false, $level = 0)
    {
        // Trim the trailing slash
        $path = rtrim($path, DIRECTORY_SEPARATOR);

        if (!$current_dir = @opendir($path)) {
            return false;
        }

        while (false !== ($filename = @readdir($current_dir))) {
            if ($filename != "." and $filename != "..") {
                if (is_dir($path . DIRECTORY_SEPARATOR . $filename)) {
                    if (substr($filename, 0, 1) != '.') {
                        delete_files($path . DIRECTORY_SEPARATOR . $filename, $del_dir, $level + 1);
                    }
                } else {
                    unlink($path . DIRECTORY_SEPARATOR . $filename);
                }
            }
        }
        @closedir($current_dir);

        if ($del_dir == true && $level > 0) {
            return @rmdir($path);
        }
        return true;
    }
}
