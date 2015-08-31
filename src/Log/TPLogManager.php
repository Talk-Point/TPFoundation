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
        $logTitle = env('TP_LOG_NAME', 'TPLog');
        $this->log = new Logger($logTitle);
        $this->log->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
    }

    public function info($message, array $options = [])
    {
        $this->log->addInfo($message);
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