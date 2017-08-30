<?php

    class ErrorHandling { 


        public static function LogError($Error) {
            $ErrorFile = fopen("ErrorLog.txt", "a") or die("Unable to open file!");
            $txt = "******************************************************************************************************************************" .PHP_EOL;
            fwrite($ErrorFile, $txt);
            $txt = "Error occured at " . date('Y-m-d H:i:s') .PHP_EOL;
            fwrite($ErrorFile, $txt);
            //$txt = "Trace: " . json_encode($Error->getTrace()) .PHP_EOL;
            $trace = $Error->getTrace();
            $txt = "Trace:" .PHP_EOL;;
            fwrite($ErrorFile, $txt);
            foreach ($trace as $item) {
                fwrite($ErrorFile,  "file: " . $item["file"] . " => line: " . $item["line"] . " => function: " . $item["function"] . 
                                    " => class: " . $item["class"] . " => type: " . $item["type"] .PHP_EOL);
            }
            $txt = "Message: " . $Error->getMessage() .PHP_EOL;
            fwrite($ErrorFile, $txt);
            $txt = "Code: " . $Error->getCode() .PHP_EOL;
            fwrite($ErrorFile, $txt);
            fclose($ErrorFile);        
        }
    }
