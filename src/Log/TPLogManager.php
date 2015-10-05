<?php /* Log Manager */

namespace TPFoundation\Log;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class TPLogManager
{
    protected $log;

    /**
     * Konsturktor
     */
    public function __construct()
    {
        $logTitle = tpenv('TP_LOG_NAME', 'TP-Log');

        $log = tpenv('TP_LOG', 'production');
        $this->log = new Logger($logTitle);
        if ($log == 'developement') {
            $this->log->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
        } else {
            $this->log->pushHandler(new StreamHandler(storage_path().'/logs/'.$logTitle.'.log', Logger::DEBUG));
        }

    }

    public function info($message, array $options = [])
    {
        $this->log->addInfo($message, $options);
    }

    public function debug($message, array $options = [])
    {
        $this->log->addDebug($message, $options);
    }

    public function error($message, array $options = [])
    {
        $this->log->addError($message, $options);
    }

    public function critical($message, array $options = [])
    {
        $this->log->addCritical($message, $options);
    }
}