<?php
/**
*  TukangAbsen
*  (c) 2017 Ipan Ardian
*
*  When engineers doesn't want to fill out attendance manually, tukangAbsen is the answer!
*  For details, see the web site: https://github.com/ipanardian/tukangAbsen
*  The GPL 3.0 License
*/

if (isset($_SERVER['REMOTE_ADDR'])) die('Permission denied.');
error_reporting(E_ALL ^E_NOTICE);

class TukangAbsen 
{
    protected $arg;
    protected $command;
    protected $CODECEPTION_ARG;

    const CODECEPTION = "php ~/usr/local/bin/codecept ";
    const CODECEPTION_RUN = "run acceptance ";
    const CODECEPTION_PATH_SCREENSHOTS = "./tests/_output/debug/";
    const DEBUG = "-debug";

    function __construct($argv) {
        $this->command    = $argv[1];
        
        //-debug or tolerance time
        $this->arg  = $argv[2];

        $this->CODECEPTION_ARG = " -q ";
    }

    protected function _execute($string)
    {
        if (self::DEBUG == $this->arg)
            passthru($string);
        else 
            exec($string);
    }

    protected function _clearSS($file)
    {
        @unlink(self::CODECEPTION_PATH_SCREENSHOTS.$file);
    }

    public function run()
    {
        if (self::DEBUG == $this->arg) {
            $this->CODECEPTION_ARG = "";
        }
        elseif (is_numeric($this->arg)) {
            $arg_tolerance_time = $this->arg * 60;
            setcookie('tolerance_time', $arg_tolerance_time);
        }

        echo "TukangAbsen v0.1\n\n";
        echo "Processing...\n";

        switch ($this->command) {
            case 'in':
                $this->_clearSS('debug_checkin.png');
                $this->_execute(self::CODECEPTION.$this->CODECEPTION_ARG.self::CODECEPTION_RUN. "checkinCept.php --steps");
                echo "Done\n";
                echo "Opening screenshots...\n";
                $this->_execute("open ".self::CODECEPTION_PATH_SCREENSHOTS."debug_checkin.png");
                break;

            case 'out':
                $this->_clearSS('debug_checkout.png');
                $this->_execute(self::CODECEPTION.$this->CODECEPTION_ARG.self::CODECEPTION_RUN. "checkoutCept.php --steps");
                echo "Done\n";
                echo "Opening screenshots...\n";
                $this->_execute("open ".self::CODECEPTION_PATH_SCREENSHOTS."debug_checkout.png");
                break;
            
            default:
                die('Invalid argument');
                break;
        }
        exit();
    }
}