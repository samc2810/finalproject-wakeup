<?php

namespace WakeUp;
/**
 * Description of Logger
 *
 * @author sarora
 */
class Logger {
    //put your code here
    private $file ;

    private function  __construct($mode) {
        $this->file = fopen(APPLICATION_PATH.'/src/log/wol.log',$mode);
    }

    public function getFile() {
        return $this->file;
    }

    public static function log($message) {
        $logfile = new self('a');

        fwrite($logfile->getFile(), date('D, d M Y H:i:s')." -> ".$message."\n");
        fclose($logfile->getFile());
    }

    /**
     *
     * @return array
     */
    public static function getLog() {
        $logfile = new self('r');
        $logs = array();
        if($logfile->getFile())
            while(!feof($logfile->getFile())) {
                $logs[] = fgets($logfile->getFile());
            }
        return $logs;
    }

    public static function unlog() {
//        $file = APPLICATION_PATH.'/src/log/wol.log';

        $logfile = new self('w');
        fwrite($logfile->getFile(), NULL);
        fclose($logfile->getFile());
//        if(file_exists($file)) {
//            unlink($file);
//            return true;
//        }else
//            return false;
    }
}
