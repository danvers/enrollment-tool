<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 02.12.2015
 * Time: 22:06
 */

namespace Helpers;


/**
 * ExportDataCSV - Exports to CSV (comma separated value) format.
 */
class ExportDataCSV extends ExportData
{

    function generateRow($row)
    {
        foreach ($row as $key => $value) {
            // Escape inner quotes and wrap all contents in new quotes.
            // Note that we are using \" to escape double quote not ""
            $row[$key] = '"' . str_replace('"', '\"', $value) . '"';
        }
        return implode(",", $row) . "\n";
    }

    function sendHttpHeaders()
    {
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=" . basename($this->filename));
    }
}