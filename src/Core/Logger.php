<?php
namespace App\Core;

class Logger
{
    public function writeLog($message, $code, $file, $line, $localCsvFile) : void
    {
        $data = array(
            $message,
            $code,
            $file,
            $line
        );

        $fp = fopen($localCsvFile, 'a');

        $data = fputcsv($fp, $data, ",");
    
        fclose($fp);
    }
}
